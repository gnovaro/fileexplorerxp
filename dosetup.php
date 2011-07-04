<?php
/**
* File Explorer XP
* Setup Process
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version $Id$
*/
require("./error_handler.php");	
require("./function.php");
session_start();
if (isset($_POST['user'])){
	$sUser = trim($_POST['user']);
	$sPass = sha1(trim($_POST['password']));
	$sUrl = $_POST['url'];
	$sTimeZone = (isset($_POST['php_zone']))? $_POST['php_zone'] : '';

	$sVersion = '1.73';
	
	$oFile = fopen('config.php',"w+");
	$sLineBreak = "\n";
	
	$sContent = "<?php
			 /**
			  * File Explorer XP 
			  * Configuration File
			  * @author Gustavo Novaro <gnovaro@gmail.com>
			  * @version $sVersion
			  * Project Home Page: http://fileexplorerxp.googlecode.com
			  * Blog: http://gustavonovaro.com.ar
			  * Twitter: http://www.twitter.com/gnovaro
			  */
			\$config = array(
				'VERSION'	=> '$sVersion',
				'USER'		=> '$sUser',
				'PASS'		=> '$sPass',
				'TIME_ZONE'	=> '$sTimeZone'
			);
			define('URL','$sUrl');
	";

	fwrite($oFile,$sContent);
	fclose($oFile);
	chmod('config.php',444); //Change file permisions to read only
	$_SESSION['__MSG__'] = 'Setup Sucess';
	redirect('index.php');
}//if
