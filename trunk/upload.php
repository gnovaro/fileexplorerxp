<?php
/**
* @author: G. Novaro <gnovaro@gmail.com>
* @version: 0.93
* URL: http://www.novarsystems.com.ar
* File: upload.php
* Purpose:
*/
require("./config.php");
require("./error_handler.php");	
require("./function.php");
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

//Security check
session_start();
if(!isset($_SESSION["login"]))
	goto("index.php");
//security

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?=$CONTENT["TITLE"];?></title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
</head>

<body>
<script type="text/javascript">
function goto(sUrl){
	window.location = sUrl;
}
</script>

<form name="frmSendFiles" id="frmSendFiles" action="doupload.php" method="post" enctype="multipart/form-data">
	<table>
    <tr>
    	<td width="180px;" height="500" bgcolor="#6B85DC" style="vertical-align:top;" rowspan="2">&nbsp;</td>
		<td style="vertical-align:top;">
        <br />
        <?=$CONTENT["CHOOSE_FILE"];?>
        <input type="file" name="fileUpload" id="fileUp0R"/>
        </td>
    </tr>
<!--
    <tr>
		<td><input type="file" name="fileUpload[1]" id="fileUp1R"/></td>
    </tr>
    <tr>
		<td><input type="file" name="fileUpload[2]" id="fileUp2R"/></td>
    </tr>
-->    
    <tr>
		<td style="text-align:right"><input type="button" name="btCancel" value="<?=$CONTENT["BT_CANCEL"];?>" onclick="goto('tree.php');" />&nbsp;<input type="submit" value="<?=$CONTENT["BT_UPLOAD"];?>"/></td>
    </tr>
    </table>
</form>
</body>
</html>