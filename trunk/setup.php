<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 0.75
* Purpouse: Setup a config file first time execution
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>:: File Explorer XP - SETUP ::</title>
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<h1>Setup</h1>
    <form id="frmSetup" action="dosetup.php" method="post">
    <table>
    <tr>
      <td colspan="2">File manager access:</td>
      </tr>
    <tr>
      <td width="86">User:</td>
      <td width="220"><input type="text" name="txtUserAdmin" id="txtUserAdminR" maxlength="12" value="admin" /></td>
    </tr>
    <tr>
      <td>Pass:</td>
      <td><input type="text" name="txtPassAdmin" id="txtPassAdminR" maxlength="12" value="admin" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>URL:</td>
        <td><input type="text" name="txtUrl" id="txtUrlR" value="http://" maxlength="255" /></td>
    </tr>
    <tr>
      <td>PHP Time Zone:</td>
      <td><input type="text" name="php_zone" id="php_zoneR" value="UTC" size="35" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <!--
    <tr>
      <td colspan="2"><i>Database:</i></td>
      </tr>
    <tr>
      <td>Host:</td>
      <td><input type="text" name="txtHost" value="localhost" maxlength="255" /></td>
    </tr>
    <tr>
    	<td>User:</td>
        <td><input type="text" name="txtUserDB" id="" maxlength="12" /></td>
    </tr>
    <tr>
    	<td>Pass:</td>
        <td><input type="text" name="txtPassDB" id="" maxlength="12" /></td>
    </tr>
    <tr>
      <td>Port:</td>
      <td><input type="text" value="3306" maxlength="4" size="7" /></td>
    </tr>
    -->
    <tr>
      <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><input type="submit" name="btSend" id="btSend" value="Submit" onclick="" /></td>
    </tr>
    </table>
</form>
</body>
</html>