<?php
/*
@Auther: Gabriel Rodriguez
Page: Del Msg
Project: Collaborate
Date: 3/6/2018

Delete messages from database
Mark message with ENUM set to 1 in order to hide it from users
messages displayed in deleted box

*/
	include("header.php");
	//id of message
	$id = $_GET['id'];
	try
	{
		//open MySQL connection
		$con = Connect();
		//update ENUM value
		$erase_msg = mysqli_query ($con, "UPDATE `collaborate`.`pvt_messages` SET `senderDelete` = '1' WHERE `from_user` = '$username' AND `id`='$id'");
        //close connection
		$con = NULL;
	}
	catch (\Exception $e)
	{
		//TODO create log for exceptions
	}


?>
