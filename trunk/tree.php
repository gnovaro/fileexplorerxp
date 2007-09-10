<?php
/*
Author: G. Novaro
E-mail: gnovaro@gmail.com
URL: http://www.novarsystems.com.ar
File: tree.php
Purpose:
*/

//Security check
session_start();
if(!isset($_SESSION["login"]))
	header("Location: index.php");
//security

	define("URL","http://localhost/fileexplorerxp/");
	require("languages/spanish.php");
	require("error_handler.php");	
	
	function phpnum() {
		$version = explode('.', phpversion());
		return (int) $version[0];
	}
	function is_php5() { if (phpnum() == 5) return true; }
	function is_php4() { if (phpnum() == 4) return true; }
	
	if (phpnum()==5)
		date_default_timezone_set('America/Argentina/Buenos_Aires');		
		
	$cantFiles = 0;
	$sPath = "";
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
					echo "Archivo creado en forma satisfactoria";//"File created sucess"
				}
				else
					echo "ERROR: Ya existe un archivo con ese nombre";
				break;
			case "DELETE":
				$sName = $_POST["H_NAME"];
				if(is_dir($sName)){
					if (rmdir($sName)== true) 
						echo "Directorio $sName eliminado correctamente";
					else
						echo "Error al borrar directorio $sName, compruebe que esta vacio";
				}
				else
					if(file_exists($sName))
						if ( unlink($sName) ){
							echo "Delete Sucess";
						}//if	
				break;
			case "RENAME":
				//rename();
				break;
		}//switch
			
	}//if action
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?=$titulo;?></title>
    <link rel="stylesheet" type="text/css" href="<?=URL?>style.css">
<script type="text/javascript">
function showhide_with_image(targetDiv,actionImage){
	    image = document.getElementById(actionImage)
		var oVDiv = document.getElementById(targetDiv);
		prop = oVDiv.style.display;
		if(prop == "none"){
			oVDiv.style.display = "block";
			image.src = "<?=URL?>images/up.jpg";
		}
		else{
			oVDiv.style.display = "none";
			image.src = "<?=URL?>images/down.jpg";
		}
}//showhide_with_image
	
function rename(name){
	prompt("¿Renombrar el archivo: " + name + "?",name);
}//rename

function delete_file(sName){
	var resp;
	resp = confirm("¿Desea eliminar el archivo: '" + sName + "' ?");
	document.getElementById("H_ACTION").value = "DELETE";
	document.getElementById("H_NAME").value = sName;
	document.getElementById("frmMain").submit();
}//deleteFile

function new_folder(){
	folder = prompt("Nombre carpeta:");
	if (folder !="" && folder != null){
		//Validar charAt " " != espacio
		document.getElementById("H_ACTION").value = "NEW_FOLDER";
		document.getElementById("H_NAME").value = folder;
		document.getElementById("frmMain").submit();
	}//if
}//new_folder

function new_file(){
	sFile = prompt("Nombre archivo:");
	if (sFile !="" && sFile != null){
		//Validar charAt " " != espacio
		document.getElementById("H_ACTION").value = "NEW_FILE";
		document.getElementById("H_NAME").value = sFile;
		document.getElementById("frmMain").submit();
	}//if
}//new_file

