<?php
/**
* @author Gustavo Novaro
* @version 1.74
* https://github.com/gnovaro/fileexplorerxp
* File: tree.php
* Purpose: View and listing files and directory
*/
	error_reporting(E_ALL);
	require('./config.php');
	//require('./error_handler.php');
	require('./function.php');
	
	$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
	//echo $sLang;
	$sPath = './languages/'.$sLang.'.php';
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
	   date_default_timezone_set($config['TIME_ZONE']);

	$sMessage = '';
	$cantFiles = 0;
	$sPath = '';
	if (!isset($_SESSION["path"]) ){
		$sRootPath = getcwd(); 	//Obtiene el directorio actual de trabajo.
		$_SESSION["path"] = $sRootPath;
		$sPath = $sRootPath;
	//	echo "session path ".$_SESSION["path"];
	}
	else
	{
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
	
	function compress_gz($sFile)
	{
		// abrir el archivo para escritura con maxima compresion
		$zp = gzopen($sFile.'.gz', "w9");
		$fp = fopen($sFile,"rb"); //windows rb
		while(!feof($fp)){
			// escribir la cadena en el archivo
			$s = fread($fp,2000);
			gzwrite($zp, $s);
		}
		fclose($fp);
		// cerrar el archivo
		gzclose($zp);
	}//compress_gz
	
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

	if (isset($_POST["H_ACTION"])){
		$sAction = $_POST["H_ACTION"];
		
		switch($sAction){
			case 'NEW_FOLDER': 
				$sDirName = $_POST["H_NAME"];
				if(mkdir($sDirName, 0700))
				{
					$sMessage = $CONTENT["CREATE_DIR_SUCESS"];
				} else {
					$sMessage = $CONTENT["CREATE_DIR_FAIL"];
				}			
				break;
			case 'NEW_FILE':
				$sName = $_POST["H_NAME"];
				if (!file_exists($sName)){
					fopen($sName,'w');
					$sMessage = $CONTENT["FILE_SUCESS"];//"File created sucess"
				}else{
					$sMessage = $CONTENT["FILE_FAIL"];
				}//if
				break;
			case 'DELETE':
				$sName = $_POST["H_NAME"];
				if(is_dir($sName)){
					if (rmdir($sName)== true) 
						$sMessage = $CONTENT["DELETE_DIR_SUCESS"];
					else
						$sMessage = $CONTENT["DELETE_DIR_FAIL"];
				}
				else
					if(file_exists($sName))
						if ( unlink($sName) ){
							$sMessage = $CONTENT["DELETE_FILE_SUCESS"];
						} else{
							$sMessage = $CONTENT["DELETE_FILE_FAIL"];
						}//if	
				break;
			case 'RENAME':
				$sName = $_POST["H_NAME"];
				$sExtra = $_POST["H_EXTRA"];
				if(file_exists($sName))
				{
					if(rename($sName,$sExtra))
						$sMessage = $CONTENT["RENAME_FILE_SUCESS"];
					else
						$sMessage = $CONTENT["RENAME_FILE_FAIL"];
				}//if
				break;
			case 'COMPRESS':
				$sName = $_POST["H_NAME"];
				if(file_exists($sName))
					compress_gz($sName);
				break;
		}//switch
			
	}//if action
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $CONTENT["TITLE"];?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/assets/css/fileexplorer.css" />
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script src="//ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js"></script> 
	<script type="text/javascript">
	function showhide_with_image(targetDiv,actionImage){
		var image = document.getElementById(actionImage);
		if($("#"+targetDiv).css("display") == "none"){
			$("#"+targetDiv).slideDown("slow");
			image.src = "<?php echo URL?>/assets/images/up.jpg";
		} else {
			$("#"+targetDiv).slideUp("slow");
			image.src = "<?php echo URL?>/assets/images/down.jpg";
		}
	}//showhide_with_image
	
	function rename(sName){
		var resp;
		resp = prompt("<?php echo $CONTENT["RENAME_FILE"];?> " + sName + "?",sName);
		if (resp != null){
			document.getElementById("H_ACTION").value = "RENAME";
			document.getElementById("H_NAME").value = sName;
			document.getElementById("H_EXTRA").value = resp;
			document.getElementById("frmMain").submit();
		}//if
	}//rename

function delete_file(sName){
	var resp;
	resp = confirm("<?php echo $CONTENT["DELETE_FILE"];?> '" + sName + "' ?");
	if (resp != null){
		document.getElementById("H_ACTION").value = "DELETE";
		document.getElementById("H_NAME").value = sName;
		document.getElementById("frmMain").submit();
	}//if
}//delete_file

function new_folder(){
	folder = prompt("<?php echo $CONTENT["NEW_FOLDER"];?>");
	if (folder !="" && folder != null){
		//Validar charAt " " != espacio
		document.getElementById("H_ACTION").value = "NEW_FOLDER";
		document.getElementById("H_NAME").value = folder;
		document.getElementById("frmMain").submit();
	}//if
}//new_folder

function new_file(){
	sFile = prompt("<?php echo $CONTENT["NEW_FILE"];?>");
	if (sFile !="" && sFile != null){
		//Validar charAt " " != espacio
		document.getElementById("H_ACTION").value = "NEW_FILE";
		document.getElementById("H_NAME").value = sFile;
		document.getElementById("frmMain").submit();
	}//if
}//new_file

function close_admin(){
	sclose = confirm("<?php echo $CONTENT["EXIT"];?>");
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

function compress(sFile)
{
	document.getElementById("H_NAME").value = sFile;
	document.getElementById("H_ACTION").value = "COMPRESS";
	document.getElementById("frmMain").submit();
}
function show_pop(id)
{
	$("#"+id).show();
}
function close_pop(id)
{
	$("#"+id).hide();
}
</script>
</head>
<body>
		<?php
		if(!empty($sMessage)):
		?>
		<div id="divMessage" class="box radius">
			<div style="float:right"><a href="#" onclick="close_pop('divMessage');"><img src="<?php echo URL;?>/assets/images/close.png" alt="close" /></a></div>
			<img src="<?php echo URL;?>/assets/images/info.png" alt="Info" />&nbsp;<strong><?php echo $sMessage;?></strong>
		</div>
		<?php
		endif;
		?>
		<div id="divHelp" class="box" style="display:none;">
			<div style="float:right"><a href="#" onclick="$('#divHelp').hide();"><img src="<?php echo URL;?>/assets/images/close.png" alt="close" /></a></div>
			<a href="http://fileexplorerxp.googlecode.com/" target="_blank">File Explorer XP</a><br />
				PHP Web File Manager<br />
				Author: &nbsp;Gustavo Novaro<br />
				Version:&nbsp;<?php echo $config['VERSION'];?><br />
		</div><!--divHelp-->
		
<form name="frmMain" id="frmMain" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<div id="header-bar">
		<div id="header-bar-title">&nbsp;<?php echo $CONTENT['TITLE'];?></div>
		<div id="header-bar-button">
		<a href="#" onclick="close_admin();">
		<img src="<?php echo URL;?>/assets/images/close.png" alt="close" title="<?php echo $CONTENT['EXIT'];?>" /></a>&nbsp;
		</div>
	</div><!--header-bar-->

	<div id="address-bar">
		<span>
			&nbsp;<?php echo $CONTENT["PATH"];?>&nbsp;
			<input type="text" name="dir" id="txtPath" style="width:650px;" value="<?php echo realpath($sPath);?>"/>
		</span>
		<a href="#" onclick="go_path();"><img src="<?php echo URL;?>/assets/images/arrow_go.jpg" alt="<?php echo $CONTENT["GO"];?>" style="border:none;" /></a>
		<?php echo $CONTENT["GO"];?>
		&nbsp;&nbsp;&nbsp;<a href="#" onclick="show_pop('divHelp');"><img src="<?php echo URL;?>/assets/images/help.gif" alt="<?php echo $CONTENT["HELP"];?>" /></a>
	</div><!--address-bar-->

	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="180" bgcolor="#6B85DC" style="vertical-align:top;">
	<br />
	<!--file-task-->
	<div id="file-task">
		<div class="box-title">
			<div class="textoAzul">&nbsp;<?php echo $CONTENT['FILE_TASK'];?></div>
			<div class="arrow"><a href="javascript:showhide_with_image('task','img_arrow_task');"><img src="<?php echo URL;?>/assets/images/up.jpg" id="img_arrow_task" style="border:none" /></a></div>
		</div>
		<div id="task">
			<ul>c
				<li><img src="<?php echo URL;?>/assets/images/file.gif" alt="" />&nbsp;<a href="javascript:new_file();" class="menuLeftBar"><?php echo $CONTENT["NEW_FILE"];?></a></li>
				<li><img src="<?php echo URL;?>/assets/images/new_folder.jpg" alt="" />&nbsp;<a href="javascript:new_folder();" class="menuLeftBar"><?php echo $CONTENT["NEW_FOLDER"];?></a></li>
				<li>&nbsp;<img src="<?php echo URL;?>/assets/images/upload.jpg" alt="" />&nbsp;<a href="<?php echo URL;?>/upload.php" class="menuLeftBar"><?php echo $CONTENT["UPLOAD_FILE"];?></a></li>
				<li>&nbsp;<img src="<?php echo URL;?>/assets/images/control_panel.jpg" alt="" />&nbsp;<a href="<?php echo URL;?>/control_panel.php" class="menuLeftBar"><?php echo $CONTENT["CONTROL_PANEL"];?></a></li>
			</ul>
		</div><!--task-->
	</div><!--file-task-->
	  
	<!-- Detail Panel-->
	<div id="details">
		<!--box-title-->
		<div class="box-title">
			<div class="textoAzul">&nbsp;<?php echo $CONTENT['DETAILS'];?></div>
			<div class="arrow">
			<a href="javascript:showhide_with_image('details-box','img_arrow_detail');"><img src="<?php echo URL;?>/assets/images/up.jpg" id="img_arrow_detail" style="border:none" alt="" /></a>
			</div>
		</div>
		<!--box-title-->
		<div id="details-box">
			<?php
			// $df contiene el numero total de bytes disponible en "/"
			$df = disk_free_space(".");
			$df = format_size($df);
  		  	?>
			  &nbsp;<?php echo $CONTENT['SPACE_FREE'];?>:<br />
			  &nbsp;<?php echo $df;?>
			  <br />
			  <br />
			<?php
			// $df contiene el numero total de bytes disponible en "/"
			$dt = disk_total_space(".");
			$dt = format_size($dt);
  			?>
			&nbsp;<?php echo $CONTENT['SPACE_TOTAL'];?>:<br />
			&nbsp;<?php echo $dt;?>
		</div><!--details-->
	  </div>
	  <!-- -->	  </td>
	  <td width="778" style="vertical-align:top;">
	  <!-- Listado Archivos -->
	  <div style="top: 66px; left: 191px;">
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr bgcolor="#EFEFE9">
		  <td width="10px">&nbsp;</td>
		  <td width="270px">&nbsp;<?php echo $CONTENT['NAME'];?> </td>
		  <td width="80px"><span class="barra">|</span><?php echo $CONTENT['SIZE'];?></td>
		  <td><span class="barra">|</span><?php echo $CONTENT['LAST_MODIFY'];?></td>
		  <td><span class="barra">|</span><?php echo $CONTENT['OWNER'];?></td>
		  <td><span class="barra">|</span><?php echo $CONTENT['GROUP'];?></td>
		  <td><span class="barra">|</span><?php echo $CONTENT['PERMISSIONS'];?></td>
		  <td colspan="5">&nbsp;</td>
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
		<td>
		<?php if($file!='.' && $file!='..'):?>
			<input type="checkbox" name="[]" id="" />
		<?php endif;?>
		</td>
		<td bgcolor="#F7F7F7">&nbsp;
		<?php
		if(is_dir($file)&& $file!='.'):
		?>
			<img src='<?php echo URL?>/assets/images/folder.jpg' alt="" />&nbsp;<a href="tree.php?dir=<?php echo $file;?>" class="menuLeftBar"><?php echo $file;?></a>
		<?php
		else:
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
				<img src="<?php echo $sPathIcon;?>" alt="" />&nbsp;<?php echo$file;?>
			<?php
				}//if
		endif;
		?>
		</td>
		<td>&nbsp;
		<?php
		//File Size
			if ($file!= "." && $file != ".."){
				$tam = filesize($file);
				if( $tam > 1024 ){
					$tam = round($tam / 1024);
					echo $tam.' Kb'; 
				}
				else
				{
					echo $tam.' bytes'; 
				}//if
			}//if
		  ?>
		  </td>
		  <?php
		  if($file!="." && $file != ".."){
		  ?>
		  <td>&nbsp;<?php echo date ("d F Y H:i:s", filemtime($file));?></td>
		  <td>&nbsp;
		  <?php
			if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' )
			{
				$uid = fileowner($file); //return uid owner file 
				$sUser = posix_getpwuid($uid); //return array asoc uid with name...  
				echo $sUser['name'];
			}
		  ?>
		  </td>
		  <td>&nbsp;<?php
			if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' )
			{
				$gid = filegroup($file); //return file group id
				$sGroup = posix_getgrgid($gid);
				echo $sGroup['name'];
			}
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
		  if (fileperms($file))
			  echo substr(sprintf('%o', fileperms($file)), -4);
		  ?>
		  </td>
		  <?php
		  if(is_file($file)){
		  ?>
		  <td><a href="javascript:edit('<?php echo $file?>');"><img src="<?php echo URL?>/assets/images/b_edit.png" alt="<?php echo $CONTENT["EDIT"];?>" title="<?php echo $CONTENT["EDIT"];?>" /></a></td>
		  <?php
		  }//if
		  else
		  	echo "<td>&nbsp;</td>";
		  ?>
		  <td><a href="javascript:rename('<?php echo $file;?>');"><img src="<?php echo URL?>/assets/images/rename.jpg" title="<?php echo $CONTENT["RENAME"];?>" alt="<?php echo $CONTENT["RENAME"];?>" /></a></td>
		  <td><a href="javascript:delete_file('<?php echo $file;?>');"><img src="<?php echo URL?>/assets/images/delete.gif" title="<?php echo $CONTENT["DELETE"];?>" alt="<?php echo $CONTENT["DELETE"];?>" /></a></td>		  
		  <?php
			  if(is_file($file)){
		  ?>
		  <td><a href="javascript:compress('<?php echo $file;?>');"><img src="<?php echo URL?>/assets/images/zip.gif" alt="<?php echo $CONTENT["COMPRESS"];?>" title="<?php echo $CONTENT["COMPRESS"];?>" /></a></td>
		  <td><a href="javascript:download_file('<?php echo $file?>');"><img src="<?php echo URL?>/assets/images/download.gif" alt="<?php echo $CONTENT["DOWNLOAD"];?>" title="<?php echo $CONTENT["DOWNLOAD"];?>" /></a></td>
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
  </table>
  <!--status-bar-->
  <div id="status-bar">
	<div id="objects">&nbsp;<?php echo $i-2;?>&nbsp;<?php echo $CONTENT['OBJECTS'];?>&nbsp;</div>
	<div id="about"><a href="https://github.com/gnovaro/fileexplorerxp" target="_blank">File Explorer XP</a> | Version: <?php echo $config['VERSION'];?> &nbsp;</div>
  </div>
  <!--status-bar-->
  <input type="hidden" name="H_NAME" id="H_NAME" value="" />
  <input type="hidden" name="H_ACTION" id="H_ACTION" value="" />
  <input type="hidden" name="H_EXTRA" id="H_EXTRA" value="" />
</form>
</div>
</body>
</html>
