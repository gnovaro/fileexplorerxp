<?php
/**
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.59
* Purpouse: Setup a config file first time execution
*/
$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
//echo $sLang;
$sPath = './languages/'.$sLang.'.php';
if (file_exists($sPath))
{
	require($sPath);
}
else
{
	//defualt lang spanish
	require('./languages/es.php'); 
}//if
//echo $_SERVER['DOCUMENT_ROOT'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>:: File Explorer XP - SETUP ::</title>
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<link rel="stylesheet" type="text/css" href="fileexplorer.css" />
</head>

<body>
	<h1><?=$CONTENT["SETUP"];?></h1>
    <form id="frmSetup" action="dosetup.php" method="post">
    <table style="margin-left:20px;">
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
        <td><input type="text" name="txtUrl" id="txtUrlR" value="http://<?=$_SERVER['HTTP_HOST'];?>/<?=basename(dirname(__FILE__));?>" maxlength="255" /></td>
    </tr>
    <?php
    if (phpversion()>= "5.1.0"){
	?>
    <tr>
      <td>PHP Time Zone:</td>
      <td>
 			<select name="php_zone" id="php_zoneR">
            <option value="UTC">UTC</option>
			<?php
            $timezone_identifiers = DateTimeZone::listIdentifiers();
			for ($i=0; $i < count($timezone_identifiers); $i++) {
			?>
           	<option value="<?=$timezone_identifiers[$i];?>"><?=$timezone_identifiers[$i];?></option>
			<?php
			}//for
			?>                
            </select>
      </td>
    </tr>
    <?php
	}//if
	?>
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
        <td colspan="2" align="right"><input type="submit" name="btSend" id="btSend" value="<?=$CONTENT["SUBMIT"];?>" onclick="" /></td>
    </tr>
    </table>
</form>
</body>
</html>