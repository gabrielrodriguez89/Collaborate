<?php
/*
@Author: Gabriel Rodriguez
Page: Registration
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
the users data is checked using test_input to help prevent sql injecting
session variables are set using SetUser function parsing mysqli_query and username
session variables are registered and session is started using StartSession
MD5 hashing is used to provide basic security.
User registration starts with basic information and after that required
data is entered the user is directed to the forms page
*/

  include  "header.php";
	// define variables and set to empty values
	$firstN = $lastN = $password = $password2 = $email = $email2 = $userN = $user_check = $user_check2 = $email_check = $email_check2 = $date = "";
	$fnameErr = $lnameErr = $userErr = $emailErr = $email2Err = $passErr = $pass2Err = "";
	$userLogErr = $passLogErr = $md5password_login = $sql = $userCount = $row = $id = "";
	$date = date("Y-m-d"); // Year - Month - Day

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
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
										header("Location: new_user_form.php");
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
		    $user_login = "Username is required";
			}
			else
			{
			  $user_login = test_input($_POST["user_login"]);
			}
			if (empty($_POST["password_login"]))
			{
		  	$emailErr = "Password is required";
		  }
		  else
		  {
		  	$password_login = test_input($_POST["password_login"]);
		  }
			$md5password_login = md5($password_login);

			//Check username
			$sql = ("SELECT * FROM users WHERE username ='$user_login' AND password='$md5password_login' AND activated='0' LIMIT 1");
      try
      {
        $_SESSION['username'] = SetUser($sql);
        if(isset($_SESSION['username']))
        {
          header("Location: home.php");
          exit("<meta http-equiv=\"refresh\" content=\"0\">");
        }
        else
        {
          print("PDO::ErrorException");
        }
    	}
    	catch (Exception $e)
    	{
    		//TODO add log for catch statement
    	}
   }
 }
 /*
 START SESSION DATA
 */
 function SetUser($sql)
 {
 	try
 	{
 		//open database connection
 		$con = Connect();
 		//mysqli_query database
 		$mysqli_query = mysqli_query ($con, $sql);

 		while($row = mysqli_fetch_assoc($mysqli_query))
 		{
 			$username = $row["username"];
 		}
     //get users profile_pictures
 		$check_pic = mysqli_query ($con, "SELECT user_picture FROM profile_pictures WHERE user='$username'");
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
 	catch (Exception $e)
 	{
 		//TODO add log for catch statement
 	}
 }
 /*
 END SESSION DATA
 */
?>
