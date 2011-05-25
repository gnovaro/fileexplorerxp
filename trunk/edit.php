<?php
/**
* @author Gustavo Novaro <gnovaro@gmail.com>
* @version 1.77
* URL: http://gustavonovaro.com.ar
* File: edit.php
* Purpose: Edit text files
*/

require('./config.php');
require('./languages/es.php');
require('error_handler.php');

//Security check
session_start();
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $CONTENT['TITLE'];?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo URL?>/fileexplorer.css" />
	<script src="<?php echo URL?>/codepress/codepress.js" type="text/javascript"></script>
	<script src="<?php echo URL?>/js/function.js" type="text/javascript"></script>
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
</head>

<body>
<?php
/*if(isset($_POST['H_FILE_NAME']))
	echo "Datos guardados satifactoriamente";*/
?>
	<h2>Editar Archivo:</h2>
	<form id="frmEditor" action="" method="post" onsubmit="myCpWindow.toggleEditor();">
	<div id="editor" align="center">
	<table>
	<tr>
		<td>
		<?php
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
		<textarea name="content" id="myCpWindow" class="codepress <?php echo $language;?> linenumbers-on" cols="80" rows="40"><?php echo $sContent;?></textarea>
		</td>
	</tr>
	<tr>
		<td>
		<div style="text-align:right">
		<input type="button" name="btCancel" value="Cancelar" onclick="redirect('tree.php');" />
		<input type="submit" name="btSend" id="btSend" value="Guardar" />
		</div>
		</td>
	</tr>
	</table>
	<input type="hidden" name="H_FILE_NAME" id="H_FILE_NAME" value="<?php echo $sFile?>" />

	</div>
	</form>
</body>
</html>
