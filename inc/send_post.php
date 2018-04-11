<!--
@Auther: Gabriel Rodriguez
Page: Send Post
Project: Collaborate 2017-2018
Date: 3/6/2018

This script was wriiten for Collaborate 2017-2018
This script is called by AJAX and submits comments to database
-->
<?php
	include("header.php");

	if(isset($_SESSION["user"]))
	{
		$user = $_SESSION["user"];
	}
	else
	{
		$user = $username
	}

	try
	{
		//open database connection
		$con = Connect();

		//get url data
		$id = mysqli_real_escape_string($con, $_GET['id'])
		$post = mysqli_real_escape_string($con, $_GET['post'])
		//check if post is an empty string
		if($post != "")
		{
			$date = date("Y-m-d");
			$added_by = $username;
			$user_posted_to = $user;
			//create statement string
			$send_post = "INSERT INTO `posts` (`body`, `date_added`, `added_by`, `user_posted_to`, `project_id`) VALUES('$post', '$date', '$added_by', '$user_posted_to', '$id')";
      //mysqli_query database
			if(mysqli_query ($con, $send_post))
			{

			}
			else
			{
				die(mysqli_error());
			}

		}
	}
	catch (\Exception $e)
	{

	}
?>
