<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 0.99
*/
require("./error_handler.php");	
require("./function.php");

if ($_POST["txtUserAdmin"]){
	$sUser = $_POST["txtUserAdmin"];
	$sPass = md5($_POST["txtPassAdmin"]);
	$sUrl = $_POST["txtUrl"];
	$sTimeZone = $_POST["php_zone"];
	$sVerion = "1.04";
	
	$oFile = fopen("config.php","w+");
	$sLineBreak = " \n";
	
	$sContent = '<?php '.$sLineBreak;
	$sContent .='/**'.$sLineBreak;
	$sContent .='* @auhtor: Gustavo Novaro <gnovaro@gmail.com>'.$sLineBreak;
	$sContent .='* @version: '.$sVerion.$sLineBreak;
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
	goto('index.php?err=Setup sucess');
}
?>