function close_admin(){
	sclose = confirm("¿Esta seguro que de sea cerrar el Administrador de Archivos?");
	if (sclose){
		window.location = "index.php";
	}
}//closeAdmin

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
}
</script>
</head>
<body>
<form name="frmMain" id="frmMain" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
  <table width="80%" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#EFEFE9">
      <td colspan="2"><div align="right"><a href="javascript:close_admin();"><img src="<?=URL;?>images/close.png" alt="close" style="border:none;" title="Salir" /></a>&nbsp;</div></td>
    </tr>
    <tr bgcolor="#EFEFE9">
      <td colspan="2">&nbsp;Direcci&oacute;n:&nbsp;<span><input type="text" name="dir" id="txtPath" style="width:650px;" value="<?=realpath($sPath);?>"/></span><input type="button" name="btSend" id="btSend" value="Ir" class="button" onclick="go_path();" /></td>
    </tr>
    <tr>
      <!-- -->
      <td width="180" height="500" bgcolor="#6B85DC" style="vertical-align:top;">
	  <br />
	  <!-- Panel Tareas -->
	  <div style="width:160px; margin:10px;">
	  <table border="0" cellpadding="0" cellspacing="0" width="160px">
          <tr bgcolor="#FFFFFF">
            <td width="133" class="textoAzul">&nbsp;Tareas de archivo </td>
            <td width="27"><a href="javascript:showhide_with_image('task','img_arrow_task');"><img src="<?=URL;?>images/up.jpg" id="img_arrow_task" style="border:none" /></a></td>
          </tr>
	 </table>
    <div id="task">
	<table border="0" cellpadding="0" cellspacing="0" width="160px">     		  
		  <tr bgcolor="#D6DFF7">
		  	<td colspan="2">&nbsp;<img src="<?=URL;?>images/file.gif" />&nbsp;<a href="javascript:new_file();" class="menuLeftBar">Crear Nuevo Archivo</a></td>
		  </tr>
          
		  <tr bgcolor="#D6DFF7">
		  	<td colspan="2">&nbsp;<img src="<?=URL;?>images/new_folder.jpg" />&nbsp;<a href="javascript:new_folder();" class="menuLeftBar">Crear Nueva Carpeta</a></td>
		  </tr>

		  <tr bgcolor="#D6DFF7">
		  	<td colspan="2">&nbsp;<img src="<?=URL;?>images/upload.jpg" />&nbsp;<a href="<?=URL;?>uploadFiles.php" class="menuLeftBar">Subir archivo</a></td>
		  </tr>
		  
		  <tr bgcolor="#D6DFF7">
		  	<td colspan="2">&nbsp;<img src="<?=URL;?>images/control_panel.jpg" />&nbsp;<a href="#" class="menuLeftBar">Panel de Control</a></td>
		  </tr>
	  </table>
      </div>
	  </div>
	  <!-- Panel Tareas -->
	  
	  <!-- Panel Detalle -->
	  <div style="width:160px; margin:10px;">
	    <table border="0" cellpadding="0" cellspacing="0" width="160px">
          <tr bgcolor="#FFFFFF">
            <td width="133" class="textoAzul">&nbsp;Detalles</td>
            <td width="27"><a href="javascript:showhide_with_image('details','img_arrow_detail');"><img src="<?=URL;?>images/up.jpg" id="img_arrow_detail" style="border:none" /></a></td>
          </tr>
        </table>
        <div id="details">
        <table border="0" cellpadding="0" cellspacing="0" width="160px">
          <tr bgcolor="#D6DFF7">
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
			$df = disk_free_space("/");
			$df = format_size($df);
  		  	?>
              &nbsp;Espacio libre:<br />
              &nbsp;<?=$df;?>
              <br />
              <br />
              </td>
          </tr>
          <tr bgcolor="#D6DFF7">
            <td colspan="2" style="border-bottom: 1px #FFFFFF; border-right: 1px #FFFFFF;"><?
			// $df contiene el numero total de bytes disponible en "/"
			$dt = disk_total_space("/");
			$dt = format_size($dt);
  		  ?>
              &nbsp;Espacio Total:<br />
              &nbsp;<?=$dt;?>
              </td>
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
          <td width="250px" height="24">&nbsp;Nombre</td>
          <td width="75px"><span class="barra">|</span>Tama&ntilde;o</td>
          <td><span class="barra">|</span>Fecha Modificaci&oacute;n</td>
		  <td><span class="barra">|</span>Propietario</td>
		  <td><span class="barra">|</span>Grupo</td>
		  <td><span class="barra">|</span>Permisos</td>
		  <td colspan="4">&nbsp;</td>
        </tr>
		<?php 
          //Poner en un include
          
          //Lista los archivos y directorios ubicados en la ruta especificada en un array
          $dh  = @opendir($sPath)or die("No se puede abrir el  $sPath");
          $i=0;
          while (false !== ($file_name = readdir($dh))) {
            $i++;
            	$files[$i] = $file_name;
        ?>
        <tr>
          <td bgcolor="#F7F7F7">&nbsp;
		  <?php
		  	if(is_dir($files[$i])){
		  ?>
				<img src='<?=URL?>images/folder.jpg' \>&nbsp;<a href="tree.php?dir=<?=$files[$i];?>" class="menuLeftBar"><?=$files[$i];?></a>
		  <?php
			}				
			else{
				//is file
				$sExtension = explode(".", $files[$i]);
				$sPathIcon = URL."icons/".$sExtension[1].".gif";
				/*if (!file_exists($sPathIcon))
					$sPathIcon = URL."icons/file.gif";*/
			?>
				<img src="<?=$sPathIcon;?>" alt="" />&nbsp;<?=$files[$i];?>
			<?php
			}//if
		  ?>		  </td>
          <td>&nbsp;
		  <?php
		  		$tam = filesize($files[$i]);
		  		if( $tam > 1024 ){
					$tam = round($tam / 1024);
					echo $tam." Kb"; 
				}
				else
				{
					echo $tam." bytes"; 
				}//if
		  ?>		  </td>
          <?php
          if($files[$i]!="." && $files[$i] != ".."){
		  ?>
		  <td>&nbsp;<?=date ("d F Y H:i:s", filemtime($files[$i]));?></td>
          <td>&nbsp;<?php
	          $uid = fileowner($files[$i]); //return uid owner file 
			  $sUser = posix_getpwuid($uid); //return array asoc uid with name...  
			  echo $sUser["name"];
		  ?>          </td>
          <td>&nbsp;<?php
		  	  $gid = filegroup($files[$i]); //return file group id
			  $sGroup = posix_getgrgid($gid);	 
 		      echo $sGroup["name"];
		  ?>          
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
		  if (fileperms($files[$i]))
		  echo substr(sprintf('%o', fileperms($files[$i])), -4)
		  ?>
          </td>
          <?php
          if(is_file($files[$i])){
		  ?>
          <td><a href="javascript:edit('<?=$files[$i]?>');"><img src="<?=URL?>images/b_edit.png" name="ren<?=$i;?>" style="border:none;" alt="Editar" title="Editar" /></a></td>
          <?php
		  }//if
		  else
		  	echo "<td>&nbsp;</td>";
		  ?>
		  <td><a href="javascript:rename('<?=$files[$i]?>');"><img src="<?=URL?>images/rename.jpg" name="ren<?=$i;?>" style="border:none;" title="Renombrar" /></a></td>
          <td><a href="javascript:delete_file('<?=$files[$i]?>');"><img src="<?=URL?>images/delete.jpg" style="border:none;" title="Eliminar" /></a></td>
		  <td><img src="<?=URL?>images/zip.gif" alt="Comprimir" title="Comprimir" /></td>
          <?php
          if(is_file($files[$i])){
		  ?>
          <td><a href="javascript:download_file('<?=$files[$i]?>');"><img src="<?=URL?>images/download.gif" alt="Descargar" title="Descargar" style="border:none;" /></a></td>
          <?php
          }//if
		  ?>
          <?php
		  }//if
		  ?>
        </tr>
        <?		
		  }//
	 ?>
      </table>
	 </div> 
	   <!-- -->	  
      </td>
    </tr>
    <!-- BARRA ESTADO -->
    <tr bgcolor="#EFEFE9">
      <!-- -->
      <td>&nbsp;<?=$i-2;?>&nbsp;Objetos&nbsp;</td>
      <td align="right"><a href="http://www.novarsystems.com.ar" target="_blank">NovAR Systems - www.novarsystems.com.ar</a>&nbsp; - Version: 1.0 &nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="H_NAME" id="H_NAME" value="" />
  <input type="hidden" name="H_ACTION" id="H_ACTION" value="" />
</form>
</body>
</html>
