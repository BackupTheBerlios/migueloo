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
 * Se define una plantilla com�n para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentar� la informaci�n
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
include_once (Util::base_Path("view/classes/base_layoutpage.class.php"));
//include_once(Util::app_Path("common/view/classes/miguel_vbase.class.php"));
include_once(Util::base_Path('include/classes/nls.class.php'));
include_once(MIGUELBASE_DIR.'control/classes/menubar.class.php');

class miguel_VPage extends base_LayoutPage //miguel_VBase
{
	/**
	 * @access private
	 * @var string
	 */
	var $str_title = '';
	/**
	 * @access private
	 * @var string
	 */
	var $str_type = '';
	
	/**
	 * Constructor.
	 * @param string $str_title T�tulo de la p�gina
	 * @param array $arr_commarea Variables necesarias para la visualizaci�n de la vista
	 * 
	 */
    function miguel_VPage($str_title, $arr_commarea)
    {   
        $this->base_LayoutPage($this->str_title, $arr_commarea);
		
		$this->str_title = $str_title;
        $this->str_type = Session::getContextValue("mainInterfaceType");
        
    }
	
	function initialize()
    {
        //Preparamos valores para los header de la p�gina
        $this->add_head_content("<meta name=\"keywords\" content=\"miguel,hispalinux,indetec,campus,ecampus,e-campus,classroom,elearning,learning,pedagogy,platform,teach,teaching,teacher,prof,professor,student,study,open,source,gpl,mysql,php,e-learning, apprentissage,ecole,universite,university,contenu,classe, universidad, enseñanza, virtual, distribuida, sl, gpl, software, libre, clases, aprendizaje, proceso\">"); 
        $this->add_head_content("<link rel=\"icon\" href=\"".Theme::getThemeImagePath('favicon.png')."\" type=\"image/png\">");
		
		//Hojas de estilo CSS
		$this->add_css_link(Theme::getThemeCSSPath('common.css'));
		$this->add_css_link(Theme::getThemeCSSPath('headers.css'));
		$this->add_css_link(Theme::getThemeCSSPath('index.inc.css'));
		
		//JavaScript File
		$this->add_css_link(Theme::getThemeCSSPath('menu.css'));
		$this->add_js_link(Theme::getThemeJSPath('menu.js'));
    }
	
	/**
	 * Define la estructura global de la p�gina
	 *
	 */
	function body_content() 
	{		
		$this->set_body_attributes("bgcolor=\"white\"");
		//$this->set_body_attributes("onload=songticker()");
		
		//add the header area
		$this->add( html_comment( "Header block begins") );
		$this->add( $this->header_block() );
		$this->add( html_comment( "Header block ends") );		

		//add it to the page
		//build the outer wrapper div
		//that everything will live under
		$wrapper_div = html_div();
		$wrapper_div->set_id( "mainarea" );

		//add the main body
		$wrapper_div->add( html_comment( "Main block begins") );
		$wrapper_div->add( $this->main_block() );
		$wrapper_div->add( html_comment( "Main block ends") );

		$this->add( $wrapper_div );

		//add the footer area. 
		if ($this->str_type == 'menu') {
			$this->add( html_comment( "Footer block begins") );
			$this->add( $this->footer_block() );
			$this->add( html_comment( "Footer block ends") );
		}
		
	}

    /**
     * Define el valor de la cabecera.
     * @see base_Header
     * @return HTMLtag object.
     */
    function header_block() 
    {
		NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		
		switch($this->str_type){
			case 'toolbar':
				$header = $this->toolbar_header_block();
				break;
			default:
				$header = $this->menu_header_block();
		}

        return $header;
    }


    /**
     * Define el formato del �rea principal.
     * @return HTMLTag object
     */
    function main_block() 
    {
		NLS::setTextdomain($this->registry->gettextDomain(), Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		
		switch($this->str_type){
			case 'toolbar':
				$main = $this->toolbar_header_block();
				break;
			default:
				$main = $this->menu_header_block();
		}

		return $main;
    }


    /**
     * Define el formato del �rea izquierda
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
     * Define el formato del �rea derecha
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
     * Define el valor del pie de p�gina..
     * @see base_Footer
     * @return HTMLtag object.
     */
    function footer_block() 
    {
		NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		
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
	
	/**
     * Define el valor de la cabecera. Tipo ventana: miguel
     * @see base_Header
     * @return HTMLtag object.
     */
    function menu_header_block() 
    {
		NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		
		include_once(Util::app_Path('common/view/classes/miguel_header.class.php'));
		$header = html_div();
		$table = new miguel_Header($this->getViewVariable("str_help"), $this->getViewVariable("str_message"));
		$header->add($table->getContent());
		unset($table);

        return $header;
    }
	
	/**
     * Define el formato del �rea principal.
     * @return HTMLTag object
     */
    function menu_main_block() 
    {
		NLS::setTextdomain($this->registry->gettextDomain(), Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
		
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
     * Define el valor de la cabecera.
     * @see base_Header
     * @return HTMLtag object.
     */
    function toolbar_header_block() 
    {
		include_once(Util::app_Path('common/view/classes/miguel_dheader.class.php'));
		$header = html_div();
		$table = new miguel_DHeader($this->getViewVariable("str_message"));
		$header->add($table->getContent());
		unset($table);

        return $header;
    }
	
	/**
     * Define el formato del �rea principal.
     * @return HTMLTag object
     */
    function toolbar_main_block() 
    {

		$main = html_div();
		$main->set_id("content");
        $main->add( $this->right_block() );

		return $main;
    }
	
	/**
     * 
     * 
     */
    function setDefaultType() 
    {
		$this->str_type = 'menu';
    }
}
?>
