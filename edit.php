<?php
/*
Author: G. Novaro
E-mail: gnovaro@gmail.com
URL: http://www.novarsystems.com.ar
File: edit.php
Purpose: Edit text files
*/

//Security check
session_start();
if(!isset($_SESSION["login"]))
	header("Location: index.php");
//security
define("URL","http://localhost/fileexplorerxp/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>:: File Explorer XP ::</title>
    <link rel="stylesheet" type="text/css" href="<?=URL?>style.css">
    <script src="<?=URL?>codepress/codepress.js" type="text/javascript"></script>
</head>

<body>
<?php
	if(isset($_POST["H_FILE_NAME"])){
			$sFile = $_POST["H_FILE_NAME"];
			$sPath = $_SESSION["path"];
			$sPath = $sPath.DIRECTORY_SEPARATOR.$sFile;		
			$sContent = $_POST["content"];
			file_put_contents($sPath,$sContent);
			echo "Datos guardados satifactoriamente";
	}//if
?>
	<h2>Editar Archivo:</h2>
	<form id="frmEditor" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<div id="editor" align="center">
    <table>
    <tr>
	    <td>
        <?php
			$sContent = "";
            if(isset($_GET["file"]))
                $sFile = $_GET["file"];
            
            if(isset($_POST["H_FILE_NAME"]))
                $sFile = $_POST["H_FILE_NAME"];
                
            $sPath = $_SESSION["path"];
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
					case 'j':
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
        <textarea name="content" id="myCpWindow" class="codepress <?=$language;?> linenumbers-on" cols="80" rows="40"><?=$sContent;?></textarea>
        </td>
	</tr>
    <tr>        
		<td>        
	   	<div style="text-align:right">
        <input type="button" name="btCancel" value="Cancelar" onclick="window.location='tree.php';" />
        <input type="submit" name="btSend" id="btSend" value="Guardar" onclick="" />
        </div>
        </td>
	</tr>        
    </table>
    <input type="hidden" name="H_FILE_NAME" id="H_FILE_NAME" value="<?=$sFile?>" />

	</div>
    </form>
</body>
</html>
