<?php
/**
 * @author	Gustavo Novaro
 * @version	1.67
 * https://github.com/gnovaro/fileexplorerxp
 * File: index.php
 * Purpose: Login
 */
	error_reporting(E_ALL);
	if (!file_exists("./config.php"))
		{header("location: setup.php");}
	else
		{require("./config.php");}

	//require("./error_handler.php");
	require("./function.php");
	
	session_start();
	$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
	//echo $sLang;
	$sPath = "./languages/".$sLang.".php";
	if (file_exists($sPath))
	{
		require($sPath);
	} else {
		//default lang spanish
		require("./languages/es.php"); 
	}//if

	if (isset($_SESSION['__MSG__'])) 
	{
		$sMsg = $_SESSION['__MSG__'];
		unset($_SESSION['__MSG__']);
	} else {
		$sMsg = '';
	}//if
	
	//destroy session - Logout
	if (isset($_SESSION['login'])) 
	{
		session_unset();
		session_destroy();
		$_SESSION = array();
	}//if	
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $CONTENT['TITLE'];?></title>
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<link rel="stylesheet" href="fileexplorer.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script src="//ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js"></script> 
</head>
<body>
<form id="frmLogin" name="frmLogin" action="validate.php" method="post" style="margin-top:100px">
<div align="center">
	<div style="background:#EEFFEE; border:#CCF7CC 1px solid; padding:5px; width:300px;" class="radius">
	<table border="0">
		<tr>
		  <td colspan="2"><h1>&nbsp;Login</h1></td>
		</tr>
		<tr>
		  <td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;<strong><?php echo $CONTENT['USER']?>:</strong></td>
			<td><input type="text" name="user" id="user" autocomplete="false" required="required" /></td>
		</tr>
		<tr>
			<td>&nbsp;<strong><?php echo $CONTENT['PASSWORD']?>:</strong></td>
			<td><input type="password" name="password" id="password" autocomplete="false" required="required" /></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" name="btLogin" id="btLogin" value="Login"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><img src="images/padlock.gif" alt="" />&nbsp;<strong>IP:</strong>&nbsp;
			<?php 
			$sIp = getIP();
			$sDate = date("Y-m-d H:m:s");
			write_log($sDate." - ".$sIp);
			echo $sIp; 
			?>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<div id="div_msg">&nbsp;<strong><?php echo $sMsg;?></strong></div>
</div>
</form>
<div style="margin-top:170px;">
	<div align="right">
	<a href="https://github.com/gnovaro/fileexplorerxp" target="_blank">File Explorer XP</a> | Version: <?php echo $config["VERSION"];?> &nbsp;
	</div>
</div>
</body>
</html>
