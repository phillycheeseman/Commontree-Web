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
	// Test scriptAction vs. memberAllowed
	//
		$scriptAction = 5;
		$memberAllowed = checkActionAllow($scriptAction);
		
		if(!$memberAllowed)
		{
			header("Location: ./index.php"); 
			exit();
		}
	//
	// *******************************************************************************************************

	
	// *******************************************************************************************************
	// Get memberLoginName from the memberLoginNameCookie
	//
		$memberLoginName = filter_var($_COOKIE['memberLoginNameCookie'], FILTER_VALIDATE_EMAIL);
		$pwError = filter_input(INPUT_GET, 'pwError', FILTER_SANITIZE_STRING);
	//
	// *******************************************************************************************************
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Change Password</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">

		<link href="./css/styles.css" rel="stylesheet" media="screen">

		<script src="js/script.js"></script>
	</head>
	<body>
		<?php include_once("./inc/menuBarMember.php"); ?>
		<script>setActiveMenuItem("changePasswordMenuItem");</script>
	
		<div class="container">
			<!-- Main hero unit for a primary marketing message or call to action -->
			<div class="hero-unit">
				<h2>Change Password?</h2>
			</div>
	
			<div class="row">
				<div class="span12">
					<?php
						if($pwError == "true")
						{
					?>
						<div class="alert alert-error">
							<a class="close" data-dismiss="alert">&times;</a>
							<strong>Oh snap!</strong> Change a few things up and try submitting again.
						</div>
					<?php
						}
					?>
					<form class="form-horizontal" id="changePasswordForm" name="changePasswordForm" method="post" action="./verifyChangePassword.php">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="memberLoginPasswordOld">Old password:</label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="memberLoginPasswordOld"  name="memberLoginPasswordOld">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberLoginPasswordNew">New password:</label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="memberLoginPasswordNew"  name="memberLoginPasswordNew">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberLoginPasswordConfirm">Confirm password:</label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="memberLoginPasswordConfirm"  name="memberLoginPasswordConfirm">
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Go</button>
							</div>
						</fieldset>
						<input name="memberLoginName" type="hidden" id="memberLoginName" value="<?php echo $memberLoginName; ?>" />
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