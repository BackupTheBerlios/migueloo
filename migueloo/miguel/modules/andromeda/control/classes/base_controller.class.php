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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |      
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
 * Define la clase controlador base de miguel.
 * Se definen los elementos básicos de un controlador para miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class base_Controller
{
	/**
	 * @access private
	 * @var string
	 */
	var $str_moduleName = '';
    /**
	 * @access private
	 * @var string
	 */
	var $str_viewClass = '';
	/**
	 * @access private
	 * @var string
	 */
	var $str_modelClass = '';
	/**
	 * @access private
	 * @var boolean
	 */
	var $bol_isCacheable = true;
	/**
	 * @access private
	 * @var boolean
	 */
	var $str_cacheFile = '';
	/**
	 * @access private
	 * @var boolean
	 */
	var $arr_menuElem = array();
	/**
	 * @access private
	 */
	var $str_pageTitle = '';
	/**
	 * @access private
	 */
	var $obj_data = null;
	/**
	 * @access private
	 */
	var $arr_commarea = null;
	/**
	 * @access private
	 */
	var $arr_form = null;
	/**
	 * @access private
	 */
	var $registry = null;
	

	/**
	 * Constructor.
	 * @param boolean $check Control de aplicación configurada. Por defecto, se controla (true).
	 */
	function base_Controller($bol_check = true)
	{	
	    //Preparamos la sesión
        $obj_session = &Session::start();

        //Obtenemos el registro de miguel
        $this->registry = &Registry::start();
        
        //dbg_var($this, __FILE__, __LINE__);

		if(MIGUELBASE_CACHEABLE){
			$this->bol_isCacheable = true;
		} else {
			$this->bol_isCacheable = false;
		}
		
		if(!$bol_check){
			//Si falla la lectura del fichero de configuración, por ahora, error.
			//dbg_boolean_echo("okConfFile", $this->context->okConfFile);
			//TODO: Optimizar con llamada a modulo de errores.
			
			//OJO:: Problema. Si el que falla es base_controller no se puede llamar a un 
			//controlador, se un bucle en la aplicación
			if(!$obj_session->bol_okConfFile){
				$this->setError("miguel no está configurado");
				/*
				$arr_menuElem[]= array ("url" => Util::app_URLPath("base/include/error/index.php"), "name" => "Error");
				include_once(Util::base_Path("view/classes/base_layoutpage.class.php"));
				include (Util::app_Path("base/include/error/classes/base_verror.class.php"));
				$obj_view = new base_VError("miguel Error page");
			
				Session::setValue("menubar", $arr_menuElem);
				Session::setValue("error","Miguel no está configurado.");
				$obj_view->initialize();
    		   	print $obj_view->render();
				
				$this->Close();
				*/
			}
		}
    }
    
	/**
	 * Arranca el controlador y ejecuta su funcionalidad
	 *
	 */
	function Exec()
	{
        //Recuperamos los parámetros recibidos
        if (!empty($_POST)) {
			$this->arr_form = $_POST;
		} else {
			if (!empty($_GET)) {
				$this->arr_form = $_GET;
			}
		}
		if(isset($this->arr_form)){
			foreach($this->arr_form as $key => $value){
				$this->setViewVariable($key, $value);
			}
		}

		//include_once(Util::base_Path('include/classes/debug.class.php'));
		//Debug::oneVar($this->arr_form, __FILE__, __LINE__);
		
        //Controlamos que el usuario esta logeado. Para evitar retornos desde el navegador
        //Debug::oneVar($this->getSessionElement('session'),__FILE__,__LINE__);
       	if (!$this->getSessionElement('session')){
		    $this->setModuleName('common');
            $this->setViewClass("miguel_VReload");
            $this->setSessionElement('bar_array', null);
            $this->setViewVariable('str_message', '');
            $this->setViewVariable('str_help', '');
            //Session::setValue('session', true);
		} else {
		    //Abrimos y Activamos acceso a BBDD
            if($this->str_modelClass != ''){
    	   	   if(file_exists(Util::app_Path($this->str_moduleName.'/model/classes/'.strtolower($this->str_modelClass).".class.php"))) {
    	   	   	   include (Util::app_Path($this->str_moduleName.'/model/classes/'.strtolower($this->str_modelClass).".class.php"));
                   $this->obj_data = new $this->str_modelClass();
		  	   }
          	   $this->obj_data->openModel();
            }
            //Procesamos lógica de negocio
            $this->processPetition();

   		   //Desactivamos y Cerramos acceso a Base de datos
   		   if($this->str_modelClass != ''){
                $this->obj_data->closeModel();
                unset($this->obj_data);
           }
        }
        
        //Damos de alta en el registro el módulo.
        $this->registry->pushApp($this->str_moduleName);
        //Debug::oneVar($this->registry,__FILE__,__LINE__);

    	//Preparamos el contenido de la pagina
    	if(file_exists($this->str_cacheFile) && (time() - filemtime($this->str_cacheFile) < MIGUELBASE_CACHE_TIME)) {
    	   $str_content = File::Read($this->str_cacheFile);
    	} else {
    	   $str_content = $this->_getViewContent();
    	
            if($this->bol_isCacheable) {    	
   		   	   File::Write($this->str_cacheFile, $str_content);
       	    }
       	}

       	//Visualizamos la pagina
    	print $str_content;
    	unset($str_content);
    }

    /**
	 * Cierra el controlador, borrando contenidos y liberando recursos
	 * 
	 */
	function Close(&$obj_model)
	{
		//Log de salida
		include_once(Util::app_Path("common/control/classes/miguel_userinfo.class.php"));
		$ok = miguel_UserInfo::setLogin($obj_model, $this->getSessionElement('userinfo', 'name'), false);
		
		//Cerramos modelo
		$obj_model->closeDDBB();
		
		//Damos de baja en el registro el módulo.
        $this->registry->popApp();
        
		//Cerrando la sesión, se cierra el contexto.
		Session::close();

		$this->arr_form = array();
    }
	
	/**
	 * Permite asignar una Vista al controlador.
	 * @param string $str_nameClass Nombre de la clase que define la vista
	 */
	function setViewClass($str_nameClass)
	{
    	if(file_exists(Util::app_Path($this->str_moduleName.'/view/classes/'.strtolower($str_nameClass).'.class.php'))) {
    		$this->str_viewClass = $str_nameClass;
    		
    		if($this->str_cacheFile == ''){
    	      $this->str_cacheFile = MIGUELBASE_CACHE_DIR.$str_nameClass.'.cch';
    	   }
    	}    	
    }
    
    /**
	 * Asigna el valor de una variable que se usará en la vista.
	 * @param string $str_name Nombre de la variable
	 * @param mixto $mix_value Valor de la variable
	 */
	function setViewVariable($str_name, $mix_value)
	{
    	if($str_name != ''){
    		$this->arr_commarea["$str_name"] = $mix_value;
    	}  
    	
    }
    
    /**
	 * Obtiene el valor de una variable que se definió en la vista.
	 * @param string $str_name Nombre de la variable
	 * @return mixto Valor de la variable, null si no existe
	 */
	function getViewVariable($str_name)
	{
    	$ret_val = null;
    	if (isset($this->arr_form["$str_name"]) ){
    		$ret_val = $this->arr_form["$str_name"];
    	}
    	
    	return $ret_val;
    }
    
    /**
	 * Comprueba la existencia de una variable en el retorno de la vista.
	 * @param string $str_name Nombre de la variable
	 * @return boolean Valor de la variable, null si no existe
	 */
	function issetViewVariable($str_name)
	{
    	$ret_val = false;
    	
    	if(isset($this->arr_form)){
    		if (isset($this->arr_form["$str_name"]) ){
    			$ret_val = true;
    		}
    	} 
    	
    	if(!$ret_val){
    		if(isset($this->arr_commarea)){
    			if (isset($this->arr_commarea["$str_name"]) ){
    				$ret_val = true;
    			}
    		}
    	}
    	
    	return $ret_val;
    }
    
    /**
	 * Permite asignar una Vista al controlador.
	 * @param string $str_newClass Nombre de la clase que define el modelo
	 */
	function setModelClass($str_nameClass)
	{
	   if($str_nameClass != ''){
    	   if(file_exists(Util::app_Path($this->str_moduleName.'/model/classes/'.strtolower($str_nameClass).'.class.php'))) {
    		  $this->str_modelClass = $str_nameClass;
    	   }
	   } else {
	       $this->str_modelClass = $str_nameClass;
	   }
    }
    
    /**
	 * Permite activar o desactivar el sistema de cache.
	 * @param boolean $bol_cache Para activar true, para desactivar false
	 */
	function setCacheFlag($bol_cache)
	{
    	if(MIGUELBASE_CACHEABLE){
			$this->bol_isCacheable = $bol_cache;
		} 
    }
    
    /**
	 * Permite asignar un título a la página
	 * @param boolean $str_title Título
	 */
	function setPageTitle($str_title)
	{
    	if($str_title == ''){
    	   $str_title = 'MiguelOO default title page';
    	}
        $this->str_pageTitle = $str_title;
    }
    
    /**
	 * Asigna el nombre del módulo al que pertenece el controlador
	 * @param string $str_name Nombre del módulo en el que se engloba el controlador.
	 */
	function setModuleName($str_name)
	{
    	if($str_name != ''){
    	   $this->str_moduleName = $str_name;
    	}
    }
    
    /**
	 * Permite asignar el nombre del fichero de cache..
	 * @param string $str_cacheName Nombre, sin extensiones ni path, del fichero.
	 */
	function setCacheFile($str_cacheName)
	{
    	if($str_cacheName == '') {
    		$this->str_cacheFile = MIGUELBASE_CACHE_DIR.$this->str_viewClass.'.cch';
    	} else {
    		$this->str_cacheFile = MIGUELBASE_CACHE_DIR.$str_cacheName.'.cch';
    	}
    }
    
    /**
	 * Permite asignar un nuevo elemento a la barra de navegación
	 * @param string $str_url URL destino
	 * @param string $str_text Literal asociado
	 */
	function addNavElement($str_url, $str_text)
	{
    	$int_desp = -1;
    	$arr_bar = $this->getSessionElement('bar_array');
    	
    	for($i = 0;$i < count($arr_bar); $i++) {
    		if($arr_bar[$i]['url'] == $str_url) {
    			$int_desp = $i;
    		}
	    }
	
        if ($int_desp != -1) {
	    	$arr_bar = array_slice($arr_bar, 0, $int_desp);
	    } else {
			$this->clearNavBarr();
		}

	    $arr_bar[] = array ("url" => $str_url, "name" => $str_text);
	    $this->setSessionElement('bar_array', $arr_bar);
    }
    
    /**
	 * Permite limpiar la barra de navegación.
	 *
	 * Se eliminan todos los elementos.
	 * 
	 */
	function clearNavBarr()
	{
	    $this->setSessionElement('bar_array', array());
    }

    /**
	 * Asigna el texto a mostrar en la barra de avisos
	 * @param string $str_value Texto.
	 */
	function setMessage($str_value)
	{
        if(is_string($str_value)) {
            $this->setViewVariable('str_message', $str_value);
        } else {
            $this->setViewVariable('str_message', '');
        }
    }
    
    /**
	 * Asigna el texto a mostrar en la barra de avisos
	 * @param string $str_value Texto.
	 */
	function setHelp($str_value)
	{
        if(is_string($str_value)) {
            $this->setViewVariable('str_help', $str_value);
        } else {
            $this->setViewVariable('str_help', '');
        }
    }
    
    /**
	 * Permite asignar un nuevo elemento (variable) a los datos de sesión
	 * @param string $str_name Nombre del elemento (variable)
	 * @param mixto $mix_value Valor asociado
	 */
	function setSessionElement($str_name, $mix_value)
	{
    	Session::setValue("$str_name", $mix_value);
    }
    
    /**
	 * Permite asignar un nuevo elemento (variable) a los datos de sesión partiendo de un array.
	 * Genera elementos de sesión, uno por cada elemento del array.
	 * @param string $str_name Nombre del elemento (variable)
	 * @param array $arr_value Valor asociado en un array
	 */
	function setSessionArray($str_name, $arr_value)
	{
        if(is_string($str_name)) {
            if(is_array($arr_value)) {
                foreach($arr_value as $key => $val) {
		  		  Session::setValue($str_name.'_'.$key, $val);
		  	    }
	       }
        }
    }
    
    /**
	 * Permite recuperar un elemento (variable) de los datos de sesión
	 * @param string $str_name Nombre del elemento (variable)
	 * @return mixto Valor asociado
	 */
	function getSessionElement($str_name, $str_key = '')
	{
    	$ret_val = null;
    	if($str_name != ''){
    	   if($str_key != ''){
             $ret_val = Session::getValue("$str_name".'_'.$str_key);
           } else {
             $ret_val = Session::getValue("$str_name");
           }
        }
        
        return $ret_val;
    }
    
    /**
	 * Contiene la funcionalidad de control sobre el usuario.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_username Identificador de usuario
	 * @param string $str_userpswd Clave de acceso a validar.
	 * @return boolean TRUE si tiene acceso, FALSE si no.
	 */
    function processUser(&$obj_model, $str_username, $str_userpswd)
    {
    	$ret_val = false;
    	
        if (isset($str_username) && $str_username != ''){
			if (isset($str_userpswd) && $str_userpswd != ''){
			    include_once(Util::app_Path("common/control/classes/miguel_userinfo.class.php"));
				if(miguel_UserInfo::hasAccess($obj_model, $str_username,  $str_userpswd)) {
				    if($this->getSessionElement('userinfo', 'name') == $str_username) {   
				       //Control sobre re-login
				       $ret_val = true;
	               } else {
					   $arr_userinfo = miguel_UserInfo::getInfo($obj_model, $str_username);
					   //Debug::oneVar($obj_model, __FILE__, __LINE__);
					   $arr_userinfo['isadmin'] = miguel_UserInfo::isAdmin($obj_model, $str_username);
					   $this->setSessionArray('userinfo', $arr_userinfo);
					   					
					   $ok = miguel_UserInfo::setLogin($obj_model, $str_username);

					   $ret_val = true;
                    }
				} 
			} 
		} 
		
		return($ret_val);
	}
    
    /**
	 * Contiene la funcionalidad del controlador.
	 * Se debe sobreescribir por las clases que heredan de esta.
	 */
    function processPetition()
    {
    	$arr_menuElem[]= array ("url" => app_URLPath("index.php"), "name" => Session::getValue("siteName"));
    }

    /**
	 * Obtiene el contenido de la Vista ya procesado.
	 * @internal
	 */
    function _getViewContent()
    {	
    	$ret_val = '';
    	
        include_once(Util::base_Path("view/classes/base_layoutpage.class.php"));
        if(file_exists(Util::app_Path($this->str_moduleName.'/view/classes/'.strtolower($this->str_viewClass).".class.php"))) {
    		include (Util::app_Path($this->str_moduleName.'/view/classes/'.strtolower($this->str_viewClass).".class.php"));
			$obj_view = new $this->str_viewClass($this->str_pageTitle, $this->arr_commarea);
		}

		if (isset($obj_view)) {
			$obj_view->initialize();
    		$ret_val = $obj_view->render();
    		unset($obj_view);
    	}
        return $ret_val;
    }
    
    /**
	 * Escribe un mensaje en el log
	 * @param string $message Mensaje a guardar en el Log
     * @param string $priority Nivel de log
	 */
    function log($message, $priority)
    {	
    	include_once(Util::base_Path("include/classes/loghandler.class.php"));
  		LogHandler::log($message, $this->str_moduleName.'_controller', $priority);
    }
    
    /**
	 * Presenta en pantalla el error detectado
	 * @param string $msg_error Literal asociado al error
	 * @param string $msg_url URL para el retorno
	 */
    function setError($msg_error, $msg_url = '')
    {
    	include_once (Util::app_Path("base/include/error/control/classes/base_cerror.class.php"));
		
		$miguel_error = new base_CError($msg_error, $msg_url);
		$miguel_error->Exec();
		die();
    }
}
?>
