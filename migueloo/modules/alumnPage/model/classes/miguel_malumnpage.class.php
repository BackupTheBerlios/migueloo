<?php
/*
      +----------------------------------------------------------------------+
      | miguel_malumnpage.class.php                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, SHS Polar Sistemas Informáticos, S.L.            |
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
      | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Include libraries
 */

class miguel_MAlumnPage extends base_Model
{
    function miguel_MAlumnPage() 
    { 
        $this->base_Model();
    }
    
    function getNewUserMessages()
    {
    	$iMyId = Session::getValue('USERINFO_USER_ID');
		
		$ret_val = $this->SelectMultiTable('message,receiver_message,user', 
                                           'user.user_alias, message.sender,message.subject,message.body,message.date,receiver_message.status,message.id',
                                           "user.user_id = receiver_message.id_receiver AND receiver_message.id_message = message.id AND receiver_message.id_receiver = $iMyId AND receiver_message.status < 1");

        if ($this->hasError()) {
        	$ret_val = null;
        } 
        
        return($ret_val);			 	
    }

	function getNotices()
    {
		 $ret_val = $this->Select('notice', 'author, text, time, notice_id', "");

	
    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
}    
