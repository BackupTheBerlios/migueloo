<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This program is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU General Public License        |
      |   as published by the Free Software Foundation; either version 2     |
      |   of the License, or (at your option) any later version.             |
      |                                                                      |
      |   This program is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
      |   GNU General Public License for more details.                       |
      |                                                                      |
      |   You should have received a copy of the GNU General Public License  |
      |   along with this program; if not, write to the Free Software        |
      |   Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA          |
      |   02111-1307, USA. The GNU GPL license is also available through     |
      |   the world-wide-web at http://www.gnu.org/copyleft/gpl.html         |
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
include_once(Util::base_Path("view/includes.inc.php"));

/**
 * Define la clase base para las pantallas de miguel.
 *
 * Se define una plantilla común para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentará la información
 *  + Bloque de pie en la parte inferior
 * <pre>
 * --------------------------------
 * |         header block         |
 * --------------------------------	
 * |                              |	
 * |         data block           |
 * |                              |
 * --------------------------------	
 * |         footer block         |
 * --------------------------------
 * </pre>
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */ 

class base_LayoutPage extends PageWidget 
{
	/**
	 * @access private
	 * @var string
	 */
	var $str_renderType = HTML;
	/**
	 * @access private
	 */
	var $arr_commarea = null;
	/**
	 * @access private
	 */
	var $registry = null;
	
	/**
	 * Constructor.
	 * @param string $str_title Título de la página
	 * @param array $arr_commarea Variables necesarias para la visualización de la vista
	 * 
	 */
    function base_LayoutPage($str_title, $arr_commarea)
    {   
        $this->arr_commarea = $arr_commarea;
        
        //Obtenemos el registro de miguel
        $this->registry = &Registry::start();
        
        //Superclass initialization
        $this->PageWidget(agt($str_title), $this->str_renderType );
    }
    
    function initialize()
    {
		return null;
    }

	/**
	 * Define la estructura global de la página
	 *
	 */
	function body_content() 
	{		
		return null;     
	}
    
    /**
	 * Permite añadir un formulario en la página
	 * @param string $str_moduleName Nombre del módulo al que pertenece
	 * @param string $str_className Nombre de la clase Formulario
	 * @return object FormProcessor
	 */
	function addForm($str_moduleName, $str_className)
	{
    	$ret_val = container();
    	
    	$file_name = Util::app_Path($str_moduleName.'/view/classes/'.strtolower($str_className).".class.php");
        
    	if(file_exists($file_name)) {
    		include($file_name);
        	$ret_val = new FormProcessor(new $str_className($this->arr_commarea), strtolower($str_className), Util::format_URLPath(trim(str_replace( '/'.MIGUELBASE_MODULES_BASE, ' ', $_SERVER['PHP_SELF']))));
		}
    	
        return $ret_val;
    }
    
    /**
     * Lee el contenido de un fichero
     * @access private
     */
    function _addFileContent($filename)
    {
    	return File::Read($filename);
    }
    
    /**
     * Construye una imagen con referencia
     * @access private
     */
    function imag_ref($path_action, $path_img, $text, $width = 0, $height = 0, $border = 0)
    {
    	$table = html_table("100%",0,1,0,"left");
    	$row = html_tr();
    	$row->set_tag_attribute("align","center");
    	$col = html_td("","left");
    	$col->set_tag_attribute("width","20%");
    	$elem = html_a($path_action,"");
        $elem->add(html_img($path_img, $width, $height, $border));
        $col->add($elem);
        $row->add($col);
        $col = html_td("","left");
    	$col->set_tag_attribute("width","80%");
        $col->add(html_a($path_action,$text));
        $row->add($col);
        $table->add($row);
        
        return $table;
    }
    
    /**
     * Construye una imagen con referencia
     * @access private
     */
    function icon_link($path_action, $path_img, $text)
    {
    	$container = new container();
    	
    	$elem = html_a($path_action,"");
        $elem->add(html_img($path_img, $width, $height, $border));
        
        $container->add($elem);
        $container->add(html_a($path_action,$text));
		        
        return $container;
    }
    
    /**
     * Construye una imagen con referencia
     * @access private
     */
    function help_img($path_action, $path_img, $text)
    {
    	$table = html_table("100%",0,1,0);
    	$row = html_tr();
    	
    	if($text == ''){
    		$col = html_td("","center");
    		$elem = html_a("#","");
        	$elem->add(html_img($path_img, 0, 0, 0, ""));
        	$elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=500,height=600,left=300,top=40'); return false;");
        	$col->add($elem);
        	$row->add($col);
    	} else {
    		$table->set_tag_attribute("align","left");
	    	$row->set_tag_attribute("align","left");
    		$col = html_td("","left");
    		$col->set_tag_attribute("width","20%");
    		$elem = html_a("#","");
        	$elem->add(html_img($path_img, 0, 0, 0, ""));
        	$elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=400,height=500,left=300,top=10'); return false;");
        	$col->add($elem);
        	$row->add($col);
        	
        	$col = html_td("","left");
    		$col->set_tag_attribute("width","80%");
    		$elem = html_a("#",$text);
    		$elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=400,height=500,left=300,top=10'); return false;");
        	$col->add($elem);
        	$row->add($col);
        	
        }
        $table->add($row);
        
        return $table;
    }
    
