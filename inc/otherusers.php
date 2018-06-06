<?php
    include ("header.php");
	
    if(!isset($_SESSION['username']))
	{
		Header("Location: ./../index.php");
	}
    print ('<div class="bgstyle3">');
    
	if(isset($_GET['query']))
	{
		$q = mysqli_real_escape_string($con, $_GET['query']);
		if (ctype_alnum($q))
		{
			$query = "SELECT * FROM users WHERE username='$q' OR first_name='$q' OR last_name='$q' OR bio='$q' OR interest='$q' OR hobbies='$q' OR looking_for='$q' OR city='$q' OR state='$q'";
			OtherUsers($query);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$state = "";
		if($_POST['state-choice'] == "none")
		{
			$state = "";
		}
		else
		{
			$state = $_POST['state-choice'];
		}
		if( $_POST['Choices'] == "None")
		{
			$category = "";
		}
		else
		{
			$category = $_POST['Choices'];
		}

		if($category != "")
		{
			if($state != "")
			{
				$query ="SELECT * FROM users WHERE state='$state' AND type_of_project='$category'";
			}
			else
			{
				$query = "SELECT * FROM users WHERE type_of_project='$category'";
			}
		}
		else
			if($state != "")
			{
				$query = "SELECT * FROM users WHERE state='$state'";
			}
		else
		{
			$query = "SELECT * FROM users WHERE state='$user_state_' OR city='$user_city_'";
		}

        OtherUsers($query);
	}
	else
	{
		$query =  "SELECT * FROM users WHERE state='$user_state_' OR city='$user_city_'";
	    OtherUsers($query);
	}
    print ("</div>");
    _html_end();
?>
