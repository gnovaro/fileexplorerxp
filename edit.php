<?php
/**
* @author Gustavo Novaro
* @version 2.0
* https://github.com/gnovaro/fileexplorerxp
* File: edit.php
* Purpose: Edit text files
*/
require('application/bootstrap.php');
require("function.php");

//Security check
if(!isset($_SESSION['login']))
	header('Location: index.php');
//security

$sContent = '';

if(isset($_POST['H_FILE_NAME']))
{
	$sFile = $_POST['H_FILE_NAME'];
	$sPath = $_SESSION['path'];
	$sPath = $sPath.DIRECTORY_SEPARATOR.$sFile;

	$sContent = $_POST['content'];
	$fp = fopen($sPath,"w+");
	fwrite($fp,$sContent);
	fclose($fp);
}//if

if(isset($_GET['file']))
	$sFile = $_GET['file'];

if(isset($_POST['H_FILE_NAME']))
	$sFile = $_POST['H_FILE_NAME'];

$sPath = $_SESSION['path'];
$sPath = $sPath.DIRECTORY_SEPARATOR.$sFile;
//
$path_parts = pathinfo($sPath);
$ext = $path_parts['extension'];
/**
 * determine language for Codepress
 */
switch($ext){
	case 'html':
	case 'tpl':
		$language='html';
		break;
	case 'php':
		$language = 'php';
		break;
	case 'css':
		$language = 'css';
		break;
	case 'js':
		$language = 'javascript';
		break;
	case 'java':
		$language = 'java';
		break;
	case 'pl':
		$language = 'perl';
		break;
	case 'ruby':
		$language = 'ruby';
		break;
	case 'sql':
		$language = 'sql';
		break;
	case 'tex':
		$language = 'tex';
		break;
	case 'txt':
		$language = 'text';
		break;
	default:
		$language = 'generic';
		break;
}

if (is_file($sPath)){
	$sContent = file_get_contents($sPath);
}//is_file

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE">
	<title><?php echo $CONTENT['TITLE'];?></title>
	<link rel="stylesheet" href="<?php echo URL?>/fileexplorer.css">
	<script src="<?php echo URL?>/codepress/codepress.js"></script>
	<script src="<?php echo URL?>/assets/js/function.js"></script>
</head>
<body>
<?php
/*if(isset($_POST['H_FILE_NAME']))
	echo "Datos guardados satifactoriamente";*/
?>
	<h2>Editar Archivo:</h2>
	<form id="frmEditor" action="" method="post" onsubmit="myCpWindow.toggleEditor();">
	<div id="editor" align="center">
	<?php

		?>
		<div>
			<textarea name="content" id="myCpWindow" class="codepress <?php echo $language;?> linenumbers-on" cols="80" rows="40"><?php echo $sContent;?></textarea>
		</div>
		<div style="text-align:right">
			<button type="button" name="btCancel" onclick="redirect('tree.php');" class="btn btn-default"><?php echo $CONTENT['Cancel'];?></button>
			<button type="submit" name="btSend" id="btSend" class="btn btn-primary"><?php echo $CONTENT['Save'];?></button>
		</div>

	<input type="hidden" name="H_FILE_NAME" id="H_FILE_NAME" value="<?php echo $sFile?>" />
	</div>
	</form>
</body>
</html>
