<?php
/**
* Setup Process
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.59
*/
require("./error_handler.php");	
require("./function.php");
session_start();
if ($_POST["txtUserAdmin"]){
	$sUser = $_POST["txtUserAdmin"];
	$sPass = sha1($_POST["txtPassAdmin"]);
	$sUrl = $_POST["txtUrl"];
	$sTimeZone = (isset($_POST["php_zone"]))? $_POST["php_zone"] : "";
	$sVersion = '1.59';
	
	$oFile = fopen("config.php","w+");
	$sLineBreak = " \n";
	
	$sContent = '<?php '.$sLineBreak;
	$sContent .='/**'.$sLineBreak;
	$sContent .='* Configuration File'.$sLineBreak;
	$sContent .='* @author Gustavo Novaro <gnovaro@gmail.com>'.$sLineBreak;
	$sContent .='* @version '.$sVersion.$sLineBreak;
	$sContent .='* http://fileexplorerxp.googlecode.com'.$sLineBreak;
	$sContent .='*/'.$sLineBreak;
	$sContent .='$sConfig["VERSION"]   = "'.$sVersion.'";'.$sLineBreak;
	$sContent .='$sConfig["USER"]      = "'.$sUser.'"; '.$sLineBreak;
	$sContent .='$sConfig["PASS"]      = "'.$sPass.'"; '.$sLineBreak;
	$sContent .='$sConfig["TIME_ZONE"] = "'.$sTimeZone.'"; '.$sLineBreak;
	$sContent .='define("URL","'.$sUrl.'"); '.$sLineBreak;
	
	fwrite($oFile,$sContent);
	fclose($oFile);
	chmod('config.php',444); //Change file permisions to read only
	$_SESSION['__MSG__'] = 'Setup Sucess';
	redirect('index.php');
}//if
