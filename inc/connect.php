<?php
/*
@Auther: Gabriel Rodriguez
Page: Connect
Project: collaborate
Date: 3/6/2018

Connect.php was created to maintain all of the functions used in the Collaborate website 2017-2018

*/

// start user session
SESSION_START();

// start user creation, regenrate session id after 30 minutes
if (!isset($_SESSION['CREATED'])) 
	{
		$_SESSION['CREATED'] = time();// start creation time
	} 
	else 
		if (time() - $_SESSION['CREATED'] > 1800) 
		{
			// session started more than 30 minutes ago
			session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
			$_SESSION['CREATED'] = time();  // update creation time
		}
		
//database connection information
function Connect()
{
	$servername = "localhost";
	$db = "collaborate";
    $username = "users";
    $password = "users";
	$port = 3306;

    $conn = mysqli_connect($servername,$username, $password, $db, $port);

    // Check connection
    if (!$conn) 
	{
        die("Connection failed: " . mysqli_connect_error());
    }
	else
	{
		return $conn;
	}
}

//used to test various data input by users, preventative measure for sql injection
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
/*
open connection and get projects from all users based on mysqli_query
int sent to print the proper output while maitaining re-usability
*/
function GetProject($project, $i)
{
	$numProjects = 0;
	try
	{
		//open connection
		$con = Connect();
		$getProject = mysqli_query($con, $project);
		//try parsing mysqli_query
		if($numrows = mysqli_num_rows($getProject) > 0)
        {
			//loop to display all results of posted projects and users
	        while($row = mysqli_fetch_assoc($getProject))
	        {
				//get project details
				$proId = $row['id'];
				$user = $row['username'];
				$project_name = $row['project_name'];
				$description = $row['description'];
				$type = $row['type_of_project'];
				$city = $row['city'];
				$state = $row['state'];
				$date = $row['date'];
				$attachment = $row['attachment'];
                $numProjects += 1;
				switch ($i)
				{
					case '0':
						//get user details
						$get_user_data = mysqli_query ($con, "SELECT * FROM `collaborate`.`users` WHERE `username`='$user'");
						if($get_user_data)
						{
							while($user_info = mysqli_fetch_assoc($get_user_data))
							{
								$id = $row['id'];
								$fname = $user_info['first_name'];
								$lname = $user_info['last_name'];
								$city = $user_info['city'];
								$state = $user_info['state'];
								$profile_pic = $user_info['profile_pic'];
							}
						}

						//if there is no image for the project print this
						if($attachment == "")
						{
							print ("<br/>");
							print ("<a href='./profile.php?u=$user'>");
							print ("<div class='display_project' onclick='Go_To_Profile()'>");
							print ("<input id='getUser' name='id' value='$user' type='hidden' />");
							print ("<img src='$profile_pic' alt='Profile picture for $user'/>");
							print ("<h2>$user</h2>");
							print ("<h5>$date</h5><br/><br/>");
							print ("<div class='project_container'>");
							print ("<h1>$project_name</h1>");
							print ("<h2>$type</h2><br/><br/>");
							print ("<p>$description</p>");
							print ("</div>");
							print ("</div>");
							print ("</a>");
						}
						else
						{
							print ("<br/>");
							print ("<a href='./profile.php?u=$user'>");
							print ("<div class='display_project' onclick='Go_To_Profile()'>");
							print ("<input id='getUser' name='id' value='$user' type='hidden' />");
							print ("<img src='$profile_pic' alt='Profile picture for $user'/>");
							print ("<h2>$user</h2>");
							print ("<h5>$date</h5><br/><br/>");
							print ("<div class='project_container'>");
							if($attachment != "" AND $attachment != NULL)
							{
							    print ("<img src='./../$attachment' alt='picture for $project_name'/><br/>");
							}
							print ("<h1>$project_name</h1>");
							print ("<h2>$type</h2><br/><br/>");
							print ("<p>$description</p>");
							print ("</div>");
							print ("</div>");
							print ("</a>");
						}
					  break;
				    case '1':
							print ("<div id='showPro$proId' onclick='Show($proId)'>");
							print ("<h1>$project_name</h1>");
							print ("<h2>$type</h2><br/>");
							print ("</div>");	
							print ('<hr id="hr"/>');
					  break;
				    default:
						if($attachment == "")
						{
							 print ("<div id='project$proId'>");
							 print ("<h1>$project_name</h1><br/>");
							 print ("<h5>$date</h5><br/>");
							 print ("<h4>$type</h4><br/><br/>");
							 print ("<p>$description</p>");
							 print ("<br/>");
						}
						else
						{
							print ("<div id='project$proId'>");
							if($attachment != "" AND $attachment != NULL)
							{
							    print ("<img src='$attachment' alt='picture for $project_name'/>");
							}
							print ("<h5>$date</h5><br/><br/>");
							print ("<h1>$project_name</h1><br/>");
							print ("<h4>$type</h4><br/><br/>");
							print ("<p>$description</p>");
							print ("<br/>");
							
						}
						print ("</div>	<!--project close-->");
						
					  break;
				}
			}
		}
		else
		{
			if($i == 2)
			{
				print ("<div id='no_project'>");
			    print ("<h1>There are no projects to display</h1>");
				print ('<img src="./../img/no_proj.png" alt="no project" />');
				print ("</div>");
			}
		}
	}
	catch (Exception $e)
	{
		print("An unexpected error occured.");
	}
	finally 
	{
		//close connection
		$con = NULL;
	}
}

