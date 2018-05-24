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
		<a href="inbox.php"><button>Inbox</button></a>
		<hr class="hr"/>
		<a href="sent.php"><button>Sent</button></a>
		<hr class="hr"/>
		<a href="deleted.php"><button>Deleted</button></a>
	</div>
</div>
<br/>
<div class="bgstyle">
    <h2 id='messageHead' >Deleted</h2>
	<div class="hr" ></div>
	<br/><br/>
<?php
  //retreive messages that are marked deleted by user
  $grab_messages = ( "SELECT * FROM pvt_messages WHERE to_user='$username' && recipientDelete='1'");
  //call to function to get messages
  GetMessages($get_messages, 1);
?>
</div>
<br/>
<?php
   _html_end()
?>
