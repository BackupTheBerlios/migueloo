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
 * Todo el patr�n MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage control
 */

 /**
 * Define la clase encargada de registrar todas los m�dulos disponibles
 * en la aplicaci�n.
 * Se definen los elementos b�sicos del control de herramientas.
 * Permite tener una configuraci�n base com�n, y la intercomunicaci�n entre
 * m�dulos/herramientas.
 *
 * La idea, como otras, ha sido tomada del framework Horde
 *       http://www.horde.org/horde/
 * Esta clase es una reimplementaci�n/adaptaci�n de Registry.class del proyecto Horde.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage control
 * @version 1.0.0
 *
 */

class Registry
{
	/**
     * Tabla (hash) en la que se guardan los servicios definidos.
     *
     * @internal
     */
    var $services = array();

    /**
     * Tabla (hash) en la que se guardan los interfaces definidos.
     *
     * @internal
     */
    var $interfaces = array();

    /**
     * Tabla (hash) en la que se guardan los modulos definidos.
     *
     * @internal
     */
    var $modules = array();

    /**
     * Pila de los m�dulos en uso.
     *
     * @internal
     */
    var $_appStack = array();

    /**
     * Puntero al m�dulo en activo.
     *
     * @internal
     */
    var $_currentApp = null;

    /**
     * Indicador de si el m�dulo est� activo
     *
     * @var array $_confCache
     */
    var $_app_active = true;

    /**
     * Devuelve una referencia al objeto global Registry, y crea el
     * objeto solo si no existe previamente.
     *
     * El m�todo se invoca: $registry = &Registry::start()
     *
     * @param optional integer $session_flags  Par�metros de sesi�n.
     *
     * @return object Registry  Instancia del objeto Registry
     */
    function &start($session_flags = 0)
    {
        static $registry;

        if (!isset($registry)) {
            $registry = new Registry($session_flags);
        }

        return $registry;
    }

