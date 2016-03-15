<?php
/**
* File Upload process
* @author: Gustavo Novaro
* @version: 2.0
*/
require('application/bootstrap.php');
require('function.php');

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
	$sPath = $_SESSION['path'].DIRECTORY_SEPARATOR.$sourceFileName;
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
