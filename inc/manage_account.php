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
	print ("<label for='color-changing' >Change Background Color</label>");
	print ("<select id='color-changing' onmouseout='Chameleon()' name='color-changing'>");
	print ("<option value='None'>None</option>");
	print ("<option value='Blue'>Blue</option>");
	print ("<option value='Purple'>Purple</option>");
	print ("<option value='Green'>Green</option>");
	print ("<option value='Pink'>Pink</option>");
	print ("</select><br><br>");
	print ("<form id='account' action='#' method='post' enctype='multipart/form-data'><br><br>");
	print ("<label for='fileToUpload'>Select Background Image</label>");
	print ("<input id='change' type='file' name='fileToUpload' id='fileToUpload'><br><br>");
	print ("<label for='email_update'>Change Email Address&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>");
	print ("<input id='change' type='text' id='email_update' name='email' value='' placeholder='Enter a new email'><br><br>");
	print ("<input type='submit' name='submit' value='Save'>");
	print ("</form><br><br>");
	print ("<a href='close_account.php' id='close_account'><h3>Close Account</h3></a><br><br>");
	print ("</div>");

	 _html_end();
?>