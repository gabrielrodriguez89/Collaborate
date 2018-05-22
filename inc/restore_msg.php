<?php
/*
@Author: Gabriel Rodriguez
Page: Restore Messages
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
intendend to mark ENUM value back to 0 to display message to user again
called with AJAXmysqli_mysqli_query
*/
    include "header.php";

    try
    {
		//get message id using POST
		$id = $_POST['restore'];
		//prep for mysqli_mysqli_query
		$restore_msg = "UPDATE `collaborate`.`pvt_messages` SET `recipientDelete` = '0' WHERE `to_user` = '$username' AND `id` = '$id'";
		//mysqli_mysqli_query database
		if(mysqli_query($con, $restore_msg))
		{

		}
		else
		{
		    echo "error";
		}
	}
	catch (\Exception $e)
	{

	}
?>
