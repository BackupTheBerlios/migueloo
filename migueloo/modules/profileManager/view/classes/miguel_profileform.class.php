<?php
/*
	  +----------------------------------------------------------------------+
	  |newInscription/view form                                              |
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
	  | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
	  |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
	  |          miguel Development Team                                     |
	  |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
	  +----------------------------------------------------------------------+
*/
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_profileForm extends miguel_FormContent
{
	/**
	 * Este metodo se llama cada vez que se instancia la clase.
	 * Se utiliza para crear los objetos del formulario
	 */
	function form_init_elements() 
	{

		$elemNombre = $this->_formatElem("FEText", "Nombre", "nom_form", FALSE, "25", "25");
		$elemNombre->set_attribute('class',''); 
		$this->add_element($elemNombre);

		$elemDescripcion = $this->_formatElem("FEText", "Descripci�n", "des_form", FALSE, "75", "100");
		$elemDescripcion->set_attribute('class',''); 
		$this->add_element($elemDescripcion);

		$elemPriority = $this->_formatElem("FEText", "Prioridad", "pri_form", FALSE, "2", "2");
		$elemPriority->set_attribute('class',''); 
		$this->add_element($elemPriority);
	
		$profiles = $this->getViewVariable('perfiles');
		for($i=0;$i<count($profiles);$i++){
		
			$id = $profiles[$i]['profile.id_profile'];
			$pri = $profiles[$i]['profile.profile_priority'];
			
			$elemNewPriority[$i] = $this->_formatElem("FEText", "Nueva Prioridad ".$i, "newpri_form_".$pri, FALSE, "2", "2");
			$elemNewPriority[$i]->set_attribute('class',''); 
			$this->add_element($elemNewPriority[$i]);
	
			$elemNewPriorityBtn[$i] = $this->_formatElem("base_SubmitButton", "Modificar ".$i, "submit", agt("modificar ".$pri));
			$elemNewPriorityBtn[$i]->set_attribute('class','p'); 
			$this->add_element($elemNewPriorityBtn[$i]);					
		}
		$elemOK = $this->_formatElem("base_SubmitButton", "Insertar", "submit", agt('Insertar perfil'));
		$elemOK->set_attribute('class','p'); 
		$this->add_element($elemOK);


	}

	function form_init_data() 
	{
		$this->initialize();
	}

	function initialize() 
	{
		$arr_info = $this->getViewVariable('arr_info');
		$profiles = $this->getViewVariable('perfiles');

		$this->set_element_value('Nombre',$arr_info['nombre']);
		$this->set_element_value('Descripci�n',$arr_info['descripcion']);
		$this->set_element_value('Prioridad',$arr_info['prioridad']);
		for ($i=0;$i<count($profiles);$i++){
			$this->set_element_value('Nueva Prioridad '.$i,0);
		}
		
	}
	
	function add_class_row(&$table, $name)
	{
		$row=$this->_tableRow($name);
		$row->set_class('ptabla03');
		$table->add_row($row);
	}

	/**
	 * Este metodo construye el formulario en s�.
	 */
	function form() 
	{
		
		//Inicializa campos
		$this->initialize();

        $cabecera = html_td('ptabla02', '', '');
        $cabecera->set_tag_attribute("width","5%");
		
		//inicializa la tabla
		$table = &html_table($this->_width,0,0,0);
		$table->set_class("mainInterfaceWidth");
		
		//inicializa tabla detalle		
		$table_detail = &html_table($this->_width,0,0,0);
		$table_detail->set_class("mainInterfaceWidth");		
		$row1 = html_tr();
		$row1->add(html_td('ptabla01', '', 'Perfil'));
		$row1->add(html_td('ptabla01', '', 'Descripci�n'));
		$row1->add(html_td('ptabla01', '', 'Prioridad'));
        $row2 = html_tr();
		$row2->add(html_td('ptabla03', '', $this->element_form('Nombre')));
		$row2->add(html_td('ptabla03', '', $this->element_form('Descripci�n')));
		$row2->add(html_td('ptabla03', '', $this->element_form('Prioridad')));
		$table_detail->add_row($row1);
		$table_detail->add_row($row2); 

		//inicializa tabla
        $row1 = html_tr(); 
        $row1->add($cabecera);
        $row1->add($table_detail);
        $table->add($row1);
        
		//a�ade el boton de guardar
		$table->add_row(_HTML_SPACE);
		$table->add_row(_HTML_SPACE, $this->element_form("Insertar"));
		$table->add_row(_HTML_SPACE);
	
		$row2 = html_tr();
		$row2->add($cabecera);
		
		$tabla_lista = $this->addProfileList();
		if($tabla_lista == null){
			$row2->add(html_td('ptabla03','','No existen perfiles'));
		}else{
			$row2->add($this->addProfileList());
		}
			
		$table->add($row2);
		
		return $table;
	}

	function addProfileList()
 	{
				
 		//inicializa la tabla
		$table = &html_table($this->_width,0,0,0);
		$table->set_class("mainInterfaceWidth");
			
		$profiles = $this->getViewVariable('perfiles');
		 
 		if ($profiles != null){
			
			$row1 = html_tr();
			
			$id = html_td('ptabla01', '', 'ID');
			$id->set_tag_attribute("width","5%");			
			
			$profile = html_td('ptabla01', '', 'Perfil');
			$profile->set_tag_attribute("width","25%");
			
			$description = html_td('ptabla01', '', 'Descripci�n');
	        $description->set_tag_attribute("width","50%");
			
			$priority = html_td('ptabla01', '', 'Prioridad');
	        $priority->set_tag_attribute("width","10%");
			
			$newpriority = html_td('ptabla01', '', 'Nueva prioridad');
	        $newpriority->set_tag_attribute("width","5%");
			
			$cambiar = html_td('ptabla01', '', 'Modificar prioridad');
	        $cambiar->set_tag_attribute("width","5%");
			
			$eliminar = html_td('ptabla01', '', 'Eliminar');
	        $eliminar->set_tag_attribute("width","5%");
			
			//$row->add($id);
			$row1->add($profile);
			$row1->add($description);
			$row1->add($priority);
			$row1->add($newpriority);
			$row1->add($cambiar);
			$row1->add($eliminar);
			
			$table->add_row($row1);     
	        
	        for($i=0;$i<count($profiles);$i++){
	        	
	        	$rowN = html_tr();
	        	
	        	$profileid = $profiles[$i]['profile.id_profile'];
	        	$pri = $profiles[$i]['profile.profile_priority'];
	        	
	        	$id = html_td('ptabla03', '', $profiles[$i]['profile.id_profile']);
	        	$id->set_tag_attribute("width","0%");
	        	
	        	$profile = html_td('ptabla03', '', $profiles[$i]['profile.profile_description']);
	        	$profile->set_tag_attribute("width","25%");
	        	
	        	$description = html_td('ptabla03', '', $profiles[$i]['profile.profile_notes']);
	        	$description->set_tag_attribute("width","50%");
	        	
	        	$priority = html_td('ptabla03', '', $profiles[$i]['profile.profile_priority']);
	        	$priority->set_tag_attribute("width","10%");	
		
	        	$newpriority = html_td('ptabla03', 'center', $this->element_form("Nueva Prioridad $i"));
	        	$newpriority->set_tag_attribute("width","5%");
	        	
	        	//$img = html_img(Theme::getThemeImagePath("boton_red.gif"));
	        	//$url = html_a(Util::format_URLPath('profileManager/index.php',"submit=mod&id=".$profilepri."&val=".$valor),$img, 'ptabla03');
	        	//$modificar = html_td('ptabla03', 'center',  $url);
	        	$boton = $this->element_form("Modificar ".$i);
	        	$boton->set_tag_attribute("width","5");
	        	$modificar = html_td('ptabla03', 'center',$boton);
                $modificar->set_tag_attribute('align', 'center');
	        	$modificar->set_tag_attribute("width","1%");
	        	
	        	$img = html_img(Theme::getThemeImagePath("boton_papelera.gif"));
	        	$url = html_a(Util::format_URLPath('profileManager/index.php',"submit=del&id=".$profileid."&pri=".$pri),$img, 'ptabla03');
	        	$eliminar = html_td('ptabla03', '',  $url);
                $eliminar->set_tag_attribute('align', 'center');
	        	$eliminar->set_tag_attribute("width","5%");
	        	
	        	//$row->add($id);
	        	$rowN->add($profile);
	        	$rowN->add($description);
	        	$rowN->add($priority);
	        	$rowN->add($newpriority);
	        	$rowN->add($modificar);
	        	$rowN->add($eliminar);
	        	
				$table->add_row($rowN); 
	        }
        				
 		}else{
			return null;
 		}
 			
		return $table;
		
 	}

	
}

?>
