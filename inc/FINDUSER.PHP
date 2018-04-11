<?php
/*
@Auther: Gabriel Rodriguez
Page: finduser
Project: collaborate
Date: 3/6/2018

This page is not currently used

Functionality to search for users will possibly be added
*/
  include ("header.php");

  $user = $q = $check_user = $get_row = $profile = "";

  $q = $_GET["u"];
  $query =  mysqli_real_escape_string($con, $q);
  $check_user = mysqli_query($con, "SELECT username FROM users WHERE username='$query'");
	$get_row = mysqli_fetch_assoc($check_user);
	$profile = $get_row['username'];

	$_SESSION["user"] = $profile;
	$user = $_SESSION["user"];
	header("Location: $user");
?>
