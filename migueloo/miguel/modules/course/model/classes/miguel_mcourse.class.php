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

class miguel_MCourse extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MCourse() 
    {	
        $this->base_Model();
    }
        
    function getCourseData($code)
    {
        //Obtiene informaci—n del curso
        $ret_sql = $this->SelectMultiTable('course, user', 
                                      'course.course_name, course.course_description, course.course_language, user.user_name, user.user_surname, user.email',
                                      'course_id = ' . $course_id . ' AND course.user_id = user.user_id');

    	if ($this->hasError()) {
    	    $ret_val = null;
    	} else {
            $ret_val = array ( 'name'          => $ret_sql[0]['course.course_name'],
                               'description'       => $ret_sql[0]['course.course_description'],
                               'user_responsable'    => $ret_sql[0]['user.user_name'] . ' ' . $ret_sql[0]['user.user_surname'],
                               'email'         => $ret_sql[0]['user.email'],
                               'language'      => $ret_sql[0]['course.course_language']);
    	}
    	return ($ret_val);
    }
    
    function getPath( $course_id ) {
        $ret_sql = $this->Select('course',
                                 'institution_id, faculty_id, department_id, area_id',
                                 'course_id = ' . $course_id);
    	if ($this->hasError()) {
    	    $ret_val = null;
    	} else {
    	    $institution_id = $ret_sql[0]['course.institution_id'];
       	    $faculty_id = $ret_sql[0]['course.faculty_id'];
       	    $department_id = $ret_sql[0]['course.department_id'];
       	    $area_id = $ret_sql[0]['course.area_id'];
    	}
    	$ret_sql = $this->Select('institution', 'institution_description', 'institution_id = ' . $institution_id);
    	if ( $this->hasError() ) {
    	    $institution_description = '';
    	} else {
    	    $institution_description = $ret_sql[0]['institution.institution_description'];
        }

    	$ret_sql = $this->Select('faculty', 'faculty_description', 'faculty_id = ' . $faculty_id);
    	if ( $this->hasError() ) {
    	    $faculty_description = '';
    	} else {
    	    $faculty_description = $ret_sql[0]['faculty.faculty_description'];
        }
        
    	$ret_sql = $this->Select('department', 'department_description', 'department_id = ' . $department_id);
    	if ( $this->hasError() ) {
    	    $department_description = '';
    	} else {
    	    $department_description = $ret_sql[0]['department.department_description'];
        }
        
    	$ret_sql = $this->Select('area', 'area_description', 'area_id = ' . $area_id);
    	if ( $this->hasError() ) {
    	    $area_description = '';
    	} else {
    	    $area_description = $ret_sql[0]['area.area_description'];
        }
            $ret_val = array ( 'institution'          => $institution_description,
                               'faculty'       => $faculty_description,
                               'department'    => $department_description,
                               'area'      => $area_description);
    	return ($ret_val);
                                                
    }
}    
