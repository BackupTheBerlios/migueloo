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
 * @subpackage control
 */
/**
 * Define la clase para el tratamiento de sesiones.
 * Se define el tratamiento de los datos que configuran la sesión activa de miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class Session
{
	/**
	 * @access private
	 */
	var $bol_okConfFile = false;
	
	/**
	 * Devuelve una referencia al objeto global Session, que solo
	 * se crea si no existe.
	 *
	 * Este método se invoca $session = &Session::start();
	 */
	function &start()
	{
		static $miguel_session;
		
		if(!isset($miguel_session)){
			$miguel_session = new Session();
		}
		
		return $miguel_session;
	} 

	/**
	 * Constructor.
     *
	 */
    function Session() 
    {	
        $str_name = session_name();

		if ($str_name != "MIGUEL_BASE") {
			session_name("MIGUEL_BASE");
		}
		
		ini_set("session.save_handler", "files");
		ini_set("session.use_cookies", 0);
		/* Comentado para miguelHib
		if(MIGUELBASE_SESSION_DIR != ''){
        	ini_set("session.save_path", MIGUELBASE_SESSION_DIR);
        }
        */
        ini_set("session.use_trans_sid", 0);
        ini_set("session.gc_probability", 100);
        //ini_set("display_errors", "On");
        //ini_set("display_startup_errors", "Off");
        //ini_set("log_errors", "Off");
        //ini_set("upload_tmp_dir", MIGUELBASE_CACHE_DIR);
        //ini_set("upload_max_filesize", "2M");

		if(!session_id()){
            session_start();
        }

		if (MIGUELBASE_PHP_INT_VERSION >= 40200) {
			session_cache_expire(MIGUELBASE_SESSION_TIME);
		}

		//Cargamos los valores de contexto
		if ($this->_isContextSet()) {
			$this->bol_okConfFile = true;
		} else {
			$this->_initContext();
			$this->setValue('session', true);
		}
    }
    
    /**
	 * Libera todos los recursos asociados a la sesión.
	 */
    function close()
    {
        //Bloqueamos la sesión actual
        //session_start();
        Session::setValue('session', false);
        
        //Guardamos el la sesión 
        session_write_close();
        
        //Creamos una nueva sesión, cambiando el nombre a la actual.
        session_id(md5(time()));
        //La "limpiamos"
        Session::clear();
        //Y la activamos
        Session::setValue('session', true);
      }

    /**
	 * Libera todos los recursos asociados a la sesión.
	 */
    function clear()
    {
        if (MIGUELBASE_PHP_INT_VERSION >= 40006) {
   			if(isset($_SESSION["CONTEXT"])){
   				$arr_context = $_SESSION["CONTEXT"];
   				$_SESSION = array();
   				$_SESSION["CONTEXT"] = $arr_context;
   			}
    	} else {
    		if(isset($HTTP_SESSION_VARS["CONTEXT"])){
   				$arr_context = $HTTP_SESSION_VARS["CONTEXT"];
   				$HTTP_SESSION_VARS = array();
   				$HTTP_SESSION_VARS["CONTEXT"] = $arr_context;
   			}
    	}
    }
    
    /**
	 * Devuelve el valor asignado a una variable de sesión.
	 * @param string $str_var Nombre de la variable.
	 * @return mixto Valor asociado.
	 */
    function getValue($str_var)
    {
    	$ret_val = null;
    	if (MIGUELBASE_PHP_INT_VERSION >= 40006) {
   			if(isset($_SESSION["MIGUEL_".strtoupper($str_var)])){
   				$ret_val = $_SESSION["MIGUEL_".strtoupper($str_var)];
   			}
    	} else {
    		if(isset($HTTP_SESSION_VARS["MIGUEL_".strtoupper($str_var)])){
   				$ret_val = $HTTP_SESSION_VARS["MIGUEL_".strtoupper($str_var)];
   			}
    	}
    	return $ret_val;
    }
    
    /**
	 * Permite asignar una valor a una variable de sesión.
	 * @param string $str_var Nombre de la variable.
	 * @param mixto $mix_value Valor asignado.
	 */
    function setValue($str_var, $mix_value = '')
    {
    	if (MIGUELBASE_PHP_INT_VERSION >= 40006) {
			$_SESSION["MIGUEL_".strtoupper($str_var)] = $mix_value;
    	} else {
   			$HTTP_SESSION_VARS["MIGUEL_".strtoupper($str_var)] = $mix_value;
    	} 
    }
    
    /*
	 * Devuelve el valor de una variable de contexto
	 * @param string $varNombre de la variable.
	 * @return mixto Valor de la variable
	 *
	 */
	function getContextValue($str_var)
	{
		$ret_val = null;
        if (MIGUELBASE_PHP_INT_VERSION >= 40006) {
   			if(isset($_SESSION["CONTEXT"]["MIGUEL_".strtoupper($str_var)])){
   				$ret_val = $_SESSION["CONTEXT"]["MIGUEL_".strtoupper($str_var)];
   			}
    	} else {
    		if(isset($HTTP_SESSION_VARS["CONTEXT"]["MIGUEL_".strtoupper($str_var)])){
   				$ret_val = $HTTP_SESSION_VARS["CONTEXT"]["MIGUEL_".strtoupper($str_var)];
   			}
    	}
    	return $ret_val;
	}
	
	/*
	 * Devuelve el valor de una variable de contexto
	 * @internal
	 *
	 */
	function _isContextSet()
	{
		$ret_val = false;
        if (MIGUELBASE_PHP_INT_VERSION >= 40006) {
   			if(isset($_SESSION['CONTEXT'])){
   				$ret_val =true;
   			}
    	} else {
    		if(isset($HTTP_SESSION_VARS['CONTEXT'])){
   				$ret_val = true;
   			}
    	}
    	return $ret_val;
	}
    
    /*
	 * Carga el fichero de configuración
	 * @internal
	 *
	 */        
	function _initContext()
	{
		$conf_file = '';
		
        if(file_exists(CONFIG_FILE)) {
			$conf_file = CONFIG_FILE;
		} else {
		    if(file_exists(Util::app_Path('common/include/config_context.xml'))) {
	           $conf_file = Util::app_Path('common/include/config_context.xml');
            }
		}
		
		if($conf_file != ''){
		  $this->_processXMLInitData($conf_file);
		  $this->bol_okConfFile = true;
		}
	}

	/*
	 * Procesa el fichero de configuración
	 * El fichero de configuración está en formato XML.
	 * @param string $str_fileName Nombre del fichero de configuración
	 * @internal
	 *
	 */     
  	function _processXMLInitData($str_fileName)
	{
		//Include XMLMini
		require_once (Util::base_Path("include/miniXML/minixml.inc.php"));
    	
		//Abrimos el fichero
		$xml_obj = new MiniXMLDoc();

		//Procesamos el contenido
		$xml_obj->fromFile($str_fileName);

		//Cargamos la variable
		$xml_root 		=& $xml_obj->getElementByPath('config');
		$xml_elements 	=& $xml_root->getAllChildren();
    	
		for ($i=0; $i < $xml_root->numChildren(); $i++) {
			$_SESSION["CONTEXT"]["MIGUEL_".strtoupper($xml_elements[$i]->name())] = $xml_elements[$i]->getValue();
		}
    	
		//Cerramos el fichero
		unset($xml_obj);
	}
}

?>
