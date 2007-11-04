<?php
/**
* @author: Gustavo Novaro <gnovaro@gmail.com>
* @version: 0.80
*/
function goto($sURL){
	if ($sURL !="")
		header("Location:".$sURL);
}//goto

function phpnum() {
	$version = explode('.', phpversion());
	return (int) $version[0];
}
function is_php5() { if (phpnum() == 5) return true; }
function is_php4() { if (phpnum() == 4) return true; }
?>