<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This library is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU Library General Public        |
      |   License as published by the Free Software Foundation; either       | 
      |   version 2 of the License, or (at your option) any later version.   |
      |                                                                      |
      |   This library is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU  |
      |   Library General Public License for more details.                   |
      |                                                                      |
      |   You should have received a copy of the GNU Library General Public  |
      |   License along with this program; if not, write to the Free         |
      |   Software Foundation, Inc., 59 Temple Place - Suite 330, Boston,    |
      |   MA 02111-1307, USA.                                                |      
      +----------------------------------------------------------------------+
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage include
 */
/**
 * Define la clase para el control de errores.
 * Se plantea un manejador de errores para su uso en el framework
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */
class ErrorHandler
{
    /**
	 * @access private
	 */
    var $str_error 			= '';
    /**
	 * @access private
	 */
    var $bol_error 		= FALSE;
    

	/**
  	  * Constructor.
  	  *
  	  * @public
  	  */
	function ErrorHandler()
	{
		error_reporting(0);
		set_error_handler(array($this,"processError"));
        //$this->_clearError();
	}
	
	// funcion de gestion de errores definida por el usuario
function gestorDeErroresDeUsuario($num_err, $mens_err, $nombre_archivo,
                                 $num_linea, $vars)
{

   // marca de fecha/hora para el registro de error
   $dt = date("Y-m-d H:i:s (T)");

   // definir una matriz asociativa de cadenas de error
   // en realidad las unicas entradas que deberiamos
   // considerar son E_WARNING, E_NOTICE, E_USER_ERROR,
   // E_USER_WARNING y E_USER_NOTICE

   $tipo_error = array (
               E_ERROR          => "Error",
               E_WARNING        => "Advertencia",
               E_PARSE          => "Error de Int&eacute;rprete",
               E_NOTICE          => "Anotaci&oacute;n",
               E_CORE_ERROR      => "Error de N&uacute;cleo",
               E_CORE_WARNING    => "Advertencia de N&uacute;cleo",
               E_COMPILE_ERROR  => "Error de Compilaci&oacute;n",
               E_COMPILE_WARNING => "Advertencia de Compilaci&oacute;n",
               E_USER_ERROR      => "Error de Usuario",
               E_USER_WARNING    => "Advertencia de Usuario",
               E_USER_NOTICE    => "Anotaci&oacute;n de Usuario",
               E_STRICT          => "Anotaci&oacute;n de tiempo de ejecuci&oacute;n"
               );
   // conjunto de errores de los cuales se almacenara un rastreo
   $errores_de_usuario = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

   $err = "<errorentry>\n";
   $err .= "\t<datetime>" . $dt . "</datetime>\n";
   $err .= "\t<errornum>" . $num_err . "</errornum>\n";
   $err .= "\t<errortype>" . $tipo_error[$num_err] . "</errortype>\n";
   $err .= "\t<errormsg>" . $mens_err . "</errormsg>\n";
   $err .= "\t<scriptname>" . $nombre_archivo . "</scriptname>\n";
   $err .= "\t<scriptlinenum>" . $num_linea . "</scriptlinenum>\n";

   if (in_array($num_err, $errores_de_usuario))
       $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
   $err .= "</errorentry>\n\n";

   // para efectos de debug
   // echo $err;

   // guardar en el registro de errores, y enviar un correo
   // electr&oacute;nico si hay un error cr&iacute;tico de usuario
   error_log($err, 3, "/usr/local/php4/error.log");
   if ($num_err == E_USER_ERROR) {
       mail("phpdev@example.com", "Error Cr&iacute;tico de Usuario", $err);
   }
}
  
  	/**
  	  * Informa de la ocurrencia de un error
  	  * @returns boolean True si ha ocurrido un error, False si no.
  	  */
	function hasError()
	{
		return $this->bol_error;
	}
	
