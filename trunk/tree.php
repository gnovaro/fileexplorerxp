<?php
/**
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.52
* URL: http://gustavonovaro.blogspot.com
* File: tree.php
* Purpose: View and listing files and directory
*/
require('./config.php');
require('./error_handler.php');	
require('./function.php');	

$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
//echo $sLang;
$sPath = './languages/'.$sLang.".php";
if (file_exists($sPath)){
	require($sPath);
}else{
	//defualt lang english
	require('./languages/en.php'); 
}//if

//Security check
session_start();
if(!isset($_SESSION['login']))
	redirect('index.php');
//security
	
if (phpnum()==5)
	date_default_timezone_set($sConfig['TIME_ZONE']);		
		
	$cantFiles = 0;
	$sPath = '';
	if (!isset($_SESSION["path"]) ){
		$sRootPath = getcwd(); 	//Obtiene el directorio actual de trabajo.
		$_SESSION["path"] = $sRootPath;		
		$sPath = $sRootPath;
	//	echo "session path ".$_SESSION["path"];
	}
	else{
		$sPath = $_SESSION["path"];
//		echo "Path: ".$sPath; //debug
		if ( isset($_REQUEST["dir"]) ){ 
			$sDir =  $_REQUEST["dir"];
			//comprueba que lo que se pasa sea un directorio
			if(	is_dir($sPath.DIRECTORY_SEPARATOR.$sDir)){
			$sPath = $sPath.DIRECTORY_SEPARATOR.$sDir;
			$_SESSION["path"] = $sPath;
			}//if
		}//if
		chdir($sPath); //Cambio de directorio
	}//if
	$order = 0;
	

	if (isset($_POST["H_ACTION"])){
		$sAction = $_POST["H_ACTION"];
		
		switch($sAction){
			case "NEW_FOLDER": 
				$sDirName = $_POST["H_NAME"];
				mkdir($sDirName, 0700);			
				break;
			case "NEW_FILE":
				$sName = $_POST["H_NAME"];
				if (!file_exists($sName)){
					fopen($sName,'w');
					echo $CONTENT["FILE_SUCESS"];//"File created sucess"
				}
				else
					echo $CONTENT["FILE_FAIL"];
				break;
			case "DELETE":
				$sName = $_POST["H_NAME"];
				if(is_dir($sName)){
					if (rmdir($sName)== true) 
						echo $CONTENT["DELETE_DIR_SUCESS"];
					else
						echo $CONTENT["DELETE_DIR_FAIL"];
				}
				else
					if(file_exists($sName))
						if ( unlink($sName) ){
							echo $CONTENT["DELETE_FILE_SUCESS"];
						}
						else{
							echo $CONTENT["DELETE_FILE_FAIL"];
						}	
				break;
			case "RENAME":
				$sName = $_POST["H_NAME"];
				$sExtra = $_POST["H_EXTRA"];
				if(file_exists($sName))
				{
					if(rename($sName,$sExtra))
						echo $CONTENT["RENAME_FILE_SUCESS"];
					else
						echo $CONTENT["RENAME_FILE_FAIL"];
				}//if
				break;
		}//switch
			
	}//if action
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?=$CONTENT["TITLE"];?></title>
    <link rel="stylesheet" type="text/css" href="<?=URL?>/fileexplorer.css" />
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
<script type="text/javascript">
function showhide_with_image(targetDiv,actionImage){
	    image = document.getElementById(actionImage)
		var oVDiv = document.getElementById(targetDiv);
		prop = oVDiv.style.display;
		if(prop == "none"){
			oVDiv.style.display = "block";
			image.src = "<?=URL?>/images/up.jpg";
		}
		else{
			oVDiv.style.display = "none";
			image.src = "<?=URL?>/images/down.jpg";
		}
}//showhide_with_image
	
