<?php
	date_default_timezone_set('America/New_York');
	
	$titleBarCompanyName = "";
	$footerCompanyName = "";

	$dbLocation = "";
	$dbName = "";
	
	$dbUserName = "";
	$dbPassWord = "";

	$salt = "";
	$peppa = "";

	// *******************************************************************************************************
	// New Member Email Settings
	//
		$emailSubject_NM = "Company - New Member Verification";
		$emailBody_NM = "You are cordially invited to join the Company:\n\nTo confirm your login and set your password, please click:\nhttp://www.company.com/verifyNewMemberForm.php?";
		$emailFromName_NM = "Company Admin";
		$emailFromAddress_NM = "company@company.com";
	//
	// *******************************************************************************************************

	
	// *******************************************************************************************************
	// Forgotten Password Email Settings
	//
		$emailSubject_FP = "Company - Password Reset";
		$emailBody_FP = "Did you forget your Company password?\n\nPlease click below to reset your password:\http://www.company.com/verifyForgottenPasswordForm.php?";
		$emailFromName_FP = "Company Admin";
		$emailFromAddress_FP = "company@company.com";
	//
	// *******************************************************************************************************

	
	// *******************************************************************************************************
	// Verify New Member Email Settings
	//
		$emailSubject_VNM = "Company - Welcome!";
		$emailBody_VNM = "Welcome to the Company.\n\nIf you have any questions or suggestions, please contact: company@company.com\n\n";
		$emailFromName_VNM = "Company Admin";
		$emailFromAddress_VNM = "company@company.com";
	//
	// *******************************************************************************************************
?>