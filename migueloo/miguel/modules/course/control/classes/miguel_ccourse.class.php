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
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */


class miguel_CCourse extends base_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CCourse()
	{	
		$this->base_Controller();
        $this->setModuleName('course');
		$this->setModelClass('miguel_MCourse');
		$this->setViewClass('miguel_VCourse');
	}
     
	function processPetition() 
	{
	
	    /* Falta la comprobaci—n del acceso */
	    
	    $user_id = $this->getSessionElement('userinfo','user_id');
	    $course_id = 0;
	    if ( $this->issetViewVariable('course') ) {
	        $course_id = $this->getViewVariable('course');
	    }
        
        include_once( Util::app_Path('common/control/classes/miguel_courseinfo.class.php') );
	    $infoCourse = miguel_CourseInfo::getInfo($this->obj_data, $course_id);
	    $this->setViewVariable('infoCourse', $infoCourse);
  		
  		$infoPath = $this->obj_data->getPath($course_id);
  		$this->setViewVariable('infoPath', $infoPath);
  		
		$this->addNavElement(Util::format_URLPath("lib/course/index.php", "course=".$course_id), $infoCourse['name']);
		
  		$this->setCacheFile('miguel_VCourse_' . $course_id . '_' . $this->getSessionElement("userinfo","user_id"));
  		
  		$this->setPageTitle("miguelOO Curso: " . $infoCourse['name']);
		$this->setMessage('Bienvenido al curso "' . $infoCourse['name'] . '"');
		$this->setHelp("EducContent");
	}
}
