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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Esta clase obtiene informaci�n relativa a un curso.
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */
class miguel_CourseInfo
{
	/**
	 * Informa si el curso es de acceso p�blico.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $course_id Identificador del curso.
	 * @return boolean Devuelve TRUE si el usuario es p�blico, y FALSE si no lo es.
	 */
    function getAccess(&$obj_model, $course_id)
    {
        $ret_sql = $obj_model->Select('course', 'course_access', 'course_id = ' . $course_id);
        if ($obj_model->hasError()) {
           $ret_val = null;
    	} else {
    	   if($ret_sql[0]['course.course_access'] == 1) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }
    
	/**
	 * Informa si el curso est� disponible o activado.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $course_id Identificador del curso.
	 * @return boolean Devuelve TRUE si el curso est� activo, y FALSE si no.
	 */    
    function getActive(&$obj_model, $course_id)
    {
        $ret_sql = $obj_model->Select('course', 'course_active', 'course_id = ' . $course_id);
        if ($obj_model->hasError()) {
           $ret_val = null;
    	} else {
    	   if($ret_sql[0]['course.course_active'] == 1) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }    
    /**
	 * Informa si el usuario/clave tiene acceso permitido al curso.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @param string $str_password Clave del usuario.
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function hasAccess(&$obj_model, $course_id, $user_id)
    {
        $ret_sql_course = $obj_model->Select('course', 'course_active, course_access', 'course_id = ' . $course_id);
     
        if ($obj_model->hasError()) {
    		$ret_val = null;
    	} else {
    	   $active = $ret_sql_course[0]['course.course_active'];
    	   $access = $ret_sql_course[0]['course.course_access'];    	   
    	}    	
        
        $ret_val = false;
        if ( $active == 1 ) { //Si el curso est� activado
            if ( $access == 1 ) { //Es necesario estar matriculado
                $ret_sql_user = $obj_model->Select('user_course', 'user_id', 'course_id = ' . $course_id . ' AND user_id = ' . $user_id);
                if ($obj_model->hasError()) {
    		        $ret_val = null;
    	        } else {
    	           if ($ret_sql_user[0]['user_course.user_id'] ) { //El usuario est� matriculado
                       $ret_val = true;
                   }
    	        }
    	    } else {
    	        $ret_val = true;
    	    }
        }
        
    	return ($ret_val);
    }

    /**
	 * Obtiene toda la informaci�n de un usuario
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @return array Toda la informaci�n: nombre, email, nick, trato, idioma,...
	 */
    function getInfo(&$obj_model, $course_id)
    {
        //Obtiene informaci�n del curso
        $ret_sql = $obj_model->SelectMultiTable('course, user, person', 
                                      'course.course_name, course.course_description, course.course_language, person.person_name, person.person_surname, user.email',
                                      'course_id = ' . $course_id . ' AND course.user_id = user.user_id AND user.person_id = person.person_id');

    	if ($obj_model->hasError()) {
    	    $ret_val = null;
    	} else {
            $ret_val = array ( 'course_id'          => $course_id,
                               'name'               => $ret_sql[0]['course.course_name'],
                               'description'        => $ret_sql[0]['course.course_description'],
                               'user_responsable'   => $ret_sql[0]['person.person_name'] . ' ' . $ret_sql[0]['person.person_surname'],
                               'email'              => $ret_sql[0]['user.email'],
                               'language'           => $ret_sql[0]['course.course_language']);
    	}
    	return ($ret_val);
    }

    /**
	 * Inserta en la tabla de accesos un nuevo registro
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $user Identificador de usuario (nickname).
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function setLogin(&$obj_model, $user, $type = 1)
    {
		$ret_select = $obj_model->Select('user', 'user_id', "user_alias = $user");

    	if ($obj_model->hasError()) {
    		$ret_val = false;
    	} else {
    		$userId = $ret_select[0]['user.user_id'];
			$now = date("Y-m-d H:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];
			if($type == 1) {
				$log = 'LOGIN';
			} else {
				$log = 'LOGOUT';
			}
		
			$ret_sql = $obj_model->Insert('loginout', 'id_user, ip, log_when, log_action', "$userId, $ip, $now, $log");

    		if ($obj_model->hasError()) {
    			$ret_val = false;
    		} else {
    		   $ret_val = true;
    		}    	
		}
    	return ($ret_val);
    }
}
?>
