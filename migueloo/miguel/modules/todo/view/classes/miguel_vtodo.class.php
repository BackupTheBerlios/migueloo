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
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));
include_once (Util::app_Path("common/view/classes/miguel_navform.class.php"));
include_once (Util::app_Path("todo/view/include/classes/miguel_todoform.class.php"));

class miguel_VTodo extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El título para la página
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesión).
     *
	 */
    function miguel_VTodo($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }
    
    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */
    function right_block() 
    {
		$ret_val = container();
		
		$hr = html_hr();
		$hr->set_tag_attribute('noshade');
		$hr->set_tag_attribute('size', 2);
		$ret_val->add($hr);
		
		$div = html_div('ul-big');
		$div->add(html_img(Util::app_URLPath('image/menu/idea.png'), 0, 0, 0, ''));
		$div->add(html_b('Sugerencias'));
		$div->add(html_br(2));
		$ret_val->add($div);
		
		$div = html_div('medium-text');

		if($this->getViewVariable('bol_cuestion')){
            $div->add('Escriba sus datos y comentario');
    		$div->add(html_br(2));
    		$ret_val->add($div);
	        $ret_val->add(new FormProcessor(new miguel_todoForm(), 'sugest', Util::format_URLPath('todo/index.php')));
        } else {
            $div->add('Datos insertados');
	   	    $div->add(html_br(2));
		    $ret_val->add($div);
            $table = &html_table(Session::getContextValue("mainInterfaceWidth"),0,2,2);
            $table->add_row(html_td("", "", container(html_b('Nombre'), $this->getViewVariable('sug_nombre'))));
            $table->add_row(html_td("", "", container(html_b('Correo Electrónico'), $this->getViewVariable('sug_email'))));
            $table->add_row(html_td("", "", container(html_b('Comentario'), html_br(), $this->getViewVariable('sug_comentario'))));
            $ret_val->add($table);
            $ret_val->add(new FormProcessor(new miguel_navForm(), 'nav', Util::format_URLPath('todo/index.php')));
        }
            	
        return $ret_val;
    }
 
}

?>
