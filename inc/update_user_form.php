<?php
/*
@Author: Gabriel Rodriguez
Page: Update User Form
Date: 6/12/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
The form below is used to update basic information
about the user.

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
		$age = test_input($_POST["age"]);
		$city = test_input($_POST["city"]);
		$state = test_input($_POST["state"]);
		$fname = test_input($_POST["fname"]);
		$lname = test_input($_POST["lname"]);
		$email = test_input($_POST["email"]);

		try
		{
			$con = Connect();

			$description = mysqli_query ($con, "UPDATE `collaborate`.`users` SET `email`='$email',`first_name`='$fname',`last_name`='$lname',`age`='$age',`city`='$city',`state`='$state' WHERE username='$username'");
			if($description)
			{
				header("Location: ./profile.php?u=$username");
			}
		}
		catch (\Exception $e)
		{
            print("OOPS... There was an error connecting to the database.");
		}	
		finally
		{
			$con = NULL;
		}
	}
?>