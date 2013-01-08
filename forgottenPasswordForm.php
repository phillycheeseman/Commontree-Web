<?php
	// *******************************************************************************************************
	/*
		Copyright (c) 2013, Commontree Inc.
		All rights reserved.
		
		Redistribution and use in source and binary forms, with or without 
		modification, are permitted provided that the following conditions are
		met:
		
		* Redistributions of source code must retain the above copyright notice, 
		this list of conditions and the following disclaimer.
		
		* Redistributions in binary form must reproduce the above copyright
		notice, this list of conditions and the following disclaimer in the 
		documentation and/or other materials provided with the distribution.
		
		* Neither the name of Commontree Inc. nor the names of its 
		contributors may be used to endorse or promote products derived from 
		this software without specific prior written permission.
		
		THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
		IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
		THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
		PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR 
		CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
		EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
		PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
		PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
		LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
		NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
		SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	*/
	// *******************************************************************************************************

	ob_start();
?>

<?php include_once("./inc/commonTree_PList.php"); ?>
<?php include_once("./inc/dbConnect.php"); ?>
<?php include_once("./inc/commonTreeUtilities.php"); ?>

<?php
	// *******************************************************************************************************
	// Set $deBug flag
	//
		$deBug = false;
	//
	// *******************************************************************************************************
	
	
	// *******************************************************************************************************
	// Sanitize memberLoginName
	//
		$memberLoginName = filter_input(INPUT_POST, 'memberLoginName', FILTER_VALIDATE_EMAIL);
  	//
	// *******************************************************************************************************


	// *******************************************************************************************************
	// Generate A Member Verification String...
	//
		$emailResult = true;
		
		if ($memberLoginName)
		{
				$mySQLQuery = mysql_query("SELECT DISTINCT memberLoginToken, memberLoginTypeID FROM memberLogin WHERE memberLoginName = '$memberLoginName'")or die(mysql_error());
				
				if(mysql_num_rows($mySQLQuery) == 1)
				{
					$memberVerifyString = generateTokenValue($memberLoginName);
				
					$mySQLQuery = mysql_query("UPDATE memberLogin SET memberVerifyString = '$memberVerifyString' WHERE memberLoginName='$memberLoginName'")or die(mysql_error());
					
					// *******************************************************************************************************
					// Send Mail...
					//
						require("./inc/sendmail/inc/class.sendmail.php");
						$mail = new SendMail;
							
						$mail->addEmail($memberLoginName);
						
						$mail->subject($emailSubject_FP);
						
						$mail->body($emailBody_FP . "memberLoginName=$memberLoginName&memberVerifyString=$memberVerifyString");
						
						$mail->fromName($emailFromName_FP);
						
						$mail->fromEmail($emailFromAddress_FP);
						
						$mail->Mailer = 'mail';
						$emailResult = $mail->send();
						
						if (!$emailResult){
							if(!empty($mail->errors)) {
								// $mail->displayErrors($mail->errors,'li');
							}
						}
				}
		}
	//
	// *******************************************************************************************************
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Forgotten Password</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">

		<link href="./css/styles.css" rel="stylesheet" media="screen">

		<script src="js/script.js"></script>
	</head>
	<body>
		<?php include_once("./inc/menuBarGuest.php"); ?>
		<script>setActiveMenuItem("forgottenPasswordMenuItem");</script>

		<div class="container">
			<div class="hero-unit">
				<h2>Forgotten Password?</h2>
			</div>

			<div class="row">
				<div class="span12">
	
					<?php
						if ($memberLoginName && $emailResult)
						{
					?>
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<strong>Thank you!</strong> An email has been sent to <?php echo $memberLoginName; ?>.
							</div>
					<?php
						}
						else
						{
							if(!$emailResult)
							{
					?>
								<div class="alert alert-error">
									<a class="close" data-dismiss="alert">&times;</a>
									<strong>Oh snap!</strong> There was an error sending an email to <?php echo $memberLoginName; ?>.
								</div>
					<?php
							}
						}
					?>
					
					<form class="form-horizontal" id="forgottenPassword" name="forgottenPassword" method="post" action="./forgottenPasswordForm.php">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="memberLoginName">Forgotten password:</label>
								<div class="controls">
									<input type="email" class="input-xlarge" id="memberLoginName"  name="memberLoginName" placeholder="Email Address">
									<p class="help-block">We'll send you an email so you may reset your password.</p>
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Go</button>
							</div>
						</fieldset>
					</form>
					
				</div>
			</div>
			<?php include_once("./inc/footer_01.php"); ?>
		</div>
	
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="./js/bootstrap.js"></script>
	</body>
</html>

<?php include_once("./inc/dbDisconnect.php"); ?>

<?php
	ob_end_flush();
?>