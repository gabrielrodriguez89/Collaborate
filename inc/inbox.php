<?php
/*
@Auther: Gabriel Rodriguez
Page: deleted
Project: collaborate
Date: 3/6/2018

inbox.php was written to retreive messages from the database
these messages are currently marked with an ENUM value set to 0
the user also has the option to move the message back to the deleted
by setting the ENUM value to 1.
Collaborate 2017-2018
*/
  include "header.php";
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
    <h2 id='messageHead' >Inbox</h2>
	<div class="hr" ></div>
	<br/><br/>
<?php
  //retreive messages that are for user
  $get_messages = ("SELECT * FROM `pvt_messages` WHERE to_user='$username' && opened='0' && recipientDelete='0'");
  //call to function to get messages
  GetMessages($get_messages, 0);
?>

</div>
<br/>
<?php
  _html_end();
?>
