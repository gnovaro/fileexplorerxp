<?php
/**
* @author	Gustavo Novaro <gnovaro@gmail.com>
* @version	1.61
*/
function redirect($sURL){
	if ($sURL !="")
		header("Location:".$sURL);
}//redirect

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
if (phpnum()==5){
	if(isset($config["TIME_ZONE"])){
		date_default_timezone_set($config["TIME_ZONE"]);
	} else {
		date_default_timezone_set("UTC");
	}//if
}//if

function getIP(){	
	if ($_SERVER) {
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}//if
	} else {
		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
		$realip = getenv( 'HTTP_CLIENT_IP' );
		} else {
			$realip = getenv( 'REMOTE_ADDR' );
		}//if
	}//if
 	return $realip;
}//getIP
