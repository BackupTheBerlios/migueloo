<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
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
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla común para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentará la información
 *  + Bloque de pie en la parte inferior
 *
 * --------------------------------
 * |         header block         |
 * --------------------------------	
 * |                              |	
 * |         data block           |
 * |                              |
 * --------------------------------	
 * |         footer block         |
 * --------------------------------
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */ 

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vpage.class.php"));
include_once (Util::app_Path("common/view/classes/miguel_navform.class.php"));

class miguel_VReload extends miguel_VPage
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El título para la página
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesión).
     *
	 */
    function miguel_VReload($title, $arr_commarea)
    {
        $this->miguel_VPage($title, $arr_commarea);
     }



    /**
     * We override this method to automatically
     * break up the main block into a 
     * left block and a right block
     *
     * @param TABLEtag object.
     */
    function main_block() 
    {
    	$main = html_div();
		$main->set_id("content");

		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,1,0);
		$table->set_class("simple");
		
		//Authentication
		$table->add_row($this->_block());
        
        $main->add( $table );

		return $main;
    }
    
    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */
    function _block() 
    {
		$ret_val = container();
		
		$ret_val->add(html_h4('Sesión no activa'));
		$ret_val->add(html_p('Para continuar trabajando en este Campus Virtual debe regresar a la página de inicio y acceder de nuevo'));
		//$ret_val->add(html_a(Util::app_URLPath("index.php"), Session::getContextValue("siteName"), null, "_top"));
		//$ret_val->add(new FormProcessor(new miguel_inscriptionForm()));
		$ret_val->add(new FormProcessor(new miguel_navForm(), 'reload', Util::main_URLPath('index.php')));
            	
        return $ret_val;
    }
 
}

?>
