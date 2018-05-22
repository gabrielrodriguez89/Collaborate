<?php
/*
@Author: Gabriel Rodriguez
Page: New User Form
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
The form below is used to get basic information
about the user in order to set up a profile.

*/

    include("header.php");

	if(!isset($_SESSION['username']))
	{
		Header("Location: ./../index.php");
	}
    //declarations
	$ageErr = $cityErr = $stateErr = "";

    //strip and check user input
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST["age"]))
		{
			$ageErr = "Age is required";
		}
		else
		{
			$age = test_input($_POST["age"]);
		}
		if (empty($_POST["city"]))
		{
			$cityErr = "Enter your city";
		}
		else
		{
			$city = test_input($_POST["city"]);
		}
		if (empty($_POST["state"]))
		{
			$stateErr = "Enter the State";
		}
		else
		{
			$state = test_input($_POST["state"]);
		}
	    if (empty($_POST["interests"]))
		{
			$interests = "none";
		}
		else
		{
			$interests = test_input($_POST["interests"]);
		}
		if (empty($_POST["hobbies"]))
		{
			$hobbies = "none";
		}
		else
		{
			$hobbies = test_input($_POST["hobbies"]);
		}
		if(empty($_POST["description"]))
		{
			$bio = "none";
		}
		else
		{
			$bio = test_input($_POST["description"]);
		}
		try
		{
			$con = Connect();

			$description = mysqli_query ($con, "UPDATE `collaborate`.`users` SET `bio`='$bio',`interest`='$interests',`hobbies`='$hobbies',`age`='$age',`city`='$city',`state`='$state',`profile_pic`='NULL' WHERE username='$username'");
			if($description)
			{
				header("Location: ./home.php");
			}
   
			$con = NULL;
		}
		catch (\Exception $e)
		{

		}
		
	}
	$time = new DateTime('now');
    $newtime = $time->modify('-13 year')->format('Y-m-d');

echo "<!--
Form to gather user information for profile
-->";
	print("<br/>");
	print("<div class='bgstyle'>");
    print("<div id='newUser'>");
	print("<div id='newUser2'>");
	print("<h1>Profile Information</h1><br/>");
	print("<form action='new_user_form.php' method='POST' >");
	print("<span class='err'>*</span> Age<br/>");
	print("<input type='date' name='age' max='$newtime' title='You must be 13 years of age to register' required><span class='err'><?php echo $ageErr;?></span><br/><br/>");
	print("<label for='city'><span class='err'>*</span> City</label>");
	print("<input type='text' name='city' placeholder='City' required><span class='err'><?php echo $cityErr;?></span><br/><br/>");
	print("<label for='state'><span class='err'>*</span> State</label>");
	print("<input type='text' name='state' placeholder='State' required><span class='err'><?php echo $stateErr;?></span><br/><br/>");
	print("<label for='interests'>Interests</label>");
	print("<textarea name='interests' rows='2' placeholder='Tell us about you interests' ></textarea><br /><br />");
	print("<label for='hobbies'>Hobbies</label>");
	print("<textarea name='hobbies' placeholder='What are a few of your hobbies' ></textarea><br /><br />");
	print("<label for='description'>Description</label>");
	print("<textarea name='description' placeholder='Introduce yourself to the other users' ></textarea><br /><br />");
	print("<input type='submit' name='about' value='Submit' >");
	print("</form>");
	print("</div>");
	print("</div>");
    print("</div>");
	
	_html_end();
?>