	/** 
	  * Devuelve el mensaje del error o información asociada.
	  * @returns string
	  */
	function getError()
	{
		return $this->str_error;
	}
	
	/**
	  * Informa de la ocurrencia de un error.
  	  * @param 	string	$error Mensaje informativo del error.
	  */
	function setError($error, $priority = 'LOG_ERR')
	{
		$this->str_error  = $error;	
		$this->bol_error = true;
		$this->_log($error, $priority);
	}
	
	/**
	  * Restaura los valores iniciales
	  * @internal
	  */
	function _clearError()
	{
		$this->str_error  = null;	
		$this->bol_error = FALSE;
	}
	
	/**
	 * Escribe un mensaje en el log
	 * @param string $message Mensaje a guardar en el Log
     * @param string $priority Nivel de log
	 */
    function _log($message, $priority)
    {	
    	include_once(Util::base_Path("include/classes/loghandler.class.php"));
  		LogHandler::log($message, 'Error', $priority);
    }
}

// haremos nuestra propia manipulaci&oacute;n de errores
error_reporting(0);

// funcion de gestion de errores definida por el usuario
function gestorDeErroresDeUsuario($num_err, $mens_err, $nombre_archivo,
                                 $num_linea, $vars)
{

   // marca de fecha/hora para el registro de error
   $dt = date("Y-m-d H:i:s (T)");

   // definir una matriz asociativa de cadenas de error
   // en realidad las unicas entradas que deberiamos
   // considerar son E_WARNING, E_NOTICE, E_USER_ERROR,
   // E_USER_WARNING y E_USER_NOTICE

   $tipo_error = array (
               E_ERROR          => "Error",
               E_WARNING        => "Advertencia",
               E_PARSE          => "Error de Int&eacute;rprete",
               E_NOTICE          => "Anotaci&oacute;n",
               E_CORE_ERROR      => "Error de N&uacute;cleo",
               E_CORE_WARNING    => "Advertencia de N&uacute;cleo",
               E_COMPILE_ERROR  => "Error de Compilaci&oacute;n",
               E_COMPILE_WARNING => "Advertencia de Compilaci&oacute;n",
               E_USER_ERROR      => "Error de Usuario",
               E_USER_WARNING    => "Advertencia de Usuario",
               E_USER_NOTICE    => "Anotaci&oacute;n de Usuario",
               E_STRICT          => "Anotaci&oacute;n de tiempo de ejecuci&oacute;n"
               );
   // conjunto de errores de los cuales se almacenara un rastreo
   $errores_de_usuario = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

   $err = "<errorentry>\n";
   $err .= "\t<datetime>" . $dt . "</datetime>\n";
   $err .= "\t<errornum>" . $num_err . "</errornum>\n";
   $err .= "\t<errortype>" . $tipo_error[$num_err] . "</errortype>\n";
   $err .= "\t<errormsg>" . $mens_err . "</errormsg>\n";
   $err .= "\t<scriptname>" . $nombre_archivo . "</scriptname>\n";
   $err .= "\t<scriptlinenum>" . $num_linea . "</scriptlinenum>\n";

   if (in_array($num_err, $errores_de_usuario))
       $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
   $err .= "</errorentry>\n\n";

   // para efectos de debug
   // echo $err;

   // guardar en el registro de errores, y enviar un correo
   // electr&oacute;nico si hay un error cr&iacute;tico de usuario
   error_log($err, 3, "/usr/local/php4/error.log");
   if ($num_err == E_USER_ERROR) {
       mail("phpdev@example.com", "Error Cr&iacute;tico de Usuario", $err);
   }
}


