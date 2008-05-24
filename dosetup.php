<?php
/**
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.25
* Change Log
* - Change md5 to sha1
*/
require("./error_handler.php");	
require("./function.php");
session_start();
if ($_POST["txtUserAdmin"]){
	$sUser = $_POST["txtUserAdmin"];
	$sPass = sha1($_POST["txtPassAdmin"]);
	$sUrl = $_POST["txtUrl"];
	$sTimeZone = (isset($_POST["php_zone"]))? $_POST["php_zone"] : "";
	$sVerion = "1.25";
	
	$oFile = fopen("config.php","w+");
	$sLineBreak = " \n";
	
	$sContent = '<?php '.$sLineBreak;
	$sContent .='/**'.$sLineBreak;
	$sContent .='* @author Gustavo Novaro <gnovaro@gmail.com>'.$sLineBreak;
	$sContent .='* @version '.$sVerion.$sLineBreak;
	$sContent .='* http://fileexplorerxp.googlecode.com'.$sLineBreak;
	$sContent .='*/'.$sLineBreak;
	$sContent .='$sConfig["VERSION"] = "'.$sVerion.'";'.$sLineBreak;
	$sContent .='$sConfig["USER"] = "'.$sUser.'"; '.$sLineBreak;
	$sContent .='$sConfig["PASS"] = "'.$sPass.'"; '.$sLineBreak;
	$sContent .='$sConfig["TIME_ZONE"] = "'.$sTimeZone.'"; '.$sLineBreak;
	$sContent .='define("URL","'.$sUrl.'"); '.$sLineBreak;
	$sContent .="?>";
	
	fwrite($oFile,$sContent);
	fclose($oFile);
	chmod("config.php",444); //Change file permisions to read only
	$_SESSION["MSG"] = "Setup Sucess";
	goto('index.php');
}//if
?>