    /**
     * Construye una imagen con referencia
     * @access private
     */
    function imag_alone($path_action, $path_img, $text, $width = 0, $height = 0, $border = 0)
    {
    	$elem = html_a($path_action,"",null,null,$text);
        $elem->add(html_img($path_img, $width, $height, $border, $text));
        
        return $elem;
    }
    
	/**
     * Se devuelve un enlace e-mail formateado: <Texto> <Enlace> <Salto de carro>
     * @access private
     */
    function _ShowMailURL($email, $name, $text = '')
	{
		if ( isset($email)  && ($email != '') ) {
			$a_ref = Util::format_URLPath("lib/app/messages/sendmail.php", "&sendTo=$email");
			$a_text = $name;
         } else {
         	$a_ref = "mailto:$email";
			$a_text = $name;
        }
        
        return $this->_tdBlock($text, $a_ref, $a_text);
	}
	
	/**
     *Se devuelve un enlace web formateado: <Texto> <Enlace> <Salto de carro>
     * @access private
     */
    function _tdBlock($text, $a_ref, $a_text, $br_num = 1) 
    {
    	$container = container( $text, html_a($a_ref, $a_text), html_br($br_num));
		return $container;
    } 
    
    /**
     * Construye la barra de navegación
     * @access private
     */
    function _menuBar()
    {
    	$ret_val = '';
    	
    	/*
        $menu[]= array ("url" => Util::format_URLPath("lib/index.php"), "name" => Session::getContextValue("siteName"));
    	//$menu = array_merge ($menu, $this->getViewVariable("menubar"));
    	$menu = array_merge ($menu, $this->getSessionElement('bar_array'));
    	*/
    	
    	$menu = $this->getSessionElement('bar_array');
    	if (is_array($menu)) {
			$ret_val = container();
        	for($i=0; $i < count($menu) -1; $i++) {
        		$ret_val->add(html_a($menu[$i]["url"], $menu[$i]["name"], null, "_top"));
        		$ret_val->add(">");
        	}
        	$ret_val->add(html_a($menu[count($menu) - 1]["url"], $menu[count($menu) - 1]["name"], null, "_top"));
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
    	
    	if(isset($this->arr_commarea)){
    		if (isset($this->arr_commarea["$str_name"]) ){
    			$ret_val = true;
    		}
    	}
    	    	
    	return $ret_val;
    }
    
    /**
	 * Recupera el valor de una variable que se usará en la vista.
	 * @param string $str_name Nombre de la variable
	 * @return mixto Valor de la variable
	 */
	function getViewVariable($str_name)
	{
    	if($str_name != ''){
    		return $this->arr_commarea["$str_name"];
    	} else {
    		return null;
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
     * Permite comprobar el "permiso" en el sistema
   	 * @param string $str_name Nombre servicio
   	 * @param string $str_profile Perfil solicitante
   	 * @return boolean
   	 */
	function checkAccess($str_name, $str_profile)
   	{
        return $this->registry->checkServiceAccess($str_name, $str_profile);
	}

	/**
     * Permite comprobar el "permiso" en el sistema usando gacl
   	 * @param string $str_name Nombre del elemento (variable)
   	 * @param string $str_name Nombre del elemento (variable)
   	 * @param string $str_name Nombre del elemento (variable)
   	 * @param string $str_name Nombre del elemento (variable)
   	 * @return boolean
	 *
	 * @since Despalzada implementación hasta versiones posteriores
   	 */
	/*
   	function checkAccess($str_aco_sys, $str_aco_elem, $str_aro_sys, $str_aro_elem)
   	{
        //Debug::oneVar($str_aco_sys,__FILE__, __LINE__);
        //Debug::oneVar($str_aco_elem,__FILE__, __LINE__);
        //Debug::oneVar($str_aro_sys,__FILE__, __LINE__);
        //Debug::oneVar($str_aro_elem,__FILE__, __LINE__);
        //Incluimos el API de phpgacl
        //define('ADODB_DIR', MIGUELBASE_ADODB);
   	    include_once(Util::base_Path("include/gacl/gacl.class.php"));

        //Probar el sistema de cache: ¿para qué? ADOdb cacheado ya.
   	    $arr_gacl_options = array(
								'debug' => FALSE,
								'items_per_page' => 100,
								'max_select_box_items' => 100,
								'max_search_return_items' => 200,
								'db_type' => Session::getContextValue('ddbbSgbd'),
								'db_host' => Session::getContextValue('ddbbServer'),
								'db_user' => Session::getContextValue('ddbbUser'),
								'db_password' => Session::getContextValue('ddbbPassword'),
								'db_name' => Session::getContextValue('ddbbMainDb'),
								'db_table_prefix' => 'gacl_',
								'caching' => FALSE,
								'force_cache_expire' => TRUE,
								'cache_dir' => MIGUELBASE_CACHE_DIR,
								'cache_expire_time' => MIGUELBASE_CACHE_TIME
							);

   	    $obj_gacl = new gacl($arr_gacl_options);

   	    return $obj_gacl->acl_check($str_aco_sys, $str_aco_elem, $str_aro_sys, $str_aro_elem);
   	}
	*/
}
?>
