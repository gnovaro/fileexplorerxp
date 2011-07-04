<?php
/**
* File Upload process
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 1.28
*/
require("./config.php");
require("./error_handler.php");
require("./function.php");
$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
//echo $sLang;
$sPath = "./languages/".$sLang.".php";
if (file_exists($sPath))
{
	require($sPath);
}
else
{
	//defualt lang spanish
	require("./languages/es.php"); 
}//if

//Security check
session_start();
if(!isset($_SESSION["login"]))
	redirect("index.php");
//security

for($q=0; $q <=count($_FILES);$q++){
	$sourceFileName = $_FILES['file']['name'][$q];
	/*
	//security validation dont upload and exe / php or other executable camufled files 
	if(is_executable($sourceFileName)){
		unlink($sourceFileName);
		$sMsg = "No se pueden subir ese archivo es un ejecutable";
		$sDestination = "my_account.php";
		redirect("thanks.php?msg=".$sMsg."&pg=".$sDestination);
	}//if
	*/
	$sPath = $_SESSION['path']."/".$sourceFileName;
	if(is_uploaded_file($_FILES['file']['tmp_name'][$q]))
	if (move_uploaded_file($_FILES['file']['tmp_name'][$q], $sPath))
	{	
		$sMsg = $CONTENT['UPLOAD_SUCESS'];
	}
	else
		$sMsg = $CONTENT['UPLOAD_FAIL'];
}//for		
	$_SESSION['__MSG__'] = $sMsg;
	redirect('tree.php');

