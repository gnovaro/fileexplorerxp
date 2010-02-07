<?php
/**
* Setup page
* @author Gustavo Novaro <gnovaro@gmail.com>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>:: File Explorer XP - SETUP ::</title>
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOCACHE, NOARCHIVE" />
	<link rel="stylesheet" type="text/css" href="fileexplorer.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js"></script> 
</head>

<body>
	<h1>File Explorer XP <?php echo $CONTENT['SETUP'];?></h1>
    
    <form id="frmSetup" action="dosetup.php" method="post">
    <fieldset>
        <legend>Configuration</legend>
        <div>
            <label>User:</label>
            <input type="text" name="user" id="user" maxlength="12" value="admin" class="required" />
        </div>
        <div>
            <label>Password:</label>
            <input type="text" name="password" id="password" maxlength="12" value="admin" class="required" />
        </div>
        <div>
            <label>URL:</label>
            <input type="text" name="url" id="url" value="http://<?php echo $_SERVER['HTTP_HOST'];?>/<?php echo basename(dirname(__FILE__));?>" maxlength="255" />
        </div>        
        <?php
        if (phpversion() >= '5.1.0') {
    	?>
        <div>
            <label>Time Zone:</label>
  			<select name="php_zone" id="php_zoneR">
                <option value="UTC">UTC</option>
    			<?php
                $timezone_identifiers = DateTimeZone::listIdentifiers();
    			for ($i=0; $i < count($timezone_identifiers); $i++) {
    			?>
               	<option value="<?php echo $timezone_identifiers[$i];?>"><?php echo $timezone_identifiers[$i];?></option>
    			<?php
    			}//for
    			?>                
            </select>
        </div>
        <?php
    	}//if
    	?>
        <div>
            <input type="submit" name="btsend" id="btsend" value="<?php echo $CONTENT['SUBMIT'];?>" />
        </div>
    </fieldset>
    </form>
</body>
</html>