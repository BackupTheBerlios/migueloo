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
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
 
class miguel_todoForm extends FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();
        
        $elemT = new FEText("Nombre", FALSE, 50);
        $elemT->set_style_attribute('align', 'right');
        $this->add_element($elemT);

        $elemP = new FEText("Email", FALSE, 60);
        $elemP->set_style_attribute('align', 'right');
        $this->add_element($elemP);
		
		//<textarea wrap="physical" rows="10" cols="60" name="contenu"></textarea>
        $elemTA = new FETextArea("Comentario", FALSE, 10, 60,"500px", "100px");
        $elemTA->set_attribute('wrap', 'physical');
        $this->add_element($elemTA);

        //lets add a hidden form field
        $this->add_hidden_element("id");
    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
        $this->set_hidden_element_value("id", "todo");
    }


    /**
     * Este metodo construye el formulario en sí.
     */
    function form() 
    {
        $table = &html_table($this->_width,0,2,2);
        //$table->set_style("border: 1px solid");

        $elem = html_td("", "", container("Nombre", html_br(), $this->element_form("Nombre")));
        //$elem->set_id("identification");        
        $table->add_row($elem);
        
        $elem = html_td("", "", container("Correo Electrónico", html_br(), $this->element_form("Email")));
        //$elem->set_id("identification");       
        $table->add_row($elem);
        $elem = html_td("", "", container("Su comentario", html_br(), $this->element_form("Comentario")));
        //$elem->set_id("identification");       
        $table->add_row($elem);
 
        $table->add_row($this->add_action("Aceptar") ,_HTML_SPACE);

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
