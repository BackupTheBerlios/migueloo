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
	  |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VNewUser extends miguel_VMenu
{
    function miguel_VNewUser($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }

    function right_block()
    {
        $ret_val = container();
		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$ret_val->add($hr);
		
		$ret_val->add(html_h4("Inscripción al Campus Virtual"));
		
		if ($this->issetViewVariable('newclient') && $this->getViewVariable('newclient') == 'ok') {
            $ret_val->add(html_h2(agt('Alta de usuario correcta.')));
			$ret_val->add(html_a(Util::format_URLPath("main/index.php", 'id=institution'), agt('Volver')));
			$ret_val->add(_HTML_SPACE);
			$ret_val->add(html_a(Util::format_URLPath('newUser/index.php'), agt('Nuevo Usuario')));
		} else {
			$ret_val->add($this->addForm('newUser', 'miguel_inscriptionForm'));
		}
        return $ret_val;
    }
}
?>