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
        $elemT->set_attribute("id","coursename");
        $elemT->set_attribute("accesskey","n");        
        $this->add_element($elemT);

        $elemP = new FETextArea("courseDescription", false, 10, 50, null, 300);
        $elemP->set_style_attribute('align', 'left');
        $elemP->set_attribute("id","coursedescription");        
        $elemP->set_attribute("accesskey","d");        
        $this->add_element($elemP);

        include(Util::app_Path("andromeda/include/classes/nls.inc.php"));
        $language = $this->_formatElem("FEListBox", "courseLanguage", "courseLanguage", FALSE, "100px", NULL, $nls['languages_form']);
        $language->set_style_attribute('align', 'left');
        $language->set_attribute("id","courselanguage");
        $language->set_attribute("accesskey","l");        
        $this->add_element($language);
        
        $elem = new FECheckBox('courseActive', agt('courseActive') );
        $elem->set_style_attribute('align', 'left');
        $elem->set_attribute("id","courseactive");        
        $elem->set_attribute("accesskey","v");                
        $this->add_element( $elem );

        $elem = new FECheckBox('courseAccess', agt('courseAccess') );        
        $elem->set_style_attribute('align', 'left');
        $elem->set_attribute("id","courseaccess");
        $elem->set_attribute("accesskey","a");                
        $this->add_element( $elem );        

        $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("miguel_Enter"));
        $submit->set_attribute("id","submit"); 
        $submit->set_attribute("accesskey","e");               
        $this->add_element($submit);
    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
        //$this->set_hidden_element_value("id", "logon");
        $this->set_element_value("courseName", agt(miguel_courseDescriptionName) );
        $this->set_element_value("courseDescription", agt(miguel_courseDescriptionExample) );
    }


    /**
     * Este metodo construye el formulario en sÌ.
     */
    function form() 
    {
        $table = &html_table($this->_width,0,1,3);
        //$table->set_style("border: 1px solid");

        $this->set_form_tabindex("courseName", '7');
        $label = html_label( "coursename" );        
        $label->add(container(html_b( agt('miguel_CourseName') ), html_br() ));
        $label->add($this->element_form("courseName") );
        
        $elem = html_td("", "left",$label);
        $elem->set_id("courseName");        
        $table->add_row($elem);

        $this->set_form_tabindex("courseDescription", '8');
        $label = html_label( "coursedescription" );
        $label->add(container(html_b( agt('miguel_CourseDescription') ), html_br(), $this->element_form("courseDescription")));

        $elem = html_td("", "left", $label);
        $elem->set_id("courseDescription");
        $table->add_row($elem);

        $this->set_form_tabindex("courseLanguage", '8');            
        $label = html_label( "courselanguage" );
        $label->add(container(html_b( agt('miguel_CourseLanguage') ), html_br(), $this->element_form("courseLanguage")));
        $elem = html_td("", "left", $label);
        $elem->set_id("courseLanguage");
        $table->add_row($elem);

        $this->set_form_tabindex("courseActive", '9');
        $label = html_label( "courseactive" );
        $label->add(container(html_b( agt('miguel_CourseActive') ), html_br(), $this->element_form("courseActive")));
        $elem = html_td("", "left", $label);
        $elem->set_id("courseActive");
        $table->add_row($elem);
        
        $this->set_form_tabindex("courseAccess", '10');        
        $label = html_label( "courseaccess" );
        $label->add(container(html_b( agt('miguel_CourseAccess') ), html_br(), $this->element_form("courseAccess")));
        $elem = html_td("", "left", $label);
        $elem->set_id("courseAccess");       
        $table->add_row($elem);

        $this->set_form_tabindex("Aceptar", '11'); 
        $label = html_label( "submit" );
        $label->add($this->element_form("Aceptar"));
        $table->add_row(html_td("", "left",  $label));

        return $table;
    }
}

?>