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
$sLanguages = get_lang();
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

//Quantity Objects Status bar
$iObject = 3;
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
<table cellspacing="0">
<tr bgcolor="#EFEFE9">
	<td colspan="2">&nbsp;<a href="<?=URL;?>tree.php" class="no_underline"><img src="images/back.gif" alt="<?=$CONTENT["BACK"];?>" />&nbsp;<span class=""><?=$CONTENT["BACK"];?></span></a></td>
</tr>
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
<td width="543" style="vertical-align:top">
	<!-- -->
	<table>
    	<tr>
        	<td class="center"><img src="<?=URL;?>images/cregion.jpg" alt="" /></td>
            <td>&nbsp;</td>
            <td class="center"><img src="<?=URL;?>images/users.jpg" alt="" /></td>
            <td>&nbsp;</td>
            <td class="center"><img src="<?=URL;?>images/bug.jpg" alt="" /></td>
        </tr>
        <tr>
        	<td class="center"><a href="" class="menuLeftBar">Idioma</a></td>
            <td>&nbsp;</td>
            <td class="center"><a href="" class="menuLeftBar">Cuentas de <br />usuarios</a></td>
            <td>&nbsp;</td>
            <td class="center"><a href="" class="menuLeftBar">Reportar<br />error</a></td>
        </tr>
    </table>
    <!-- -->
    <div id="" style="display:none">
    	<select name="cbLang" id="cbLang">
		<?php 
        foreach($sLanguages as $key => $value )
        {
        ?>
            <option value="<?=$key?>"><?=$sLanguages[$key]?></option>
        <?php
        }//for
			?>
        </select>
        <input type="button" name="btSend" id="btSendR" onclick="" value="<?=$CONTENT["SUBMIT"];?>" />
    </div>
    <div id="" style="display:none">
    	<table>
        	<tr>
            	<td></td>
            	<td><input type="text" name="txtUser" value="" /></td>
			</tr>
            <tr>
            	<td></td>                
                <td><input type="password" name="txtPass" value="" /></td>
            </tr>
            <tr>
            	<td></td>                
                <td><input type="password" name="txtPass2" value="" /></td>
            </tr>
            <tr>
            	<td colspan="2" align="right">
                	<input type="button" name="btSend2" id="btSend2R" onclick="" value="<?=$CONTENT["SUBMIT"];?>" />
                </td>
            </tr>
        </table>
    </div>
    <div id="">
    	<table>
        	<tr>
            	<td><?=$CONTENT["SUBJECT"];?>:</td>
                <td><input type="text" name="txtTitle" value="" /></td>
            </tr>
            <tr>
            	<td colspan="2">
                <textarea name="" id=""></textarea>
                </td>
            </tr>
            <tr>
            	<td colspan="2" align="right">
                	<input type="button" name="btSend3" id="btSend3R" onclick="" value="<?=$CONTENT["SUBMIT"];?>" />
                </td>
            </tr>
        </table>
    </div>
</td>   
    <!-- BARRA ESTADO -->
    <tr bgcolor="#EFEFE9">
      <!-- -->
      <td><img src="<?=URL;?>images/spacer.gif" alt="" height="20" width="3" />&nbsp;<?=$iObject;?>&nbsp;<?=$CONTENT["OBJECTS"];?>&nbsp;</td>
      <td align="right">
      <a href="http://www.novarsystems.com.ar" target="_blank">NovAR Systems - www.novarsystems.com.ar</a>&nbsp; - <a href="http://fileexplorerxp.googlecode.com/" target="_blank">File Explorer XP</a> | Version: <?=$sConfig["VERSION"];?> &nbsp;
      </td>
    </tr>
</table>
</body>
</html>
