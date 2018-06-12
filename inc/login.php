<?php
/*
@Author: Gabriel Rodriguez
Page: Login
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
the users data is checked using test_input to help prevent sql injecting
session variables are set using SetUser function parsing mysqli_query and username
session variables are registered and session is started using StartSession
MD5 hashing is used to provide basic security.
*/

// define variables and set to empty values
$user_login = $password_login = $md5password_login = $sql = $userCount = $row = $id = "";

//strip user input and test for blank fields
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (empty($_POST["user_login"]))
	{
    $user_login = "Username is required";
	}
	else
	{
	  $user_login = test_input($_POST["user_login"]);
	}
	if (empty($_POST["password_login"]))
	{
  	$emailErr = "Password is required";
}
else
{
$password_login = test_input($_POST["password_login"]);
}
	$md5password_login = md5($password_login);

	try
	{
		//Check username
		$sql = mysqli_query ($con, "SELECT * FROM users WHERE username='$user_login' AND password='$md5password_login' AND activated='0'");
		//if rows returned log in
		if ($userCheck = mysqli_fetch_assoc($sql))
		{
			//open session and register variables
			StartSession();
			//set user session data
			SetUser($sql);
			//landing page for site
			header("Location: home.php");
			exit("<meta http-equiv=\"refresh\" content=\"0\">");
		}
		else
		{
			echo 'That information is incorrect, try again';
			exit();
		}
	}
	catch (Exception $e)
	{
		 print("OOPS.... An error occured.");
	}
}

?>
