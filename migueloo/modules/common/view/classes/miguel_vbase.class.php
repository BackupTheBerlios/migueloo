<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
 * Define la clase base para las pantallas de miguel.
 *
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

class miguel_VBase extends base_LayoutPage
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
    function miguel_VBase($str_title, $arr_commarea)
    {   
        $this->str_title = $str_title;
        
        $this->base_LayoutPage($this->str_title, $arr_commarea);
    }
    
    function initialize()
    {
        //Preparamos valores para los header de la página
        $this->add_head_content("<meta name=\"keywords\" content=\"miguel,hispalinux,indetec,campus,ecampus,e-campus,classroom,elearning,learning,pedagogy,platform,teach,teaching,teacher,prof,professor,student,study,open,source,gpl,mysql,php,e-learning, apprentissage,ecole,universite,university,contenu,classe, universidad, enseÃ±anza, virtual, distribuida, sl, gpl, software, libre, clases, aprendizaje, proceso\">"); 
        $this->add_head_content("<link rel=\"icon\" href=\"".Theme::getThemeImagePath('favicon.png')."\" type=\"image/png\">");
		
		//Hojas de estilo CSS
		$this->add_css_link(Theme::getThemeCSSPath('common.css'));
		$this->add_css_link(Theme::getThemeCSSPath('headers.css'));
		$this->add_css_link(Theme::getThemeCSSPath('index.inc.css'));
    }
}
?>
