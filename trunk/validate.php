<?php
/**
* @uthor: Gustavo Novaro <gnovaro@gmail.com>
* @version: 1.27
* URL: http://gustavonovaro.blogspot.com
* Purpouse: Generic validation hardcode process
*/

	require('./config.php');
	require('./function.php');
	session_start();
	$user = addslashes($_POST['txtUserName']);  
	$pass = sha1(addslashes($_POST['txtPass']));
	if ( $user == $sConfig['USER'] &&  $pass == $sConfig['PASS'])
	{
		$_SESSION['login'] = true;
		redirect('tree.php');	
	}else{
		$_SESSION['__MSG__'] = 'Invalid user or password';
		redirect('index.php');
	}//if