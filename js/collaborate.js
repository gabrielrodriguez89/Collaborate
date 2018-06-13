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
function Update()
{
	document.getElementById('opt').style.display = "none";
	document.getElementById('opt-2').style.display = "block";
}
function CloseAccount()
{
	document.getElementById('opt').style.display = "none";
	document.getElementById('opt-3').style.display = "block";
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
function RestoreMsg(id)
{
	var newHTTP = new XMLHttpRequest();
	document.getElementById("draft" + id).style.display = "none";
	var url = "restore_msg.php?id=" + id;
	newHTTP.open("GET", url, true);
    newHTTP.onreadystatechange = function()
	{
        if(newHTTP.readyState == 4 && newHTTP.status == 200)
        {
	       var return_data = newHTTP.responseText;
		   document.getElementById("restore").innerHTML = return_data;
	    }
    }
    newHTTP.send();
}
//change ENUM to 1 in database to hide message
function DeleteMsg(id)
{
	var newHTTP = new XMLHttpRequest();
	document.getElementById("draft" + id).style.display = "none";
	var url = "del_msg.php?id=" + id;
	newHTTP.open("GET", url, true);
    newHTTP.onreadystatechange = function()
	{
        if(newHTTP.readyState == 4 && newHTTP.status == 200)
        {
	        var return_data = newHTTP.responseText;
	        document.getElementById("erase").innerHTML = return_data;
	    }
    }
    newHTTP.send();
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
    localStorage.setItem("last", id);
    var proj = document.getElementById("project" + id);
	var pro2 = document.getElementById("showPro" + id);
	
	if (proj.style.display == "block")
	{
		proj.style.display = "none";
		pro2.style.backgroundColor = "#585858";
	}
	else
	{
		proj.style.display = "block";
		pro2.style.backgroundColor = "#282828";
	}
}
function ShowProfile()
{
    var pro = document.getElementById("profile");
	var pro2 = document.getElementById("minProfile");
	var pro3 = document.getElementById("bgstyle2");
	var pro4 = document.getElementById("minProject");
	var pro5 = document.getElementById("projectheading");
    var pro6 = document.getElementById("pro-ico");
	var pro7 = document.getElementById("proj-ico");
	
	if (pro.style.display == "block")
	{
		pro.style.display = "none";
		pro2.style.backgroundColor = "#585858";
		pro2.style.color = "#ffffff";
        pro2.style.marginBottom = "0px";
		pro6.src = './../img/no-photo.png'
    }
    else
    {
        pro.style.display = "block";
		pro2.style.backgroundColor = "#E8E8E8";
		pro2.style.color = "#585858";
        pro2.style.marginBottom = "15px";
		pro3.style.display = "none";
		pro4.style.backgroundColor = "#585858";
		pro4.style.color = "#ffffff";
        pro4.style.marginBottom = "0px";
		pro5.style.display = "none";
		pro6.src = "./../img/no-photo2.png";
		pro7.src = "./../img/project.png";
    }
}
function ShowProject()
{
    var pro = document.getElementById("bgstyle2");
	var pro2 = document.getElementById("minProject");
	var pro3 = document.getElementById("profile");
	var pro4 = document.getElementById("minProfile");
	var pro5 = document.getElementById("projectheading");
	var pro6 = document.getElementById("proj-ico");
	var pro7 = document.getElementById("pro-ico");
	
    if (pro.style.display == "flex")
	{
		pro.style.display = "none";
		pro2.style.backgroundColor = "#585858";
		pro2.style.color = "#ffffff";
        pro2.style.marginBottom = "0px";
		pro5.style.display = "none";
		pro6.src = "./../img/project.png";
    }
    else
    {
        pro.style.display = "flex";
		pro2.style.backgroundColor = "#E8E8E8";
		pro2.style.color = "#585858";
        pro2.style.marginBottom = "15px";
		pro3.style.display = "none";
		pro4.style.backgroundColor = "#585858";
		pro4.style.color = "#ffffff";
        pro4.style.marginBottom = "0px";
		pro5.style.display = "block";
		pro6.src = "./../img/project2.png";
		pro7.src = './../img/no-photo.png';
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
	var btn0 = document.getElementById("messageHead");
	var btn1 = document.getElementById("search_bar2");
	var btn2 = document.getElementById("message-nav");
	var btn3 = document.getElementById("form");
	var btn4 = document.getElementById("msg");
	var btn5 = document.getElementById("minProject");
	

	if (btn.style.display == "block")
	{
		btn.style.display = "none";
		btn0.style.display = "block";
		btn1.style.display = "block";
		btn2.style.display = "block";
		btn4.style.display = "block";
		btn5.style.display = "block";
		
	}
	else
	{
		btn.style.display = "block";
		btn0.style.display = "none";
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
	var btn6 = document.getElementById("img8");
	
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
	document.getElementById('home3').src = './../img/home.png';
}
function HomeOut()
{
	document.getElementById('home3').src = './../img/home_2.png';
}
function ProOver()
{
	document.getElementById('pic3').style.opacity = '1';
}
function ProOut()
{
	document.getElementById('pic3').style.opacity = '.8';
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
	document.getElementById('inbox_icon3').src = './../img/inbox_icon2.png';
}
function InboxOut()
{
	document.getElementById('inbox_icon3').src = './../img/inbox2.png';
}
//TODO optional feature to change color layout
function Chameleon(color)
{
	var menu = document.getElementById("headerMenu");
	var btn = document.getElementById("btn");
	var drp = document.getElementById("dropdown-content");
	var drp2 = document.getElementById("dropdown-content2");
	var nav = document.getElementById("message-nav-buttons");
	var nav2 = document.getElementById("message-nav");
	
	menu.style.backgroundColor = color;
	btn.style.backgroundColor = color;
	drp.style.backgroundColor = color;
	drp2.style.backgroundColor = color;
	nav.style.backgroundColor = color;
	nav2.style.backgroundColor = color;	
}
