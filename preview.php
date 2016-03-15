<?php
/**
 * Preview file
 */
require 'application/bootstrap.php';
if(!isset($_SESSION["login"]))
	header("Location: index.php");

if (isset($_GET["file"])) {
    $sPath = $_SESSION["path"];
    $downloadfile = $sPath.DIRECTORY_SEPARATOR.$_GET["file"];
    if(file_exists($downloadfile)) {
        if(function_exists('mime_content_type')){
            $mime_type = mime_content_type($downloadfile);
            header("Content-Type: " . $mime_type);
        }
        echo file_get_contents($downloadfile);
    }
}
