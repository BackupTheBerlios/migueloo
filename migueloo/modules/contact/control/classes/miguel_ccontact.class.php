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
/**
 *
 */

class miguel_CContact extends miguel_Controller
{	
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CContact()
	{	
		$this->miguel_Controller();
		$this->setModuleName('contact');
		$this->setModelClass('miguel_MContact');
    	$this->setViewClass('miguel_VMain');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
            //Se controla que el usuario no tenga acceso. Por defecto, se tiene acceso.
            //$institution_id = -1;
		
		
            //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
            $user_id = $this->getSessionElement( 'userinfo', 'user_id' );
            if ( isset($user_id) && $user_id != '' ) {            
                $this->setViewVariable('user_id', $user_id );
                switch ($this->getViewVariable('option'))
					{
						case detail:
							$contact_id=$this->getViewVariable('contact_id');
							$detail_contacts = $this->obj_data->getContact($user_id, $contact_id);
							$this->setViewVariable('detail_contacts', $detail_contacts);
							$this->setViewClass('miguel_VDetail');
							break;
						case insert:
							$this->setViewClass('miguel_VNewContact');
							break;
						case newdata:
							$this->obj_data->insertContact($user_id, $this->getViewVariable('nom_form'), $this->getViewVariable('prenom_form'), $this->getViewVariable('uname'), $this->getViewVariable('email'), $this->getViewVariable('jabber'), $this->getViewVariable('comentario'));
							$this->setViewClass('miguel_VMain');
							$arr_contacts = $this->obj_data->listContact($user_id);
							$this->setViewClass('miguel_VMain');
							break;	
						case delete:
							$this->obj_data->deleteContact($this->getViewVariable('contact_id'));
							break;
						default:
							$arr_contacts = $this->obj_data->listContact($user_id);
							$this->setViewClass('miguel_VMain');
							break;
					}
                
                $this->setViewVariable('arr_contacts', $arr_contacts );
                $this->addNavElement(Util::format_URLPath('contact/index.php'), agt('miguel_Contact') );
                $this->setCacheFile("miguel_VMain_Contact_" . $this->getSessionElement("userinfo", "user_id"));
                $this->setMessage(agt('miguel_ContactList') );
                $this->setPageTitle( 'miguel_ContactList' );
                
                $this->setCacheFlag(true);
                $this->setHelp("EducContent");
            } else {
                header('Location:' . Util::format_URLPath('main/index.php') );
	        }
	}
}

?>
