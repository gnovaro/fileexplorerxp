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
$sPath = __DIR__.'/application/i18n/'.$sLang.'.php';
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
	<meta charset="utf-8">
	<meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<title>File Explorer XP - SETUP</title>
	<link rel="stylesheet" href="assets/css/fileexplorer.css" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="//ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js"></script>
</head>
<body>
<div class="container">
	<h1>File Explorer XP <?php echo $CONTENT['SETUP'];?></h1>

	<form id="frmSetup" action="dosetup.php" method="post">
	<fieldset>
		<legend>Configuration</legend>
		<div class="form-group">
			<label><strong>User:</strong></label>
			<input type="text" name="user" id="user" maxlength="12" value="admin" class="required form-control" required="required">
		</div>
		<div class="form-group">
			<label><strong>Password:</strong></label>
			<input type="password" name="password" id="password" maxlength="12" value="admin" class="required form-control" required="required">
		</div>
		<div class="form-group">
			<label><strong>URL:</strong></label>
			<input type="url" name="url" id="url" value="http://<?php echo $_SERVER['HTTP_HOST'];?>/<?php echo basename(dirname(__FILE__));?>" maxlength="255" required="required" class="form-control">
		</div>
		<?php if (phpversion() >= '5.3.0'):?>
		<div class="form-group">
			<label><strong>Time Zone:</strong></label>
  			<select name="php_zone" id="php_zoneR" required="required" class="form-control">
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
		<div class="form-group">
			<button type="submit" name="btsend" id="btsend" class="btn btn-default"><?php echo $CONTENT['SUBMIT'];?></button>
		</div>
	</fieldset>
	</form>
</div><!--./container-->
</body>
</html>
