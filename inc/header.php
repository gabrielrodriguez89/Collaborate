<?php
/*
@Auther: Gabriel Rodriguez
Page: Header
Project: collaborate
Date: 3/6/2018

Header.php contains the head of the HTML document
connect.php is required here becasue every page needs access to the
functions contained within that page. if the session is active
a menu is displayed for the user, else login and registration
options are displayed
*/

  require_once "connect.php";

//check session status
  if (isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];

    $sql = $user_id = $user_age = $user_bio = $user_fname = $user_lname = $user_state = "";
    $user_city = $user_hobbies = $user_interest = $get_user_pic = $user_id = $first_name = "";
    $last_name = $user_state_ = $user_city_ = $age = $hobbies = $interest = $bio = "";
    $sql = ("SELECT * FROM users WHERE username ='$username' AND activated='0' LIMIT 1");
    try
   	{
   		//open database connection
   		$con = Connect();
   		//mysqli_query database
   		$mysqli_query = mysqli_query ($con, $sql);

   		while($row = mysqli_fetch_assoc($mysqli_query))
   		{
   			$user_id = $row["id"];
   			$user_fname = $row['first_name'];
   			$user_lname = $row['last_name'];
   			$user_state_ = $row["state"];
   			$user_city_ = $row["city"];
   			$user_age = $row['age'];
   			$user_hobbies = $row['hobbies'];
   			$user_interest = $row['interest'];
   			$user_bio = $row['bio'];
   		}
       //get users profile_pictures
   		$check_pic = mysqli_query ($con, "SELECT user_picture FROM profile_pictures WHERE user='$username'");
   		$get_pic_row = mysqli_fetch_assoc($check_pic);
   		$profile_pic_db = $get_pic_row['user_picture'];
   		if($profile_pic_db != "")
   		{
   			$get_user_pic = $profile_pic_db;
   		}
   		else
   		{
   			$get_user_pic = "";
   		}
      $_SESSION['get_user_pic'] = $get_user_pic;
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_fname'] = $first_name;
      $_SESSION['user_lname'] = $last_name;
      $_SESSION['user_state_'] = $user_state_;
      $_SESSION['user_city_']= $user_city_;
      $_SESSION['user_age'] = $age;
      $_SESSION['user_hobbies'] = $hobbies;
      $_SESSION['user_interest'] = $interest;
      $_SESSION['user_bio'] = $bio;

   		$con = NULL;
   	}
   	catch (Exception $e)
   	{
   		//TODO add log for catch statement
   	}
  }
  //else
  //{
    //redirect to logout and to index page if no seesion is active
    //header("location: logout.php");
  //}

  print ("<!doctype html>");
  print ("<html>");
  print ("<head>");
  print ("<title >Collaborate</title>");


	if(isset($_SESSION["username"]))
	{
    print ("<link rel='stylesheet' type='text/css' href='./../css/style.css' >");
    print ("<link rel='stylesheet' type='text/css' href='./../css/profile.css' >");
    print ("<script src='./../js/collaborate.js' ></script>");
    print ("</head>");
		if(Empty($_SESSION["user_city_"]))
		{
      //funtion that hold the Body tag with navigation control
      ShowBody(0);
		}
    else
    {
      //funtion that hold the Body tag with navigation control
      ShowBody(1);

			if(isset($_SESSION['get_user_pic']))
			{
				print("<a id='user' href='$username' ><img class='userPic' src='$get_user_pic' alt='Avatar'></a>");
			}
			print("</div>");
	  }
	}
	else
	{
    print ("<link rel='stylesheet' type='text/css' href='css/style.css' >");
    print ("<link rel='stylesheet' type='text/css' href='css/profile.css' >");
    print ("<script src='js/collaborate.js' ></script>");
    print ("</head>");
    //funtion that hold the Body tag with navigation control
    ShowBody(2);
	}
  print("</div>");
  print("<div id='wrapper'>");
