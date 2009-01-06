<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 1.36
* URL: http://gustavonovaro.blogspot.com
* File: index.php
* Purpose: Download file 
*/
if (!file_exists("./config.php"))
	{header("location: setup.php");}
else	
	{require("./config.php");}
	
require("./error_handler.php");	
require("./function.php");
session_start();
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

	if (isset($_SESSION['__MSG__']))
		$sMsg = $_SESSION['__MSG__'];		
	else
		$sMsg = '';

	//destroy session - Logout
	if (isset($_SESSION['login'])) 
	{
		session_unset();
		session_destroy();
		$_SESSION = array();
	}//if	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?=$CONTENT["TITLE"];?></title>
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form id="frmLogin" name="frmLogin" action="validate.php" method="post" style="margin-top:100px">
<div align="center">
    <div style="background:#EEFFEE; border:#CCF7CC 1px solid; padding:5px; -moz-border-radius:10px; width:300px;">
    <table border="0">
        <tr>
          <td colspan="2"><h1>&nbsp;Login</h1></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;<strong><?=$CONTENT["USER"]?>:</strong></td>
            <td><input type="text" name="txtUserName" id="txtUserName" autocomplete="false" /></td>
        </tr>
        <tr>
            <td>&nbsp;<strong><?=$CONTENT["PASSWORD"]?>:</strong></td>
            <td><input type="password" name="txtPass" id="txtPass" autocomplete="false" /></td>
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
			$sIp = $_SERVER['REMOTE_ADDR'];
			$sDate = date("Y-m-d h:m:s");
			write_log($sDate." - ".$sIp);
			echo $sIp; 
			?>
            </td>
        </tr>
    </table>
    </div>
    <br />
    <div id="div_msg">&nbsp;<strong><?=$sMsg;?></strong></div>
</div>
</form>
<div style="margin-top:170px;">
	<div align="right">
    <a href="http://gustavonovaro.blogspot.com" target="_blank">Blog de Tavo</a>&nbsp; - <a href="http://fileexplorerxp.googlecode.com/" target="_blank">File Explorer XP</a> | Version: <?=$sConfig["VERSION"];?> &nbsp;
    </div>
</div>
</body>
</html>