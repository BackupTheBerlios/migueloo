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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class miguel_mContact extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_mContact() 
    {	
		$this->base_Model();
    }
    
 
    function listContact($user_id=0)
    {
    	//Get code contact
    	$contact = $this->Select('contact', "contact_id, contact_name, contact_surname", "user_id = $user_id");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	$countContact = count($contact);
    	for ($i=0; $i < $countContact; $i++) {
                $contact_id=$contact[$i]['contact.contact_id'];
                $contactelem[$i]= array ("contact_id" => $contact[$i]['contact.contact_id'],
                                "contact_name" => $contact[$i]['contact.contact_name'],
                                "contact_surname" => $contact[$i]['contact.contact_surname']);
    	}
    	
    	return ($contactelem);

    }
    
    function deleteContact($contact_id=0)
    {
    	//Get code contact
    	$this->Delete('contact', "contact_id = $contact_id");
    }
    
    function getContact($user_id="0", $contact_id="0")
    {

        $ret_val = $this->Select( 'contact', "contact_name, contact_surname", "user_id = $user_id AND contact_id = $contact_id"); 

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	//Debug::oneVar($this, __FILE__, __LINE__);
		return ($ret_val);
    }
	
	//Implementa el método insertSugestion
    function insertContact($user, $name, $surname, $nick, $mail, $jabber, $comment)
    {
        //Inserta en la tabla todo. Los parámetros de Insert son: tabla, campos y valores
        $ret_val = $this->Insert('contact',
                                 'user_id, contact_name, contact_surname, contact_nick, contact_mail, contact_jabber, contact_comments, is_from_miguel',
                                 "$user, $name, $surname, $nick, $mail, $jabber, $comment, 0");

        //Comprueba si ha ocurrido algún error al realizar la operación
    	if ($this->hasError()) {
    		$ret_val = null;
    	}

        //Devuelve el resultado
    	return ($ret_val);
    }
}
?>
