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
 * Esta clase se encarga de gestionar el formulario para crear nuevos cursos
 *
 * @author  Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
 
class miguel_newCourseForm extends base_FormContent 
{

    var $listInstitution;
    var $listFaculty;
    var $listDepartment;
    var $listArea;    
    
    function miguel_newCourseForm($listInstitution, $listFaculty, $listDepartment, $listArea)
    {
        $this->base_FormContent();
        $this->listInstitution = $listInstitution;
        $this->listDepartment = $listDepartment;
        $this->listFaculty = $listFaculty;
        $this->listArea = $listArea;
     }
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();
        
        $elemT = new FEText( "courseName", FALSE, 10);
        $elemT->set_style_attribute('align', 'left');
        $this->add_element($elemT);

        $elemP = new FETextArea("courseDescription", false, 10, 50, null, 300);
        $elemP->set_style_attribute('align', 'left');
        $this->add_element($elemP);

        $listValues = $this->listInstitution;      
        $listValues[agt('undefined')] = 0;
        $listBox_Institution = new FEListBox('courseInstitution', false, '200px', NULL, $listValues);
        $this->add_element( $listBox_Institution );

        $listValues = $this->listFaculty;
        $listValues[agt('undefined')] = 0;
        $listBox_Faculty = new FEListBox('courseFaculty', false, '200px', NULL, $listValues);
        $this->add_element( $listBox_Faculty );
        
        $listValues = $this->listDepartment;
        $listValues[agt('undefined')] = 0;
        $listBox_Department = new FEListBox('courseDepartment', false, '200px', NULL, $listValues); 
        $this->add_element( $listBox_Department );

        $listValues = $this->listArea;
        $listValues[agt('undefined')] = 0;
        $listBox_Area = new FEListBox('courseArea', false, '200px', NULL, $listValues );
        $this->add_element( $listBox_Area );

        $elem = new FECheckBox('courseActive', agt('courseActive') );
        $elem->set_style_attribute('align', 'left');
        $this->add_element( $elem );

        $elem = new FECheckBox('courseAccess', agt('courseAccess') );
        $elem->set_style_attribute('align', 'left');
        $this->add_element( $elem );        
        
        $this->add_element($this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("miguel_Enter")." >"));
    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
        //$this->set_hidden_element_value("id", "logon");
    }


    /**
     * Este metodo construye el formulario en sí.
     */
    function form() 
    {
        $table = &html_table($this->_width,0,1,3);
        //$table->set_style("border: 1px solid");

        $elem = html_td("", "left", container(html_b( agt('miguel_CourseName') ), html_br(), $this->element_form("courseName")));
        $elem->set_id("identification");        
        $table->add_row($elem);
        
        $elem = html_td("", "left", container(html_b( agt('miguel_CourseDescription') ), html_br(), $this->element_form("courseDescription")));
        $elem->set_id("identification");       
        $table->add_row($elem);

        $elem = html_td("", "left", container(html_b( agt('miguel_Institution') ), html_br(), $this->element_form("courseInstitution")));
        $elem->set_id("identification");       
        $table->add_row($elem);

        $elem = html_td("", "left", container(html_b( agt('miguel_Faculty') ), html_br(), $this->element_form("courseFaculty")));
        $elem->set_id("identification");       
        $table->add_row($elem);
        
        $elem = html_td("", "left", container(html_b( agt('miguel_Department') ), html_br(), $this->element_form("courseDepartment")));
        $elem->set_id("identification");       
        $table->add_row($elem);
        
        $elem = html_td("", "left", container(html_b( agt('miguel_Area') ), html_br(), $this->element_form("courseArea")));
        $elem->set_id("identification");       
        $table->add_row($elem);
        
        $elem = html_td("", "left", container(html_b( agt('miguel_CourseActive') ), html_br(), $this->element_form("courseActive")));
        $elem->set_id("identification");       
        $table->add_row($elem);
        
        $elem = html_td("", "left", container(html_b( agt('miguel_CourseAccess') ), html_br(), $this->element_form("courseAccess")));
        $elem->set_id("identification");       
        $table->add_row($elem);
 
        $table->add_row(html_td("", "left",  $this->element_form("Aceptar")));

        return $table;
    }

    /**
     * This method gets called after the FormElement data has
     * passed the validation.  This enables you to validate the
     * data against some backend mechanism, say a DB.
     *
     */
    function form_backend_validation() 
    {
        //Los controles se hacen en el controlador
        return TRUE;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action() 
    {
        //Evitamos que se escriba nada
        return false;
    }
}

?>
