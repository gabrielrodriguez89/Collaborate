<?php
/*
@Author: Gabriel Rodriguez
Page: New User Form
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
The form below is used to set basic information
about the user in order to set up a profile.

*/

    include("header.php");

	if(!isset($_SESSION['username']))
	{
		Header("Location: ./../index.php");
	}
    //declarations
	$ageErr = $cityErr = $stateErr = "";

    //strip and check user input
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		UploadNewImage($username);
		
		if (empty($_POST["age"]))
		{
			$ageErr = "Age is required";
		}
		else
		{
			$age = test_input($_POST["age"]);
		}
		if (empty($_POST["city"]))
		{
			$cityErr = "Enter your city";
		}
		else
		{
			$city = test_input($_POST["city"]);
		}
		if (empty($_POST["state"]))
		{
			$stateErr = "Enter the State";
		}
		else
		{
			$state = test_input($_POST["state"]);
		}
	    if (empty($_POST["interests"]))
		{
			$interests = "none";
		}
		else
		{
			$interests = test_input($_POST["interests"]);
		}
		if (empty($_POST["hobbies"]))
		{
			$hobbies = "none";
		}
		else
		{
			$hobbies = test_input($_POST["hobbies"]);
		}
		if(empty($_POST["description"]))
		{
			$bio = "none";
		}
		else
		{
			$bio = test_input($_POST["description"]);
		}

		try
		{
			$con = Connect();

			$description = mysqli_query ($con, "UPDATE `collaborate`.`users` SET `bio`='$bio',`interest`='$interests',`hobbies`='$hobbies',`age`='$age',`city`='$city',`state`='$state', `activated`='0' WHERE `username`='$username'");
			if($description)
			{
				header("Location: ./home.php");
			}
   
			$con = NULL;
		}
		catch (\Exception $e)
		{
			print("OOPS.... It looks like an error has occured.");
		}
		finally
		{
			//close database connection
			$con = NULL;
		}
	}
?>
