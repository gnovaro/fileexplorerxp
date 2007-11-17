<?php
/**
* @author: G. Novaro <gnovaro@gmail.com>
* @version: 0.99
* URL: http://www.novarsystems.com.ar
* file: control_panel.php
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$CONTENT["TITLE"];?></title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
</head>
<body>
<table>
<tr>
	<td width="180" height="500" bgcolor="#7aa1e6" style="vertical-align:top;">
    	<div style="width:160px; margin:10px;">
        <table border="0" cellpadding="0" cellspacing="0" width="160px">
          <tr>
          	<td rowspan="2"><img src="<?=URL;?>images/cpanel_header.jpg" alt="" /></td>
            <td width="133"><img src="<?=URL;?>images/spacer.gif" alt="" height="8" /></td>
            <td></td>
          </tr>
          <tr bgcolor="#034bb7">
            <td><span class="textWhite"><strong><?=$CONTENT["CONTROL_PANEL"];?></strong></span></td>
            <td width="24"><a href="javascript:showhide_with_image('task','img_arrow_task');"><img src="<?=URL;?>images/up_blue.jpg" alt="" id="img_arrow_task" style="border:none" /></a></td>
          </tr>
	 	</table>
            <div id="task">
            <table border="0" cellpadding="0" cellspacing="0" width="160px">     		  
              <tr bgcolor="#D6DFF7">
                <td colspan="2">&nbsp;<img src="<?=URL;?>images/file.gif" alt="" />&nbsp;<a href="javascript:new_file();" class="menuLeftBar">Ver informaci&oacute;n del sistema<? //=$CONTENT["NEW_FILE"];?></a></td>
              </tr>          
            </table>
            </div>
        </div>
    </td>
    <td width="0">    </td>
<td width="600" style="vertical-align:top">
	<!-- -->
	<table>
    	<tr>
        	<td><img src="<?=URL;?>images/cregion.jpg" alt="" /><br />Idioma</td>
        </tr>
    </table>
    <!-- -->
</td>    
</table>
</body>
</html>
