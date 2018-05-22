<?php
/*
@Auther: Gabriel Rodriguez
Page: Index
Project: Collaborate 2017-2018
Date: 3/6/2018

Index page displays introduction images to user within a "Poloroid" type
of container. There are options to register as a new user as well as a signhp
area

*/
    include ("./inc/header.php");

  //prevent users from going to the index page without logging out
	if (!isset($_SESSION["username"])) {
		echo "";
	}
	else
	{
		echo "<meta http-equiv='refresh' content='0; url='inc/home.php'>";
	}
	
	// define variables and set to empty values
	$firstN = $lastN = $password = $password2 = $email = $email2 = $userN = $user_check = $user_check2 = $email_check = $email_check2 = $date = "";
	$fnameErr = $lnameErr = $userErr = $emailErr = $email2Err = $passErr = $pass2Err = "";
	$userLogErr = $passLogErr = $md5password_login = $sql = $password_login = $userCount = $row = $id = "";
	$date = date("Y-m-d"); // Year - Month - Day
	
    //POST data from user registration or log in
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$con = Connect();
		if(isset($_POST["reg"]))
		{
			if (empty($_POST["fname"]))
			{
				$fnameErr = "Name is required";
			}
			else
			{
				$firstN = test_input($_POST["fname"]);
			}
			if (empty($_POST["lname"]))
			{
				$lnameErr = "Name is required";
			}
			else
			{
				$lastN = test_input($_POST["lname"]);
			}
			if (empty($_POST["uname"]))
			{
				$userErr = "Username is required";
			}
			else
			{
				$userN= test_input($_POST["uname"]);
			}
			if (empty($_POST["email"]))
			{
				$emailErr = "Email is required";
			}
			else
			{
				$email = test_input($_POST["email"]);
			}
			if (empty($_POST["email2"]))
			{
				$email2Err = "Email is required";
			}
			else
			{
				// Remove all illegal characters from email
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);

				// Validate e-mail
				if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
				{
					$email2 = test_input($_POST["email2"]);
				}
			}
			if (empty($_POST["password"]))
			{
				$passErr = "Password is required";
			}
			else
			{
				$password = test_input($_POST["password"]);
			}
			if (empty($_POST["password2"]))
			{
				$pass2Err = "Password verification is required";
			}
			else
			{
				$password2 = test_input($_POST["password2"]);
			}
			
			if ($email == $email2)
			{
				// Check if user already exists
				$user_check = mysqli_query($con, "SELECT username FROM users WHERE username='$userN'");
				//Check whether Email already exists in the database
				$email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

				if (!$user_check2 = mysqli_fetch_assoc($user_check))
				{
					if (!$email_check2 = mysqli_fetch_assoc($email_check))
					{
						// check that passwords match
						if ($password === $password2)
						{
							// check the maximum length of username/first name/last name does not exceed 25 characters
							if (strlen($userN) > 25 || strlen($firstN) > 25 || strlen($lastN) > 25)
							{
							   echo "The maximum amount of characters has been exceeded";
							}
							else
							{
								// check the maximum length of password does not exceed 25 characters and is not less than 5 characters
								if (strlen($password) > 30 || strlen($password2) < 5)
								{
									echo "Your password must be between 5 and 30 characters long!";
								}
								else
								{
									//encrypt password and password 2 using md5 before sending to database
									$password = md5($password);

									$mysqli_query = "INSERT INTO users (username, first_name, last_name, email, password, sign_up_date) VALUES ('$userN', '$firstN', '$lastN', '$email', '$password', '$date')";
									if(mysqli_query ($con, $mysqli_query))
									{
										$username = $userN;
                                        $_SESSION['username'] = $username;
										header("Location: ./inc/new_user_form.php");
									}
								}
							}
						}
						else
						{
							$passErr = "Your passwords don&apos;t match!";
						}
					}
					else
					{
						$emaiErr = "Sorry, that Email address is already in use.";
					}
				}
				else
				{
					$userErr = "That username has been taken.";
				}
			}
			else
			{
				$email2Err = "Your E-mails don&apos;t match.";
			}
		}
		else
		{
			if (empty($_POST["user_login"]))
			{
		        $userLogErr = "Username is required";
			}
			else
			{
			    $user_login = test_input($_POST["user_login"]);
			}
			if (empty($_POST["password_login"]))
			{
		  	    $passLogErr = "Password is required";
		    }
		    else
		    {
		   	    $password_login = test_input($_POST["password_login"]);
		    }
			$md5password_login = md5($password_login);

			//Check username
			$sql = ("SELECT `username` FROM `collaborate`.`users` WHERE `username`='$user_login' AND `password`='$md5password_login' AND `activated`='0' LIMIT 1");
          
			 
			$user = SetUser($sql);
			if($user)
			{
				$_SESSION['username'] = $user;
				
				header("Location: ./inc/home.php");
				
			}
			else
			{
				$userLogErr = "There was no user found using the information provided.";	
				
			}
        }
    }
 /*
 START SESSION DATA
 */
 function SetUser($sql)
 {
	 $username = "";
 	try
 	{
 		//open database connection
 		$con = Connect();
 		//mysqli_query database
 		if($mysqli_query = mysqli_query ($con, $sql))
        {
			while($row = mysqli_fetch_assoc($mysqli_query))
			{
				$username = $row["username"];
			}
			if($username != "")
			{
				//get users profile_pictures
				$check_pic = mysqli_query ($con, "SELECT `user_picture` FROM `collaborate`.`profile_pictures` WHERE `user`='$username'");
				$get_pic_row = mysqli_fetch_assoc($check_pic);
				$profile_pic_db = $get_pic_row['user_picture'];
				if($profile_pic_db != "")
				{
					$get_user_pic = $profile_pic_db;
				}
				else
				{
					$get_user_pic = "";
				}
				$con = NULL;
				return $username;
			}
		}
		else
		{
			return false;
		}
 	}
 	catch (Exception $e)
 	{
		return false;
 		//TODO add log for catch statement
 	}
 }
 /*
 END SESSION DATA
 */
