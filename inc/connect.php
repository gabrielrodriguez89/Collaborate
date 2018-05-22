<?php
/*
@Auther: Gabriel Rodriguez
Page: Connect
Project: collaborate
Date: 3/6/2018

Connect.php was created to maintain all of the functions used in the Collaborate website 2017-2018

*/
session_start();

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
		//mysqli_query database
		$getProject = mysqli_query($con, $project);
		//try parsing mysqli_query
		if($getProject)
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

						//if there is no image for the project print this, else print this
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
							    print ("<img src='$attachment' alt='picture for $project_name'/><br/>");
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
						if($attachment == '')
						{
							print ("<div id='showPro$proId' onclick='Show($proId)'>");
							print ("<h1>$project_name</h1><br/>");
							print ("<h2>$type</h2><br/>");
							print ("</div><br/>");
						}
						else
						{
							print ("<div id='showPro$proId' onclick='Show($proId)'>");
							print ("<img src='$attachment' alt='$attachment'/>");
							print ("<h1>Name: $project_name</h1><br/>");
							print ("<h1>Type: $type</h1>");
							print ("</div><br/>");
						}
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
							    print ("<img src='$attachment' alt='picture for $project_name'/><br/>");
							}
							print ("<h5>$date</h5><br/>");
							print ("<h1>$project_name</h1><br/>");
							print ("<h4>$type</h4><br/><br/>");
							print ("<p>$description</p>");
							print ("<br/>");
						}
						print ("<div class='chat'>");
						print ("<div class='chatDiv'>");
						print ("<input type='text' id='post' name='post' placeholder='Comment..'>");
						print ("</div>");
						print ("<div id='subChat'>");
						print ("<button id='buttons' type='submit' onclick='sendPost($proId)' >Post</button>");
						print ("</div>");
						//get count of comments on projects
						$total = CountPosts();

						print ("<small id='openComment' onclick='Comments()'>Comments $total</small>");
						print ("</div>	<!--chat close-->");
					  break;
				}
			}
		}
	}
	catch (Exception $e)
	{
		//TODO catch statement log
	}
	//close connection
	$con = NULL;
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
		//close connection
		$con = NULL;
	}
	catch (Exception $e)
	{
		//TODO add log for exceptions
	}
}

