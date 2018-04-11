<?php
  include ("header.php");

  ShowFilter();

	if(isset($_GET['query']))
	{
		$query = mysqli_real_escape_string($con, $_GET['query']);
		if (ctype_alnum($query))
		{
			$getBio = mysqli_query($con, "SELECT * FROM users WHERE username='$query' OR first_name='$query' OR last_name='$query' OR bio='$query' OR interest='$query' OR hobbies='$query' OR looking_for='$query' OR city='$query' OR state='$query'");
			if($getBio)
			{
				while($row = mysqli_fetch_assoc($getBio))
				{
					$user = $row['username'];
					$fname = $row['first_name'];
					$lname = $row['last_name'];
					$age = $row['age'];
					$city = $row['city'];
					$state = $row['state'];

					echo "<a href='$user?u=$user'>
					<div id='profile2'>
					";

					$check_pic = mysqli_query($con, "SELECT user_picture FROM profile_pictures WHERE user='$user'");
					if($check_pic)
					{
						While($get_pic_row = mysqli_fetch_assoc($check_pic))
						{
							$check_if_null = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user'");
							$row = mysqli_fetch_assoc($check_fetch_assoc);
							if (empty($row['profile_pic']))
							{
								echo "
								<div id='proPicNoImg'>
									<h1 id='noPic'>The user has not uploaded any photos.</h1>
								</div>
								";

							}
							else
							{
								$profile_pic_db = $get_pic_row['user_picture'];
								$profile_pic = $profile_pic_db;
								echo "
								<div id='proPic3'>
									<img src='$profile_pic' alt='Profile Picture '  >
								</div>
								";
							}
						}
					}
					else
					{
						echo "error";
					}

					echo "
					<div class='profileLeftContent'>
						<div id='me2'>
						<h1>$fname&nbsp$lname</h1><br/><br/>
						<h3>$age&nbsp&nbsp&nbsp$city,&nbsp$state</h3>
						<br><br>
					</div>
					</div>
					</div></a>
					";
				}
			}
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
				$getBio = mysqli_query($con, "SELECT * FROM users WHERE state='$state' AND type_of_project='$category'");
			}
			else
			{
				$getBio = mysqli_query($con, "SELECT * FROM users WHERE type_of_project='$category'");
			}
		}
		else
			if($state != "")
			{
				$getBio = mysqli_query($con, "SELECT * FROM users WHERE state='$state'");
			}
		else
		{
			$getBio = mysqli_query($con, "SELECT * FROM users WHERE state='$user_state_' OR city='$user_city_'");
		}

		if($getBio)
		{
			while($row = mysqli_fetch_assoc($getBio))
			{
				$user = $row['username'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$age = $row['age'];
				$city = $row['city'];
				$state = $row['state'];

				echo "<a href='$user?u=$user'>
				<div id='profile2'>
				";
				$check_pic = mysqli_query($con, "SELECT user_picture FROM profile_pictures WHERE user='$user'");
				While($get_pic_row = mysqli_fetch_assoc($check_pic))
				{
					$profile_pic_db = $get_pic_row['user_picture'];
					if ($profile_pic_db == "")
					{
						echo "
						<div id='proPic3'>
							<h1 id='noPic'>The user has not uploaded any photos.</h1>
						</div>
						";
					}
					else
					{
						$profile_pic = $profile_pic_db;
						echo "
						<div id='proPic3'>
							<img src='$profile_pic' alt='Profile Picture '  >
						</div>
						";
					}
				}
				echo "

				<div class='profileLeftContent'>
				    <div id='me2'>
						<h1>$fname&nbsp$lname</h1><br/><br/>
						<h3>$age&nbsp&nbsp&nbsp$city,&nbsp$state</h3>
						<br><br>
					</div>
				</div>
			    </div></a>
				";
			}
		}
	}
	else
	{
		$getBio = mysqli_query($con, "SELECT * FROM users WHERE state='$user_state_' OR city='$user_city_'");
		if($getBio)
		{
			while($row = mysqli_fetch_assoc($getBio))
			{
				$user = $row['username'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$age = $row['age'];
				$city = $row['city'];
				$state = $row['state'];

				echo "<a href='$user?u=$user'>
				<div id='profile2'>
				";
				$check_pic = mysqli_query($con, "SELECT `user_picture` FROM `profile_pictures` WHERE user='$user'");
				if($check_pic)
				{

					While($get_pic_row = mysqli_fetch_assoc($check_pic))
				    {
						$profile_pic_db = $get_pic_row['user_picture'];
						$profile_pic = $profile_pic_db;
						if($profile_pic == NULL)
						{
							echo "
							<div id='proPic3'>
								<img src='img/no_photo.png' alt='Profile Picture '  >
							</div>";
						}
						else
						{
							echo "
							<div id='proPic3'>
								<img src='$profile_pic' alt='Profile Picture '  >
							</div>
							";
						}
		            }
				}

				echo "
				<div class='profileLeftContent'>
					<div id='me2'>
						<h1>$fname&nbsp$lname</h1><br/><br/>
						<h3>$age&nbsp&nbsp&nbsp$city,&nbsp$state</h3>
						<br><br>
					</div>
				</div>
				</div></a>
				";
			}
		}
	}
?>
</div>
<?php
    _html_end();
?>
