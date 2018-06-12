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
		
		$getUser = mysqli_query ($con, "SELECT * FROM `collaborate`.`pvt_messages` WHERE `id`='$id'");
		
		$row = mysqli_fetch_assoc($getUser);
		
		$name = $row['from_user'];
		//update ENUM value
		if($name == $username)
		{
			$erase_msg = mysqli_query ($con, "UPDATE `collaborate`.`pvt_messages` SET `senderDelete` = '1' WHERE `from_user` = '$username' AND`id`='$id'");
		}
		else
		{
			$erase_msg = mysqli_query ($con, "UPDATE `collaborate`.`pvt_messages` SET `recipientDelete` = '1' WHERE `to_user` = '$username' AND `id`='$id'");
		}
	}
	catch (\Exception $e)
	{
		print("OOPS.... An error occured.");
	}
	finally
	{
		$con = NULL;
	}

?>
