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
		$scriptAction = 2;
		$memberAllowed = checkActionAllow($scriptAction);
		
		if($memberAllowed)
		{
			header("Location: ./schedule.php"); 
			exit();
		}
	//
	// *******************************************************************************************************

	
	// *******************************************************************************************************
	// Sanitize memberLoginName and memberPassword and memberRemember
	//
		$filters = array
		(
			"memberLoginName"=> FILTER_VALIDATE_EMAIL,
			"memberPassword"=> FILTER_SANITIZE_STRING,
			"memberRemember"=> FILTER_SANITIZE_STRING,
		);
		$formDataArray = filter_input_array(INPUT_POST, $filters);
		
		/*
		echo $formDataArray['memberLoginName'] . "<br />";
		echo $formDataArray['memberPassword'] . "<br />";
		echo $formDataArray['memberRemember'] . "<br />";
		print_r(filter_input_array(INPUT_POST, $filters));
		*/
	//
	// *******************************************************************************************************
		
		
	// *******************************************************************************************************
	// If there is data then check login... 
	//
		if($formDataArray['memberLoginName'] && $formDataArray['memberPassword'])
		{
			// Set a memberPasswordHash so we are not storing the actual password in DB - the $salt and $peppa addative values are in the commonTreeUtilities.php script for global access.
			//
			$memberPasswordHash = hash('md5', $salt . $formDataArray['memberLoginName'] . $formDataArray['memberPassword'] . $peppa);
	
			// Lookup $formDataArray['memberLoginName'] with $memberPasswordHash and get $memberToken
			//
			$mySQLQuery = mysql_query("SELECT DISTINCT memberID, memberLoginToken FROM memberLogin WHERE memberLoginName='" . $formDataArray['memberLoginName'] . "' AND memberLoginPassword='" . $memberPasswordHash . "'")or die(mysql_error());
			$mySQLQueryResultRow = mysql_fetch_array($mySQLQuery);
			
			$mySQLMemberID = $mySQLQueryResultRow['memberID'];
			$mySQLMemberLoginToken = $mySQLQueryResultRow['memberLoginToken'];
	
			// Set memberLoginNameCookie
			//
			if($mySQLMemberID && $mySQLMemberID != "")
			{
				$hour = -rand(1, 100000);
				if($formDataArray['memberRemember'])
				{
					$hour = time() + 3600 * 24 * 365 * 10;
				}
				
				setCookie("memberLoginNameCookie", $formDataArray['memberLoginName'], $hour, "/", false, 0);
				setCookie("memberTokenCookie", $mySQLMemberLoginToken, $hour, "/", false, 0);
	
				header("Location: ./schedule.php"); 
				exit();
			}
			else
			{
				setCookie("memberLoginNameCookie", "", time()-3600);
				setcookie("memberTokenCookie", "", time()-3600);
			}
		}
	//
	// *******************************************************************************************************
?>
		
		
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Company</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="./css/styles.css" rel="stylesheet" media="screen">
		<script src="js/script.js"></script>
	</head>
	<body>
		<?php include_once("./inc/menuBarGuest.php"); ?>
		<script>setActiveMenuItem("loginMenuItem")</script>
	
		<div class="container">
			<div class="row">
				<div class="span10 offset1">
					<form class="well form-inline" action="./index.php" method="post">
						<input type="email" class="input-long" name="memberLoginName" id="memberLoginName" placeholder="Email Address" required>
						<input type="password" class="input-long" placeholder="Password" name="memberPassword" id="memberPassword">
						<label class="checkbox memberRemember" for="memberRemember">
							<input type="checkbox" id="memberRemember" name="memberRemember" checked> Remember?
						</label>
						<button type="submit" class="btn">Login</button>
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