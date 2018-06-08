<?php
/*
@Auther: Gabriel Rodriguez
Page: Drafts
Project: Collaborate
Date: 3/6/2018

draft.php was written to retreive messages from the database
these messages are currently marked draft
the user also has the option to move the message to deleted
by setting the ENUM value to 1.
Collaborate 2017-2018
*/
    include ("header.php");
?>
<div id="message-nav">
    <div id="message-nav-buttons">
		<a href="inbox.php"><img src='./../img/inbox_icon.png' alt='Inbox' />Inbox</a>
		<hr id="hr2"/>
		<a href="sent.php"><img src='./../img/sent.png' alt='Sent' />Sent</a>
		<hr id="hr2"/>
		<a href="draft.php"><img src='./../img/draft.png' alt='Draft' />Drafts</a>
		<hr id="hr2"/>
		<a href="deleted.php"><img src='./../img/trash.png' alt='Sent' />Deleted</a><br/>
	</div>
</div>
<br/>
<div id='messageHead'>
<h2  >Drafts</h2>
</div>
<div class="bgstyle4">
    <div id="msg">
	<br/>
	<div id="draft-2">
<?php
	//retreive messages that are marked from_user
	$get_messages = ("SELECT * FROM `collaborate`.`pvt_messages` WHERE `from_user`='$username' AND `draft`='1' AND `senderDelete`='0'");
	//call to function to get messages
	GetMessages($get_messages, 3);

    print("</div></div></div>");
    
    _html_end();
?>