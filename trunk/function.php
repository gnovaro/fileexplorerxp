<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 0.84
*/
function goto($sURL){
	if ($sURL !="")
		header("Location:".$sURL);
}//goto

function write_log($sText){
	$oFp = fopen("logs".DIRECTORY_SEPARATOR."login.log","a+");
	fwrite($oFp,$sText." \n");
	fclose($oFp);
}//write_log

function phpnum() {
	$version = explode('.', phpversion());
	return (int) $version[0];
}
function is_php5() { if (phpnum() == 5) return true; }
function is_php4() { if (phpnum() == 4) return true; }
if (phpnum()==5)
	date_default_timezone_set($sConfig["TIME_ZONE"]);
?>