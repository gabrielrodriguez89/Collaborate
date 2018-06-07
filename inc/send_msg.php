<?php
/*
@Author: Gabriel Rodriguez
Page: Send Message
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
The form below is used to support the messaging system
TODO-
* Create funtion to call for messages sent
*/
    include "header.php";
    //declarations
	$msg_sub = $subErr = $messageErr = $msg_body = "";
    //GET user intended to receive message from URL
	if (isset($_GET['u']))
    {
		try
		{
			//open database connection
            $con = Connect();
			//statement contruction
			$user = mysqli_real_escape_string($con, $_GET['u']);
			//check username to assure digits and letters only
			if (ctype_alnum($user))
			{
				//mysqli_query database
				$check = mysqli_query ($con, "SELECT `username` FROM `collaborate`.`users` WHERE `username`='$user'");
				//check database for user
				if ($get = mysqli_fetch_assoc($check))
				{
					//set session variable
					$user = $get['username'];
					//compare user to the current session
					if($username == $user)
					{
						header("Location: ./profile.php?u=$username");
					}
					else
					{
						$_SESSION['user'] = $user;
					}
				}
			}
			//close database connection
			$con = NULL;
		}
		catch (\Exception $e)
		{
            print ("There was an issue connecting to the server. If this error continues please contact support.");
		}

	}
	if (isset($_GET['id']))
	{
		try
		{
			//open database connection
            $con = Connect();
			//statement contruction
			$msg = mysqli_real_escape_string($con, $_GET['id']);
			//check username to assure digits and letters only
			if (ctype_alnum($msg))
			{
				//mysqli_query database
				$check = mysqli_query ($con, "SELECT * FROM `collaborate`.`pvt_messages` WHERE `id`='$msg'");
				//check database for user
				if ($get = mysqli_fetch_assoc($check))
				{
					//set session variable
					$body = $get['message'];
				}
			}
			//close database connection
			$con = NULL;
		}
		catch (\Exception $e)
		{
            print ("There was an issue connecting to the server. If this error continues please contact support.");
		}
	}
	print ("<br/>");
	print ("<div class='bgstyle'>");
	print ("<div class='reply'>");
	print ("<form action='#' method='POST'>");
	print ("<h1>Compose Message</h1>");
	print ("<br/>");
	print ("<hr id='hr-left'/>");
	print ("<br/><br/>");
	print ("<h2>To: $user</h2>");
	if (isset($_GET['id']))
	{
		print ("<textarea id='message' type='text' name='message' >$body</textarea><span id='err'><?php echo $messageErr; ?></span>");
	}
	else
	{
		print ("<textarea id='message' type='text' name='message' placeholder='Message Body'></textarea><span id='err'><?php echo $messageErr; ?></span>");
	}
	print ("<input id='btn' type='submit' name='submit' value='Send'/>");
	print ("<input id='btn2' type='submit' name='draft' value='Save as Draft'/>");
	print ("</form>");
	print ("</div>");

  //process form using POST
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		try
		{
			//open database connection
            $con = Connect();
		    if(isset($_POST["submit"]))
			{
				if (empty($_POST["message"]))
				{
					$messageErr = "You have not entered any text";
				}
				else
				{
					$msg_body = test_input($_POST["message"]);
				}
				$date = date("Y-m-d");
				$draft = '0';
				$opened = '0';
				$deleted_recp = '0';
				$deleted_send = '0';
				//prepair mysqli_query string
				$send_msg = "INSERT INTO `collaborate`.`pvt_messages` (`to_user`, `from_user`, `date`, `message`, `draft`, `opened`, `recipientDelete`, `senderDelete`) VALUES ('$user','$username','$date','$msg_body', '$draft', '$opened','$deleted_recp','$deleted_send')";
				//mysqli_query database
				if(mysqli_query($con, $send_msg))
				{
					header("Location: profile.php?u=$user");
					$con = NULL;
				}
				else
				{
					print ("There was an issue sending the message.");
				}
				$con = NULL;
		    }
			if(isset($_POST["draft"]))
			{
				if (empty($_POST["message"]))
				{
					$messageErr = "You have not entered any text";
				}
				else
				{
					$msg_body = test_input($_POST["message"]);
				}
				$date = date("Y-m-d");
				$draft = '1';
				$opened = '0';
				$deleted_recp = '0';
				$deleted_send = '0';
				//prepair mysqli_query string
				$send_msg = "INSERT INTO `collaborate`.`pvt_messages` (`to_user`, `from_user`, `date`, `message`, `draft`, `opened`, `recipientDelete`, `senderDelete`) VALUES ('$user','$username','$date','$msg_body', '$draft', '$opened','$deleted_recp','$deleted_send')";
				//mysqli_query database
				if(mysqli_query($con, $send_msg))
				{
					header("Location: profile.php?u=$user");
					$con = NULL;
				}
				else
				{
					print ("There was an issue sending the message.");
				}
				$con = NULL;
		    }
		}
		catch (\Exception $e)
		{
            print ("There was an issue connecting to the server. If this error continues please contact support.");
		}
	}

    print ("<br/><br/>");
    print ("</div>");

    _html_end();
?>
