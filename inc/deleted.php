<?php
/*
@Auther: Gabriel Rodriguez
Page: deleted
Project: Collaborate
Date: 3/6/2018

deleted.php was written to retreive messages from the database
these messages are currently marked with an ENUM value set to 1
the user also has the option to move the message back to the Inbox
by setting the ENUM value to 0.
Collaborate 2017-2018
*/

  include "header.php";
?>
<!--
Side navigation for message inbox/sent/deleted
-->
<div id="message-nav">
    <div id="message-nav-buttons">
		<a href="inbox.php"><img src='./../img/inbox_icon.png' alt='Inbox' />Inbox</a>
		<hr id="hr2"/>
		<a href="sent.php"><img src='./../img/sent.png' alt='Sent' />Sent</a>
		<hr id="hr2"/>
		<a href="draft.php"><img src='./../img/draft.png'  alt='Draft' />Drafts</a>
		<hr id="hr2"/>
		<a href="deleted.php"><img src='./../img/trash.png' alt='Sent' />Deleted</a><br/>
	</div>
</div>
<br/>
<?php



    $count = CountDeleted();
    if($count > 0)
	{
        print ("<div id='messageHead'><h2>Trash<div id='del'><a href='empty_trash.php?u=$username'><img src='./../img/delete_trash.png' alt='Empty Trash' /><h4>Empty Trash</h4></a></div></h2></div>");
    }
	else
	{
		print ("<div id='messageHead'><h2>Trash</h2></div>");
	}
	print ('<div class="bgstyle4">');
    print ('<div id="msg"><br/>');
	print ('<div id="draft-2">');
    //retreive messages that are marked deleted by user
    $get_messages = ( "SELECT * FROM `collaborate`.`pvt_messages` WHERE `from_user`='$username' AND `senderDelete`='1' OR `to_user` = '$username' AND `recipientDelete`='1'");
    //call to function to get messages
    GetMessages($get_messages, 1);

    print("</div></div></div>");

    _html_end()
?>
