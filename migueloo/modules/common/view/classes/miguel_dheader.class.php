<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004 miguel Development Team                     |
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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
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
 * Define la clase que construye la cabecera para las pantallas de miguel.
 *
 * Se definen dos barra de servicios dinámicas, y un área de mensajes.
 *
 * Utiliza la libreria phphtmllib.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package common
 * @subpackage view
 * @version 1.0.0
 *
 */ 
 
class miguel_DHeader
{
	var $str_message = '';
	/**
	 * Constructor.
	 * @param string $message Mensaje para presentar al usuario
	 */
    function miguel_DHeader($message)
    {
    	$this->str_message = $message;
    }

    /**
     * Define el formato de la cabecera
     * @access private
     */
    function getContent() 
    {
    	include_once(Util::base_Path('include/classes/nls.class.php'));
		NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		
		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,1);
        $table->set_class("mainInterfaceWidth");
        $table->set_id("header");
 		//Debug::oneVar($_SESSION, __FILE__, __LINE__);
		//Icono y bienvenida 
        if(Session::getValue("userinfo_user_alias") == null) {
        	$container = container(html_img(Theme::getThemeImagePath("logo.png"), 0, 0, 0, "miguel Home"), html_br(), "&nbsp;");
        } else {
            if (Session::getValue("userinfo_user_alias") != 'guest') {
        		$str_userName = Session::getValue('userinfo_treatment') . ' ' . Session::getValue("userinfo_name").' '.Session::getValue("userinfo_surname");
        	} else {
        		$str_userName = agt("Guest");
        	}
           	$container = container(html_img(Theme::getThemeImagePath("logo.png"), 0, 0, 0, "miguel Home"), html_br(), $str_userName);	//agt("LoggedAs")."&nbsp;".
        }
  
		$elem1 = html_td("colorMedium-bg", "",  $container);
        $elem1->set_id("cell-logo");
		$elem1->set_tag_attribute('align', 'left');
		
		$elem2 = html_td("colorMedium-bg", "", $this->_getServicesBar());
		
        $row = html_tr();
        $row->add($elem1);
        $row->add($elem2);
        
        $table->add_row($row);
		
		//Sistema de mensajes de la aplicación
        $row = html_tr();
		$row->set_tag_attribute('bgcolor', '#CECECE');
        //$row->set_class("color2-bg");
        //$row->set_id("cell-nav-links");

		//TODO Si mensaje vacio que ponga literal por defecto. Quitar 'Mensaje: '
		$msg = html_td("", "", html_b($this->str_message));
		$msg->set_tag_attribute('align', 'left');
        //$msg->set_tag_attribute("colspan","4");
        $msg->set_tag_attribute("colspan","3");
        $row->add($msg);
		/*
        if($this->str_help){
       		$help = html_td("", "", $this->help_img(Util::format_URLPath("lib/help/miguel_help.php","help=".$this->str_help), Theme::getThemeImagePath("help_mini.png"), ""));
 	       	$help->set_tag_attribute("align","center");
        } else {
        	$help = html_td("", "", '');
        }
        $row->add($help);
		*/
        $table->add_row($row);
        
        //Sistema de menues
        $row = html_tr();
        //$row->set_class("color2-bg");
        //$row->set_id("cell-nav-links");

		$menu = html_td("", "", $this->_menuBar());
		$menu->set_tag_attribute('bgcolor', '#CECECE');
		$menu->set_tag_attribute('align', 'left');
        //$menu->set_tag_attribute("colspan","3");
        $menu->set_tag_attribute("colspan","4");
        $row->add($menu);
		$table->add_row($row);
		    	
		return $table;
    }
	
	function _getServicesBar()
	{
		$registry = Registry::start();
		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,0);
		$table->set_tag_attribute('bgcolor', '#CECECE');
        $table->set_class("mainInterfaceWidth");
        $table->set_id("header");
		$row = html_tr();
		
		$arr_elem = $registry->listServices();
		//$arr_elem = $this->_getBarrElementsbyFile();

		$profile = Session::getValue("userinfo_profile_id");
		//Debug::oneVar($profile, __FILE__, __LINE__);

		foreach ($arr_elem as $app => $params) {
			if($registry->checkServiceAccess($params[0], $profile)){
            	if(strncmp($params[1], 'http://', 7) != 0) {
    		  		$row->add($this->_getBarElement(Util::format_URLPath($params[1], $params[2]),
														  $params[4]));
    		  	} else {
    		  		$row->add($this->_getBarElement($params[1], $params[4]));
    		  	}
    		}
        }
				
		$table->add_row($row);
		
		return $table;
	}

	function _getBarElement($url, $literal, $accesskey = '', $tabindex = 0)
	{
		$link = html_a($url, $literal);
  		//$link->set_tag_attribute('accesskey',$accesskey);
		//$link->set_tag_attribute('tabindex', $tabindex);	       
	    $elem = html_td("", "", $link);
		$elem = html_td("colorMedium-bg", "", $link);
        $elem->set_id("cell-sitename");
        $elem->set_tag_attribute("target","_blank");
		
		return $elem;
	}
	
	function _getShowElement($literal, $accesskey = '', $tabindex = 0)
	{
		//$link = html_a($url, $literal);
		$link = $literal;
  		//$link->set_tag_attribute('accesskey',$accesskey);
		//$link->set_tag_attribute('tabindex', $tabindex);	       
	    $elem = html_td("", "", $link);
			$elem = html_td("colorMedium-bg", "", $link);
        $elem->set_id("cell-sitename");
        $elem->set_tag_attribute("target","_blank");
		
		return $elem;
	}
	
	/**
     * Construye la barra de navegaciÃ›n
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
    	
    	$menu = Session::getValue('bar_array');
    	if (is_array($menu) && !empty($menu)) {
			$ret_val = container();
        	for($i=0; $i < count($menu) -1; $i++) {
        		$ret_val->add(html_a($menu[$i]["url"], $menu[$i]["name"], null, "_top"));
        		$ret_val->add(">");
        	}
        	$ret_val->add(html_a($menu[count($menu) - 1]["url"], $menu[count($menu) - 1]["name"], null, "_top"));
        }
        return $ret_val;

    }
}
?>
