<?php
/**
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.04
* URL: http://gustavonovaro.blogspot.com
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
    	redirect("index.php");
    //security
    
    //Quantity Objects Status bar
    $iObject = 3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $CONTENT["TITLE"];?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>/fileexplorer.css" />
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<script type="text/javascript" src="<?php echo URL;?>/js/function.js"></script>
</head>
<body>
<table cellspacing="0" width="100%">
<!-- Menu BAR -->
<tr bgcolor="#EFEFE9">
	<td colspan="2">&nbsp;<a href="<?php echo URL;?>/tree.php" class="no_underline"><img src="images/back.gif" alt="<?php echo $CONTENT["BACK"];?>" />&nbsp;<span class=""><?php echo $CONTENT["BACK"];?></span></a></td>
</tr>
<!-- Menu BAR -->
<tr>
	<td width="199" height="500" bgcolor="#7aa1e6" style="vertical-align:top;">
   	  <div style="width:170px; margin:10px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
          	<td rowspan="2"><img src="<?php echo URL;?>/images/cpanel_header.jpg" alt="" /></td>
            <td width="133"><img src="<?php echo URL;?>/images/spacer.gif" alt="" height="8" /></td>
            <td></td>
          </tr>
          <tr bgcolor="#034bb7">
            <td><span class="textWhite"><strong><?php echo $CONTENT["CONTROL_PANEL"];?></strong></span></td>
            <td width="24"><a href="javascript:showhide_with_image('task','img_arrow_task');"><img src="<?php echo URL;?>/images/up_blue.jpg" alt="" id="img_arrow_task" style="border:none" /></a></td>
          </tr>
	 	</table>
            <div id="task">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">     		  
              <tr bgcolor="#D6DFF7">
                <td colspan="2">&nbsp;<img src="<?php echo URL;?>/images/file.gif" alt="" />&nbsp;<a href="javascript:new_file();" class="menuLeftBar">Ver informaci&oacute;n del sistema<? //=$CONTENT["NEW_FILE"];?></a></td>
              </tr>          
            </table>
            </div>
        </div>
    </td>
<td width="1029" style="vertical-align:top">
	<!-- -->
	<table>
    	<tr>
        	<td class="center"><img src="<?php echo URL;?>/images/cregion.jpg" alt="" /></td>
            <td>&nbsp;</td>
            <td class="center"><img src="<?php echo URL;?>/images/users.jpg" alt="" /></td>
            <td>&nbsp;</td>
            <td class="center"><img src="<?php echo URL;?>/images/bug.jpg" alt="" /></td>
        </tr>
        <tr>
        	<td class="center"><a href="javascript:showhide('panel_lang');" class="menuLeftBar"><?php echo $CONTENT["LANGUAGE"];?></a></td>
            <td>&nbsp;</td>
            <td class="center"><a href="javascript:showhide('panel_user');" class="menuLeftBar"><?php echo $CONTENT["USER_ACCOUNTS"];?></a></td>
            <td>&nbsp;</td>
            <td class="center"><a href="javascript:showhide('panel_bug');" class="menuLeftBar"><?php echo $CONTENT["REPORT_BUG"];?></a></td>
        </tr>
    </table>
    <!-- -->
    <form action="" method="post">
    <div id="panel_lang" style="display:none">
    	<select name="cbLang" id="cbLang">
		<?php 
        foreach($sLanguages as $key => $value )
        {
        ?>
            <option value="<?php echo $sLanguages[$key]?>"><?php echo $key?></option>
        <?php
        }//for
			?>
        </select>
    </div>
    <div id="panel_user" style="display:none">
    	<table>
        	<tr>
            	<td><?php echo $CONTENT["USER"]?></td>
            	<td><input type="text" name="txtUser" value="" /></td>
			</tr>
            <tr>
            	<td><?php echo $CONTENT["PASSWORD"]?></td>                
                <td><input type="password" name="txtPass" value="" /></td>
            </tr>
            <tr>
            	<td></td>                
                <td><input type="password" name="txtPass2" value="" /></td>
            </tr>
        </table>
    </div>
    <div id="panel_bug" style="display:none">
    	<table>
        	<tr>
            	<td>Email:</td>
                <td><input type="text" name="txtEmail" id="emailR" value="" /></td>
            </tr>
        	<tr>
            	<td><?php echo $CONTENT["SUBJECT"];?>:</td>
                <td><input type="text" name="txtTitle" value="" /></td>
            </tr>
            <tr>
            	<td colspan="2">
                <textarea name="" id=""></textarea>
                </td>
            </tr>
        </table>
    </div>
    <input type="submit" name="btSend" id="btSendR" onclick="" value="<?php echo $CONTENT["SUBMIT"];?>" />
    </form>
</td>   
    <!-- BARRA ESTADO -->
    <tr bgcolor="#EFEFE9">
      <!-- -->
      <td><img src="<?php echo URL;?>/images/spacer.gif" alt="" height="20" width="3" />&nbsp;<?php echo $iObject;?>&nbsp;<?php echo $CONTENT["OBJECTS"];?>&nbsp;</td>
      <td align="right">
      <a href="http://gustavonovaro.com.ar" target="_blank">Blog de Tavo</a>&nbsp; - <a href="http://fileexplorerxp.googlecode.com/" target="_blank">File Explorer XP</a> | Version: <?php echo $sConfig["VERSION"];?> &nbsp;
      </td>
    </tr>
</table>
</body>
</html>