function distancia($vect1, $vect2)
{
   if (!is_array($vect1) || !is_array($vect2)) {
       trigger_error("Par&aacute;metros incorrectos, se esperan matrices", E_USER_ERROR);
       return NULL;
   }

   if (count($vect1) != count($vect2)) {
       trigger_error("Los vectores deben ser del mismo tama&ntilde;o", E_USER_ERROR);
       return NULL;
   }

   for ($i=0; $i<count($vect1); $i++) {
       $c1 = $vect1[$i]; $c2 = $vect2[$i];
       $d = 0.0;
       if (!is_numeric($c1)) {
           trigger_error("La coordenada $i en el vector 1 no es un ".
                         "n&uacute;mero, se usar&aacute; cero",
                           E_USER_WARNING);
           $c1 = 0.0;
       }
       if (!is_numeric($c2)) {
           trigger_error("La coordenada $i en el vector 2 no es un".
                         "n&uacute;mero, se usar&aacute; cero",
                           E_USER_WARNING);
           $c2 = 0.0;
       }
       $d += $c2*$c2 - $c1*$c1;
   }
   return sqrt($d);
}

$gestor_de_errores_anterior = set_error_handler("gestorDeErroresDeUsuario");

// constante indefinida, se genera una advertencia
$t = NO_ESTOY_DEFINIDA;

// definir algunos "vectores"
$a = array(2, 3, "foo");
$b = array(5.5, 4.3, -1.6);
$c = array(1, -3);

// generar un error de usuario
$t1 = distance($c, $b) . "\n";

// generar otro error de usuario
$t2 = distance($b, "no soy una matriz") . "\n";

// generar una advertencia
$t3 = distance($a, $b) . "\n";
?>
**************************************************************************
<?php
// redefine the user error constants - PHP4 only
define (FATAL,E_USER_ERROR);
define (ERROR,E_USER_WARNING);
define (WARNING,E_USER_NOTICE);

// set the error reporting level for this script
error_reporting  (FATAL + ERROR + WARNING);

// error handler function
function myErrorHandler ($errno, $errstr) {
   switch ($errno) {
   case FATAL:
   echo "<b>FATAL</b> [$errno] $errstr<br>\n";
   echo "  Fatal error in line ".__LINE__." of file ".__FILE__;
   echo ", PHP ".PHP_VERSION." (".PHP_OS.")<br>\n";
   echo "Aborting...<br>\n";
   exit -1;
   break;
   case ERROR:
   echo "<b>ERROR</b> [$errno] $errstr<br>\n";
   break;
   case WARNING:
   echo "<b>WARNING</b> [$errno] $errstr<br>\n";
   break;
   default:
   echo "Unkown error type: [$errno] $errstr<br>\n";
   break;
   }
}

// function to test the error handling
function scale_by_log ($vect, $scale) {
   if ( !is_numeric($scale) || $scale <= 0 )
   trigger_error("log(x) for x <= 0 is undefined, you used: scale = $scale",
     FATAL);
   if (!is_array($vect)) {
   trigger_error("Incorrect input vector, array of values expected", ERROR);
   return null;
   }
   for ($i=0; $i<count($vect); $i++) {
   if (!is_numeric($vect[$i]))
   trigger_error("Value at position $i is not a number, using 0 (zero)",
     WARNING);
   $temp[$i] = log($scale) * $vect[$i];
   }
   return $temp;
}

// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");

// trigger some errors, first define a mixed array with a non-numeric item
echo "vector a\n";
$a = array(2,3,"foo",5.5,43.3,21.11);
print_r($a);

// now generate second array, generating a warning
echo "----\nvector b - a warning (b = log(PI) * a)\n";
$b = scale_by_log($a, M_PI);
print_r($b);

// this is trouble, we pass a string instead of an array
echo "----\nvector c - an error\n";
$c = scale_by_log("not array",2.3);
var_dump($c);

// this is a critical error, log of zero or negative number is undefined
echo "----\nvector d - fatal error\n";
$d = scale_by_log($a, -2.5);

