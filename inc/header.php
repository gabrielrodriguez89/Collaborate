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
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
		{
			//if over 30 minutes since session activity, destroy session
			LogOut();
		}
		else
		{
			$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
			$username = $_SESSION['username'];

			$sql = $user_id = $user_age = $user_bio = $user_fname = $user_lname = $user_state = "";
			$user_city = $user_hobbies = $user_interest = $get_user_pic = $user_id = $first_name = "";
			$last_name = $user_state_ = $user_city_ = $age = $hobbies = $interest = $bio = $pic = "";
			$sql = ("SELECT * FROM `collaborate`.`users` WHERE `username` ='$username' AND `activated`='0' LIMIT 1");
			try
			{
				//open database connection
				$con = Connect();
				//mysqli_query database
				if($mysqli_query = mysqli_query ($con, $sql))
				{
					while($row = mysqli_fetch_assoc($mysqli_query))
					{
						$user_id = $row["id"];
						$first_name = $row['first_name'];
						$last_name = $row['last_name'];
						$user_state_ = $row["state"];
						$user_city_ = $row["city"];
						$date = $row['age'];
						$hobbies = $row['hobbies'];
						$interest = $row['interest'];
						$bio = $row['bio'];
						$get_user_pic = $row['profile_pic'];
						$email = $row['email'];
						
						$date1 = new DateTime($date);
						$date2 = new DateTime("now");
						$date3 = $date1->diff($date2);
						$age = $date3->y;
						if($get_user_pic == "")
						{
							$_SESSION['get_user_pic'] = "./../img/no-photo.png";
						}
						else
						{
							$_SESSION['get_user_pic'] = $get_user_pic;
						}
						$_SESSION['user_id'] = $user_id;
						$_SESSION['user_fname'] = $first_name;
						$_SESSION['user_lname'] = $last_name;
						$_SESSION['user_state_'] = $user_state_;
						$_SESSION['user_city_']= $user_city_;
						$_SESSION['user_age'] = $age;
						$_SESSION['user_hobbies'] = $hobbies;
						$_SESSION['user_interest'] = $interest;
						$_SESSION['user_bio'] = $bio;
						$_SESSION['email'] = $email;
					}
				}
			}
			catch (Exception $e)
			{
				print("OOPS... Something unexpected happened.");
			}
			finally
			{
				$con = NULL;
			}
		}
	}

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
            //function that hold the Body tag with navigation control
            ShowBody(0);
		}
		else
		{
		    //funtion that hold the Body tag with navigation control
		    ShowBody(1);
	    }
	}
	else
	{
		print ("<link rel='stylesheet' type='text/css' href='./css/style.css' >");
		print ("<link rel='stylesheet' type='text/css' href='./css/profile.css' >");
		print ("<script src='./js/collaborate.js' ></script>");
		print ("</head>");
		//funtion that hold the Body tag with navigation control
		ShowBody(2);
	}

?>
<div id='wrapper'>