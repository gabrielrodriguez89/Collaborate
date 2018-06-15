<?php
/*
@Auther: Gabriel Rodriguez
Page: Del User
Project: Collaborate
Date: 6/14/2018

Delete user and information from database

*/
	include("header.php");

	try
	{
		$con = Connect();
		$user = $_GET['u'];
		
		$erase_msg = mysqli_query ($con, "UPDATE `collaborate`.`pvt_messages` SET `senderDelete`='2' WHERE `from_user`= '$user'");
		$erase_msg2 = mysqli_query ($con, "UPDATE `collaborate`.`pvt_messages` SET `recipientDelete`='2' WHERE `to_user` = '$user'");
		$erase_projects = mysqli_query ($con, "DELETE * FROM `collaborate`.`projects` WHERE `username` = '$user' ");
		$erase_user = mysqli_query ($con, "DELETE FROM `collaborate`.`users` WHERE `username` = '$user' ");
	}
	catch (\Exception $e)
	{
		print("OOPS.... An error occured.");
	}
	finally
	{
		$con = NULL;
		LogOut();
	}

?>