?>
********************************************************************
<?php

       class error {

               var $conf;
               var $lang;

               function error($conf, $lang) {
                       $this->conf = $conf;
                       $this->lang = $lang;

                       set_error_handler(array(&$this, 'handler'));
               }

               function handler($no, $str, $file, $line, $ctx) {
                       echo '<pre>';
                       echo 'no  : ' . $no . "\n";
                       echo 'str  : ' . $str . "\n";
                       echo 'file : ' . $file . "\n";
                       echo 'line : ' . $line . "\n";
                       echo 'ctx  : ';
                       print_r($ctx);
                       echo '</pre>';
               }

       }
?>
******************************************************************
class ApplicationObject {
   var $error_List;

   function ApplicationObject() {
       set_error_handler('trapError');
       $this->error_List = &trapError();
   }

}

function &trapError() {
   static $error_Vals = array();

   if (func_num_args()==5) { // Error Event has been passed
       $error_Vals[] = array(    'err_no' => func_get_arg(0), 'err_text' => func_get_arg(1), 'err_file' => func_get_arg(2), 'err_line' => func_get_arg(3), 'err_vars'=>func_get_arg(4));
   }
   if (func_num_args()==0) { // Setup call. Return reference
       return $error_Vals;
   }
}
********************************************************************
A quote from Zeev Suraski:

"The CVS version (scheduled for 4.0.2) of the function has been enhanced:

- The error handler accepts three additional arguments - the filename in  which the error occured, the line number in which the error occured, and the context of the in which the error occured (a hash that points to the active symbol table at the place of the error)."

So, you can now do this:

function myErrorHandler ($errno, $errstr, $errfile, $errline, $errcontext) {...}

[Editor's Note:
The above phrase: "...the context of the in which the error occured (a hash that points to the active symbol table at the place of the error)." may be difficult for new programmers to understand.

What it means is that the last argument passed to your error handler (the $errcontext in the above example) will contain an array that contains the value of every variable that existed in the scope the error was triggered in.

Try the following example to see exactly how this works:

<pre>
<?php
// Define a simple error handler
function error_handler ($level, $message, $file, $line, $context) {

   echo <<<_END_
An error of level $level was generated in file $file on line $line.
The error message was: $message
The following variables were set in the scope that the error occurred in:

<blockquote>
_END_;

   print_r ($context);
   print "\n</blockquote>";
}

// Set the error handler to the error_handler() function
set_error_handler ('error_handler');

// Make a function and trigger an error
function foo () {
   global $SERVER_ADMIN;
   $bar = 1;

   // Trigger the error in the local scope of the function
   trigger_error ("Some error");
}

foo();

// Now trigger the error in global scope
trigger_error ("Some other error");
?>
*****************************************************************
function ErrorHandler()
{
   $this->error_messages  = array();
   error_reporting (E_ALL);
   set_error_handler(array($this,"assignError"));
}

and my assignError method:
//accept the required arguments
function assignError($errno, $errstr, $errfile, $errline)
{
   //get the error string
   $error_message = $errstr;
//if in debug mode, add line number and file info
 if(ErrorHandler::DEBUG())
 $error_message .= "<br>".basename($errfile).",line: ".$errline;

           switch ($errno)
           {
               //if the error was fatal, then add the error
               //display an error page and exit
               case ErrorHandler::FATAL():
                   $this->setType('Fatal');
                   $this->addError($error_message);
                   Display::errorPage($this->errorMessages());
                   exit(1);
               break;
               //if it was an error message, add a message of
               //type error
               case ErrorHandler::ERROR():
                   $this->setType('Error');
                   $this->addError($error_message);
               break;
               //if it was a warning, add a message of type
               //warning
               case ErrorHandler::WARNING():
                   $this->setType('Warning');
                   $this->addError($error_message);
               break;
               //if it was some other code then display all
               //the error messages that were added
               default:
                   Display::errorRows($this->errorMessages());
               break;
           }
           //return a value so that the script will continue
           //execution
           return 1;
}
************************************************************
if (_DEBUG_) {
   set_error_handler ('debug_error_handler');
}
else {
   set_error_handler ('nice_error_handler');
}
*********************************************************
