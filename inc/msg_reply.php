<?
/*
@Author: Gabriel Rodriguez
Page: Message Reply
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
The form below is used to support the messaging system
TODO-
* Create funtion to call for messages sent
*/
    include "header.php";
	
	if(!isset($_SESSION['username']))
	{
		Header("Location: ./../index.php");
	}
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
        $user = mysqli_real_escape_string($con, $_GET['u'])
        //check username to assure digits and letters only
        if (ctype_alnum($user))
        {
          //mysqli_mysqli_fetch_assoc()_assoc() database
          $check =  mysqli_query($con, "SELECT `username` FROM `users` WHERE `username`='$user'");
          //check database for user
          if ($userFound = mysqli_fetch_assoc($check)
          {
            //mysqli_fetch_assoc() array for user data
            $get = mysqli_fetch_assoc($check);
            //set session variable
            $user = $get['username'];
          }
        }
        //compare user to the current session
        if($username == $user)
        {
          $_SESSION['user'] = $user;
          $user = $_SESSION["user"];
        }
        //close database connection
        $con = NULL;
      }
      catch (\Exception $e)
      {

      }

	}
  //if the user isn't sending themselves a message display form
	if ($username != $user)
	{
    print ("<br/>");
    print ("<div class='bgstyle'>");
    print ("<div class='reply'>");
    print ("<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'' method='POST'>");
    print ("<h2><?php echo $username;?></h2>");
    print ("<br/>");
    print ("<div class='hr'></div>");
    print ("<br/><br/>");
    print ("<textarea id='message' type='text' name='message' placeholder='Message Body'></textarea><span id='err'><?php echo $messageErr; ?></span>");
    print ("<input id='btn' type='submit' name='submit' value='Send'/>");
    print ("</form>");
    print ("</div>");
	}
	else
	{
		header("Location: $username");
	}

  //process form using POST
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
    try
    {
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
  			$opened = '0';
  			$deleted_recp = '0';
  			$deleted_send = '0';
        //prepair mysqli_mysqli_fetch_assoc()_assoc() string
  			$send_msg = "INSERT INTO `pvt_messages` (`to_user`, `from_user`, `date`, `subject`, `message`, `opened`, `recipientDelete`, `senderDelete`) VALUES ('$user','$username','$date','$msg_sub','$msg_body','$opened','$deleted_recp','$deleted_send')";
        //mysqli_query database
        if(mysqli_query($con, $send_msg))
  			{
  				header("Location: $user");
  			}
  			else
  			{
  				print ("error");
  			}
      }
    }
    catch (\Exception $e)
    {

    }
  }

  print ("<br/><br/>");
  print ("</div>");

  _html_end();
?>
