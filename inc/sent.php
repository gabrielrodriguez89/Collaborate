<?php
/*
@Auther: Gabriel Rodriguez
Page: Sent
Project: Collaborate
Date: 3/6/2018

sent.php was written to retreive messages from the database
these messages are currently marked from_user
the user also has the option to move the message to deleted
by setting the ENUM value to 1.
Collaborate 2017-2018
*/
    include ("header.php");
?>
<div id="message-nav">
    <div id="message-nav-buttons">
		<a href="inbox.php"><button>Inbox</button></a>
		<a href="sent.php"><button>Sent</button></a>
		<a href="deleted.php"><button>Deleted</button></a>
	</div>
</div>
<br/>
<div class="bgstyle">
    <h2 id='messageHead' >Sent</h2>
	<div class="hr" ></div>
	<br/><br/>
<?php
	//retreive messages that are marked from_user
	$grab_messages = ("SELECT * FROM `collaborate`.`pvt_messages` WHERE `from_user`='$username' AND `senderDelete`='0'");
	//call to function to get messages
	GetMessages($get_messages, 2);

    print("</div><br/>");
    
    _html_end();
?>
