<?php
/**
 * Setup page
 * @author Gustavo Novaro
 * https://github.com/gnovaro/fileexplorerxp
 * @version $Id$
 * Purpouse: Setup a config file first time execution
 */
$sLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
//echo $sLang;
$sPath = './languages/'.$sLang.'.php';
if (file_exists($sPath))
{
	require($sPath);
}
else
{
	//default lang english
	require('./languages/en.php'); 
}//if
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>:: File Explorer XP - SETUP ::</title>
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<link rel="stylesheet" type="text/css" href="assets/css/fileexplorer.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script src="//ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js"></script> 
</head>

<body>
	<h1>File Explorer XP <?php echo $CONTENT['SETUP'];?></h1>

	<form id="frmSetup" action="dosetup.php" method="post">
	<fieldset>
		<legend>Configuration</legend>
		<div>
			<label><strong>User:</strong></label>
			<input type="text" name="user" id="user" maxlength="12" value="admin" class="required" required="required" />
		</div>
		<div>
			<label><strong>Password:</strong></label>
			<input type="text" name="password" id="password" maxlength="12" value="admin" class="required" required="required" />
		</div>
		<div>
			<label><strong>URL:</strong></label>
			<input type="url" name="url" id="url" value="http://<?php echo $_SERVER['HTTP_HOST'];?>/<?php echo basename(dirname(__FILE__));?>" maxlength="255" required="required" />
		</div>
		<?php if (phpversion() >= '5.1.0'):?>
		<div>
			<label><strong>Time Zone:</strong></label>
  			<select name="php_zone" id="php_zoneR" required="required">
				<option value="UTC">UTC</option>
				<?php
				$timezone_identifiers = DateTimeZone::listIdentifiers();
				for ($i=0; $i < count($timezone_identifiers); $i++):
				?>
				<option value="<?php echo $timezone_identifiers[$i];?>"><?php echo $timezone_identifiers[$i];?></option>
				<?php
				endfor;
				?>
			</select>
		</div>
		<?php endif;?>
		<div>
			<input type="submit" name="btsend" id="btsend" value="<?php echo $CONTENT['SUBMIT'];?>" />
		</div>
	</fieldset>
	</form>
</body>
</html>
