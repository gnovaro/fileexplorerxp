<?php
/**
* @author 	Gustavo Novaro
* @version	1.76
* https://github.com/gnovaro/fileexplorerxp
* File: upload.php
* Purpose:
*/
require("./config.php");
require("./error_handler.php");	
require("./function.php");
$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
//echo $sLang;
$sPath = "./languages/$sLang.php";
if (file_exists($sPath))
{
	require($sPath);
}
else
{
	//default lang spanish
	require('./languages/es.php'); 
}//if

//Security check
session_start();
if(!isset($_SESSION['login'])) redirect('index.php');
//security
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $CONTENT["TITLE"];?></title>
	<link rel="stylesheet" href="<?php echo URL?>/fileexplorer.css" />
	<script src="<?php echo URL?>/js/function.js"></script>
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
</head>

<body>
<form name="frmSendFiles" id="frmSendFiles" action="doupload.php" method="post" enctype="multipart/form-data">
<table cellspacing="0" width="100%">
<!-- Menu BAR -->
<tr bgcolor="#EFEFE9">
	<td colspan="2">&nbsp;<a href="<?php echo URL;?>/tree.php" class="no_underline"><img src="images/back.gif" alt="<?php echo $CONTENT['BACK'];?>" />&nbsp;<span class=""><?php echo $CONTENT['BACK'];?></span></a></td>
</tr>
<!-- Menu BAR -->   
<tr>
	<td width="180px;" height="500" bgcolor="#6B85DC" style="vertical-align:top;" rowspan="2">&nbsp;</td>
	<td style="vertical-align:top;">
	<br />

	<table>
	<tr>
		<td><?php echo $CONTENT['CHOOSE_FILE'];?></td>
	</tr>
	<tr>
		<td>
		<a href="javascript:add_file();"><?php echo $CONTENT['FILE_ADD'];?>&nbsp;
			<img src="<?php echo URL?>/images/add.gif" alt="<?php echo $CONTENT['FILE_ADD'];?>" />
		</a>
		<div id="div_upload_photos">
			<input type="file" name="file[]" id="file" /><br />
		</div>
		</td>
	</tr>
		<tr>
		<td style="text-align:right">
		<input type="button" name="btCancel" value="<?php echo $CONTENT['BT_CANCEL'];?>" onclick="redirect('<?php echo URL;?>/tree.php');" />
		&nbsp;
		<input type="submit" value="<?php echo $CONTENT['BT_UPLOAD'];?>"/></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</form>
</body>
</html>
