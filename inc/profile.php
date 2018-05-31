<?php
/***********
@Author: Gabriel Rodriguez
Date: 3/8/2018
Page: Profile.php
Project: Collaborate

Profile page for users

2017-2018 Collaborate
This page retrieves data from the database and displays
the users profile. If a user is browsing another persons
profile it will be displayed without editing options.
*************/

    include("header.php");

	if(!isset($_SESSION['username']))
	{
		Header("Location: ./../index.php");
	}
	/*
	Check to see if the person who is currently viewing the page
	is the profile page owner. If not display alternate view without
	edit abilities.
	*/

	if (isset($_GET['u']))
    {
		try
		{
		    //open database connection
		    $con = Connect();
		    //get name from url
		    $user = mysqli_real_escape_string($con, $_GET['u']);
		    if (ctype_alnum($user))
		    {
			//mysqli_query database
			$check = mysqli_query ($con, "SELECT `username`, `profile_pic` FROM `collaborate`.`users` WHERE `username`='$user'");
			//get asscoc data
			if ($get = mysqli_fetch_assoc($check))
			{
			  //set user
			  $user = $get['username'];
			  $user_pic = $get['profile_pic'];
			}
			$con = NULL;
			}
		}
		catch (\Exception $e)
		{
            print("There was an error retreiving the user.");
		}
		//compare user to the current session
		if($username == $user)
		{
			print ("<div id='profileButtons'>");
			print ("<div id='minProfile' onclick='ShowProfile()'>");
			print ("<h1>Profile</h1>");
			print ("</div>");
			print ("<div id='minProject' onclick='ShowProject()'>");
			print ("<h1>Project</h1>");
			print ("</div>");
			print ("</div>");
			print ('<div id="profile">');
			//get the users profile picture
			if($user_pic == "")
			{
				print ("<div id='proPic'>");
				print ("<span onclick='UploadPic()'><img src='./../img/upload_photo.png' alt='Placeholder for user to upload image' ></span>");
				print ("</div>");
				print ("<div id='proPic2'>");
				print ("<br>");
				print ("<form action='#' method='post' enctype='multipart/form-data'>");
				print ("<br>");
				print ("<input type='file' name='fileToUpload' id='fileToUpload'><br><br>");
				print ("<input id='btn' type='submit' name='upload' value='submit'>");
				print ("<small onclick='NoUpload()'>Cancel</small>");
				print ("</form>");
				print ("</div> ");
			}
			else
			{
				print ("<div id='proPic'>");
				print ("<img src='$user_pic' alt='Profile Picture for $username'>");
				print ("</div>");
			}
			//upload profile picture if non exist
			if (isset($_POST['upload']))
			{
				
				UploadNewImage($username);
			}
			print ("<a href='./change_bio.php' ><div class='profileheading2'>");
			print ("Edit");
			print ("</div></a>");
			print ("<div class='profileLeft'>");
			print ("<div id='me'>");
			print ("<h1>$user_fname&nbsp$user_lname</h1><br/><br/>");
			print ("<h3>Age:&nbsp$user_age</h3><br/>");
			print ("<h3>Location:&nbsp$user_city_,&nbsp$user_state_</h3><br/>");
			print ("<h3>Hobbies:&nbsp$user_hobbies</h3><br/>");
			print ("<h3>Interest:&nbsp$user_interest</h3><br/>");
			print ("<h3>More:&nbsp$user_bio</h3>");
			print ("</div>");
			print ("</div> <!--close profileleftcontent-->");
			print ("<br/>");
			if(isset($_POST['sendmsg']))
			{
				header("Location: ");
			}

			print ("</div><!--Close Profile div-->");
		
			print ("</div> ");
			print ("<div class='bgstyle2'>");
			print ("<div id='projectMain'>");
			print("<div class='profileLeftContent'>");

			//get and display the users projects and display them in small window
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$username' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 1);

			print ("</div><!--profileleftcontent close-->");
			print ("<br/>");
			print ("</div><!--projectmain close-->");
			print ("<div class='projects'>");
			print ("<div id='user_content' >");

			//get projects and set them in separate div elements for full display
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$username' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 2);

			print ("</div>	<!--project close-->");
			print ("</div>	<!--user_content close-->");
			print ("<div id='user_content2'>");
			print ("<span id='close' onclick='Close()'><u>Close</u></span>");
			print ("<div id='userposts'>");
			print ("<div id='profilePosts'>");

			//get comments for profile
			$getPost = ("SELECT * FROM `collaborate`.`posts` WHERE `user_posted_to`='$username' ORDER BY `id` DESC LIMIT 10");
			GetPosts($getPost);

			print ("</div><!--projects close-->");
			print ("<br/><br/>");
			print ("</div><!--bgstyle close-->");
			print ("<br/>");
		}
	

		//if the profile being viewed belongs to someone else display this
		else
		{
			$_SESSION['user'] = $user;
			$user_name = $_SESSION['user'];

			print ("<div id='profile'>");
			//get users picture from database
			GetProfilePic($user_name);
			print("<br>");
			print ("<div class='profileLeftContent'>");
			//get users bio from database
			$getBio = ("SELECT * FROM `collaborate`.`users` WHERE `username`='$user'");
			GetBio($getBio);

			print ("<br/>");
			print ("<div class='bgstyle2'>");
			print ("<div id='projectMain'>");
			print ("<div class='profileheading'>");
			print ("<h2 id='bio'>Projects</h2>");
			print ("</div>");
			print ("<br/>");
			print ("<div class='profileLeftContent'>");

			//get and display the users projects and display them in small window
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$username' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 1);

			print ("</div><!--profileleftcontent close-->");
			print ("<br/>");
			print ("</div><!--projectmain close-->");
			print ("<div class='projects'>");
			print ("<div id='user_content' >");

			//get projects and set them in separate div elements for full display
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$username' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 2);

			print ("</div>	<!--project close-->");
			print ("</div>	<!--user_content close-->");
			print ("<div id='user_content2'>");
			print ("<span id='close' onclick='Close()'><u>Close</u></span>");
			print ("<div id='userposts'>");
			print ("<div id='profilePosts'>");

			//get comments for profile
			//get comments for profile
			$getPost = ("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10");
			GetPosts($getPost);

			print ("</div><!--projects close-->");
			print ("<br/><br/>");
			print ("</div><!--bgstyle close-->");
			print ("<br/>");
		}
	}

    _html_end();
?>
