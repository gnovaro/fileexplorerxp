<?php
	session_start();
	//destroy session - Logout
	if (isset($_SESSION['login'])) 
	{
		session_unset();
		session_destroy();
		$_SESSION = array();
	}//if
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>:: FileManagerPHP - www.novarsystems.com.ar::</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<form id="frmLogin" name="frmLogin" action="validate.php" method="post" style="margin-top:150px">
<table border="0" align="center">
	<tr>
	  <td colspan="2">Ingreso al sistema</td>
    </tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
		<td>&nbsp;<strong>Usuario:</strong></td>
		<td><input type="text" name="txtUserName" id="txtUserName" autocomplete="false" /></td>
	</tr>
	<tr>
		<td>&nbsp;<strong>Contrase&ntilde;a:</strong></td>
		<td><input type="password" name="txtPass" id="txtPass" autocomplete="false" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" name="btLogin" id="btLogin" value="Ingresar"/></td>
	</tr>
</table>
</form>
</body>
</html>
