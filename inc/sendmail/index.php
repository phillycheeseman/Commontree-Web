<?php
require("./inc/sendmail/inc/class.sendmail.php");
$mail = new SendMail;
	
	$mail->addEmail("philip.singer@commontree.com");
	
	$mail->subject("Test 2");
	$mail->body("Hi There - What is happening?");
	
	$mail->fromName("Philip Rodrigues Singer");
	$mail->fromEmail("philip@islandapps.ca");
	
	$mail->Mailer = 'mail'; //options: smtp, mail, sendmail
	
	$result = $mail->send();
	
	if (!$result){
		if(!empty($mail->errors)) {
			$mail->displayErrors($mail->errors,'li');
		}
		exit();
	}

echo "Email sent";
?>