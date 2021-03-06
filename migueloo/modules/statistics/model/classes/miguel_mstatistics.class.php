<?php
/*
      +----------------------------------------------------------------------+
      |statistics/model                                                      |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
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

class miguel_MStatistics extends base_Model
{
    function miguel_MStatistics() 
    { 
        $this->base_Model();
    }
    
    function countLogin($user_id)
    {
    	$ret_val = $this->SelectCount('loginout', 'id_user = ' . $user_id . ' AND log_action = LOGIN'); 
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	
    	return $ret_val;
    }
    
	function getUsers()
    {
		 $ret_val = $this->Select('user', 'user_id, user_alias', '');

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	
    	return $ret_val;
    }	
}    
?>