function rename(sName){
	var resp;
	resp = prompt("<?=$CONTENT["RENAME_FILE"];?> " + sName + "?",sName);
	if (resp != null){
		document.getElementById("H_ACTION").value = "RENAME";
		document.getElementById("H_NAME").value = sName;
		document.getElementById("H_EXTRA").value = resp;
		document.getElementById("frmMain").submit();
	}//if
}//rename

function delete_file(sName){
	var resp;
	resp = confirm("<?=$CONTENT["DELETE_FILE"];?> '" + sName + "' ?");
	if (resp != null){
		document.getElementById("H_ACTION").value = "DELETE";
		document.getElementById("H_NAME").value = sName;
		document.getElementById("frmMain").submit();
	}//if
}//delete_file

function new_folder(){
	folder = prompt("<?=$CONTENT["NEW_FOLDER"];?> ");
	if (folder !="" && folder != null){
		//Validar charAt " " != espacio
		document.getElementById("H_ACTION").value = "NEW_FOLDER";
		document.getElementById("H_NAME").value = folder;
		document.getElementById("frmMain").submit();
	}//if
}//new_folder

function new_file(){
	sFile = prompt("<?=$CONTENT["NEW_FILE"];?> ");
	if (sFile !="" && sFile != null){
		//Validar charAt " " != espacio
		document.getElementById("H_ACTION").value = "NEW_FILE";
		document.getElementById("H_NAME").value = sFile;
		document.getElementById("frmMain").submit();
	}//if
}//new_file

function close_admin(){
	sclose = confirm("<?=$CONTENT["EXIT"];?>");
	if (sclose){
		window.location = "index.php";
	}
}//close_admin

function edit(sFile){
	window.location = "edit.php?file=" + sFile;
}//edit

function go_path(){
	sPath = document.getElementById("txtPath").value;
	if(sPath == "")
		alert("Por favor complete la direccion");
	else
		document.getElementById("frmMain").submit();
}//go_path

