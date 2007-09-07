<?php
/*
Author: G. Novaro
E-mail: gnovaro@gmail.com
URL: http://www.novarsystems.com.ar
Purpouse: Generic validation hardcode
*/
	$user = $_POST["txtUserName"]; //adslash
	$pass = $_POST["txtPass"];
	if ( $user == "admin" &&  $pass == "admin")
	{
		session_start();
		$_SESSION["login"] = true;
		header("Location: tree.php");	
	}
	else
	{
		header("Location: index.php");
	}//if
?>