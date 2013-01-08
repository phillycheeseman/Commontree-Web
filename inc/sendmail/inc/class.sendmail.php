<?php

 /*
 * SendMail Class
 * Version 2.1
 *
 * Author: Koa Metter (koa.metter@bkwld.com)
 * Updated: Tues, Jan 15 2008
 *
 * Specifically for PHPMailer to prevent
 * spammers/hackers from abusing a contact or
 * newsletter form. 
 *
 * @author Koa Metter
 */


// -- imports
require("./inc/sendmail/inc/phpmailer/class.phpmailer.php");
require("./inc/sendmail/inc/phpmailer/class.smtp.php");
require("./inc/sendmail/inc/phpmailer/class.pop3.php");
require("./inc/sendmail/inc/language/phpmailer.lang-en.php");

class SendMail extends PHPMailer {
	
	/**
	  *	Public Vars
	  */
	
	var $CharSet		= 'utf-8';
	var $Host			= 'localhost';
	var $username = "philly@islandapps.ca";
	var $password = "cheeseman";
	var $authHosts;
	var $attachments	= array();
	var $Mailer			= 'smtp';
	var $bodyText;
	var $bodyHtml;
	
	var $errors;
	
	/**
	  *	Private Vars
	  */
	
	var $_emails = array();
	var $_bodyText;
	var $_bodyHtml;
	var $_subject;
	var $_fromName;
	var $_fromEmail;
	
	
	function addEmail ($email, $name = '') {
		if ($this->isValidEmail($email) && !$this->badStr($name)) {          
	    	if(!is_array($this->_emails)) $this->_emails = array();
			array_push($this->_emails, array($name => $email));
	    } else {
			$this->error("Send to: $name &lt;$address&gt; is not a valid email address.");
		}
	}
	
	function subject ($subject) {
		!$this->badStr($subject) ? $this->_subject = $subject : $this->error("Possible attack: Invalid subject");
	}
	
	function body ($bodyText, $bodyHtml = null) {
		if ($bodyHtml != '') $this->_bodyHtml = $bodyHtml;
		if ($bodyText != '') $this->_bodyText = $bodyText;
	}
	
	function from ($email, $name) {
		$this->fromEmail($email);
		$this->fromName($name);
	}
	
	function fromName ($name) {
		!$this->badStr($name) ? $this->_fromName = $name : $this->error("Possible attack: Invalid from name.");
	}
	
	function fromEmail ($email) {
		!$this->badStr($email) && $this->isValidEmail($email) ? $this->_fromEmail = $email : $this->error("Possible attack: Invalid from email");
	}
	
	function send () {
		
		// -- create PHPMailer
		$mail = new PHPMailer();
		
		// -- verify domain as OK
		if(is_array($this->authHosts)) $this->verify($this->authHosts);
		
		//exit(print_r($this->_emails));
		
		foreach($this->_emails as $theEmails) {
			foreach ($theEmails as $name => $email) {          
	    		$mail->AddAddress($email,$name);
			}
	    }
	
		$mail->From = $this->_fromEmail;
		$mail->FromName = $this->_fromName;
		$mail->Subject = $this->_subject;
		
		if ($this->_bodyHtml != '') {
		    $mail->IsHTML(true);       
		    $mail->Body = $this->_bodyHtml;
		    $mail->AltBody = $this->_bodyText;
		} else {
		    $mail->IsHtml(false);
		    $mail->Body = $this->_bodyText;
		}

		if ($this->username !== null) {
			$mail->SMTPAuth = true;
		    $mail->Username = $this->username;	// SMTP username
		    $mail->Password = $this->password;	// SMTP password           
		}

		$mail->WordWrap = 75;					// set word wrap
		if(!empty($this->attachments)) {
			foreach ($this->attachments as $attach) {
			    $mail->AddAttachment($attach['path'],$attach['name'],'base64',$attach['type']);
			}
		}
		
		if(!empty($this->errors)) {
			return false;
			exit();
		}
		
		if (!$mail->Send()) {
			$this->error($mail->ErrorInfo);
		    return false;           
		} else return true;
	}
	
	// -- make sure email addresses are valid
	function isValidEmail ($email) {
		if(preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email)) {
			return true;
		}
	}
	
	// -- check if "attack terms" are being used
	function badStr ($str_to_test) {
		$bad_strings = array(
			"content-type:"
			,"mime-version:"
			,"multipart/mixed"
			,"Content-Transfer-Encoding:"
			,"bcc:"
			,"cc:"
			,"to:"
		);

		foreach($bad_strings as $bad_string) {
			if(eregi($bad_string, strtolower($str_to_test))) return true;
		}
	}
	
	/**
	  * verify
	  * + make sure we're posting from a legit domain
	  *		@ authHosts - array of hosts
	  * ex:
	  *		$result = new verify(array("domain.com"));
	  */
	function verify ($authHosts) {

		// make sure the form was posted from a browser
		if(!isset($_SERVER['HTTP_USER_AGENT'])){
			header('HTTP/1.1 403 Forbidden');
			$this->error("Forbidden - You are not authorized to view this page.");
			exit;
		}

		if(!$_SERVER['REQUEST_METHOD'] == "POST"){
			header('HTTP/1.1 403 Forbidden');
			$this->error("Forbidden - You are not authorized to view this page.");
			exit;    
		}

		$fromArray = parse_url(strtolower($_SERVER['HTTP_REFERER']));

		// test to see if the $fromArray used "www" to get here
		$wwwUsed = strpos($fromArray['host'], "www.");

		if(!in_array(($wwwUsed === false ? $fromArray['host'] : substr(stristr($fromArray['host'], '.'), 1)), $authHosts)){    
			header('HTTP/1.1 403 Forbidden');
		   	$this->error("Forbidden - You are not authorized to send email from this domain.");
		    exit();
		}  

		// we're done, free up some memory   
		unset($authHosts, $fromArray, $wwwUsed);
	}
	
	// -- add a message to stack
	function error ($message) {
		if (!is_array($this->errors)) $this->errors = array();
		array_push($this->errors, $message);
	}
	
	// -- nicely display errors via <ul> or <ol>
	function displayErrors ($messages, $type = null) {
		$display = '';
		if (!is_null($type)) {
			$allowed = array('ul','ol');
			if(!in_array($type,$allowed)) $type = 'ul';
		
			$display = "<".$type.">";
		
			if(!is_array($messages)) {
				$display .= $inner[0].$messages.$inner[1];
			} else {
				switch ($type) {
					case "ul":
					case "ol":
						$inner = array("<li>","</li>");
						break;
				}
				foreach($messages as $message) {
					$display .= $inner[0].$message.$inner[1];
				}
			}
			$display .= "</".$type.">";
		} else {
			$count = 0;
			foreach($messages as $message) {
				if ($count!=0&&$count<=count($messages)) $display .= "&";
				$display .= $message;
				$count++;
			}
		}
		echo $display;
	}
}
?>