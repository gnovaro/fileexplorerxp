<?php
/**
 * @author	Gustavo Novaro
 * @version	2.0.1
 * https://github.com/gnovaro/fileexplorerxp
 * File: index.php
 * Purpose: Login
 */
	require('application/bootstrap.php');
	require("function.php");

	if (isset($_SESSION['__MSG__']))
	{
		$sMsg = $_SESSION['__MSG__'];
		unset($_SESSION['__MSG__']);
	} else {
		$sMsg = '';
	}//if

	//destroy session - Logout
	if (isset($_SESSION['login']))
	{
		session_unset();
		session_destroy();
		$_SESSION = array();
	}//if
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE">
	<title><?php echo I18n::get('Title');?></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link rel="stylesheet" href="fileexplorer.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="//ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js"></script>
</head>
<body>
<form id="frmLogin" name="frmLogin" action="validate.php" method="post" style="margin-top:100px">
<div align="center">
	<div style="background:#EEFFEE; border:#CCF7CC 1px solid; padding:5px; width:300px;" class="radius">
	<div>
		<h1>&nbsp;Login</h1>
	</div>
	<div class="form-group">
		<label class="control-label"><strong><?php echo I18n::get('User');?>:</strong></label>
		<input type="text" name="user" id="user" autocomplete="false" required="required" class="form-control">
	</div>
	<div class="form-group">
		<label><strong><?php echo I18n::get('Password');?>:</strong></label>
		<input type="password" name="password" id="password" autocomplete="false" required="required"  class="form-control">
	</div>
	<div class="form-group">
		<div class="text-right">
			<button type="submit" name="btLogin" id="btLogin" class="btn btn-primary"><?php echo I18n::get('Login');?></button>
		</div>
	</div>
	<div class="form-group text-center">
		<img src="<?php echo URL;?>/assets/images/padlock.gif" alt="" />&nbsp;<strong>IP:</strong>&nbsp;
			<?php
			$sIp = getIP();
			$sDate = date("Y-m-d H:m:s");
			write_log('login_access.log',$sDate." - ".$sIp);
			echo $sIp;
			?>
	</div>
	<div id="div_msg">&nbsp;<strong><?php echo $sMsg;?></strong></div>
</div>
</form>
<div style="margin-top:170px;">
	<div align="right">
	<a href="https://github.com/gnovaro/fileexplorerxp" target="_blank">File Explorer XP</a> | Version: <?php echo $config["VERSION"];?> &nbsp;
	</div>
</div>
</body>
</html>
