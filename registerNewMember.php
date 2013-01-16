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
	// Get memberLoginName from the memberLoginNameCookie
	//
		$memberLoginName = filter_var($_COOKIE['memberLoginNameCookie'], FILTER_VALIDATE_EMAIL);
		$updateResult = false;
		$emailResult = true;
		
		$updateMember = filter_input(INPUT_POST, 'updateMember', FILTER_SANITIZE_STRING);
		$newMemberID = "";
		$newMemberLoginName = filter_input(INPUT_POST, 'memberLoginName', FILTER_VALIDATE_EMAIL);
		$newMemberLoginPassword = "";
		$newMemberLoginToken = "";
		$newMemberDateAdded = filter_input(INPUT_POST, 'memberDateAdded', FILTER_SANITIZE_STRING);
		$newMemberDateAddedServer = "";
		if($newMemberDateAdded && $newMemberDateAdded != "")
		{
			$newMemberDateAddedServer = date("Y-m-d", strtotime($newMemberDateAdded));
		}
		$newMemberExpiryDate = filter_input(INPUT_POST, 'memberExpiryDate', FILTER_SANITIZE_STRING);
		$newMemberExpiryDateServer = date("Y-m-d", strtotime($newMemberExpiryDate));
		$newMemberVerifyString = generateTokenValue($newMemberLoginName);
		$newMemberVerified = 0;
		$newMemberActive = 0;
		$newMemberLoginTypeID = filter_input(INPUT_POST, 'memberLoginTypeID', FILTER_SANITIZE_STRING);
		$newMemberEmployeeID = filter_input(INPUT_POST, 'memberEmployeeID', FILTER_SANITIZE_STRING);
		
		$newMemberFirstName = filter_input(INPUT_POST, 'memberFirstName', FILTER_SANITIZE_STRING);
		$newMemberMiddleName = "";
		$newMemberLastName = filter_input(INPUT_POST, 'memberLastName', FILTER_SANITIZE_STRING);
		$newMemberAddress = "";
		$newMemberCity = "";
		$newMemberCounty = "";
		$newMemberStateProv = "61";
		$newMemberZipPostal = "";
		$newMemberCountry = "2";
		$newMemberLat = "";
		$newMemberLong = "";
		$newMemberPhone1 = "";
		$newMemberPhone2 = "";
		$newMemberMobile = "";
		$newMemberFax = "";
		$newMemberEmail = filter_input(INPUT_POST, 'memberLoginName', FILTER_SANITIZE_STRING);
		$newMemberDescription = filter_input(INPUT_POST, 'memberDescription', FILTER_SANITIZE_STRING);
		

		// Query mySQL for memberID and memberPasswordHash and return a memberToken
		//
		if($newMemberLoginName != "" && $updateMember == "true")
		{
			$mySQLQuery = mysql_query("SELECT DISTINCT memberID FROM memberLogin WHERE memberLoginName='$newMemberLoginName'")or die(mysql_error());
			$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
			if(mysql_num_rows($mySQLQuery) == 0)
			{
				$mySQLQuery = mysql_query("INSERT INTO memberLogin (memberLoginName, memberLoginPassword, memberLoginToken, memberDateAdded, memberVerifyString, memberVerified, memberActive, memberLoginTypeID, memberExpiryDate, memberEmployeeID) VALUES ('$newMemberLoginName', '$newMemberLoginPassword', '$newMemberLoginToken', '$newMemberDateAddedServer', '$newMemberVerifyString', '$newMemberVerified', '$newMemberActive', '$newMemberLoginTypeID', '$newMemberExpiryDateServer', '$newMemberEmployeeID')")or die(mysql_error());
				$mySQLQuery = mysql_query("SELECT DISTINCT memberID FROM memberLogin WHERE memberLoginName='$newMemberLoginName'")or die(mysql_error());
				$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
				if($mySQLQueryResultsArray['memberID'])
				{
					$newMemberID = $mySQLQueryResultsArray['memberID'];
					$mySQLQuery = mysql_query("INSERT INTO members (memberID, memberFirstName, memberMiddleName, memberLastName, memberAddress, memberCity, memberCounty, memberStateProv, memberZipPostal, memberCountry, memberLat, memberLong, memberPhone1, memberPhone2, memberMobile, memberFax, memberEmail, memberDescription) VALUES ('$newMemberID', '$newMemberFirstName', '$newMemberMiddleName', '$newMemberLastName', '$newMemberAddress', '$newMemberCity', '$newMemberCounty', '$newMemberStateProv', '$newMemberZipPostal', '$newMemberCountry', '$newMemberLat', '$newMemberLong', '$newMemberPhone1', '$newMemberPhone2', '$newMemberMobile', '$newMemberFax', '$newMemberEmail', '$newMemberDescription')")or die(mysql_error());

					$updateResult = true;
					
					// *******************************************************************************************************
					//
					// Send Mail...
					//
					// *******************************************************************************************************
					//
					require("./inc/sendmail/inc/class.sendmail.php");
					$mail = new SendMail;
						
						$mail->addEmail($newMemberLoginName);
						
						$mail->subject($emailSubject_NM);
						
						$mail->body($emailBody_NM . "memberLoginName=$newMemberLoginName&memberVerifyString=$newMemberVerifyString");
						
						$mail->fromName($emailFromName_NM);
						
						$mail->fromEmail($emailFromAddress_NM);
						
						$mail->Mailer = 'mail';
						$emailResult = $mail->send();
						
						if (!$emailResult)
						{
							if(!empty($mail->errors)) {
								// $mail->displayErrors($mail->errors,'li');
							}
						}
					//
					// *******************************************************************************************************
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

		<title>Register A New Member</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="./css/styles.css" rel="stylesheet" media="screen">
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="./js/bootstrap.js"></script>
		<script src="./js/script.js"></script>
	</head>
	<body>
		<?php include_once("./inc/menuBarGuest.php"); ?>
		<script>setActiveMenuItem("loginMenuItem")</script>

		<div class="container">
			<div class="hero-unit">
				<h2>Registration</h2>
			</div>
			<div class="row">
				<div class="span12">
					<?php
						if($updateMember == "true")
						{
							if($updateResult && $emailResult)
							{
								?>
									<div class="alert alert-success">
										<a class="close" data-dismiss="alert">&times;</a>
										<strong>Thank you!</strong> An invitation email has been sent to <?php echo $newMemberLoginName; ?>.
									</div>
								<?php
							}
							else
							{
								if(!$updateResult)
								{
									if($newMemberLoginName == ""){
										?>
											<div class="alert alert-error">
												<a class="close" data-dismiss="alert">&times;</a>
												<strong>Oh snap!</strong> You must enter a Login Name.
											</div>
										<?php
									} else {
										?>
											<div class="alert alert-error">
												<a class="close" data-dismiss="alert">&times;</a>
												<strong>Oh snap!</strong> We already have a member by the name of <?php echo $newMemberLoginName; ?>.
											</div>
										<?php
									}
								}
								else
								{
									?>
										<div class="alert alert-error">
											<a class="close" data-dismiss="alert">&times;</a>
											<strong>Oh snap!</strong> There was an error sending an email to <?php echo $newMemberLoginName; ?>.
										</div>
									<?php
								}
							}
						}
					?>
					<form class="form-horizontal" id="registerNewMember" name="registerNewMember" method="post" action="./registerNewMember.php">
						<input type="hidden" id="memberDateAdded" name="memberDateAdded" value="<?php echo date("m/d/Y"); ?>" />
						<input type="hidden" id="memberExpiryDate" name="memberExpiryDate" value="12/31/2013" />
						<input type="hidden" id="memberLoginTypeID" name="memberLoginTypeID" value="4" />
						<input type="hidden" id="memberEmployeeID" name="memberEmployeeID" value="" />
						<input type="hidden" id="updateMember" name="updateMember" value="true" />
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="memberLoginName">Login Name:</label>
								<div class="controls">
									<input type="email" class="input-xlarge" id="memberLoginName"  name="memberLoginName" placeholder="Email Address">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberFirstName">First Name:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberFirstName"  name="memberFirstName">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberLastName">Last Name:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberLastName"  name="memberLastName">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberDescription">Description:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberDescription"  name="memberDescription">
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
	
	</body>
</html>

<?php include_once("./inc/dbDisconnect.php"); ?>

<?php
	ob_end_flush();
?>