<!--
@Auther: Gabriel Rodriguez
Page: Home
Project: Collaborate 2017-2018
Date: 3/6/2018

Home.php is the main landing page to display projects to users within the same Location
projects will be displayed as cards, within the cards will display the user who pasted
the project for others.

-->
<?php
  include "./header.php";

//filter and query function to support users search and filter menu
  ShowFilter();

//get user from url and retreive data from database
	if(isset($_GET['query']))
	{
		$query =  mysqli_real_escape_string($con, $_GET['query']);
		if (ctype_alnum($query))
		{
			$getProject = ("SELECT * FROM projects WHERE project_name='$query' OR description='$query' OR type_of_project='$query' OR state='$query' OR city='$query'");
      GetProject($getProject, 0);
		}
	}
//search user query
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$getProject = "";
		$state = $_POST['state-choice'];
		$category = $_POST['Choices'];

//check to see if the filter is by state or category or both and set query accordingly
		if($category != "None")
		{
			if($state != "none")
			{
				$getProject = ("SELECT * FROM projects WHERE state=' " . $_SESSION['user_state_'] . "' AND type_of_project='$category'");
			}
			else
			{
				$getProject = ("SELECT * FROM projects WHERE type_of_project='$category'");
			}
		}
		else
			if($state != "none")
			{
				$getProject = ("SELECT * FROM projects WHERE state=' " . $_SESSION['user_state_'] . "");
			}
		else
		{
			$getProject = ("SELECT * FROM projects WHERE city='" .$_SESSION['user_city_']. "' OR state=' " . $_SESSION['user_state_'] . "'");
	  }

    //check to make sure query isn't blank
		if($getProject != "")
		{
      GetProject($getProject, 0);
		}
		else
		{
			Echo "<h1 style='text-align: center;font-weight: bold;color:#e60000;margin-top: 20px;'>No results found.</h1>";
		}
	}
	else
	{
		$getProject = ("SELECT * FROM projects WHERE city='" . $_SESSION['user_city_'] . "' OR state=' " . $_SESSION['user_state_'] . "'");
    GetProject($getProject, 0);
	}

   _html_end();
?>
