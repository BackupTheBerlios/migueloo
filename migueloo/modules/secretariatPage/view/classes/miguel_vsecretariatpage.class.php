<?php
/*
      +----------------------------------------------------------------------+
      |secretariatPage/view                                                  |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, SHS Polar Sistemas Informáticos, S.L.            |
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
/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VSecretariatPage extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El tâˆšÃ¥tulo para la pÂ¬âˆ‘gina
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesiâˆšÃµn).
     *
	 */
    function miguel_VSecretariatPage($title, $arr_commarea)
    {
        //Ejecuta el constructor de la superclase de la Vista
        $this->miguel_VMenu($title, $arr_commarea);
     }

	function add_sectionHead($strName, $strIcon)
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
		$name = html_td("", "", html_b($strName));
		//$name->set_tag_attribute("bgcolor","808080");
		$name->set_tag_attribute("width","30%");
		$icon = html_td("", "", Theme::getThemeImage($strIcon));
		$icon->set_tag_attribute("width","70%");
		$icon->set_tag_attribute("align","right");
	
		//$icon->set_tag_attribute("bgcolor","808080");
		$row->add($name);
		$row->add($icon);
		$table->add($row);
		return $table;
	}
		

	function add_mailHead($from_to)
	{
        //$check = html_input('radio','');
		    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
		$from = html_td("", "", html_b('De'));
		$from->set_tag_attribute("bgcolor","#808080");
		$subject = html_td("", "", html_b('Asunto'));
		$subject->set_tag_attribute("bgcolor","#808080");
		$date = html_td("", "", html_b('Hora'));
		$date->set_tag_attribute("bgcolor","#808080");
		
		$from->set_tag_attribute('width',"30%");
		$subject->set_tag_attribute('width',"50%");
		$date->set_tag_attribute('width',"20%");
	
		$row->add($from);
		$row->add($subject);
		$row->add($date);
		
		return $row;
	}


	function add_emailInfo($_from, $_subject, $_date, $_id_msg)
	{
        //$check = html_input('radio','');
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');      
		$from = html_td('', '', html_a(Util::format_URLPath('email/index.php','status=new&to=' . $_from),$_from));
		$subject = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=show&id=$_id_msg"),$_subject));
		$date = html_td('', '', $_date);
		//$row->add($check);

		$color = '#99CE99';
		//$color = 'CECECE';
		$from->set_tag_attribute('bgcolor',$color);  	
		$date->set_tag_attribute('bgcolor',$color);
		$subject->set_tag_attribute('bgcolor',$color);

		$from->set_tag_attribute('width','30%');
		$subject->set_tag_attribute('width','50%');
		$date->set_tag_attribute('width','20%');
		
		$row->add($from);
		$row->add($subject);
		$row->add($date);
		
		return $row;
	}
		
	function add_inbox()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$arrMessages = $this->getViewVariable('arrMessages');

		if ($arrMessages[0]['user.user_alias']!=null){
			$table->add($this->add_mailHead());
			for ($i=0; $i<count($arrMessages); $i++){
				$table->add($this->add_emailInfo($arrMessages[$i]['user.user_alias'],
												$arrMessages[$i]['message.subject'],
												$arrMessages[$i]['message.date'],
												$arrMessages[$i]['message.id'],
												$arrMessages[$i]['receiver_message.status']));
			}
		} else {
			$table->add('La carpeta está vacía');
		}
	
		return $table;
	}

	function add_noticeHead()
	{
        //$check = html_input('radio','');
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
		$from = html_td("", "", html_b('Autor'));
		$from->set_tag_attribute("bgcolor","#808080");
		$subject = html_td("", "", html_b('Título'));
		$subject->set_tag_attribute("bgcolor","#808080");
		$date = html_td("", "", html_b('Hora'));
		$date->set_tag_attribute("bgcolor","#808080");

		$from->set_tag_attribute('width','30%');
		$subject->set_tag_attribute('width','50%');
		$date->set_tag_attribute('width','20%');

		$row->add($from);
		$row->add($subject);
		$row->add($date);
		
		return $row;
	}
		
	function add_notice($author, $text, $_date, $id)
	{
        //$check = html_input('radio','');
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');      
		$subject = html_td('', '', html_a(Util::format_URLPath('notice/index.php',"status=show&id=$id"),$text));
		$from = html_td('', '', $author);
		$date = html_td('', '', $_date);

		//$color = 'CECECE';
		$color = '#99CE99';
		$from->set_tag_attribute('bgcolor',$color);  	
		$date->set_tag_attribute('bgcolor',$color);
		$subject->set_tag_attribute('bgcolor',$color);

		$from->set_tag_attribute('width','30%');
		$subject->set_tag_attribute('width','50%');
		$date->set_tag_attribute('width','20%');
	
		$row->add($from);
		$row->add($subject);
		$row->add($date);
		
		return $row;
	}
		
	function add_notices()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$notice_array=($this->getViewVariable('notice_array'));
		$table->add($this->add_noticeHead());
		for ($i=0; $i < count($notice_array); $i++) 
		{
			$table->add($this->add_notice($notice_array[$i]['notice.author'], 
										$notice_array[$i]['notice.text'], 
										$notice_array[$i]['notice.time'],
										$notice_array[$i]['notice.notice_id'])
								);
		}
		
		return $table;
	}

	function add_candidateHead()
	{
        //$check = html_input('radio','');
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
		//$dni = html_td("", "", html_b('DNI'));
		//$dni->set_tag_attribute("bgcolor","#808080");
		$nombre = html_td("", "", html_b('Nombre'));
		$nombre->set_tag_attribute("bgcolor","#808080");
		$surname = html_td("", "", html_b('Apellido'));
		$surname->set_tag_attribute("bgcolor","#808080");

		//$dni->set_tag_attribute('width','10%');
		$nombre->set_tag_attribute('width','30%');

		//$row->add($dni);
		$row->add($nombre);
		$row->add($surname);
		
		return $row;
	}
	
	function add_candidate($strDni, $strName, $strSurname, $id)
	{
        //$check = html_input('radio','');
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');      
		$name = html_td('', '', html_a(Util::format_URLPath('newUser/index.php',"id_cand=$id"),$strName));
		//$dni = html_td('', '', $strDni);
		$surname = html_td('', '', $strSurname);

		//$color = 'CECECE';
		$color = '#99CE99';
		$name->set_tag_attribute('bgcolor',$color);  	
		//$dni->set_tag_attribute('bgcolor',$color);
		$surname->set_tag_attribute('bgcolor',$color);

		//$dni->set_tag_attribute('width','10%');
		$name->set_tag_attribute('width','30%');
		//$surname->set_tag_attribute('width','60%');
	
		//$row->add($dni);
		$row->add($name);
		$row->add($surname);
		
		return $row;
	}
		
	function add_candidates()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$notice_array=($this->getViewVariable('candidates_array'));
		$table->add($this->add_candidateHead());
		for ($i=0; $i < count($notice_array); $i++) {
					$table->add($this->add_candidate($notice_array[$i]['candidate.dni'], 
													$notice_array[$i]['candidate.person_name'], 
													$notice_array[$i]['candidate.person_surname'],
													$notice_array[$i]['candidate.person_id'])
										);
		}
		return $table;
	}

	function add_resume($strName, $strNumber)
	{
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
		$name = html_td("", "", $strName);
		$number = html_td("", "", $strNumber);
		$name->set_tag_attribute('width','80%');
		$row->add($name);
		$row->add($number);		
		
		return($row);
	}
		
	function left_section()
	{
	    //Crea el contenedor del right_block
        $ret_val = html_div();

		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);

		$arrMessages = $this->getViewVariable('arrMessages');
		$unreaded=count($arrMessages);
		//Si es 1 hay que mirar que no sea nulo
		if ($unreaded == 1 && $arrMessages[0]['message.id']==null) {
			$unreaded=0;
		}
		$table->add($this->add_resume('Mensajes', $unreaded));
		
		$notice_array=($this->getViewVariable('notice_array'));
		$unreaded=count($notice_array);
		//Si es 1 hay que mirar que no sea nulo
		if ($unreaded == 1 && $notice_array[0]['notice.author']==null) {
			$unreaded=0;
		}
		$table->add($this->add_resume('Tablón de anuncios', $unreaded));
		
		$candidates_array=($this->getViewVariable('candidates_array'));
		$unreaded=count($candidates_array);
		//Si es 1 hay que mirar que no sea nulo
		if ($unreaded == 1 && $candidates_array[0]['candidate.dni']==null) {
			$unreaded=0;
		}
		$table->add($this->add_resume('Candidatos', $unreaded));
		
		$fieldset = html_fieldset();
		$fieldset->add(html_b('Para hoy'));
		$fieldset->add($table);

		$ret_val->add($fieldset);		
        //EnvÃŒa el contenedor del bloque right para que sea renderizado por el sistema
        return $ret_val;
	}

	function right_section()
	{
       	$ret_val = html_div();
		$ret_val->set_id('content');		
		
        $div = html_div();
   
		$status = $this->getViewVariable('status');
		
   		switch($status) {
			case 'menu':
			default:  
				$arrMessages = $this->getViewVariable('arrMessages');
				$unreaded=count($arrMessages);
				//Si es 1 hay que mirar si no es nulo
				if ($unreaded == 1 && $arrMessages[0]['message.id']==null){
						$unreaded=0;
					}
				$div->add($this->add_sectionHead('Mensajería ' . "($unreaded)",'modules/email.png'));      	
				$div->add($this->add_inbox());
				
				$div->add(html_br(2));
				$div->add(html_hr());
				$notice_array=($this->getViewVariable('notice_array'));
				$unreaded=count($notice_array);
				//Si es 1 hay que mirar que no sea nulo
				if ($unreaded == 1 && $notice_array[0]['notice.author']==null) {
					$unreaded=0;
				}
				$div->add($this->add_sectionHead('Tablón de anuncios ' . "($unreaded)",'modules/announces.png'));      	
				$div->add($this->add_notices());
							
							
				$div->add(html_br(2));
				$div->add(html_hr());
				$candidates_array=($this->getViewVariable('candidates_array'));
				$unreaded=count($candidates_array);
				//Si es 1 hay que mirar que no sea nulo
				if ($unreaded == 1 && $candidates_array[0]['candidate.dni']==null) {
					$unreaded=0;
				}
				$div->add($this->add_sectionHead('Candidatos ' . "($unreaded)",'modules/inscription.png'));      	
				$div->add($this->add_candidates());
				break;
		}

		$ret_val->add($div);
        
        return $ret_val;
	}	

    function right_block() 
    {
		$main = container();
		
		$hr = html_hr();
		$hr->set_tag_attribute('noshade');
		$hr->set_tag_attribute('size', 2);
		
		$main->add($hr);
		
		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
		$table->set_class('simple');
		
		$elem1 = html_td('', '', $this->left_section());
		$elem1->set_tag_attribute('width', '20%');
		$elem1->set_tag_attribute('valign', 'top');
		$elem2 = html_td('', '',$this->right_section());
		$elem2->set_tag_attribute('valign', 'top');
		
		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);
	
		$table->add_row($row);
		
		$main->add( $table );
		
		return $main;
    }
}
?>