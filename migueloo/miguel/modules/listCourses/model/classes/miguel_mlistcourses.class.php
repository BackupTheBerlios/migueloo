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
class miguel_mListCourses extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_mListCourses() 
    {	
		$this->base_Model();
    }

    function getCourse($institution_id=0, $faculty_id = 0, $department_id = 0, $area_id = 0)
    {
    	//Get code cours
    	$course = $this->Select('course', "course_id, course_name, course_description, course_access,  course_active", "institution_id = $institution_id AND faculty_id = $faculty_id AND department_id = $department_id AND area_id = $area_id AND course_active = 0 AND course_access = 0");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	$countCourse = count($course);
    	for ($i=0; $i < $countCourse; $i++) {
                $courselem[]=array ("course_id" => $course[$i]['course.course_id'],
                                "course_name" => $course[$i]['course.course_name'],
                                "course_description" => $course[$i]['course.course_description'],
                                "course_access" => $course[$i]['course.course_access'],
                                "course_active" => $course[$i]['course.course_active']);
    	}
    	
    	return ($courselem);
    }

}
?>