?>
  <!--
  Registration start located on the right of screen
  -->
	<div id="join">
	<span class="err"><?php echo $userLogErr;?></span>
		<table >
			<tr> 
				<td >
					<h2 id="h2sign">Sign Up Below or<span id="in" onclick="SignIn()">Sign In</span></h2>
					<form id="signIn" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
						<input type="text" name="user_login" size="50" placeholder="Username" /><br /><br />
						<input type="password" name="password_login" size="50" placeholder="Password" /><br /><br />
						<input type="submit" name="log" value="Login" />
					</form>
					<form id="signUp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
						<input type="text" name="fname" size="25" placeholder="First Name" /><span class="err"><?php echo $fnameErr;?></span><br /><br />
						<input type="text" name="lname" size="25" placeholder="Last Name" /><span class="err"><?php echo $lnameErr;?></span><br /><br />
						<input type="text" name="uname" size="25" placeholder="Username" /><span class="err"><?php echo $userErr;?></span><br /><br />
						<input type="text" name="email" size="25" placeholder="Email Address" /><span class="err"><?php echo $emailErr;?></span><br /><br />
						<input type="text" name="email2" size="25" placeholder="Re-Enter Email" /><span class="err"><?php echo $email2Err?></span><br /><br />
						<input type="password" name="password" size="25" placeholder="Password" /><span class="err"><?php echo $passErr;?></span><br /><br />
						<input type="password" name="password2" size="25" placeholder="Password Verification" /><span class="err"><?php echo $pass2Err;?></span><br /><br />
						<input type="submit" name="reg" value="Sign Up!" >
					</form>
				</td>
			</tr>
		</table>
	</div>

	
	<div class="bgstyleIndex">
    <!--
    Container with images and text
    -->
		<br/><br/>
		<div class="photos">
			<img id="img1" src="img/intro_pic_1.jpg" alt="" >
			<img id="img2" src="img/intro_pic_2.jpg" alt="" >
			<img id="img3" src="img/intro_pic_3.jpg" alt="" >
			<img id="img4" src="img/intro_pic_4.jpg" alt="" >
			<img id="img5" src="img/intro_pic_5.jpg" alt="" >
			<img id="img6" src="img/intro_pic_6.jpg" alt="" >
			<img id="img7" src="img/intro_pic_7.jpg" alt="" >
			<div class="container">
				<h1 id="jumbo"><img src="img/slide1.png"></h1>
				<h1 id="jumbo1"><img src="img/slide2.png"></h1>
				<h1 id="jumbo2"><img src="img/slide3.png"></h1>
				<h1 id="jumbo3"><img src="img/slide4.png"></h1>
				<h1 id="jumbo4"><img src="img/slide5.png"></h1>
				<h1 id="jumbo5"><img src="img/slide6.png"></h1>
			</div>
		</div>
		<br/><br/>
	</div>

<?php
	
    _html_end();
?>