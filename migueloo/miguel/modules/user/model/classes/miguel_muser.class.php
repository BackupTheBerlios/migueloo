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
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel auth
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MUser extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MUser() 
    {	
        $this->base_Model();
    }
    
    function insertSugestion($str_name, $str_email, $str_content)
    {
        $now = date("Y-m-d H:i:s");
        $visible = "YES";
        
        $ret_val = $this->Insert('todo',
                                 'contenu, temps, auteur, email, priority, type, cible, statut, assignTo, showToUsers',
                                 "$str_content, $now, $str_name, $str_email, 0, 0, 0, 0, 0, $visible");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
}    