//get messages in inbox/outbox/deleted
function GetMessages($grab_messages, $x)
{
	try
	{
		$con = Connect();
        $get_messages = mysqli_query($con, $grab_messages);
		$sub = "";

		if ($get_messages)
		{
			$numrows_read = mysqli_num_rows($get_messages);
			while ($get_msg = mysqli_fetch_assoc($grab_messages))
			{
				$id = $get_msg['id'];
				$from_user = $get_msg['from_user'];
				$to_user = $get_msg['to_user'];
				$msg = $get_msg['message'];
				$date = $get_msg['date'];
				$opened = $get_msg['opened'];
				$deleted = $get_msg['recipientDelete'];
				$imgOfUser = mysqli_query ($con, "SELECT `user_picture` FROM `collaborate`.`profile_pictures` WHERE `user`='$from_user'");

				if(strlen($msg) < 1)
				{
					//skip umpty messages
				}
				else
				{
					if($imgOfUser)
					{
						$get_pic_row = mysqli_fetch_assoc($imgOfUser);
						$profile_pic = $get_pic_row['user_picture'];

						switch ($x)
						{
							case '1':
								//display messages to user, toggle functions written in javascript
								//the id is used to find the correct message to restore and delete it
								print ("<div id='$id'>");
								print ("<div id='showMsg' onClick='toggle($id)'>");
								print ("<img src='$profile_pic' alt='Avatar'>");
								print ("<a href='$from_user'>$from_user</a>");
								print ("<span class='time-right'>$date</span><br/></br/>");
								print ("<input id='restore' name='restore' type='text' value='$id' hidden>");
								print ("<button onclick='RestoreMsg()' id='delete' name='delete'>Restore</button>");
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
								print ("<div id='$id'>");
								print ("<div id='showMsg' onClick='toggle($id)'>");
								print ("<img src='$profile_pic' alt='Avatar'>");
								print ("<a href='$from_user'>$from_user</a>");
								print ("<span class='time-right'>$date</span><br/></br/>");
								print ("<input id='erase' name='erase' type='text' value='$id' hidden>");
								print ("<button onclick='DeleteMsg()' id='delete' name='delete'>Delete</button>");
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
		}
		else
		{
			//display empty message to user based upon which message screen they are on
			switch ($x) {
				case '0'://inbox
						print("&nbsp;&nbsp;&nbsp;Inbox Empty");
						print ("<div class='hr'></div>");
						print ("<br/><br/>");
					break;
				case '1'://deleted
						print ("&nbsp;&nbsp;&nbsp;Read Messages Empty");
						print ("<div class='hr'></div>");
						print ("<br/><br/>");
					break;
				default: //sent
						print ("&nbsp;&nbsp;&nbsp;Sent Messages Empty");
						print ("<div class='hr'></div>");
						print ("<br/><br/>");
					break;
			}
		}
	    //close connection
		$con = NULL;
	}
	catch (Exception $e)
	{
		  //TODO add log for catch statement
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
	print("<span id='adv' onclick='Advance()'>Advanced</span>");
	print("<span id='clr' onclick='CLR()'>Close</span>");
    print ('<div class="hr"></div>');
    print ('<div id="filter-people">');
    print ('<a href="otherusers.php"><h1>People</h1></a>');
    print ('</div>');
    print ('<div class="hr"></div>');
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
    print ('<div class="hr"></div>');
    print ('</div><br/>');
    print ('<div class="bgstyle">');
}
//update users information POST from form in change_bio.php
function UpdateUser()
{
	try
	{
		$con = Connect();

		$fname = test_input($_POST["fname"]);
		$lname = test_input($_POST["lname"]);
		$age = test_input($_POST["age"]);
		$city = test_input($_POST["city"]);
		$state = test_input($_POST["state"]);
		$interests = test_input($_POST["interests"]);
		$hobbies = test_input($_POST["hobbies"]);
		$bio = test_input($_POST["description"]);
		//update the users profile
		$description = mysqli_query ($con, "UPDATE `collaborate`.`users` SET `first_name`='$fname',`last_name`='$lname',`bio`='$bio',`interest`='$interests',`hobbies`='$hobbies',`age`='$age',`city`='$city',`state`='$state' WHERE `username`='$username'");
		if($description)
		{
			//re-establish session data so information is correct
			$sql = mysqli_query ($con, "SELECT * FROM `collaborate`.`users` WHERE `username`='$username' LIMIT 1");
			SetUser($sql);
			//redirect user to their profile
			header("Location: $username");
		}
		else
		{
			die("Connection failed: " . mysqli_connect_error());
		}
	}
	catch (Exception $e)
	{

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
			print ("<div class='headerMenu'>");
			print ("<div id='menu'>");
			print ("<div class='logo'>");
			print ("<img src='./../img/logo.png'/>");
			print ("</div>");
			print ("</div>");
			print ("</div>");
		  break;
		case '1':
			print ("<body>");
			print ("<div class='headerMenu'>");
			print ("<div id='menu'>");
			print ("<div class='logo'>");
			print ("<img src='./../img/logo.png'/>");
			print ("</div>");
			print ('<div id="search_bar3">');
			print ('<div id="form2">');
			print ('<form action="home.php" method="get" id="search">');
			print ('<input type="text" name="mysqli_query" placeholder="Search">');
			print ('</form>');
			print ("</div>");
			print ('<input type="image" id="img" src="./../img/search.png" alt="Submit" name="submit" onclick="SearchBar2()"><span class="tooltip">Search</span>');
			print ('</div>');
			print ('<div id="search_bar2">');
			print ('<div id="form">');
			print ('<form action="home.php" method="get" id="search">');
			print ('<input type="text" name="mysqli_query" placeholder="Search">');
			print ('</form>');
			print ("</div>");
			print ('<input type="image" id="img" src="./../img/search.png" alt="Submit" name="submit" onclick="SearchBar()"><span class="tooltip">Search</span>');
			print ('</div>');
			print ("<div class='menuItem'>");
			print ("<div id='hideMenu'>");
	        print ("<a href='home.php'  ><img id='home2' src='./../img/home.png' alt='Home' /><span class='tooltip'>Home</span></a>");
			print ("<a href='inbox.php'><img id='inbox_icon2' src='./../img/inbox.png' alt='Inbox' /><span class='tooltip'>Inbox</span></a>");
			print ("<a href='profile.php?u=$username'><img id='pic' src='$pic' alt='$username'/><span class='tooltip'>Profile</span></a>");
			print ("</div>");
			print ("<div class='dropdown2'>");
			print ('<input type="image" src="./../img/settings.png" id="dropbtn"  onclick="DropDown()">');
			print ('<div id="dropdown-content">');
			print ("<a href='manage_account.php'  ><img id='manage' src='./../img/settings_hover.png' alt='Settings' /><span class='tooltip2'>Settings</span></a>");
			print ("<a href='logout.php' ><img id='signout2' src='./../img/signout_hover.png' alt='Logout'/><span class='tooltip2'>Logout</span></a>");
			print ('</div>');
			print ("</div>");
			print ("</div>");
			print ("<div class='dropdown'>");
			print ('<input type="image" src="./../img/hamburger.png" id="dropbtn2" onclick="DropDown2()">');
			print ('<div id="dropdown-content2" >');
			print ('<div id="nav" >');
			print ("<a href='home.php'  ><img id='home2' src='./../img/home.png' alt='Home' /><h4>Home</h4></a>");
			print ("<hr/>");
			print ("<a href='inbox.php'><img id='inbox_icon2' src='./../img/inbox.png' alt='Inbox' /><h4>Inbox</h4></a>");
			print ("<hr/>");
			print ("<a href='profile.php?u=$username'><img id='pic2' src='$pic' alt='$username'/><h4>Profile</h4></a>");
			print ("<hr/>");
			print ("<a href='manage_account.php'  ><img id='manage2' src='./../img/settings.png' alt='Settings' /><h3>Settings</h3></a>");
			print ("<hr/>");
			print ("<a href='logout.php' ><img id='signout2' src='./../img/signout.png' alt='Logout'/><h4>Logout</h4></a>");
			print ('</div>');
			print ("</div>");
			print ("</div>");
			print ("</div>");
			print ('</div>');
		  break;
		default:
		    print ("<body onload='read()''>");
			print ("<div class='headerMenu'>");
		    print ("<div id='menu'>");
		    print ("<div class='logo'>");
		    print ("<img src='img/logo.png'/>");
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
		$check_pic = mysqli_query($con, "SELECT user_picture FROM profile_pictures WHERE user='$user'");
		$get_pic_row = mysqli_fetch_assoc($check_pic);
		$profile_pic_db = $get_pic_row['user_picture'];

    //display "NoPhoto.PNG" if user has no photo
		if ($profile_pic_db == NULL)
		{
			//print ("<img src='img/no_photo.png' alt='No photo to show'  >");
			print ("<img src='./../img/no_photo.png' alt='No photo to show'  >");
		}
		else
		{
			$profile_pic = $profile_pic_db;
			print ("<div id='proPic'>");
			print ("<img src='$profile_pic' alt='Profile Picture for $user'  >");
			print ("</div>");
		}
		$con = NULL;
	}
	catch (\Exception $e)
	{

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
		//close connection
		$con = NULL;
	}
	catch (\Exception $e)
	{

	}
	return $total;
}
//get users bio and information to display
function GetBio($bio)
{
	$user = $fname = $lname = $age = $city = $state = $hobbies = $interest = $user_bio = "";
	try
	{
		//open connection
		$con = Connect();
		//mysqli_query database
		$getBio = mysqli_query($con, $bio);

		while($row = mysqli_fetch_assoc($getBio))
		{
			$user = $row['username'];
			$fname = $row['first_name'];
			$lname = $row['last_name'];
			$age = $row['age'];
			$city = $row['city'];
			$state = $row['state'];
			$hobbies = $row['hobbies'];
			$interest = $row['interest'];
			$user_bio = $row['bio'];
		}
		print ("<div id='me'>");
		print ("<h1>$fname&nbsp$lname</h3><br/><br/>");
		print ("<h3>Age:&nbsp$age</h3><br/>");
		print ("<h3>Location:&nbsp$city,&nbsp$state</h3><br/>");
		print ("<h3>Hobbies:&nbsp$hobbies</h3><br/>");
		print ("<h3>Interest:&nbsp$interest</h3><br/>");
		print ("<h3>More:&nbsp$user_bio</h3>");
		print ("</div>");
		print ("</div><!--profileLeftContent close-->");
		print ("<br/>");
		print ("<form action='send_msg.php?u=$user' method='post'>");
		print ("<button  name='sendmsg'>Contact</button>");
		print ("</form>");
		print ("</div><!--Profile close-->");
	}
	catch (\Exception $e)
	{

	}
	//close connection
	$con = NULL;
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
				print ("<img src='./../img/no_photo.png' alt='Avatar'>");
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

	}

}
function OtherUsers($query)
{
	$con = Connect();
	try
	{
		if($getBio = mysqli_query($con, $query))
	    {
			while($row = mysqli_fetch_assoc($getBio))
			{
				$user = $row['username'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$age = $row['age'];
				$city = $row['city'];
				$state = $row['state'];
				$pic = $row['profile_pic'];

				print ("<a href='$user?u=$user'>");
				print ("<div id='profile2'>");

				if ($pic == "")
				{
					print("<div id='proPic3'>");
					print("<img src='./../img/no_photo.png' alt='Profile Picture '  >");
					print("</div>");
				}
				else
				{
					print("<div id='proPic3'>");
					print("<img src='$pic' alt='Profile Picture '>");
					print("</div>");
				}

				print("<div class='profileLeftContent'>");
				print("<div id='userInfo'>");
				print("<h1>$fname&nbsp$lname</h1><br/><br/>");
				print("<h3>$age&nbsp&nbsp&nbsp$city,&nbsp$state</h3>");
				print("<br><br>");
				print("</div>");
				print("</div>");
				print("</div></a>");
			}
		}
	}
	catch (Exception $e)
	{

	}
}
?>