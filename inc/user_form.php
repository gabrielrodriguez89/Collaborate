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
    $states = array("Alabama","Alaska","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts");
    $states2 = array("Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma");
    $states3 = array("Oregon","Pennsylvania","Rhode Island","South Carolina","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");

	$time = new DateTime('now');
    $newtime = $time->modify('-13 year')->format('Y-m-d');

	print ("<!--Form to gather user information for profile-->");
	if(!isset($_GET['u']))
	{
		print("<br/>");
		print("<div class='bgstyle'>");
		print("<div id='newUser'>");
		print("<div id='newUser2'>");
		print("<h1>Profile Information</h1><br/>");
		print("<form action='new_user_form.php' method='POST' enctype='multipart/form-data'>");
		print("<span class='err'>*</span>Birthday<br/>");
		print("<input type='date' name='age' max='$newtime' title='You must be 13 years of age to register' required><span class='err'><?php echo $ageErr;?></span><br/><br/>");
		print("<label for='city'><span class='err'>*</span> City</label>");
		print("<input type='text' name='city' placeholder='City' required><span class='err'><?php echo $cityErr;?></span><br/><br/>");
		print("<label for='state'><span class='err'>*</span> State</label>");
		print('<input list="type" name="state" placeholder="State" required><span class="err"><?php echo $stateErr;?></span><br/><br/><datalist id="type">');
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
		print("</datalist>");
		print ("<input type='file' name='fileToUpload' id='fileToUpload' ><br/><br/>");
		print("<label for='interests'>Interests</label>");
		print("<textarea name='interests' rows='2' placeholder='Tell us about you interests' ></textarea><br /><br />");
		print("<label for='hobbies'>Hobbies</label>");
		print("<textarea name='hobbies' placeholder='What are a few of your hobbies' ></textarea><br /><br />");
		print("<label for='description'>Description</label>");
		print("<textarea name='description' placeholder='Introduce yourself to the other users' ></textarea><br /><br />");
		print("<input id='btn' type='submit' name='about' value='Submit' >");
		print("</form>");
		print("</div>");
		print("</div>");
		print("</div>");
	}
	else
	{
		try
		{
			//open database connection
            $con = Connect();
			//statement contruction
			$user = mysqli_real_escape_string($con, $_GET['u']);
			//check username to assure digits and letters only
			if (ctype_alnum($user))
			{
				print("<br/>");
				print("<div class='bgstyle'>");
				print("<div id='opt'>");
				print('<button onclick="Update()"><img src="./../img/no-photo.png" ><h3>Update Profile</h3></button><br/><br/>');
				print('<button onclick="CloseAccount()"><img id="secure" src="./../img/secure.png" ><h3>Close Account</h3></button>');
				print("</div>");
				print("<div id='opt-2'>");
				print("<div id='newUser'>");
				print("<div id='newUser2'>");
				print("<h1>Profile Update</h1><br/>");
				print("<form action='update_user_form.php' method='POST' >");
				print("<label for='fname'>First Name</label>");
				print("<input type='text' name='fname' value='$first_name' required/><br/><br/>");
				print("<label for='lname'>Last Name</label>");
				print("<input type='text' name='lname' value='$last_name' required/><br/><br/>");
				print("<label for='email'>Email</label>");
				print("<input type='text' name='email' value='$email' required/><br/><br/>");
				print("<label for='age'>Birthday</label>");
				print("<input type='date' name='age' value='$age' required/><br/><br/>");
				print("<label for='city'>City</label>");
				print("<input type='text' name='city' value='$user_city_' required/><br/><br/>");
				print("<label for='state'>State</label>");
				print("<input type='text' name='state' value='$user_state_' required/><br/><br/>");
				print("<input id='btn' type='submit' name='about' value='Submit' >");
				print("</form>");
				print("</div>");
				print("</div>");
				print("</div>");
				print("<div id='opt-3'>");
				print("<h1>Close account and delete your profile information.</h1>");
				print('<hr id="hr"/>');
				print("<form action='del_user.php?u=$user' method='POST' >");
				print("<button type='submit'>Close Account</button>");
				print("</form>");
				print("</div>");
				print("</div>");

			}
		}
		catch(\Exception $e)
		{
			print("OOPS.... An error occured.");
		}
	}
	
	_html_end();
?>
