<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 1.04
*/
function goto($sURL){
	if ($sURL !="")
		header("Location:".$sURL);
}//goto

function get_lang(){
/**
*
* @returns: Array with lenguages files to load 
*/
	$sLang = false;
	$oFp = opendir("languages");
	 while (false !== ($oFile = readdir($oFp))) {
		if ($oFile != "." && $oFile != "..") {
			$oFileParts = pathinfo($oFile);
			if (isset($oFileParts["extension"])){
				if ($oFileParts["extension"] == "php"){
	            	$sLang[$oFileParts["filename"]] = $oFile;
				}//if
			}//if
        }//if
    }//while
	return $sLang;
}//get_lang
function get_os(){
	return PHP_OS;
}//get_os

function phpnum() {
	$version = explode('.', phpversion());
	return (int) $version[0];
}
function is_php5() { if (phpnum() == 5) return true; }
function is_php4() { if (phpnum() == 4) return true; }
if (phpnum()==5)
	date_default_timezone_set($sConfig["TIME_ZONE"]);
?>