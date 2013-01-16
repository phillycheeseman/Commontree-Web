<?php
	date_default_timezone_set('America/New_York');
	
	$titleBarCompanyName = "QCYC Tender Schedule";
	$footerCompanyName = "Queen City Yacht Club";

	$dbLocation = "mysql.islandapps.ca";
	$dbName = "iapps_qcyctenderschedule";
	
	//$dbUserName = "phillycheeseman";
	//$dbPassWord = "cheeseman";
	$dbUserName = "qcyc_admin";
	$dbPassWord = "qcyc_admin_sched";

	$salt = "newton";
	$peppa = "bunny";

	// *******************************************************************************************************
	// New Member Email Settings
	//
		$emailSubject_NM = "QCYC Tender Schedule - New Member Verification";
		$emailBody_NM = "You are cordially invited to join the QCYC Tender Schedule:\n\nTo confirm your login and set your password, please click:\nhttp://www.islandapps.ca/QCYCTenderSchedule/verifyNewMemberForm.php?";
		$emailFromName_NM = "QCYC Tender Schedule Admin";
		$emailFromAddress_NM = "admin@islandapps.ca";
	//
	// *******************************************************************************************************

	
	// *******************************************************************************************************
	// Forgotten Password Email Settings
	//
		$emailSubject_FP = "QCYC Tender Schedule - Password Reset";
		$emailBody_FP = "Did you forget your QCYC Tender Schedule password?\n\nPlease click below to reset your password:\nhttp://www.islandapps.ca/QCYCTenderSchedule/verifyForgottenPasswordForm.php?";
		$emailFromName_FP = "QCYC Tender Schedule Admin";
		$emailFromAddress_FP = "admin@islandapps.ca";
	//
	// *******************************************************************************************************

	
	// *******************************************************************************************************
	// Verify New Member Email Settings
	//
		$emailSubject_VNM = "QCYC Tender Schedule - Welcome!";
		$emailBody_VNM = "Welcome to the QCYC Tender Schedule.\n\nIf you have any questions or suggestions, please contact: admin@islandapps.ca\n\n";
		$emailFromName_VNM = "QCYC Tender Schedule Admin";
		$emailFromAddress_VNM = "admin@islandapps.ca";
	//
	// *******************************************************************************************************
?>