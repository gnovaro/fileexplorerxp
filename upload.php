<?php
/**
* @author 	Gustavo Novaro
* @version	1.76
* https://github.com/gnovaro/fileexplorerxp
* File: upload.php
* Purpose:
*/
session_start();
require("config.php");
require("error_handler.php");
require("function.php");
$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
//echo $sLang;
$sPath = "application/i18n/$sLang.php";
if (file_exists($sPath))
{
	require($sPath);
}
else
{
	//default lang spanish
	require('application/i18n/es.php');
}//if

//Security check
if(!isset($_SESSION['login'])) redirect('index.php');
//security
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE">
	<title><?php echo $CONTENT["TITLE"];?></title>
	<link rel="stylesheet" href="<?php echo URL?>/assets/css/fileexplorer.css">
	<script src="<?php echo URL?>/assets/js/function.js"></script>
</head>
<body>
	<form name="frmSendFiles" id="frmSendFiles" action="doupload.php" method="post" enctype="multipart/form-data">
	<table cellspacing="0" width="100%">
	<!-- Menu BAR -->
	<tr bgcolor="#EFEFE9">
		<td colspan="2">&nbsp;<a href="<?php echo URL;?>/tree.php" class="no_underline"><img src="<?php echo URL?>/assets/images/back.gif" alt="<?php echo $CONTENT['BACK'];?>" />&nbsp;<span class=""><?php echo $CONTENT['BACK'];?></span></a></td>
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
				<img src="<?php echo URL?>/assets/images/add.gif" alt="<?php echo $CONTENT['FILE_ADD'];?>" />
			</a>
			<div id="div_upload_photos">
				<input type="file" name="file[]" id="file"><br>
			</div>
			</td>
		</tr>
			<tr>
			<td style="text-align:right">
				<button type="button" name="btCancel" onclick="redirect('<?php echo URL;?>/tree.php');" class="btn btn-default"><?php echo $CONTENT['Cancel'];?></button>
				&nbsp;
				<button type="submit" class="btn btn-primary"><?php echo $CONTENT['BT_UPLOAD'];?></button>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
</form>
</body>
</html>
