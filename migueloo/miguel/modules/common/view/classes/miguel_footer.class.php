<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, miguel Development Team                          |
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
 * Define la clase que construye el pie para las pantallas de miguel.
 * Utiliza la libreria phphtmllib.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */ 
class miguel_Footer
{
	/**
	 * Constructor.
	 */
	function miguel_Footer() 
	{	
	}

	/**
	 * Define el formato del pie de página.
	 * @return HTMLtag object.
	 */
	function getContent() 
	{
    	$table = html_table(Session::getContextValue("mainInterfaceWidth"));
		
		$table->set_id("footer");
		$table->set_class("mainInterfaceWidth");
		
		if(Session::getContextValue("emailAdministrator") != '') {
			$table->add_row( html_td("", "", $this->_ShowMailURL(Session::getContextValue("emailAdministrator"), Session::getContextValue("administratorName"). ' ' .Session::getContextValue("administratorSurname"), agt("Manager").": ")));
		}
		
		//$table->add_row(html_td("", "center", $this->_tdBlock( agt("Develop"), "http://www.claroline.net", "Claroline")));
		$table->add_row(html_td("", "center", $this->_tdBlock( agt("Copyright"), "http://hidrogeno.unileon.es/miguel-web/", agt("DevelopTeam"))));
		$table->add_row(html_td("", "center", $this->_tdBlock( agt("Licence"), "http://www.gnu.org/copyleft/gpl.html", "GPL")));
		
		return $table;
	}
	
	/**
     * Se devuelve un enlace e-mail formateado: <Texto> <Enlace> <Salto de carro>
     * @access private
     */
    function _ShowMailURL($email, $name, $text = '')
	{
		if ( isset($email)  && ($email != '') ) {
			$a_ref = Util::format_URLPath("lib/messages/sendmail.php", "&sendTo=$email");
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
}
?>