function download_file(sFile){
	window.location = "get_file.php?file=" + sFile;
}//download_file
</script>
</head>
<body>
<form name="frmMain" id="frmMain" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#EFEFE9">
      <td colspan="2"><div align="right"><a href="javascript:close_admin();"><img src="<?=URL;?>/images/close.png" alt="close" style="border:none;" title="<?=$CONTENT["EXIT"];?>" /></a>&nbsp;</div></td>
    </tr>
    <tr bgcolor="#EFEFE9">
      <td colspan="2">
      	<table>
        	<tr>
            	<td>&nbsp;<?=$CONTENT["PATH"];?>&nbsp;<span><input type="text" name="dir" id="txtPath" style="width:650px;" value="<?=realpath($sPath);?>"/></span></td>
                <td><a href="javascript:go_path();"><img src="<?=URL;?>/images/arrow_go.jpg" alt="<?=$CONTENT["GO"];?>" style="border:none;" /></a></td>
				<td><?=$CONTENT["GO"];?></td>
                <td>&nbsp;&nbsp;&nbsp;<a href="#"><img src="<?=URL;?>/images/help.gif" alt="<?=$CONTENT["HELP"];?>" /></a></td>
			</tr>
		</table>
      </td>
    </tr>
    <tr>
    <td width="180" bgcolor="#6B85DC" style="vertical-align:top;">
	<!-- Panel Tareas -->
    <br />
	<div style="width:160px; margin:10px;">
	  <table border="0" cellpadding="0" cellspacing="0" width="160px">
          <tr bgcolor="#FFFFFF">
          	<td><img src="<?=URL;?>/images/box_left.jpg" alt="" /></td>
            <td width="133" class="textoAzul">&nbsp;<?=$CONTENT["FILE_TASK"];?> </td>
            <td width="27"><a href="javascript:showhide_with_image('task','img_arrow_task');"><img src="<?=URL;?>/images/up.jpg" id="img_arrow_task" style="border:none" /></a></td>
          </tr>
	 </table>
    <div id="task">
        <table border="0" cellpadding="0" cellspacing="0" width="160px" bgcolor="#D6DFF7" style="filter:alpha(opacity=100,finishopacity=40,style=1);">     		  
        <tr>
	        <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;<img src="<?=URL;?>/images/file.gif" alt="" />&nbsp;<a href="javascript:new_file();" class="menuLeftBar"><?=$CONTENT["NEW_FILE"];?></a></td>
          </tr>          
          <tr>
            <td colspan="2">&nbsp;<img src="<?=URL;?>/images/new_folder.jpg" alt="" />&nbsp;<a href="javascript:new_folder();" class="menuLeftBar"><?=$CONTENT["NEW_FOLDER"];?></a></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;<img src="<?=URL;?>/images/upload.jpg" alt="" />&nbsp;<a href="<?=URL;?>/upload.php" class="menuLeftBar"><?=$CONTENT["UPLOAD_FILE"];?></a></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;<img src="<?=URL;?>/images/control_panel.jpg" alt="" />&nbsp;<a href="<?=URL;?>/control_panel.php" class="menuLeftBar"><?=$CONTENT["CONTROL_PANEL"];?></a></td>
          </tr>
          <tr>
	        <td colspan="2">&nbsp;</td>
          </tr>
        </table>
    </div>
    </div>
	  <!-- Panel Tareas -->
	  
	  <!-- Panel Detalle -->
	  <div style="width:160px; margin:10px;">
	    <table border="0" cellpadding="0" cellspacing="0" width="160px">
          <tr bgcolor="#FFFFFF">
          	<td><img src="<?=URL;?>/images/box_left.jpg" alt="" /></td>
            <td width="133" class="textoAzul">&nbsp;<?=$CONTENT["DETAILS"];?></td>
            <td width="27"><a href="javascript:showhide_with_image('details','img_arrow_detail');"><img src="<?=URL;?>/images/up.jpg" id="img_arrow_detail" style="border:none" alt="" /></a></td>
          </tr>
        </table>
        <div id="details">
        <table border="0" cellpadding="0" cellspacing="0" width="160px" bgcolor="#D6DFF7" style="filter:alpha(opacity=100,finishopacity=40,style=1);">
          <tr>
	        <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="border-bottom: 1px #FFFFFF; border-right: 1px #FFFFFF;">
			<?php
			function format_size($size){
				switch (true){
				case ($size > 1099511627776):
					$size /= 1099511627776;
					$suffix = 'TB';
				break;
				case ($size > 1073741824):
					$size /= 1073741824;
					$suffix = 'GB';
				break;
				case ($size > 1048576):
					$size /= 1048576;
					$suffix = 'MB';   
				break;
				case ($size > 1024):
					$size /= 1024;
					$suffix = 'KB';
					break;
				default:
					$suffix = 'B';
				}
				return round($size, 2)." ".$suffix;
			}
			// $df contiene el numero total de bytes disponible en "/"
			$df = disk_free_space(".");
			$df = format_size($df);
  		  	?>
              &nbsp;<?=$CONTENT["SPACE_FREE"];?><br />
              &nbsp;<?=$df;?>
              <br />
              <br />
              </td>
          </tr>
          <tr>
            <td colspan="2" style="border-bottom: 1px #FFFFFF; border-right: 1px #FFFFFF;"><?
			// $df contiene el numero total de bytes disponible en "/"
			$dt = disk_total_space(".");
			$dt = format_size($dt);
  		  ?>
              &nbsp;<?=$CONTENT["SPACE_TOTAL"];?><br />
              &nbsp;<?=$dt;?>
              </td>
          </tr>		  
          <tr>
          	<td colspan="2">&nbsp;</td>
          </tr>
        </table>
        </div>
	  </div>
	  <!-- -->	  </td>
      <td width="778" style="vertical-align:top;">
	  <!-- Listado Archivos -->
	  <div style="top: 66px; left: 191px;">
	  <table border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#EFEFE9">
          <td width="250px">&nbsp;<?=$CONTENT["NAME"];?> </td>
          <td width="75px"><span class="barra">|</span><?=$CONTENT["SIZE"];?></td>
          <td><span class="barra">|</span><?=$CONTENT["LAST_MODIFY"];?></td>
		  <td><span class="barra">|</span><?=$CONTENT["OWNER"];?></td>
		  <td><span class="barra">|</span><?=$CONTENT["GROUP"];?></td>
		  <td><span class="barra">|</span><?=$CONTENT["PERMISSIONS"];?></td>
		  <td colspan="4">&nbsp;</td>
        </tr>
		<?php 
          //Poner en un include
          
          //Lista los archivos y directorios ubicados en la ruta especificada en un array
          $dh  = @opendir($sPath)or die("No se puede abrir el  $sPath");
          $i = 0;
          while (false !== ($file_name = readdir($dh))) {
		  		$types[] = filetype($file_name);
            	$files[] = $file_name;
				$i++;
		  }//while
		  array_multisort($types,SORT_ASC,$files,SORT_ASC); //sort by type, name
		  foreach($files as $file) {		  	
        ?>
        <tr>
          <td bgcolor="#F7F7F7">&nbsp;
		  <?php
		  	if(is_dir($file)&& $file!='.'){
		  ?>
				<img src='<?=URL?>/images/folder.jpg' alt="" />&nbsp;<a href="tree.php?dir=<?=$file;?>" class="menuLeftBar"><?=$file;?></a>
		  <?php
			}else{
				//is file
				$path_parts = pathinfo($file);
				if (isset($path_parts['extension'])){
					$ext = $path_parts['extension'];
					$sPathIcon = URL."/icons/".$ext.".png";
				}
				else //load a generic icon
					$sPathIcon = URL."/icons/file.png";
			
				if($file!='.'){
			?>
				<img src="<?=$sPathIcon;?>" alt="" />&nbsp;<?=$file;?>
			<?php
				}//if
			}//if
		  ?>		  
          </td>
          <td>&nbsp;
		  <?php
		  	//File Size
			if ($file!= "." && $file != ".."){
				$tam = filesize($file);
				if( $tam > 1024 ){
					$tam = round($tam / 1024);
					echo $tam." Kb"; 
				}
				else
				{
					echo $tam." bytes"; 
				}//if
			}//if
		  ?>		  
          </td>
          <?php
          if($file!="." && $file != ".."){
		  ?>
		  <td>&nbsp;<?=date ("d F Y H:i:s", filemtime($file));?></td>
          <td>&nbsp;<?php
//	          $uid = fileowner($file); //return uid owner file 
	//		  $sUser = posix_getpwuid($uid); //return array asoc uid with name...  
		  ?>  
          <? //=$sUser["name"];?>        
          </td>
          <td>&nbsp;<?php
		  	  //$gid = filegroup($file); //return file group id
			  //$sGroup = posix_getgrgid($gid);	  		      
		  ?> 
          <? //=$sGroup["name"];?>         
          </td>
          <td>&nbsp;
          <?php
		 /* function show_perm_complete($sFile){
		  //$perms = fileperms($sFile); //get octal value of permison
		  return fileperms($sFile) & 511; 
		 /*
		  	if (($perms & 0xC000) == 0xC000) {
				// Socket
				$info = 's';
			} elseif (($perms & 0xA000) == 0xA000) {
				// Enlace Simbolico
				$info = 'l';
			} elseif (($perms & 0x8000) == 0x8000) {
				// Regular
				$info = '-';
			} elseif (($perms & 0x6000) == 0x6000) {
				// Bloque especial
				$info = 'b';
			} elseif (($perms & 0x4000) == 0x4000) {
				// Directorio
				$info = 'd';
			} elseif (($perms & 0x2000) == 0x2000) {
				// Caracter especial
				$info = 'c';
			} elseif (($perms & 0x1000) == 0x1000) {
				// Pipe FIFO
				$info = 'p';
			} else {
				// Desconocido
				$info = 'u';
			}
			
			// Duenyo
			$info .= (($perms & 0x0100) ? 'r' : '-');
			$info .= (($perms & 0x0080) ? 'w' : '-');
			$info .= (($perms & 0x0040) ?
						(($perms & 0x0800) ? 's' : 'x' ) :
						(($perms & 0x0800) ? 'S' : '-'));
			
			// Group
			$info .= (($perms & 0x0020) ? 'r' : '-');
			$info .= (($perms & 0x0010) ? 'w' : '-');
			$info .= (($perms & 0x0008) ?
						(($perms & 0x0400) ? 's' : 'x' ) :
						(($perms & 0x0400) ? 'S' : '-'));
			
			// World
			$info .= (($perms & 0x0004) ? 'r' : '-');
			$info .= (($perms & 0x0002) ? 'w' : '-');
			$info .= (($perms & 0x0001) ?
						(($perms & 0x0200) ? 't' : 'x' ) :
						(($perms & 0x0200) ? 'T' : '-'));
			
				return $info;*/
		  /*}//show_perm_complete
          echo show_perm_complete($files[$i]);
		  clearstatcache();*/
		  if (fileperms($file))
		  echo substr(sprintf('%o', fileperms($file)), -4)
		  ?>
          </td>
          <?php
          if(is_file($file)){
		  ?>
          <td><a href="javascript:edit('<?=$file?>');"><img src="<?=URL?>/images/b_edit.png" alt="<?=$CONTENT["EDIT"];?>" title="<?=$CONTENT["EDIT"];?>" /></a></td>
          <?php
		  }//if
		  else
		  	echo "<td>&nbsp;</td>";
		  ?>
		  <td><a href="javascript:rename('<?=$file;?>');"><img src="<?=URL?>/images/rename.jpg" title="<?=$CONTENT["RENAME"];?>" alt="<?=$CONTENT["RENAME"];?>" /></a></td>
          <td><a href="javascript:delete_file('<?=$file;?>');"><img src="<?=URL?>/images/delete.jpg" title="<?=$CONTENT["DELETE"];?>" alt="<?=$CONTENT["DELETE"];?>" /></a></td>
		  <td><a href="zip.php?file=<?=$file;?>"><img src="<?=URL?>/images/zip.gif" alt="<?=$CONTENT["COMPRESS"];?>" title="<?=$CONTENT["COMPRESS"];?>" /></a></td>
			  <?php
              if(is_file($file)){
              ?>
              <td><a href="javascript:download_file('<?=$file?>');"><img src="<?=URL?>/images/download.gif" alt="<?=$CONTENT["DOWNLOAD"];?>" title="<?=$CONTENT["DOWNLOAD"];?>" /></a></td>
              <?php
              }//if
              ?>
          <?php
		  }//if
		  ?>
        </tr>
     <?php		
		  }//foreach
	 ?>
      </table>
	 </div> 
	   <!-- -->	  
      </td>
    </tr>
    <!-- BARRA ESTADO -->
    <tr bgcolor="#EFEFE9">
      <!-- -->
      <td style="height:24px;"><img src="<?=URL;?>/images/spacer.gif" alt="" width="3" />&nbsp;<?=$i-2;?>&nbsp;<?=$CONTENT["OBJECTS"];?>&nbsp;</td>
      <td align="right">
      <a href="http://gustavonovaro.blogspot.com" target="_blank">Blog de Tavo</a>&nbsp; - <a href="http://fileexplorerxp.googlecode.com/" target="_blank">File Explorer XP</a> | Version: <?=$sConfig["VERSION"];?> &nbsp;
      </td>
    </tr>
  </table>
  <input type="hidden" name="H_NAME" id="H_NAME" value="" />
  <input type="hidden" name="H_ACTION" id="H_ACTION" value="" />
  <input type="hidden" name="H_EXTRA" id="H_EXTRA" value="" />
</form>
</body>
</html>