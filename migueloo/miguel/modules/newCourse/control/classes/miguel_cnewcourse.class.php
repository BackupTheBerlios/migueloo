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
 * Módulo encargado de crear cursos.
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */


class miguel_CNewCourse extends base_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CNewCourse()
	{	
		$this->base_Controller();
        $this->setModuleName('newCourse');
		$this->setModelClass('miguel_MNewCourse');
		$this->setViewClass('miguel_VNewCourse');
	}
     
	function processPetition() 
	{
	    $bol_hasAccess = false;
        //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
        $user_id = $this->getSessionElement( 'userinfo', 'user_id' );
        if ( isset($user_id) && $user_id != '' ) { 
            $bol_hasAccess = true;
        }
        
	    if ( $bol_hasAccess ) {
            if ($this->issetViewVariable('submit')) {
                $courseData = array('name' => $this->getViewVariable('coursename'),
                                      'description' => $this->getViewVariable('coursedescription'),
                                      'institution' => $this->getViewVariable('courseinstitution'),
                                      'faculty' => $this->getViewVariable('coursefaculty'),
                                      'department' => $this->getViewVariable('coursedepartment'),
                                      'area' => $this->getViewVariable('coursearea'),
                                      'access' => $this->getViewVariable('courseaccess'),
                                      'active' => $this->getViewVariable('courseactive'),
                                      'user_id' => $user_id,
                                      'language' => 'es_es');
                $this->obj_data->insertNewCourse($courseData);
                $this->obj_data->insertUserCourse($user_id, $this->obj_data->getCourseId( $courseData['name'] ) );                
                $this->setViewClass('miguel_VResultNewCourse');   
                $this->setViewVariable('courseName', $courseData['name']);
                $this->setViewVariable('courseDescription', $courseData['description']);

                $this->setCacheFile("miguel_VResultNewCourse_" . $this->getSessionElement("userinfo","user_id"));
                $this->setCacheFlag(true);  		

                $this->setMessage(agt('miguel_ResultNewCourse') );
                $this->setPageTitle( 'miguel_ResultNewCourse' );
            } else {
                $this->setViewVariable('arr_listInstitution', $this->obj_data->getInstitution() );
                $this->setViewVariable('arr_listFaculty', $this->obj_data->getFaculty() );
                $this->setViewVariable('arr_listDepartment', $this->obj_data->getDepartment() );
	            $this->setViewVariable('arr_listArea', $this->obj_data->getArea() );	    
  		
                //$this->addNavElement(Util::format_URLPath("newCourse/index.php", "course=".$course_id), $infoCourse['name']);
		 
                $this->setCacheFile("miguel_VNewCourse_" . $this->getSessionElement("userinfo","user_id"));
                $this->setCacheFlag(true);  		

                $this->setMessage(agt('miguel_NewCourse') );
                $this->setPageTitle( 'miguel_NewCourse' );
            }
        } else {
            header('Location:' . Util::format_URLPath('main/index.php') );
        }
        $this->setHelp("EducContent");        
    }
}
