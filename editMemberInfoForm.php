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
		$scriptAction = 4;
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
		
		$memberID = filter_input(INPUT_POST, 'memberID', FILTER_SANITIZE_STRING);
		$memberFirstName = filter_input(INPUT_POST, 'memberFirstName', FILTER_SANITIZE_STRING);
		$memberLastName = filter_input(INPUT_POST, 'memberLastName', FILTER_SANITIZE_STRING);
		$memberAddress = filter_input(INPUT_POST, 'memberAddress', FILTER_SANITIZE_STRING);
		$memberCity = filter_input(INPUT_POST, 'memberCity', FILTER_SANITIZE_STRING);
		$memberStateProv = filter_input(INPUT_POST, 'memberStateProv', FILTER_SANITIZE_STRING);
		$memberZipPostal = filter_input(INPUT_POST, 'memberZipPostal', FILTER_SANITIZE_STRING);
		$memberCountry = filter_input(INPUT_POST, 'memberCountry', FILTER_SANITIZE_STRING);
		$memberPhone1 = filter_input(INPUT_POST, 'memberPhone1', FILTER_SANITIZE_STRING);
		$memberEmail = filter_input(INPUT_POST, 'memberEmail', FILTER_VALIDATE_EMAIL);
		$memberDescription = filter_input(INPUT_POST, 'memberDescription', FILTER_SANITIZE_STRING);
		$updateMember = filter_input(INPUT_POST, 'updateMember', FILTER_SANITIZE_STRING);

		if($memberLoginName && $memberLoginName != "")
		{
			
			$mySQLQuery = mysql_query("SELECT DISTINCT memberID FROM memberLogin WHERE memberLoginName='$memberLoginName'")or die(mysql_error());
			if(mysql_num_rows($mySQLQuery) == 1)
			{
				$memberLoginSQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
				$memberID = $memberLoginSQLQueryResultsArray['memberID'];
			
				if($updateMember == "true")
				{
					$mySQLQuery = mysql_query("UPDATE members SET memberFirstName='" . $memberFirstName . "', memberLastName='" . $memberLastName . "', memberAddress='" . $memberAddress . "', memberCity='" . $memberCity . "', memberStateProv='" . $memberStateProv . "', memberZipPostal='" . $memberZipPostal . "', memberCountry='" . $memberCountry . "', memberPhone1='" . $memberPhone1 . "', memberEmail='" . $memberEmail . "', memberDescription='" . $memberDescription . "' WHERE memberID='" . $memberID . "'")or die(mysql_error());
				}
				else
				{
					$mySQLQuery = mysql_query("SELECT DISTINCT * FROM members WHERE memberID='" . $memberID . "'")or die(mysql_error());
					$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
					
					$memberFirstName = $mySQLQueryResultsArray['memberFirstName'];
					$memberLastName = $mySQLQueryResultsArray['memberLastName'];
					$memberAddress = $mySQLQueryResultsArray['memberAddress'];
					$memberCity = $mySQLQueryResultsArray['memberCity'];
					$memberStateProv = $mySQLQueryResultsArray['memberStateProv'];
					$memberZipPostal = $mySQLQueryResultsArray['memberZipPostal'];
					$memberCountry = $mySQLQueryResultsArray['memberCountry'];
					$memberPhone1 = $mySQLQueryResultsArray['memberPhone1'];
					$memberEmail = $mySQLQueryResultsArray['memberEmail'];
					$memberDescription = $mySQLQueryResultsArray['memberDescription'];
				}
			}
			else
			{
				header("Location: ./index.php"); 
				exit();
			}
		}
		else
		{
			header("Location: ./index.php"); 
			exit();
		}
	//
	// *******************************************************************************************************
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<title>Member Profile</title>
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
		<?php include_once("./inc/menuBarMember.php"); ?>
		<script>setActiveMenuItem("memberProfileMenuItem");</script>
	
		<div class="container">
			<div class="hero-unit">
				<h2>Member Profile</h2>
			</div>
	
			<div class="row">
				<div class="span10 offset1">
					<?php
						if($updateMember == "true")
						{
					?>
							<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								<strong>Thank you!</strong> Your profile has been updated.
							</div>
					<?php
						}
					?>
					<form class="form-horizontal" id="editMemberInfoForm" name="editMemberInfoForm" method="post" action="./editMemberInfoForm.php">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="memberID">Member ID:</label>
								<div class="controls">
									<input type="text" class="input-xlarge disabled" id="memberID"  name="memberID" value="<?php echo $memberID; ?>" disabled>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberFirstName">First Name:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberFirstName"  name="memberFirstName" value="<?php echo $memberFirstName; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberLastName">Last Name:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberLastName"  name="memberLastName" value="<?php echo $memberLastName; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberAddress">Address:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberAddress"  name="memberAddress" value="<?php echo $memberAddress; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberCity">City:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberCity"  name="memberCity" value="<?php echo $memberCity; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberStateProv">Province:</label>
								<div class="controls">
									<select name="memberStateProv" id="memberStateProv">
										<?php
											$mySQLQuery = mysql_query("SELECT * FROM stateProv ORDER BY stateProv_sort_order")or die(mysql_error());
											while ($mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH))
											{
												$memberStateProvSelected = "";
												if($mySQLQueryResultsArray['stateProv_id'] == $memberStateProv)
												{
													$memberStateProvSelected = " selected='selected'";
												}
												echo "<option value='" . $mySQLQueryResultsArray['stateProv_id'] . "'" . $memberStateProvSelected . ">" . $mySQLQueryResultsArray['stateProv_name'] . "</option>\n";
											}
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberStateProv">Country:</label>
								<div class="controls">
									<select name="memberCountry" id="memberCountry">
										<?php
											$mySQLQuery = mysql_query("SELECT * FROM countries ORDER BY country_sort_order")or die(mysql_error());
											while ($mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH))
											{
												$memberCountrySelected = "";
												if($mySQLQueryResultsArray['country_id'] == $memberCountry)
												{
													$memberCountrySelected = " selected='selected'";
												}
												echo "<option value='" . $mySQLQueryResultsArray['country_id'] . "'" . $memberCountrySelected . ">" . $mySQLQueryResultsArray['country_name'] . "</option>\n";
											}
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberZipPostal">Postal Code:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberZipPostal"  name="memberZipPostal" value="<?php echo $memberZipPostal; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberPhone1">Phone:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberPhone1"  name="memberPhone1" value="<?php echo $memberPhone1; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberEmail">Email:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberEmail"  name="memberEmail" value="<?php echo $memberEmail; ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="memberDescription">Comments:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="memberDescription"  name="memberDescription" value="<?php echo $memberDescription; ?>">
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Go</button>
							</div>
						</fieldset>
						<input type="hidden" id="updateMember" name="updateMember" value="true" />
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