<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
include_once(Util::app_Path("common/view/classes/miguel_vbase.class.php"));

class miguel_VPage extends miguel_VBase
{
	/**
	 * @access private
	 * @var string
	 */
	var $str_title = '';
	
	/**
	 * Constructor.
	 * @param string $str_title Título de la página
	 * @param array $arr_commarea Variables necesarias para la visualización de la vista
	 * 
	 */
    function miguel_VPage($str_title, $arr_commarea)
    {   
        $this->str_title = $str_title;
        
        $this->base_LayoutPage($this->str_title, $arr_commarea);
    }
	
	/**
	 * Define la estructura global de la página
	 *
	 */
	function body_content() 
	{		
		$this->set_body_attributes("bgcolor=\"white\"");
		//add the header area
		$this->add( html_comment( "Header block begins") );
		include_once(Util::base_Path('include/classes/nls.class.php'));
		NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		$this->add( $this->header_block() );
		$this->add( html_comment( "Header block ends") );		

		//add it to the page
		//build the outer wrapper div
		//that everything will live under
		$wrapper_div = html_div();
		$wrapper_div->set_id( "mainarea" );

		//add the main body
		$wrapper_div->add( html_comment( "Main block begins") );
		NLS::setTextdomain($this->registry->gettextDomain(), Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		$wrapper_div->add( $this->main_block() );
		$wrapper_div->add( html_comment( "Main block ends") );

		$this->add( $wrapper_div );

		//add the footer area.
		$this->add( html_comment( "Footer block begins") );
		NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		$this->add( $this->footer_block() );
		$this->add( html_comment( "Footer block ends") );
	}

    /**
     * Define el valor de la cabecera.
     * @see base_Header
     * @return HTMLtag object.
     */
    function header_block() 
    {
		include_once(Util::app_Path('common/view/classes/miguel_header.class.php'));
		$header = html_div();
		$table = new miguel_Header($this->getViewVariable("str_help"), $this->getViewVariable("str_message"));
		$header->add($table->getContent());
		unset($table);

        return $header;
    }


    /**
     * Define el formato del área principal.
     * @return HTMLTag object
     */
    function main_block() 
    {

		$main = html_div();
		$main->set_id("content");

		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,5,1);
		$table->set_class("simple");

		$left_div = html_div("leftblock", $this->left_block() );		

		$table->add_row( html_td("leftblock", "", $left_div ),
						 html_td("divider", "", "&nbsp;"),
						 html_td("rightblock", "", $this->right_block() ));
        $main->add( $table );
        unset($table);

		return $main;
    }


    /**
     * Define el formato del área izquierda
     * @return HTMLTag object
     */
    function left_block() 
    {
		$div = html_div();
		$div->set_style("padding-left: 6px;");

		$div->add( "LEFT BLOCK" );
        return $div;
    }

    /**
     * Define el formato del área derecha
     * @return HTMLTag object
     */
    function right_block() 
    {
		$div = html_div();
		$div->set_style("padding-left: 6px;");

		$div->add( "RIGHT BLOCK" );
        return $div;
    }

    /**
     * Define el valor del pie de página..
     * @see base_Footer
     * @return HTMLtag object.
     */
    function footer_block() 
    {
		$footer_div = html_div();
		$footer_div->set_tag_attribute("id", "footerblock");
		
		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		//$hr->set_tag_attribute("size", 2);
		$footer_div ->add($hr);
		
		include_once(Util::app_Path('common/view/classes/miguel_footer.class.php'));
		$table = new miguel_Footer();
		$footer_div->add($table->getContent());
		unset($table);
				
        return $footer_div;
    }
}
?>
