<?php
/**
* @uthor: G. Novaro <gnovaro@gmail.com>
* @version: 0.73
* URL: http://www.novarsystems.com.ar
* Purpouse: Generic validation hardcode
* Change Log:
* - Change md5 to sha1 for security
*/

	require("./config.php");
	require("./function.php");
	session_start();
	$user = addslashes($_POST["txtUserName"]);  
	$pass = sha1(addslashes($_POST["txtPass"]));
	if ( $user == $sConfig["USER"] &&  $pass == $sConfig["PASS"])
	{
		$_SESSION["login"] = true;
		goto("tree.php");	
	}else{
		$_SESSION["MSG"] = "Invalid user or password";
		goto("index.php");
	}//if
?>