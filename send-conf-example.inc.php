<?php
$smtp_configuration = array (	'host' => "ssl://mail.example.com",
				'port' => "465",
				'auth' => true,
				'username' => "smtp_username",
				'password' => "smtp_password");

$email_from = "Sandra Sender <sender@example.com>";
$email_subject = "Secret Santa";
$email_body = "Hi {name},

This is an example of e-mail.
The gift must be less than 80$.
It will be exchanged next friday.

You must give your gift to {to-full}.
 
SPOILER: If you want to know who will give the gift to you, you should wait it from {from-full}.

End of Example... ;)";
?>
