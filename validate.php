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
	$user = addslashes($_POST["txtUserName"]);  
	$pass = sha1(addslashes($_POST["txtPass"]));
	if ( $user == $sConfig["USER"] &&  $pass == $sConfig["PASS"])
	{
		session_start();
		$_SESSION["login"] = true;
		header("Location: tree.php");	
	}else{
		header("Location: index.php?err=Invalid user or password");
	}//if
?>