<?php
/*
@Auther: Gabriel Rodriguez
Page: Empty Trash
Project: Collaborate
Date: 3/6/2018

Delete messages from database
Mark message with ENUM set to 1 in order to hide it from users

*/
	include("header.php");

	$user = $_GET['u'];
	if (ctype_alnum($user))
	{
		try
		{
			//open MySQL connection
			$con = Connect();
			//update ENUM value
			$erase_msg = "UPDATE `collaborate`.`pvt_messages` SET `senderDelete`='2' WHERE `from_user`= '$user' AND `senderDelete`='1'";
			$erase_msg2 = "UPDATE `collaborate`.`pvt_messages` SET `recipientDelete`='2' WHERE `to_user` = '$user' AND `recipientDelete`='1'";
			if(mysqli_query ($con, $erase_msg) && mysqli_query ($con, $erase_msg2))
			{
				Header("Location: deleted.php");
			}
		}
		catch (\Exception $e)
		{
			//TODO create log for exceptions
		}
		finally
		{
			$con = NULL;
		}
	}
?>