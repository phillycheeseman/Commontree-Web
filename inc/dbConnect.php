<?php
	$connectionState = mysql_connect($dbLocation, $dbUserName, $dbPassWord) or die(mysql_error());
	mysql_select_db($dbName, $connectionState) or die(mysql_error());
?>