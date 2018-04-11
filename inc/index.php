<?php
/*
@Auther: Gabriel Rodriguez
Page: Index
Project: Collaborate 2017-2018
Date: 3/6/2018

Index page displays introduction images to user within a "Poloroid" type
of container. There are options to register as a new user as well as a signhp
area

*/
    include ("header.php");

  //prevent users from going to the index page without logging out
	if (!isset($_SESSION["username"])) {
		echo "";
	}
	else
	{
		echo "<meta http-equiv='refresh' content='0; url=home.php'>";
	}
?>
  <!--
  Sign in area located on left of screen
  -->
	<div id="signhp">
		<table >
			<h2 id="h2signIn">Sign In</h2>
			<td id="signIn2">
				<form action="registration.php" method="POST">
					<input type="text" name="user_login" size="50" placeholder="Username" /><span class="err"><?php echo @$userLogErr;?></span><br /><br />
					<input type="password" name="password_login" size="50" placeholder="Password" /><span class="err"><?php echo @$passLogErr;?></span><br /><br />
					<input type="submit" name="log" value="Login" />
				</form>
			</td>
		</table>
	</div>
	<div class="bgstyleIndex">
    <!--
    Container with images and text
    -->
		<br/><br/>
		<div class="photos">
			<img id="img1" src="img/intro_pic_1.jpg" alt="" >
			<img id="img2" src="img/intro_pic_2.jpg" alt="" >
			<img id="img3" src="img/intro_pic_3.jpg" alt="" >
			<img id="img4" src="img/intro_pic_4.jpg" alt="" >
			<img id="img5" src="img/intro_pic_5.jpg" alt="" >
			<img id="img6" src="img/intro_pic_6.jpg" alt="" >
			<img id="img7" src="img/intro_pic_7.jpg" alt="" >
			<div class="container">
				<h1 id="jumbo"><img src="img/slide1.png"></h1>
				<h1 id="jumbo1"><img src="img/slide2.png"></h1>
				<h1 id="jumbo2"><img src="img/slide3.png"></h1>
				<h1 id="jumbo3"><img src="img/slide4.png"></h1>
				<h1 id="jumbo4"><img src="img/slide5.png"></h1>
				<h1 id="jumbo5"><img src="img/slide6.png"></h1>
			</div>
		</div>
		<br/><br/>
	</div>
  <!--
  Registration start
  -->
	<div id="join">
		<table >
			<br/>
      <tr>
  			<td id="signUp">
  				<h2 >Sign Up Below!</h2>
  				<form action="registration.php" method="POST">
  					<input type="text" name="fname" size="25" placeholder="First Name" /><span class="err"><?php echo @$fnameErr;?></span><br /><br />
  					<input type="text" name="lname" size="25" placeholder="Last Name" /><span class="err"><?php echo @$lnameErr;?></span><br /><br />
  					<input type="text" name="uname" size="25" placeholder="Username" /><span class="err"><?php echo @$userErr;?></span><br /><br />
  					<input type="text" name="email" size="25" placeholder="Email Address" /><span class="err"><?php echo @$emailErr;?></span><br /><br />
  					<input type="text" name="email2" size="25" placeholder="Re-Enter Email" /><span class="err"><?php echo @$email2Err?></span><br /><br />
  					<input type="password" name="password" size="25" placeholder="Password" /><span class="err"><?php echo @$passErr;?></span><br /><br />
  					<input type="password" name="password2" size="25" placeholder="Password Verification" /><span class="err"><?php echo @$pass2Err;?></span><br /><br />
  					<input type="submit" name="reg" value="Sign Up!" >
  				</form>
  			</td>
      </tr>
		</table>
	</div>

	<br/><br/>
<?php
    _html_end();
?>
