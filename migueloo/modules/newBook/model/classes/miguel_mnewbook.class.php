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
 * @package miguel NewUser
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */


class miguel_MNewBook extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MNewBook()
    {	
		$this->base_Model();
    }
    
    
    /*function newUser($name, $surname, $treatment, $user, $theme, $lang, $passwd, $profile, $email)
    {
        $person = $this->_insertPerson($name, $surname, $treatment);
        $user = $this->_insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email);
    } */
    function newBook($titulo, $autor, $f_edicion, $editorial, $lugar_pub, $descripcion, $indice, $como_obtener)
    {
        //$person = $this->_insertPerson($name, $surname, $treatment);
        $book = $this->_insertBook($titulo, $autor, $f_edicion, $editorial, $lugar_pub, $descripcion, $indice, $como_obtener);
        //$user = $this->_insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email);
        
    }
    
    function _insertBook($titulo, $autor, $f_edicion, $editorial, $lugar_pub, $descripcion, $indice, $como_obtener)
    {
    
        /*$ret_val = $this->Insert('person',
                                 'person_jabber, person_name, person_surname, treatment_id, cargo',
                                 "$jabber, $name, $surname, $treatment, $cargo");*/
        $ret_val = $this->Insert('book',
                                 'titulo, autor, f_edicion, editorial, lugar_pub, descripcion, indice, como_obtener',
                                 "$titulo, $autor, $f_edicion, $editorial, $lugar_pub, $descripcion, $indice, $como_obtener");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    /*function _insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email)
    {
        $active = '1';
        $hash = '';
        $ret_val = $this->Insert('user',
                                 'user_alias, theme, language, user_password, active, activate_hash, institution_id, forum_type_bb, main_page_id, person_id, id_profile, treatment_id, email',
                                 "$user, $theme, $lang, $passwd, $active, $hash, 0, 0, 0, $person, $profile, $treatment, $email");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }*/
    
  
}
