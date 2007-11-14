<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 1.0
*/
if ($_POST["txtUserAdmin"]){
	$sUser = $_POST["txtUserAdmin"];
	$sPass = $_POST["txtPassAdmin"];
	$sUrl = $_POST["txtUrlR"];
	$oFile = fopen("config.php","w+");
	
	$sContent = '<?php /n':
	$sContent .='$sConfig["VERSION"] = "0.82"; ';
	$sContent .='$sConfig["USER"] = "admin";';
	$sContent .='$sConfig["PASS"] = "admin";';
	$sContent .='$sConfig["TIME_ZONE"] = "America/Argentina/Buenos_Aires";';
	$sContent .='define("URL","http://localhost/fileexplorerxp/");';
	$sContent .="?>";
}
?>