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

	$id = $_GET['id'];
    try
    {
		$con = Connect();
		//prep for mysqli_mysqli_query
		$restore_msg = mysqli_query($con, "UPDATE `collaborate`.`pvt_messages` SET `senderDelete` = '0' WHERE `from_user`='$username' AND `id`= '$id'");
        $con = NULL;
	}
	catch (\Exception $e)
	{

	}
?>
