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
 * @subpackage view
 */
/**
 *
 */
 
 /**
 * Define la clase encargada de registrar todas las aplicaciones disponibles
 * en la aplicación miguel.
 * Se definen los elementos básicos de el control de herramientas para miguel.
 * Permite tener una configuración base común, y la intercomunicación entre
 * módulos/herramientas.
 *
 * La idea, como otras, ha sido tomada del framework Horde
 *       http://www.horde.org/horde/
 * Esta clase es una adaptación de Registry.class del proyecto Horde.
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
     * Hash storing all of the known services and callbacks.
     *
     * @var array $_apiCache
     */
    var $_apiCache = array();

    /**
     * Hash storing all of the registered interfaces that applications
     * provide.
     *
     * @var array $_interfaces
     */
    var $_interfaces = array();

    /**
     * Hash storing information on each registry-aware application.
     *
     * @var array $applications
     */
    var $modules = array();

    /**
     * Stack of in-use applications.
     *
     * @var array $_appStack
     */
    var $_appStack = array();

    /**
     * Quick pointer to the current application.
     *
     * @var $_currentApp
     */
    var $_currentApp = null;

    /**
     * Cache of $prefs objects
     *
     * @var array $_prefsCache
     */
    var $_prefsCache = array();

    /**
     * Cache of application configurations.
     *
     * @var array $_confCache
     */
    var $_confCache = array();
    
    /**
     * Checks if application is active
     *
     * @var array $_confCache
     */
    var $_app_active = true;

    /**
     * Devuelve una referencia al objeto global Registry, y crea el
     * objeto solo si no existe previamente.
     *
     * El método se invoca: $registry = &Registry::start()
     *
     * @param optional integer $session_flags  Parámetros de sesión.
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
     * Nunca debe ser llamado. se usa el método anterior
     *
     * @param optional integer $session_flags  Paráetros de sesión
     *
     * @access private
     */
    function Registry($session_flags = 0)
    {
        /* Read the registry configuration file. */
        include_once(Util::app_Path('common/include/registry.inc.php'));

        /* Initialize the localization routines and variables. */
        include_once(Util::base_Path('include/classes/nls.class.php'));
        NLS::setLang();
        NLS::setTextdomain('miguel', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
        Session::setValue('gettext', 'miguel');

        /* Stop system if miguel is inactive. */
        if ($this->modules['main']['status'] == 'inactive') {
            $this->_app_active = false;
        }


        /* Scan for all APIs provided by each app, and set other
           common defaults like templates and graphics. */
        foreach (array_keys($this->services) as $appName) {
            $app = &$this->services[$appName];

            if ($this->modules[$app['module']]['status'] == 'inactive') {
                continue;
            }
            
            $this->_interfaces[$appName] = $app;
        }
        //include_once(Util::base_Path('include/classes/debug.class.php'));
        //Debug::oneVar($this, __FILE__, __LINE__);
    }

    /**
     * Informa de los módulos instalados.
     *
     * @access public
     *
     * @param optional array $status  Array con estados a informar.
     *                                
     * @param optional bool $assoc    Associative array with app names as keys.
     *
     * @return array  Lista de módulos, o un array nulo
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
                    /* If assoc array requested set app as key. */
                    $apps[$app] = $app;
                } else {
                    /* Otherwise push into simple array. */
                    $apps[] = $app;
                }
            }
        }

        return $apps;
    }
    
    /**
     * Informa de los módulos instalados.
     *
     * @access public
     *
     * @param optional array $status  Array con estados a informar.
     *                                
     * @param optional bool $assoc    Associative array with app names as keys.
     *
     * @return array  Lista de módulos, o un array nulo
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
     * Set the current application, adding it to the top of the Horde
     * application stack. If this is the first application to be
     * pushed, retrieve session information as well.
     *
     *
     * @access public
     *
     * @param string  $app         The name of the application to push
     *
     * @return boolean  Whether or not the _appStack was modified.
     *                  Return PEAR_Error on error.
     */
    function pushApp($app)
    {
        if ($app == $this->_currentApp) {
            return true;
        }

        /* Bail out if application is not present or inactive. */
        if (!isset($this->modules[$app]) || $this->modules[$app]['status'] == 'inactive' ) {
            return false;
        }

		/* Initialize I18N/L10N */
		include_once(Util::base_Path('include/classes/nls.class.php'));
	    NLS::setLang();
        NLS::setTextdomain($this->modules[$app]['gettext'], Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());

        /* Once we're sure this is all successful, push the new app
         * onto the app stack. */
        array_push($this->_appStack, $app);
        $this->_currentApp = $app;

        return true;
    }

    /**
     * Remove the current app from the application stack, setting the
     * current app to whichever app was current before this one took
     * over.
     *
     * @access public
     *
     * @return string  The name of the application that was popped.
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
     * Return the current application - the app at the top of the
     * application stack.
     *
     * @access public
     *
     * @return string The current application.
     */
    function gettextDomain()
    {
        return $this->modules[$this->_currentApp]['gettext'];
    }

    /**
     * Return the current application - the app at the top of the
     * application stack.
     *
     * @access public
     *
     * @return string The current application.
     */
    function getApp()
    {
        return $this->_currentApp;
    }
    
    /**
     * Informa de los módulos instalados.
     *
     * @access public
     *
     * @param optional array $status  Array con estados a informar.
     *                                
     * @param optional bool $assoc    Associative array with app names as keys.
     *
     * @return array  Lista de módulos, o un array nulo
     *                
     */
    function listThemes()
    {
        include_once(Util::base_Path("include/classes/theme.class.php"));

        return Theme::getActiveThemes();
    }
}
?>
