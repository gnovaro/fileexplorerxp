<?php
// definir el nivel de reporte de errores para este script
error_reporting(E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE);
set_error_handler('logErr');
// funcion de gestion de errores
function logErr($num_err, $cadena_err, $archivo_err, $linea_err)
{
	switch ($num_err) 
	{
		case E_USER_ERROR:
			echo "<b>Mi ERROR</b> [$num_err] $cadena_err<br />\n";
			echo "  Error fatal en la linea $linea_err del archivo $archivo_err";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Abortando...<br />\n";
			exit(1);
			break;
  		case E_USER_WARNING:
   			echo "<b>Mi ADVERTENCIA</b> [$num_err] $cadena_err<br />\n";
   			break;
  		case E_USER_NOTICE:
		    echo "<b>Mi NOTICIA</b> [$num_err] $cadena_err<br />\n";
			break;
		default:
		    echo "Tipo de error desconocido Codigo: [$num_err] $cadena_err Linea: $linea_err archivo: $archivo_err<br />\n";
			break;
  }//switch
}//function

/*

function handler($errno, $errstr, $errfile, $errline)
{
   print "Error handled!\n";
   throw new Exception($errstr, $errno);
}

set_error_handler('handler');
try
{
   print 2 / 0; // simple error - division by zero
   print "This will never be printed";
}
catch (Exception $e)
{
   print "Exception catched:\n";
   print "Code: ".$e->getCode()."\n";
   print "Message: ".$e->getMessage()."\n";
   print "Line: ".$e->getLine();
}

*/
?>