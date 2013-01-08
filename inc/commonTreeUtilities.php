<?php
	function checkActionAllow($tempScriptAction)
	{
		$tempAllowAccess=  false;
		
		if(isset($_COOKIE['memberLoginNameCookie'])){
			
			$tempMemberLoginName = filter_var($_COOKIE['memberLoginNameCookie'], FILTER_VALIDATE_EMAIL);
			$tempMemberToken = filter_var($_COOKIE['memberTokenCookie'], FILTER_SANITIZE_STRING);
			
			if($tempMemberLoginName && $tempMemberToken)
			{
				$mySQLQuery = mysql_query("SELECT DISTINCT memberLoginToken, memberLoginTypeID FROM memberLogin WHERE memberLoginName = '$tempMemberLoginName'")or die(mysql_error());
				
				if(mysql_num_rows($mySQLQuery) == 1)
				{
					$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
					if ($tempMemberToken == $mySQLQueryResultsArray['memberLoginToken'])
					{
						$tempMemberLoginTypeID = $mySQLQueryResultsArray['memberLoginTypeID'];
						
						$mySQLQuery = mysql_query("SELECT DISTINCT allow FROM actions WHERE loginTypeID='$tempMemberLoginTypeID' AND actionID='$tempScriptAction'")or die(mysql_error());
						
						if(mysql_num_rows($mySQLQuery) == 1)
						{
							$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
							if($mySQLQueryResultsArray['allow'] == "1")
							{
								$tempAllowAccess=  true;
							}
						}
					}
				}
			}
		}
		
		return $tempAllowAccess;
	}
	
	function checkMemberCookie()
	{
		$tempMemberLoginTypeID = -1;
		
		if(isset($_COOKIE['memberLoginNameCookie']))
		{
			$tempMemberLoginName = filter_var($_COOKIE['memberLoginNameCookie'], FILTER_VALIDATE_EMAIL);
			$tempMemberToken = filter_var($_COOKIE['memberTokenCookie'], FILTER_SANITIZE_STRING);
			
			if($tempMemberLoginName && $tempMemberToken)
			{
				$mySQLQuery = mysql_query("SELECT DISTINCT memberLoginToken, memberLoginTypeID FROM memberLogin WHERE memberLoginName = '$tempMemberLoginName'")or die(mysql_error());
				
				if(mysql_num_rows($mySQLQuery) == 1)
				{
					$mySQLQueryResultsArray = mysql_fetch_array($mySQLQuery, MYSQL_BOTH);
					if ($tempMemberToken == $mySQLQueryResultsArray['memberLoginToken']){
						$tempMemberLoginTypeID = $mySQLQueryResultsArray['memberLoginTypeID'];
					}
				}
			}
		}
				
		return $tempMemberLoginTypeID;
	}
	
	function generateTokenValue($tempMemberLoginName)
	{
		$tempDateStringA = time() . rand(1, 10000);
		$tempDateStringB = rand(1, 10000);
		$tempPrefix = rand(1, 100);
		$tempSuffix = rand(1, 1000);

		$tempReturnMemberToken = mysql_escape_string($tempDateStringA . "-" . hash('md5', $tempPrefix . $tempMemberLoginName . session_id() .      $tempSuffix) . "-" . $tempDateStringB);
		
		return $tempReturnMemberToken;
	}

	// *** needs to be updated
	function deleteOldMembers()
	{
		$today = date("Y-m-d");
		$update = mysql_query("DELETE FROM members WHERE member_createdOn<'" . $today . "' AND member_verified=0")or die(mysql_error());
		$update_vendor = mysql_query($update);
	}
?>