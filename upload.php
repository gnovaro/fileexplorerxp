<?php
/**
* @author: G. Novaro <gnovaro@gmail.com>
* @version: 0.77
* URL: http://www.novarsystems.com.ar
* File: upload.php
* Purpose:
*/
require("./config.php");
require("error_handler.php");	
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
	header("Location: index.php");
//security

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?=$CONTENT["TITLE"];?></title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
<script type="text/javascript">
	i = 1;
</script>
Seleccione un Archivo:
<form name="frmSendFiles" id="frmSendFiles" action="uploadProcess.php" method="post" enctype="multipart/form-data">
	<table>
    <tr>
		<td>   <input type="file" name="fileUp" id="fileUp"/></td>
    </tr>
    <tr>
		<td style="text-align:right"><input type="button" name="btCancel" value="<?=$CONTENT["BT_CANCEL"];?>" onclick="goto('tree.php');" />&nbsp;<input type="submit" value="Subir!"/></td>
    </tr>
    </table>
</form>
</body>
</html>
