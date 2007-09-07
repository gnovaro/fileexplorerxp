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
define("URL","http://localhost/filemanagerphp/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link rel="stylesheet" type="text/css" href="<?=URL?>style.css">
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
        <textarea name="content" id="content" cols="80" rows="40">
        <?php
            if(isset($_GET["file"]))
                $sFile = $_GET["file"];
            
            if(isset($_POST["H_FILE_NAME"]))
                $sFile = $_POST["H_FILE_NAME"];
                
            $sPath = $_SESSION["path"];
            $sPath = $sPath.DIRECTORY_SEPARATOR.$sFile;
            if (is_file($sPath)){
                $sContent = file_get_contents($sPath);
                echo trim($sContent);
            }//is_file
        ?>
        </textarea>
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
