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
	// Test scriptAction vs. memberAllowed
	//
		$scriptAction = 2;
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
	//
	// *******************************************************************************************************
?>
	
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<title>Company</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="./css/styles.css" rel="stylesheet" media="screen">
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="./js/bootstrap.js"></script>
		<script src="./js/script.js"></script>

		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
	</head>
	<body>
		<?php include_once("./inc/menuBarMember.php"); ?>
		<script>setActiveMenuItem("scheduleMenuItem");</script>
		
		<div class="container">
			<div class="row">
				<div class="span12">
					Content...
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