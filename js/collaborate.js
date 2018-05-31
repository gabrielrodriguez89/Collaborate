/*
@Auther: Gabriel Rodriguez
Page: collaborate javascript
Project: collaborate
Date: 3/6/2018

this Javascript page was created for Collaborate 2017-2018

*/

//not used fuction to show hidden sign in
function SignIn()
{
	document.getElementById('h2sign').innerHTML = 'Sign In or<span id="in" onclick="Register()">Create Account</span>';
	document.getElementById('signUp').style.display = 'none';
    document.getElementById('signIn').style.display = 'block';
}
function Register()
{
	document.getElementById('h2sign').innerHTML = 'Sign Up Below or<span id="in" onclick="SignIn()">Sign In</span>';
	document.getElementById('signUp').style.display = 'block';
    document.getElementById('signIn').style.display = 'none';
}
function Advance()
{
	document.getElementById('refine').style.height = '250px';
	document.getElementById('filter-people').style.display = 'block';
	document.getElementById('filter-state').style.display = 'block';
	document.getElementById('adv').style.display = 'none';
	document.getElementById('clr').style.display = 'block';
    document.getElementsByClassName('#hr').style.display = 'block';

}
function CLR()
{
	document.getElementById('refine').style.height = '50px';
	document.getElementById('filter-people').style.display = 'none';
	document.getElementById('filter-state').style.display = 'none';
	document.getElementById('clr').style.display = 'none';
	document.getElementById('adv').style.display = 'block';
    document.getElementByClassName('#hr').style.display = 'none';

}
//function for mousein effect
function In()
{
	document.getElementById('in').style.color = '#005580';
}
//function for mouse out effect
function Out()
{
	document.getElementById('in').style.color = '#0084c6';
}
//hides default image and displays profile picture
function UploadPic()
{
	document.getElementById('proPic').style.display = 'none';
    document.getElementById('proPic2').style.display = 'block';
}
//shows default image when no photo exhists
function NoUpload()
{
	document.getElementById('proPic').style.display = 'block';
    document.getElementById('proPic2').style.display = 'none';
}
//toggles between the different projects requires 2 int
//multiple switch statements depending on the amount of projects
function ShowProject(control, id)
{
	if(control == 0)
	{

	}
	else
		if(control == 1)
	    {
		    document.getElementById("project1").style.display = "block";
	    }
	else
		if(control == 2)
		{
			switch(id)
	        {
				case 1:
					document.getElementById("project2").style.display = "none";
					document.getElementById("project1").style.display = "block";
				  break;
				case 2:
					document.getElementById("project1").style.display = "none";
					document.getElementById("project2").style.display = "block";
				  break;
			}
		}
	else
		if(control == 3)
		{
			switch(id)
			{
				case 1:
					document.getElementById("project2").style.display = "none";
					document.getElementById("project3").style.display = "none";
					document.getElementById("project1").style.display = "block";
				  break;
				case 2:
					document.getElementById("project1").style.display = "none";
					document.getElementById("project3").style.display = "none";
					document.getElementById("project2").style.display = "block";
				  break;
				case 3:
					document.getElementById("project1").style.display = "none";
					document.getElementById("project2").style.display = "none";
					document.getElementById("project3").style.display = "block";
				  break;
		    }
		}
	else
		if(control == 4)
		{
			switch(id)
			{
				case 1:
					document.getElementById("project3").style.display = "none";
					document.getElementById("project2").style.display = "none";
					document.getElementById("project4").style.display = "none";
					document.getElementById("project1").style.display = "block";
				  break;
				case 2:
					document.getElementById("project1").style.display = "none";
					document.getElementById("project3").style.display = "none";
					document.getElementById("project4").style.display = "none";
					document.getElementById("project2").style.display = "block";
				  break;
				case 3:
					document.getElementById("project1").style.display = "none";
					document.getElementById("project2").style.display = "none";
					document.getElementById("project4").style.display = "none";
					document.getElementById("project3").style.display = "block";
				  break;
				case 4:
					document.getElementById("project1").style.display = "none";
					document.getElementById("project2").style.display = "none";
					document.getElementById("project3").style.display = "none";
					document.getElementById("project4").style.display = "block";
				  break;
			}
		}
	else
	{
		switch(id)
		{
			case 1:
				document.getElementById("project3").style.display = "none";
				document.getElementById("project2").style.display = "none";
				document.getElementById("project4").style.display = "none";
				document.getElementById("project5").style.display = "none";
				document.getElementById("project1").style.display = "block";
			  break;
			case 2:
				document.getElementById("project1").style.display = "none";
				document.getElementById("project3").style.display = "none";
				document.getElementById("project4").style.display = "none";
				document.getElementById("project5").style.display = "none";
				document.getElementById("project2").style.display = "block";
			  break;
			case 3:
				document.getElementById("project1").style.display = "none";
				document.getElementById("project2").style.display = "none";
				document.getElementById("project4").style.display = "none";
				document.getElementById("project5").style.display = "none";
				document.getElementById("project3").style.display = "block";
			  break;
			case 4:
				document.getElementById("project1").style.display = "none";
				document.getElementById("project2").style.display = "none";
				document.getElementById("project3").style.display = "none";
				document.getElementById("project5").style.display = "none";
				document.getElementById("project4").style.display = "block";
			  break;
			case 5:
				document.getElementById("project1").style.display = "none";
				document.getElementById("project2").style.display = "none";
				document.getElementById("project3").style.display = "none";
				document.getElementById("project4").style.display = "none";
				document.getElementById("project5").style.display = "block";
			  break;
		}
	}
}
//landing page images and text alternate automatically
function read()
{
	var w = window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth;

    var h = window.innerHeight
    || document.documentElement.clientHeight
    || document.body.clientHeight;
		document.body.style.height = h;
		document.body.style.width = w;

    var time = setInterval(display, 4500);
    var count = 0;

    function display()
		{
      if(count < 4)
		{
			switch(count)
			{
				case 0:
				    document.getElementById('jumbo').style.display = 'none';
					document.getElementById('jumbo1').style.display = 'block';
					document.getElementById('img5').style.display = 'none';
        	        document.getElementById('img2').style.display = 'block';
				break;
				case 1:
				    document.getElementById('jumbo1').style.display = 'none';
					document.getElementById('jumbo2').style.display = 'block';
					document.getElementById('img2').style.display = 'none';
                    document.getElementById('img3').style.display = 'block';
				break;
				case 2:
				    document.getElementById('jumbo2').style.display = 'none';
					document.getElementById('jumbo3').style.display = 'block';
					document.getElementById('img3').style.display = 'none';
                    document.getElementById('img7').style.display = 'block';
			    break;
				case 3:
				    document.getElementById('jumbo3').style.display = 'none';
					document.getElementById('jumbo4').style.display = 'block';
					document.getElementById('img7').style.display = 'none';
                    document.getElementById('img6').style.display = 'block';
				break;
			}
			count++;
    }
		else
		{
			document.getElementById('img6').style.display = 'none';
            document.getElementById('img4').style.display = 'block';
			document.getElementById('jumbo4').style.display = 'none';
			document.getElementById('jumbo5').style.display = 'block';
		}
	}
}
//opens comments
function Comments()
{
	document.getElementById("user_content").style.display = "none";
	document.getElementById("user_content2").style.display = "block";
	document.getElementById("close").style.display = "block";
}
//closes comments for projects
function Close()
{
	document.getElementById("user_content2").style.display = "none";
	document.getElementById("close").style.display = "none";
	document.getElementById("user_content").style.display = "block";
}
//cancels changing user profile
function Cancel()
{
	document.getElementById("user_content2").style.display = "none";
	document.getElementById("changeAbout").style.display = "none";
}
//not used was used to display user information
function About()
{
	document.getElementById("user_content2").style.display = "block";
	document.getElementById("about").style.display = "block";
}
//not used was used to show user information
function EditAbout()
{
	document.getElementById("user_content2").style.display = "block";
	document.getElementById("about").style.display = "none";
	document.getElementById("changeAbout").style.display = "block";
}
function Go_To_Profile()
{
	var xHTTP = new XMLHttpRequest();
	var id = document.getElementById("getUser").value;
    xHTTP.onreadystatechange = function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
		  document.getElementById("test").innerHTML = this.responseText;
		}
    };
	xHTTP.open("GET", "findUser.php?q=" + id, true);
    xHTTP.send();
}
//send comment to user project required id of message
function sendPost(id)
{
	var newHTTP = new XMLHttpRequest();
	var myPost = document.getElementById("post").value;
    var post = "?post=" + myPost + "&id=" + id;
	var url = "send_post.php" + post;
	document.getElementById("post").value = "";
    newHTTP.onreadystatechange = function()
	{
        if(newHTTP.readyState == 4 && newHTTP.status == 200)
        {
	       var return_data = newHTTP.responseText;
	       document.getElementById("post").innerHTML = return_data;
	    }
    }
	newHTTP.open("GET", url, true);
    newHTTP.send();
}
//change ENUM to 0 in database for user messages
function RestoreMsg()
{
	var newHTTP = new XMLHttpRequest();
	var url = "restore_msg.php";
	var msg = document.getElementById("restore").value;
	document.getElementById("" + msg).style.display = "none";
    var restore = "restore=" + msg;
	newHTTP.open("POST", url, true);
    newHTTP.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    newHTTP.onreadystatechange = function()
	{
        if(newHTTP.readyState == 4 && newHTTP.status == 200)
        {
	       var return_data = newHTTP.responseText;
	    }
    }
    newHTTP.send(restore);
}
//change ENUM to 1 in database to hide message
function DeleteMsg()
{
	var newHTTP = new XMLHttpRequest();
	var url = "del_msg.php";
	var msg = document.getElementById("erase").value;
	document.getElementById("" + msg).style.display = "none";
    var erase = "id=" + msg;
	newHTTP.open("POST", url, true);
    newHTTP.onreadystatechange = function()
	{
        if(newHTTP.readyState == 4 && newHTTP.status == 200)
        {
	        var return_data = newHTTP.responseText;
	        document.getElementById("erase").innerHTML = return_data;
	    }
    }
    newHTTP.send(erase);
}
//toggles message views to open and close messages
function toggle(id)
{
    var msg = document.getElementById("toggleText" + id);
    if (msg.style.display == "block")
	{
		msg.style.display = "none";
    }
    else
    {
        msg.style.display = "block";
    }
}
//toggles message views to open and close messages
function Show(id)
{
    var proj = document.getElementById("showPro" + id);
    if (proj.style.display == "block")
	{
		proj.style.display = "none";
    }
    else
    {
        proj.style.display = "block";
    }
}
function ShowProfile()
{
    var pro = document.getElementById("profile");
	var pro2 = document.getElementById("minProfile");
	
	
    if (pro.style.display == "block")
	{
		pro.style.display = "none";
		pro2.style.backgroundColor = "#585858";
		pro2.style.color = "#ffffff";
        pro2.style.marginBottom = "0px";
    }
    else
    {
        pro.style.display = "block";
		pro2.style.backgroundColor = "#E8E8E8";
		pro2.style.color = "#585858";
        pro2.style.marginBottom = "15px";
    }
}
function DropDown()
{
	var btn = document.getElementById("dropdown-content");

	if (btn.style.display == "block")
	{
		btn.style.display = "none";
	}
	else
	{
		btn.style.display = "block";
	}
}
function DropDown2()
{
	var btn = document.getElementById("dropdown-content2");
	var btn1 = document.getElementById("search_bar2");
	var btn2 = document.getElementById("message-nav");
	var btn3 = document.getElementById("form");
	var btn4 = document.getElementById("msg");
	var btn5 = document.getElementById("minProject");

	if (btn.style.display == "block")
	{
		btn.style.display = "none";
		btn1.style.display = "block";
		btn2.style.display = "block";
		btn4.style.display = "block";
		btn5.style.display = "block";
	}
	else
	{
		btn.style.display = "block";
		btn1.style.display = "none";
		btn2.style.display = "none";
		btn3.style.display = "none";
		btn4.style.display = "none";
		btn5.style.display = "none";
	}
}
function SearchBar()
{
	var btn = document.getElementById("form");
	var btn1 = document.getElementById("search_bar2");
	var btn2 = document.getElementById("dropdown-content2");
	var btn3 = document.getElementById("dropbtn2");
	var btn4 = document.getElementById("hideMenu");
	var btn5 = document.getElementById("img");
	var btn6 = document.getElementById("img2");
	
	if (btn.style.display == "block")
	{
		btn.style.display = "none";
		btn1.style.width = "0";
		btn4.style.display = "flex";
		btn5.style.display = "block";
		btn6.style.display = "none";
	}
	else
	{
		btn.style.display = "block";
		btn1.style.width = "75%";
	    btn2.style.display = "none";
		btn3.style.display = "block";
		btn4.style.display = "none";
		btn5.style.display = "none";
		btn6.style.display = "block";
	}
}

