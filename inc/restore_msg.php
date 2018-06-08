<?php
/*
@Author: Gabriel Rodriguez
Page: Restore Messages
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
intendend to mark ENUM value back to 0 to display message to user again

*/
    include "header.php";

	$id = $_GET['id'];
    try
    {
		//connect to database
		$con = Connect();
		//query message using id to find user
		$getUser = mysqli_query ($con, "SELECT `from_user` FROM `collaborate`.`pvt_messages` WHERE `id`='$id'");
		//fetch row
		$row = mysqli_fetch_assoc($getUser);
		//set name from row
		$name = $row['from_user'];
		//use a comparison to match logged in users name 
		if($name == $username)
		{
			$restore_msg = mysqli_query($con, "UPDATE `collaborate`.`pvt_messages` SET `senderDelete` = '0' WHERE `from_user`='$username' AND `id`= '$id'");
		}
		else
		{
			$restore_msg = mysqli_query ($con, "UPDATE `collaborate`.`pvt_messages` SET `recipientDelete` = '0' WHERE `to_user` = '$username' AND `id`='$id'");
		}
       
	}
	catch (\Exception $e)
	{

	}
	finally
	{
		$con = NULL;
	}

?>
