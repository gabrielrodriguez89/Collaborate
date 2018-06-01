<?php
/*
@Author: Gabriel Rodriguez
Page: Change Bio
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
display form to user to allow them to change profile information
TODO
* allow user to change profile colors to customize experience.
* Add functionality to delete account
* All new account settings will be added here
*/

    include "header.php";

	if(!isset($_SESSION['username']))
	{
		Header("Location: index.php");
	}

	print ("<div class='bgstyle'>");
	print ("<div class='color-changing'>");
	print ("<form id='account' action='#' method='post' enctype='multipart/form-data'>");
	print ("<label for='color-changing'>Select Color</label>");
	print ("<input id='color-changing' onchange='Chameleon(this.value)' type='color' name='color-changing'><br/>");
	print ("<label for='fileToUpload'>Background Image</label>");
	print ("<input id='change' type='file' name='fileToUpload' id='fileToUpload'><br/><br/>");
	print ("<label for='email_update'>Change Email Address</label>");
	print ("<input id='change' type='text' id='email_update' name='email' value='' placeholder='Enter a new email'><br/><br/>");
	print ("<input id='btn' type='submit' name='submit' value='Save'>");
	print ("</form>");
	print ("</div>");
	print ("<a href='close_account.php' id='close_account'>Close Account</a><br/><br/>");
	print ("</div>");
    
	if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		
        $_SESSION['color'] = $_POST["color-changing"]; 
		$color = $_SESSION['color'];

    }

	 _html_end();
?>