    /**
     * Constructor.
     * Nunca debe ser llamado. Debe usarse el m�todo anterior: &start()
     *
     * @param optional integer $session_flags  Par�etros de sesi�n
     *
     * @access private
     */
    function Registry($session_flags = 0)
    {
        //Inicia el contexto de la clase
		$this->_initContext();

        //Prepara el sistema de localizaci�n/internacionalizaci�n
        include_once(Util::base_Path('include/classes/nls.class.php'));
        NLS::setLang();
        NLS::setTextdomain('miguel', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
        Session::setValue('gettext', 'miguel');

        if ($this->modules['main']['status'] == 'inactive') {
            $this->_app_active = false;
        }

        foreach (array_keys($this->services) as $appName) {
            $app = &$this->services[$appName];

            if ($this->modules[$app['module']]['status'] == 'inactive') {
                continue;
            }

            $this->_interfaces[$appName] = $app;
        }
    }

    /**
     * Informa de los m�dulos instalados.
     *
     * @param optional array $filter  Array con estados a informar.
     *
     * @param optional bool $assoc    Determina la forma del array retornado: Si true es un array asociativo, si no, array normal.
     *
     * @return array  Lista de m�dulos, o un array nulo
	 *
	 * @access public
     *                
     */
    function listModules($filter = null, $assoc = false)
    {
        $apps = array();
        if (is_null($filter)) {
            $filter = array('active');
        }

        foreach ($this->modules as $app => $params) {
            if (in_array($params['status'], $filter)) {
                if ($assoc) {
                    $apps[$app] = $app;
                } else {
                    $apps[] = $app;
                }
            }
        }

        return $apps;
    }

    /**
     * Informa de los servicios instalados.
     *
     * @access public
     *
     * @param optional array $filter  Array con estados a informar.
     *
     * @return array  Lista de servicios, o un array nulo
     *
     */
    function listServices($filter = null)
    {
        $apps_top = array();
        $apps_mid = array();
        $apps_bottom = array();

        if (is_null($filter)) {
            $filter = array('toolbar');
        }

        foreach ($this->_interfaces as $app => $params) {
            if (in_array($params['menu'], $filter)) {
            	switch ($params['place']) {
            		case 'top':
                		$apps_top[] = array($params['name'], $params['page'], $params['param'],
            					$params['icon'], $params['help']);
                		break;
                	case 'middle':
                		$apps_mid[] = array($params['name'], $params['page'], $params['param'],
            					$params['icon'], $params['help']);
                		break;
                	case 'bottom':
                		$apps_bot[] = array($params['name'], $params['page'], $params['param'],
            					$params['icon'], $params['help']);
                		break;
               		default:     //To middle
                		$apps_mid[] = array($params['name'], $params['page'], $params['param'],
            					$params['icon'], $params['help']);
        		}
            }

            $apps = array_merge($apps_top, $apps_mid, $apps_bot);
        }

        return $apps;
    }

    /**
     * Prepara el m�dulo, lo a�ade a la pila como m�dulo activo (cabeza de pila)
     * Prepara la internacionalizaci�n/localizaci�n del m�dulo.
     *
     * @param string  $app Nombre del m�dulo
     *
     * @return boolean  Devuelve true si el m�dulo est� activo, si no, false.
	 *
	 * @access public
     */
    function pushApp($app)
    {
        if ($app == $this->_currentApp) {
            return true;
        }

        if (!isset($this->modules[$app]) || $this->modules[$app]['status'] == 'inactive' ) {
            return false;
        }

		/* Inicializa I18N/L10N */
		include_once(Util::base_Path('include/classes/nls.class.php'));
	    NLS::setLang();
        NLS::setTextdomain($this->modules[$app]['gettext'], Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());

        array_push($this->_appStack, $app);
        $this->_currentApp = $app;

        return true;
    }

    /**
     * Elimina de la pila el m�dulo, restaurando el siguiente m�dulo en la pila.
     *
     * @return string  The name of the application that was popped.
	 *
     * @access public
     */
    function popApp()
    {
        /* Pop the current application off of the stack. */
        if(count($this->_appStack) > 1){
            $previous = array_pop($this->_appStack);
            
            /* Import the new active application's configuration values
               and set the gettext domain and the preferred language. */
            $this->_currentApp = count($this->_appStack) ?  end($this->_appStack) : null;
            if ($this->_currentApp) {
               NLS::setLang();
        	   NLS::setTextdomain($this->modules[$this->_currentApp]['gettext'], Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
            }
        }
    }
    
    /**
     * Comprueba si un m�dulo de los controlados, tiene un m�todo.
     *
     * @param string  $str_module Nombre del m�dulo
	 * @param string  $str_method Nombre del m�todo
	 *
     * @return boolean
	 *
     * @access public
     */
    function hasModuleMethod($str_module, $str_method)
    {
        return $this->hasInterface($str_module.'::'.$str_method);
    }
    
    /**
     * Comprueba si un interfaz est� definido en la aplicaci�n.
     *
	 * @param string  $str_interface Nombre del interfaz.
     *
     * @return boolean.
	 *
	 * @access public.
     */
    function hasInterface($str_interface)
    {
        return !empty($this->interfaces[$str_interface]);
    }

    /**
     * LLama a un interface de un m�dulo activo en la aplicaci�n.
	 *
	 * @param string  $str_interface Nombre del interfaz.
	 * @param array optional  $arr_args Argumentos para la llamada.
     *
     * @return string The current application.
	 *
     * @access public.
     */
    function callInterface($str_interface, $arr_args = array())
    {
        $ret_val = false;

        if($this->hasInterface($str_interface, true)){
			list($module, $method) = explode('::', $str_interface);

			//Validamos que el metodo realmente existe
			$class_name = 'miguel_'.$this->interfaces[$str_interface]['interface'].'.class.php';
			$method_name = $this->interfaces[$str_interface]['method'];
			$file_name = $this->interfaces[$str_interface]['module'].'/model/classes/'.$class_name;
			//Fichero de definicion incluido
			if(file_exists(Util::app_Path($file_name))) {
				include_once($file_name);
				$obj_data = new $class_name();

				//Metodo existe en clase
				if(method_exist($obj_data, $method)){
                    $ret_val = call_user_func_array(array(&$obj_data, $method_name), $arr_args);
				} else {
                    $this->_setError('Method not found in class.', ERROR);
				}

			} else {
				$this->_setError('Class file not found.', ERROR);
			}


        } else {
            $this->_setError('Interface not defined: '.$str_interface, ERROR);
        }

        return $ret_val;
    }

	/**
     * Devuelve el dominio gettext actual
     *
     * @return string Dominio gettext
	 *
     * @access public
     */
    function gettextDomain()
    {
        return $this->modules[$this->_currentApp]['gettext'];
    }

    /**
     * Devuelve el perfil de acceso del m�dulo activo
	 *
	 * @param string $str_service Nombre del servicio
     *
     * @return string Perfil.
	 *
     * @access public
     */
    function getProfileService($str_service)
    {
        return $this->services[$str_service]['profile'];
    }

    /**
     * Devuelve el nombre dl m�dulo activo
     *
     * @return string M�dulo activo
	 *
     * @access public
     */
    function getApp()
    {
        return $this->_currentApp;
    }

    /**
     * Informa de los temas instalados.
     *
     * @return array  Lista de temas.
	 *
     * @access public
     *
     */
    function listThemes()
    {
        include_once(Util::base_Path("include/classes/theme.class.php"));

        return Theme::getActiveThemes();
    }

	/*
	 * Carga el fichero de configuraci�n
	 * @internal
	 *
	 */
	function _initContext()
	{
		if(file_exists(Util::app_Path('common/include/registry.xml'))) {
			$this->_processXMLInitData(Util::app_Path('common/include/registry.xml'));
		} else {
		  $this->_setError('Registry file not found.', FATAL);
		}
	}

	/*
	 * Procesa el fichero de configuraci�n
	 * El fichero de configuraci�n est� en formato XML.
	 * @param string $str_fileName Nombre del fichero de configuraci�n
	 *
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
		$xml_root 		=& $xml_obj->getElementByPath('registry');
		$num_elem 		=  $xml_root->numChildren();
		$root_elements 	=& $xml_root->getAllChildren();

		for($i=0; $i < $num_elem; $i++){
		    //Datos del modulo		
			$data			=& $root_elements[$i]->getElementByPath('data');
            $module			=& $data->getElementByPath('name');
			$data_elements 	=& $data->getAllChildren();

			for ($j=0; $j < $data->numChildren(); $j++) {
				$this->modules[$module->getValue()][$data_elements[$j]->name()] = $data_elements[$j]->getValue();

			}
			
			//Datos de los servicios
			$services           =& $root_elements[$i]->getElementByPath('services');
			$services_elements 	=& $services->getAllChildren();	

			for ($j=0; $j < $services->numChildren(); $j++) {
			     $service_element 	=& $services_elements[$j]->getAllChildren();
			     $service_name =& $services_elements[$j]->getElementByPath('name');
			
			     for ($k=0; $k < $services_elements[$j]->numChildren(); $k++) {
				    $this->services[$service_name->getValue()][$service_element[$k]->name()] = $service_element[$k]->getValue();
				 }
				 $this->services[$service_name->getValue()]['module'] = $module->getValue();
			}
			
			//Datos de los interfaces
			$functions           =& $root_elements[$i]->getElementByPath('functions');
			$functions_elements 	=& $functions->getAllChildren();	
			
			for ($j=0; $j < $functions->numChildren(); $j++) {
			     $function_element 	=& $functions_elements[$j]->getAllChildren();
			     $method      	=& $functions_elements[$j]->getElementByPath('method');
			     $inter_name = $module->getValue().'::'.$method->getValue();
			     
                 for ($k=0; $k < $functions_elements[$j]->numChildren(); $k++) {
				    $this->interfaces[$inter_name][$function_element[$k]->name()] = $function_element[$k]->getValue();
				 }
				 $this->interfaces[$inter_name]['module'] = $module->getValue();
			}
		}

		//Cerramos el xml
		unset($xml_obj);
	}
	
	/**
	 * Lanza un error al sistema de errores.
	 * @param string $msg_error Literal asociado al error.
	 * @param string $type_error Nivel de error.
	 *
	 * @todo Optimizaci�n general del sistema de errores.
	 *
	 * @internal
     *
	 */
	function _setError($str_error, $type_error)
	{
        trigger_error('Registry::'.$str_error, $type_error);
        return;
	}
}
?>
