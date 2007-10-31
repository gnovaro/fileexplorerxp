<?php
/**
* @author: G. Novaro <gnovaro@gmail.com>
* @version: 0.71
* URL: http://www.novarsystems.com.ar
* File: get_file.php
* Purpose: Download file 
*/

//Security check
session_start();
if(!isset($_SESSION["login"]))
	header("Location: index.php");
//security
?>
<?php
	if (isset($_GET["file"])){
		$sPath = $_SESSION["path"];		
		$downloadfile = $sPath.DIRECTORY_SEPARATOR.$_GET["file"];
		if(file_exists($downloadfile)){
			$mime_type = mime_content_type($downloadfile);
			header("Cache-Control: public, must-revalidate");
			header("Pragma: hack");
			header("Content-Type: " . $mime_type);
			header("Content-Length: " .(string)(filesize($downloadfile)) );
			header('Content-Disposition: attachment; filename="'.basename($downloadfile).'"');
			header("Content-Transfer-Encoding: binary\n");

			if($file=fopen($downloadfile,'rb')){ # send file
				while(!feof($file)){
					print(fread($file,1024*8));
					flush();
				}
				fclose($file);
			}
		}//exist
	}//if
?>