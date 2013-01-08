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
		$memberLoginPasswordOld = filter_input(INPUT_POST, 'memberLoginPasswordOld', FILTER_SANITIZE_STRING);
		$memberLoginPasswordNew = filter_input(INPUT_POST, 'memberLoginPasswordNew', FILTER_SANITIZE_STRING);
		$memberLoginPasswordConfirm = filter_input(INPUT_POST, 'memberLoginPasswordConfirm', FILTER_SANITIZE_STRING);
  	//
	// *******************************************************************************************************
	
	
	// *******************************************************************************************************
	// Verify...
	//
		if($memberLoginName == "")
		{
			header("Location: ./index.php"); 
			exit();
		}
		
		$mySQLQuery = mysql_query("SELECT DISTINCT memberID, memberLoginPassword FROM memberLogin WHERE memberLoginName='$memberLoginName'")or die(mysql_error());
		$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
		
		$memberLoginPasswordOldHash = hash('md5', $salt . $memberLoginName . $memberLoginPasswordOld . $peppa);
		
		//echo "<br /><br /><br /><br />" . "memberLoginName: " . $memberLoginName . "<br />";
		//echo $memberLoginPasswordOld . "<br />";
		//echo $memberLoginPasswordNew . "<br />";
		//echo $memberLoginPasswordConfirm . "<br />";
		//echo $memberLoginPasswordOldHash . "<br />";
		//echo $mySQLQueryResultsArray['memberLoginPassword'] . "<br />";
		
		if($memberLoginPasswordOldHash != $mySQLQueryResultsArray['memberLoginPassword'] || $memberLoginPasswordNew != $memberLoginPasswordConfirm || $memberLoginPasswordNew == "" || $memberLoginPasswordConfirm == "")
		{
			header("Location: ./changePasswordForm.php?pwError=true"); 
			exit();
		}
		
		$memberID = $mySQLQueryResultsArray['memberID'];
		$memberPasswordHash = hash('md5', $salt . $memberLoginName . $memberLoginPasswordNew . $peppa);
		$memberLoginToken = generateTokenValue($memberLoginName);
		$memberVerifyString = "";

		$mySQLQuery = mysql_query("UPDATE memberLogin SET memberLoginToken='$memberLoginToken', memberVerifyString='$memberVerifyString', memberLoginPassword='$memberPasswordHash' WHERE memberID='$memberID'")or die(mysql_error());
		
		$hour = time() + 3600 * 24 * 365 * 10;
		setCookie("memberLoginNameCookie", $memberLoginName, $hour, "/", false, 0);
		setCookie("memberTokenCookie", $memberLoginToken, $hour, "/", false, 0);

		header("Location: ./index.php"); 
		exit();
  	//
	// *******************************************************************************************************
?>

<?php include_once("./inc/dbDisconnect.php"); ?>

<?php
	ob_end_flush();
?>