//photo uploads
function UploadNewImage($username)
{
	try
	{
		//open database connection
		$con = Connect();

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$rand_dir_name = substr(str_shuffle($chars), 0, 15);
		mkdir("./../uploads/userdata/user_photos/$rand_dir_name");
		$target_file = "./../uploads/userdata/user_photos/$rand_dir_name/" . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false)
		{
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		}
		else
		{
			echo "File is not an image.";
			$uploadOk = 0;
		}
		// Check if file already exists
		if (file_exists($target_file))
		{
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000)
		{
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" )
		{
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0)
		{
			echo "Sorry, your file was not uploaded.";
		// if everything is okay, try to upload file
		}
		else
		{
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
			{
				/*
				TODO-Add hash for images/add dates

				$date = date("Y-m-d");
				$profile_pic_name = $target_file;
				$img_id_before_md5 = "$rand_dir_name/$profile_pic_name";
				$img_id = md5($img_id_before_md5);
				*/
				$url = "$target_file";
			    $upload = mysqli_query ($con, "UPDATE `collaborate`.`users` SET `profile_pic`='$url' WHERE `username`='$username'");
				if ($upload)
				{
				    header("Location: profile.php?u=$username");
				}
			}
			else
			{
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	catch (Exception $e)
	{
		print("An unexpected error occured.");
	}
	finally
	{
		$con = NULL;
	}
}

//get messages in inbox/outbox/deleted
function GetMessages($messages, $x)
{
	try
	{
		$con = Connect();
		$sub = "";

		if ($get_messages = mysqli_query($con, $messages))
		{
			if($numrows_read = mysqli_num_rows($get_messages) > 0)
			{
				while ($get_msg = mysqli_fetch_assoc($get_messages))
				{
					$id = $get_msg['id'];
					$from_user = $get_msg['from_user'];
					$to_user = $get_msg['to_user'];
					$msg = $get_msg['message'];
					$date = $get_msg['date'];
					$opened = $get_msg['opened'];
					$deleted = $get_msg['recipientDelete'];
					$imgOfUser = mysqli_query ($con, "SELECT `profile_pic` FROM `collaborate`.`users` WHERE `username`='$to_user'");

					if(strlen($msg) < 1)
					{
						$msg = "Empty Message";
					}
					if($imgOfUser)
					{
						$get_pic_row = mysqli_fetch_assoc($imgOfUser);
						
						if($get_pic_row['profile_pic'] != "" )
						{
						    $profile_pic = $get_pic_row['profile_pic'];
						}
						else
							
						{
							$profile_pic = "./../img/no-photo.png";
						}

						switch ($x)
						{
							case '1':
								//display messages to user, toggle functions written in javascript
								//the id is used to find the correct message to restore and delete it
								print ("<div id='draft$id'>");
								print ("<div id='draft'>");
								print ("<input type='image' src='./../img/restore.png' onclick='RestoreMsg($id)' id='delete' name='delete' alt='Restore'><span class='tooltip'>Restore</span>");
								print ("</div>");
								print ("<div id='showMsg' onClick='toggle($id)'>");
								print ("<img src='$profile_pic' alt='Avatar'>");
								print ("<a href='profile.php?u=$to_user'>$to_user</a>");
								print ("<span class='time-right'>$date</span><br/></br/>");
								print ("<div id='toggleText$id' style='display: none;'>");
								print ("<br/>");
								print ("<p>$msg</p>");
								print ("</div>");
								print ("</div>");
								print ("</div>");
							  break;
							default:
								//display messages to user, toggle functions written in javascript
								//the id is used to find the correct message to restore and delete it
								print ("<div id='draft$id'>");
								print ("<div id='draft'>");
								print ("<input type='image' src='./../img/trash.png' onclick='DeleteMsg($id)' id='delete' name='delete' alt='Delete'><span class='tooltip'>Delete</span>");
								print ("</div>");
								print ("<div id='showMsg' onClick='toggle($id)'>");
								print ("<img src='$profile_pic' alt='Avatar'>");
								print ("<a href='profile.php?u=$to_user'>$to_user</a>");
								print ("<span class='time-right'>$date</span><br/></br/>");
								print ("<div id='toggleText$id' style='display: none;'>");
								print ("<br/>");
								print ("<p>$msg</p>");
								print ("</div>");
								print ("</div>");
								print ("</div>");
							  break;
						}
					}
				}
			}
			else
			{
				//display empty message to user based upon which message screen they are on
				switch ($x) {
					case '0'://inbox
							print ("<img class='empty' src='./../img/inbox_over.png' alt='No Messages' />");
							print ("<h2>Inbox Empty</h2>");
							print ('<div id="hr"></div>');
							print ("<br/><br/>");
						break;
					case '1'://deleted
							print ("<img class='empty' src='./../img/inbox_over.png' alt='No Messages' />");
							print ("<h2>No erased messages</h2>");
							print ('<div id="hr"></div>');
							print ("<br/><br/>");
						break;
					default: //sent
							print ("<img class='empty' src='./../img/inbox_over.png' alt='No Messages' />");
							print ("<h2>Your sent box is empty</h2>");
							print ('<div id="hr"></div>');
							print ("<br/><br/>");
						break;
				}
			}
		}
		else
		{
			print ("Sorry, an error occured while trying to connect.");
		}
	}
	catch (Exception $e)
	{
		  print("An unexpected error occured.");
	}
	finally 
	{
		$con = NULL;
	}
}

//options for search bar and filters
function ShowFilter()
{
    //arrays to iterate through for options
    $states = array("none","Alabama","Alaska","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts");
    $states2 = array("Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma");
    $states3 = array("Oregon","Pennsylvania","Rhode Island","South Carolina","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
	$category = array("None","Music","Art","Apps","Web","Writing","Building","Growing","Other");
    //filter for search area to find relavant projects using a search bar and optional drop down
    print ('<br/>');
    print ('<div id="refine">');
    print ('<div class="search_bar">');
	print ('<form action="home.php" method="get" id="search">');
	print ('<input type="text" name="mysqli_query" placeholder="Search ">');
	print ('<input type="image" src="./../img/search.png" alt="Submit" name="submit">');
    print ('</form><br/>');
    print ('</div>');
	print ("<span id='adv' onclick='Advance()'>Advanced</span>");
	print ("<span id='clr' onclick='CLR()'>Close</span>");
    print ('<div id="hr"></div>');
    print ('<div id="filter-people">');
    print ('<a href="otherusers.php"><h1>People</h1></a>');
    print ('</div>');
    print ('<div id="hr"></div>');
    print ('<div id="filter-state">');
    print ('<form method="post" action="home.php">');
    print ('<label for="state-choice">State</label><br/>');
    print ('<select name="state-choice">');
	foreach ($states as $value)
    {
        print("<option value='$value'>$value</option>");
    }
    foreach ($states2 as $value2) 
	{
        print("<option value='$value2'>$value2</option>");
    }
	foreach ($states3 as $value3) 
	{
		print("<option value='$value3'>$value3</option>");
	}
	print ('</select><br/> <br/>');
    print ('<label for="Choices">Select a Category</label><br/>');
	print ('<select name="Choices">');
    foreach ($category as $value4) 
	{
        print("<option value='$value4'>$value4</option>");
    }
	print ('</select>');
    print ('<button name="state">Refine</button>');
    print ('</form>');
    print ('</div><br/><br/>');
    print ('<div id="hr"></div>');
    print ('</div><br/>');
    
}

//update users information POST from form in change_bio.php
function UpdateUser()
{
	try
	{
		$con = Connect();
        $username = $_SESSION["username"];
		$fname = test_input($_POST["fname"]);
		$lname = test_input($_POST["lname"]);
		$city = test_input($_POST["city"]);
		$state = test_input($_POST["state"]);
		$interests = test_input($_POST["interests"]);
		$hobbies = test_input($_POST["hobbies"]);
		$bio = test_input($_POST["description"]);
		//update the users profile
		$desc = "UPDATE `collaborate`.`users` SET `first_name`='$fname',`last_name`='$lname',`bio`='$bio',`interest`='$interests',`hobbies`='$hobbies',`city`='$city',`state`='$state' WHERE `username`='$username'";
		if($description = mysqli_query($con, $desc))
		{	
			//redirect user to their profile
			header("Location: profile.php?u=$username");
		}
		else
		{
			die("Connection failed: " . mysqli_connect_error());
		}
	}
	catch (Exception $e)
	{
        print("An unexpected error occured.");
	}
	finally
	{
		$con = NULL;
	}
}

//display body depending on session and log in
function ShowBody($k)
{
	if(isset($_SESSION['username']))
	{
		  $username = $_SESSION['username'];
		  $pic = $_SESSION['get_user_pic'] ;
	}
	switch ($k) 
	{
		case '0':
			print ("<body>");
			print ("<div id='headerMenu'>");
			print ("<div id='menu'>");
			print ("<div id='logo'>");
			print ("Collaborate");
			print ("</div>");
			print ("</div>");
			print ("</div>");
		  break;
		case '1':
			print ("<body>");
			print ("<div id='headerMenu'>");
			print ("<div id='menu'>");
			print ("<div id='logo'>");
			print ("Collaborate");
			print ("</div>");
			if(basename($_SERVER["PHP_SELF"]) == "home.php" || basename($_SERVER["PHP_SELF"]) == "otherusers.php")
			{
				print ('<div id="search_bar2">');
				print ("<div id='img'>");
				print ('<input type="image" id="search_img" src="./../img/search.png" onclick="SearchBar()"><span class="tooltip">Search</span>');
				print ("</div>");
				print ('<div id="form">');
				print ('<form action="#" method="get" id="search">');
				print ('<input type="text" name="mysqli_query" placeholder="Search">');
				print ('<input type="image" id="search_img2" src="./../img/search2.png" alt="Submit" name="submit">');
				print ('</form>');
				print ("</div>");
			    print ('</div>');
			}
			print ("<div id='img8'>");
			print ('<input type="image" id="" src="./../img/back.png" onclick="SearchBar()">');
			print ('</div>');
			print ("<div class='menuItem'>");
			print ("<div id='hideMenu'>");
	        print ("<a href='home.php' onmouseover='HomeOver()' onmouseout='HomeOut()' ><img id='home3' src='./../img/home_2.png' alt='Home' /><h3>Home</h3></a>");
			print ("<a href='inbox.php' onmouseover='InboxOver()' onmouseout='InboxOut()'><img id='inbox_icon3' src='./../img/inbox2.png' alt='Inbox' /><h3>Inbox</h3></a>");
			print ("<a href='profile.php?u=$username' ><img id='pic3' src='$pic' alt='$username'/></a>");
			print ("</div>");
			print ("<div class='dropdown2'>");
			print ('<input type="image" src="./../img/hamburger.png" id="dropbtn" onclick="DropDown()">');
			print ('<div id="dropdown-content">');
			print ("<a href='otherusers.php'><img id='icon' src='./../img/no-photo3.png' alt='Other Users'/><span id='txt'>People</span></a>");
			print ("<hr id='hr'/>");
			print ("<a href='user_form.php?u=$username'><img id='icon' src='./../img/settings.png' alt='Logout'/><span id='txt'>Settings</span></a>");
			print ("<hr id='hr'/>");
			print ("<a href='logout.php'><img id='icon' src='./../img/signout.png' alt='Logout'/><span id='txt'>Logout</span></a>");
			print ('</div>');
			print ("</div>");
			print ("</div>");
			print ("<div class='dropdown'>");
			print ('<input type="image" src="./../img/hamburger.png" id="dropbtn2" onclick="DropDown2()">');
			print ('<div id="dropdown-content2">');
			print ("<div id='drp-menu'>");
			print ("<a href='profile.php?u=$username' ><img src='$pic' alt='$username'/></a>");
			print ('</div>');
			print ("<a href='home.php'><img id='icon' src='./../img/home.png' alt='Home' /><span id='txt'>Home</span></a>");
			print ("<hr id='hr'/>");
			print ("<a href='inbox.php'><img id='icon' src='./../img/inbox.png' alt='Inbox' /><span id='txt'>Inbox</span></a>");
			print ("<hr id='hr'/>");
			print ("<a href='otherusers.php'><img id='icon' src='./../img/no-photo3.png' alt='Other Users'/><span id='txt'>People</span></a>");
			print ("<hr id='hr'/>");
			print ("<a href='user_form.php?u=$username'><img id='icon' src='./../img/settings.png' alt='Settings' /><span id='txt'>Settings</span></a>");
			print ("<hr id='hr'/>");
			print ("<a href='logout.php'><img id='icon' src='./../img/signout.png' alt='Logout'/><span id='txt'>Logout</span></a>");
			print ("</div>");
			print ("</div>");
			print ("</div>");
			print ('</div>');
		  break;
		default:
		    print ("<body >");
			print ("<div id='headerMenu'>");
		    print ("<div id='menu'>");
		    print ("<div id='logo'>");
		    print ("Collaborate");
		    print ("</div>");
		    print ("<div class='menuItem'>");
		    print ("</div>");
		    print ("</div>");
		  break;
	}
}

//footer section
function _html_end()
{
	print ("<br/><br/>");
	print ("<div id='footer'>");
	print ("<small>&copy 2017 - Collaborate</small>");
	print ("</div");
	print ("</div");
	print ("</body>");
	print ("</html>");
}

//Log out user and destroy session data
function LogOut()
{
	session_unset();
	session_destroy();
	header("Location: ./../index.php");
}

//get users profile picture
function GetProfilePic($user)
{
	try
	{
		//open database connection
		$con = Connect();
		//mysqli_query database for image
		$check_pic = "SELECT * FROM `collaborate`.`users` WHERE `username`='$user'";
		if($get_pic = mysqli_query($con, $check_pic))
		{
			$get_pic_row = mysqli_fetch_assoc($get_pic);
			$profile_pic_db = $get_pic_row['profile_pic'];
			print ("<div id='proPic'>");
			print ("<img src='$profile_pic_db' alt='Profile Picture for $user'>");
			print ("</div>");
        }
		else
		{
			print ("<img src='./../img/no-photo.png' alt='No photo to show'  >");
		}
	}
	catch (\Exception $e)
	{
        print("An unexpected error occured.");
	}
	finally
	{
		$con = NULL;
	}
}

//get posts count
function CountPosts()
{
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
	}
	try
	{
		//open database connection
		$con = Connect();
		
		//get count of posts to projects
		$getPost = mysqli_query($con, "SELECT COUNT(*) As `total` FROM `collaborate`.`posts` WHERE `user_posted_to`='$username'");
		$row = mysqli_fetch_assoc($getPost);
		$total = $row['total'];
	}
	catch (\Exception $e)
	{
        print("An unexpected error occured.");
	}
	finally
	{
		//close connection
		$con = NULL;
		
	    return $total;
	}
}

//check to see if messages have been deleted from inbox, sent and drafts
function CountDeleted()
{
	$total = 0;
	
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
	}
	try
	{
		//open database connection
		$con = Connect();
		
		//get count of messages
		$get = "SELECT COUNT(*) As `total` FROM `collaborate`.`pvt_messages` WHERE `from_user`= '$username' AND `senderDelete`='1' OR `to_user` = '$username' AND `recipientDelete`='1'";
		if($getRow = mysqli_query($con, $get))
		{
			$row = mysqli_fetch_assoc($getRow);
			$total = $row['total'];
		}	
	}
	catch (\Exception $e)
	{
        print("An unexpected error occured.");
	}
	finally
	{
		//close connection
		$con = NULL;
	    return $total;
	}
}

//get users bio and information to display
function GetBio($bio)
{
	$user = $first_name = $last_name = $age = $city = $state = $hobbies = $interest = $user_bio = $date = "";
	try
	{
		//open connection
		$con = Connect();
		//mysqli_query database
		$getBio = mysqli_query($con, $bio);

		while($row = mysqli_fetch_assoc($getBio))
		{
			$user = $row['username'];
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$date = $row['age'];
			$user_city_ = $row['city'];
			$user_state_ = $row['state'];
			$hobbies = $row['hobbies'];
			$interest = $row['interest'];
			$bio = $row['bio'];
		}
		$date1 = new DateTime($date);
		$date2 = new DateTime("now");
		$date3 = $date1->diff($date2);
		$age = $date3->y;
		
		print ("<div id='me'>");
		print ("<h1>$first_name&nbsp$last_name</h1><br/><br/>");
		print ("<h3><pre><b>Age</b>:&#09;$age</pre></h3><br/>");
		print ("<h3><pre><b>Location</b>:&#09;$user_city_,&nbsp$user_state_</pre></h3><br/>");
		print ("<h3><b>Hobbies</b>:&nbsp&nbsp&nbsp$hobbies blah blah blah blah blah</h3><br/>");
		print ("<h3><b>Interest</b>:&nbsp&nbsp&nbsp$interest</h3><br/>");
		print ("<h3><b>About Me</b>:&nbsp&nbsp&nbsp$bio</h3>");
		print ("</div>");
		print ("</div><!--profileLeftContent close-->");
		print ("<br/><br/><br/>");
		print ("<form action='send_msg.php?u=$user' method='post'>");
		print ("<button name='sendmsg'>Contact</button>");
		print ("</form>");
		print ("</div><!--Profile close-->");
	}
	catch (\Exception $e)
	{
        print("An unexpected error occured.");
	}
	finally
	{
		//close connection
		$con = NULL;
	}
}

//get comments to show users
function GetPosts($posts)
{
	try
	{
		//open connection to datbase
		$con = Connect();
		
        //mysqli_query database
		$getPost = mysqli_query($con, $posts);
		//loop through columns to set user information
		while($row = mysqli_fetch_assoc($getPost))
		{
			$id = $row['id'];
			$body = $row['body'];
			$time_stamp = $row['date_added'];
			$added_by = $row['added_by'];
			$imgOfUser = mysqli_query($con, "SELECT `user_picture` FROM `collaborate`.`profile_pictures` WHERE `user`='$added_by'");
			$get_pic_row = mysqli_fetch_assoc($imgOfUser);
			$profile_pic_db = $get_pic_row['user_picture'];
			$user_posted_to = $row['user_posted_to'];

			if($profile_pic_db == NULL)
			{
				print ("<div class='con_chat'>");
				print ("<img src='./../img/no-photo.png' alt='Avatar'>");
				print ("<p>$body</p>");
				print ("<span class='time-right'>$time_stamp</span><br/></br/>");
				print ("<span class='delete' onclick=''>Delete</span>");
				print ("</div>");
			}
			else
			{
				print ("<div class='con_chat'>");
				print ("<img src='$profile_pic_db' alt='Avatar'>");
				print ("<p>$body</p>");
				print ("<span class='time-right'>$time_stamp</span><br/></br/>");
				print ("<span class='delete' onclick=''>Delete</span>");
				print ("</div>");
			}

			$total = CountPosts();
			print ("</div><!--profilePosts close-->");
			print ("</div><!--userPosts close-->");
			print ("<div class='chat2'>");
			print ("<div class='chatDiv'>");
			print ("<input type='text' id='post' name='post' placeholder='Comment..'>");
			print ("</div>");
			print ("<div id='subChat'>");
			print ("<button id='buttons' type='submit' onclick='sendPost()' >Post</button>");
			print ("</div>");
			print ("</div>");
			print ("</div><!--user_Content2 close-->");
		}
	}
	catch (Exception $e)
	{
        print("An unexpected error occured.");
	}
    finally
	{
		$con = NULL;
	}
}

//get all user profiles for display 
function OtherUsers($query)
{
	try
	{
		//open database connection
		$con = Connect();
		
		if($getBio = mysqli_query($con, $query))
	    {
			while($row = mysqli_fetch_assoc($getBio))
			{
				$user = $row['username'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$date = $row['age'];
				$city = $row['city'];
				$state = $row['state'];
				$pic = $row['profile_pic'];

				print ("<a href='./profile.php?u=$user'>");
				print ("<div id='profile2'>");
				$date1 = new DateTime($date);
				$date2 = new DateTime("now");
				$date3 = $date1->diff($date2);
				$age = $date3->y;
		
				if ($pic == "")
				{
					print("<div id='proPic4'>");
					print("<img src='./../img/no-photo.png' alt='Profile Picture '  >");
					print("</div>");
				}
				else
				{
					print("<div id='proPic3'>");
					print("<img src='$pic' alt='Profile Picture '>");
					print("</div>");
				}

				print("<div class='profileLeftContent2'>");
				print("<div id='userInfo'>");
				print("<h1>$fname&nbsp$lname</h1><br/>");
				print("<h3>$age</h3><br/>");
				print("<h3>$city,&nbsp$state</h3>");
				print("</div>");
				print("</div>");
				print("</div></a>");
			}
		}
	}
	catch (Exception $e)
	{
        print("An unexpected error occured.");
	}
	finally 
	{
		$con = NULL;
	}
}

//image resize 
function resize_image($file, $w, $h, $crop=FALSE) 
{
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}
?>
