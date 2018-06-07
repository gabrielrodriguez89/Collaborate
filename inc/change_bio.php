<?php
/*
@Author: Gabriel Rodriguez
Page: Change Bio
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
display form to user to allow them to change profile information

*/
 	include "header.php";
	if(!isset($_SESSION['username']))
	{
		Header("Location: index.php");
	}

	print ("<br/>");
	print ("<div class='bgstyle'>");
	print ("<div id='changeAbout'>");
	print ("<div id='changeAbout2'>");
	print ("<h1>Edit Profile Information</h1><br/>");
	print ("<form action='#' method='POST'>");
	print ("<label for='fname'>First Name</label>");
	print ("<input type='text' name='fname' value='$user_fname'/><br/><br/>");
	print ("<label for='lname'>Last Name</label>");
	print ("<input type='text' name='lname' value='$user_lname'/><br/><br/>");
	print ("<label for='age'>Age</label>");
	print ("<input type='date' name='age' value='$user_age' /><br/><br/>");
	print ("<label for='city'>City</label>");
	print ("<input type='text' name='city' value='$user_city_'/><br/><br/>");
	print ("<label for='state'>State</label>");
	print ("<input type='text' name='state' value='$user_state_'/><br/><br/>");
	print ("<label for='interests'>Interests</label>");
	print ("<textarea name='interests' placeholder='$user_interest' >$user_interest</textarea><br /><br />");
	print ("<label for='hobbies'>Hobbies</label>");
	print ("<textarea name='hobbies' placeholder='$user_hobbies' >$user_hobbies</textarea><br /><br />");
	print ("<label for='description'>Describe Yourself</label>");
	print ("<textarea name='description' placeholder='$user_bio' >$user_bio</textarea><br /><br />");
	print ("<input id='btn' onclick='changeAbout()' type='submit' name='about' value='Save' />");
	print ("<a href='./profile.php?u=$username'>Cancel</a>");
	print ("</form>");
	print ("</div>");
	print ("</div>");
	print ("</div>");
	print ("");

//update session values
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        UpdateUser();
    }
    _html_end();
?>