function HomeOver()
{
	document.getElementById('home').src = './../img/home_hover.png';
}
function HomeOut()
{
	document.getElementById('home').src = './../img/home.png';
}
function HamOver()
{
	document.getElementById('dropbtn').src = './../img/hamburger2.png';
}
function HamOut()
{
	document.getElementById('dropbtn').src = './../img/hamburger.png';
}
function SearchOver()
{
	document.getElementById('search_img').src = './../img/search2.png';
}
function SearchOut()
{
	document.getElementById('search_img').src = './../img/search.png';
}
function InboxOver()
{
	document.getElementById('inbox').src = './../img/inbox_over.png';
}
function InboxOut()
{
	document.getElementById('inbox').src = './../img/inbox.png';
}
//TODO optional feature to change color layout
function Chameleon()
{
	var color = document.getElementById("color-changing").value;
	var value = document.getElementById("color").value = color;
	var menu = document.getElementById("headerMenu");
	var btn = document.getElementById("btn");
	var drp = document.getElementById("dropdown-content");
	var drp2 = document.getElementById("dropdown-content2");
	var nav = document.getElementById("message-nav-buttons");
	var nav2 = document.getElementById("message-nav");
	
	switch(value)
	{
		case "Blue":
			menu.style.backgroundColor = '#000080';
			btn.style.backgroundColor = '#000080';
			drp.style.backgroundColor = '#0000cc';
			drp2.style.backgroundColor = '#0000cc';
			nav.style.backgroundColor = '#0000cc';
			nav2.style.backgroundColor = '#0000cc';
			break;
		case "Purple":
			menu.style.backgroundColor = '#26004d';
			btn.style.backgroundColor = '#26004d';
			drp.style.backgroundColor = '#5900b3';
			drp2.style.backgroundColor = '#5900b3';
			nav.style.backgroundColor = '#5900b3';
			nav2.style.backgroundColor = '#5900b3';
			break;
		case "Green":
			menu.style.backgroundColor = '#003300';
			btn.style.backgroundColor = '#003300';
			drp.style.backgroundColor = '#006600';
			drp2.style.backgroundColor = '#006600';
			nav.style.backgroundColor = '#006600';
			nav2.style.backgroundColor = '#006600';
			break;
		case "Pink":
			menu.style.backgroundColor = '#e60073';
			btn.style.backgroundColor = '#e60073';
			drp.style.backgroundColor = '#ff1a8c';
			drp2.style.backgroundColor = '#ff1a8c';
			nav.style.backgroundColor = '#ff1a8c';
			nav2.style.backgroundColor = '#ff1a8c';
			break;
		default:
		    menu.style.backgroundColor = '#282828';
			btn.style.backgroundColor = '#282828';
			drp.style.backgroundColor = '#585858';
			drp2.style.backgroundColor = '#585858';
			nav.style.backgroundColor = '#585858';
			nav2.style.backgroundColor = '#585858';
			break;
	}
}
