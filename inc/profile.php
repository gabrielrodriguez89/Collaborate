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
			print ("<img src='./../img/no-photo2.png' alt='profile' id='pro-ico'/><h1>Profile</h1>");
			print ("</div>");
			print ('<hr id="hr2"/>');
			print ("<div id='minProject' onclick='ShowProject()'>");
			print ("<img src='./../img/project.png' alt='project' id='proj-ico'/><h1>Projects</h1>");
			print ("</div>");
			print ("</div>");
			print ('<div id="profile">');
			//get the users profile picture
			if($get_user_pic == "")
			{
				print ("<div id='proPic'>");
				print ("<span onclick='UploadPic()'><img src='./../img/no-photo.png' alt='Placeholder for user to upload image' ></span>");
				print ("</div>");
			
			}
			else
			{
				
				print ("<div id='proPic'>");
				print ("<img src='$get_user_pic' alt='Profile Picture for $username' onclick='UploadPic()'><span class='tooltip'>Change Photo</span>");
				print ("</div>");
			}
			print ("<div id='proPic2'>");
			print ("<br/>");
			print ("<form action='#' method='post' enctype='multipart/form-data'>");
			print ("<input type='file' name='fileToUpload' id='fileToUpload'><br/><br/>");
			print ("<input id='btn' type='submit' name='upload' value='Save'>");
			print ("<br/><br/><small onclick='NoUpload()'>Cancel</small>");
			print ("</form>");
			print ("</div> ");
			//upload profile picture if non exist
			if (isset($_POST['upload']))
			{
				UploadNewImage($username);
			}
			print ("<a href='./change_bio.php' ><div class='profileheading2'>");
			print ("<img id='Edit' src='./../img/Edit.gif' alt='Edit' /><h3>Edit</h3>");
			print ("</div></a>");
			print ("<div class='profileLeft'>");
			print ("<div id='me'>");
			print ("<h1>$first_name&nbsp$last_name</h1><br/><br/>");
			print ("<h3><pre><b>Age</b>:&#09;$age</pre></h3><br/>");
			print ("<h3><pre><b>Location</b>:&#09;$user_city_,&nbsp$user_state_</pre></h3><br/>");
			print ("<h3><b>Hobbies</b>:&nbsp&nbsp&nbsp$hobbies</h3><br/>");
			print ("<h3><b>Interest</b>:&nbsp&nbsp&nbsp$interest</h3><br/>");
			print ("<h3><b>About Me</b>:&nbsp&nbsp&nbsp$bio</h3>");
			print ("</div>");
			print ("</div> <!--close profileleftcontent-->");
			print ("<br/>");
			if(isset($_POST['sendmsg']))
			{
				header("Location: ");
			}

			print ("</div><!--Close Profile div-->");
		
			print ("</div> ");
			print ('<div id="projectheading">');
			print ('<h1>Projects</h1>');
			print ('</div>');
			print ("<div id='bgstyle2'>");
			print ("<div id='projectMain'>");
			print ("<div class='profileLeftContent'>");
			
		    $total = CountPosts();
			//remove option to add project if limit reached
			if(!$total >= 5)
			{
				print ('<a href="create_project.php"><div id="add">');
				print ('<img id="" src="./../img/add.gif" alt="Add" /><h3>Add</h3>');
				print ('</div></a>');
				print ('<hr id="hr"/>');
			}
		
			//get and display the users projects and display them in small window
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$username' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 1);

			print ("</div><!--profileleftcontent close-->");
			print ("<br/>");
			print ("</div><!--projectmain close-->");
			print ("<div class='projects'>");
			print ("<div id='user_content'>");

			//get projects and set them in separate div elements for full display
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$username' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 2);

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
			print ("<div id='profileButtons'>");
			print ("<div id='minProfile' onclick='ShowProfile()'>");
			print ("<img src='./../img/no-photo2.png' alt='profile' id='pro-ico'/><h1>Profile</h1>");
			print ("</div>");
			print ('<hr id="hr2"/>');
			print ("<div id='minProject' onclick='ShowProject()'>");
			print ("<img src='./../img/project.png' alt='project' id='proj-ico'/><h1>Projects</h1>");
			print ("</div>");
			print ("</div>");
			print ("<div id='profile'>");
			//get users picture from database
			GetProfilePic($user_name);
			print("<br>");
			print ("<div class='profileLeft'>");
			//get users bio from database
			$getBio = ("SELECT * FROM `collaborate`.`users` WHERE `username`='$user_name'");
			GetBio($getBio);

			print ("<br/>");
			print ('<div id="projectheading">');
			print ('<h1>Projects</h1>');
			print ('</div>');
			print ("<div id='bgstyle2'>");
			print ("<div id='projectMain'>");
			print ("<div class='profileLeftContent'>");

			//get and display the users projects and display them in small window
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$user_name' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 1);

			print ("</div><!--profileleftcontent close-->");
			print ("<br/>");
			print ("</div><!--projectmain close-->");
			print ("<div class='projects'>");
			print ("<div id='user_content' >");

			//get projects and set them in separate div elements for full display
			$getProject = ("SELECT * FROM `collaborate`.`projects` WHERE `username`='$user_name' ORDER BY `id` LIMIT 5");
			GetProject($getProject, 2);

			print ("</div>	<!--project close-->");
			print ("</div>	<!--user_content close-->");
			print ("<div id='user_content2'>");
			print ("<span id='close' onclick='Close()'><u>Close</u></span>");
			print ("<div id='userposts'>");
			print ("<div id='profilePosts'>");

			//get comments for profile
			//get comments for profile
			$getPost = ("SELECT * FROM posts WHERE user_posted_to='$user_name' ORDER BY id DESC LIMIT 10");
			GetPosts($getPost);

			print ("</div><!--projects close-->");
			print ("<br/><br/>");
			print ("</div><!--bgstyle close-->");
			print ("<br/>");
		}
	}

    _html_end();
?>
