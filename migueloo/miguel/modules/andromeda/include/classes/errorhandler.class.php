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
	function gestorDeErroresDeUsuario($num_err, $mens_err, $nombre_archivo, $num_linea, $vars)
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
       
       if (in_array($num_err, $errores_de_usuario)){
            $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
       }
       $err .= "</errorentry>\n\n";
       
       // para efectos de debug
       // echo $err;
       
       // guardar en el registro de errores, y enviar un correo
       // electr&oacute;nico si hay un error cr&iacute;tico de usuario
       //$this->_log($err, $num_err);
       if ($num_err == E_USER_ERROR) {
            //mail("jamarcer@inicia.es", "Error Critico de Usuario en miguel", $err);
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
?>
