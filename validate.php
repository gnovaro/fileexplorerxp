<?php
/**
 * Generic validation hardcode process
 * @author Gustavo Novaro
 * @version 1.77
 * https://github.com/gnovaro/fileexplorerxp
 */
	require('./config.php');
	require('./function.php');
	session_start();
	$user = addslashes(trim($_POST['user']));  
	$pass = sha1(addslashes(trim($_POST['password'])));
	if ( $user == $config['USER'] &&  $pass == $config['PASS'])
	{
		$_SESSION['login'] = true;
		redirect('tree.php');
	} else {
		$_SESSION['__MSG__'] = 'Invalid user or password';
		redirect('index.php');
	}//if
