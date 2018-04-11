<?php
/*
@Author: Gabriel Rodriguez
Page: New User Form
Date: 3/6/2018
Project: Collaborate

This script was written for Collaborate 2017-2018
The form below is used to get basic information
about the user in order to set up a profile.

*/

  include("header.php");

  //declarations
	$ageErr = $cityErr = $stateErr = "";

  //strip and check user input
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
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
		if(empty($_POST["profilePicture"]))
		{
      try
      {
        $con = Connect();

        $description = mysqli_query ($con, "UPDATE users SET bio='$bio',interest='$interests',hobbies='$hobbies',age='$age',city='$city',state='$state' WHERE username='$username'");
        if($description)
        {
          $upload_pic = mysqli_query ($con, "INSERT INTO `collaborate`.`profile_pictures` (`user`) VALUES ('$username')");
          if($upload_pic)
          {
              header("Location: $username");
          }
        }
        else
        {
          die("Connection failed: " . mysqli_connect_error());
        }
        $con = NULL;
      }
      catch (\Exception $e)
      {

      }
		}
		else
		{
			if(getimagesize($_FILES["profilePicture"]["tmp_name"]))
			{
        //call to upload images
				UploadNewImage(2);
			}
			else
			{
				header("Location: home.php");
			}
		}
	}
?>
<!--
Form to gather user information for profile
-->
<br/>
<div class="bgstyle">
    <div id="newUser">
		<div id="newUser2">
			<h1>Profile Information</h1><br/>
			<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="POST" enctype="multipart/form-data">
				<label for='age'><span class="err">*</span> Age</label>
				<input type='text' name='age' placeholder='Age'><span class="err"><?php echo $ageErr;?></span><br/><br/>
				<label for='city'><span class="err">*</span> City</label>
				<input type='text' name='city' placeholder='City'><span class="err"><?php echo $cityErr;?></span><br/><br/>
				<label for='state'><span class="err">*</span> State</label>
				<input type='text' name='state' placeholder='State'><span class="err"><?php echo $stateErr;?></span><br/><br/>
				<label for="profilePicture">Upload Profile Picture</label><br/>
				<input type="file" name="profilePicture" ><br/><br/>
				<label for='interests'>Interests</label>
				<textarea name='interests' placeholder='Tell us about you interests' ></textarea><br /><br />
				<label for='hobbies'>Hobbies</label>
				<textarea name='hobbies' placeholder='What are a few of your hobbies' ></textarea><br /><br />
				<label for='description'>Description</label>
				<textarea name='description' placeholder='Introduce yourself to the other users' ></textarea><br /><br />
				<input type='submit' name='about' value='Submit' >
			</form>
		</div>
	</div>
<?php
	_html_end();
?>
