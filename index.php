<?php
/**
* @author: G. Novaro <gnovaro@gmail.com>
* @version: 0.73
* URL: http://www.novarsystems.com.ar
* File: index.php
* Purpose: Download file 
*/
require("./config.php");

$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
echo $sLang;
require("./languages/es.php");

	session_start();
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
<form id="frmLogin" name="frmLogin" action="validate.php" method="post" style="margin-top:150px">
<div align="center">
    <div style="background:#EEFFEE; border:#CCF7CC 1px solid; padding:5px; -moz-border-radius:10px; width:300px;">
    <table border="0">
        <tr>
          <td colspan="2"><h1>Login</h1></td>
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
        	<td colspan="2" align="center"><strong>IP:</strong>&nbsp;<?=$_SERVER['REMOTE_ADDR'];?></td>
        </tr>
    </table>
    </div>
</div>
</form>
<div style="margin-top:300px;">
	<div align="right">
    <a href="http://www.novarsystems.com.ar" target="_blank">NovAR Systems - www.novarsystems.com.ar</a>&nbsp; - <a href="http://fileexplorerxp.googlecode.com/" target="_blank">File Explorer XP</a> | Version: <?=$sConfig["VERSION"];?> &nbsp;
    </div>
</div>
</body>
</html>
