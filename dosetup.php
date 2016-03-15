<?php
/**
* File Explorer XP
* Setup Process
* @author Gustavo Novaro
* @version $Id$
*/
session_start();
require("error_handler.php");
require("function.php");
if (isset($_POST['user']))
{
	$sUser = trim($_POST['user']);
	$sPass = sha1(trim($_POST['password']));
	$sUrl = $_POST['url'];
	$sTimeZone = (isset($_POST['php_zone']))? $_POST['php_zone'] : 'UTC';

	$sVersion = '2.0.0';
	$sLineBreak = "\n";
	$sContent = '<?php
	 /**
	  * File Explorer XP
	  * Configuration File
	  * @author Gustavo Novaro
	  * @version $sVersion
	  * Project Home Page: https://github.com/gnovaro/fileexplorerxp
	  * Twitter: https://twitter.com/gnovaro
	  */
	define("URL","'.$sUrl.'");
	$config = array(
		"VERSION"	=> "'.$sVersion.'",
		"USER"		=> "'.$sUser.'",
		"PASS"		=> "'.$sPass.'",
		"TIME_ZONE"	=> "'.$sTimeZone.'"
	);
	';

	try {
		$oFile = fopen('config.php',"w+");
		fwrite($oFile,$sContent);
		fclose($oFile);
		chmod('config.php',444); //Change file permisions to read only
		$_SESSION['__MSG__'] = 'Setup Sucess';
		redirect('index.php');
	} catch(Exception $e) {
		//@todo
		var_dump($e);
		die;
	}
}
