<?php
/*
      +----------------------------------------------------------------------+
      |teacherPage/view                                                      |
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

class miguel_VTeacherPage extends miguel_VMenu
{
	function miguel_VTeacherPage($title, $arr_commarea)
	{
		$this->miguel_VMenu($title, $arr_commarea);
	}
	
	function add_head()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$table->set_tag_attribute('border');
		$progress = html_td("", "", html_b('Mi progreso'));
		//$name->set_tag_attribute("bgcolor","808080");
		$progress->set_tag_attribute('colspan',2);
		$state = html_td("", "", html_b('Estado Actual'));
		$state->set_tag_attribute("width","50%");
		$continue = html_td("", "", html_b('Continuar'));
		  
		//$icon->set_tag_attribute("bgcolor","808080");
		$table->add_row($progress);
		$table->add_row($state, $continue);
 		return $table;
	}
		
	function add_sectionHead($strName, $strIcon)
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
	    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
		$name = html_td("", "", html_b($strName));
		$name->set_tag_attribute("width","30%");
		$icon = html_td("", "", Theme::getThemeImage($strIcon));
		$icon->set_tag_attribute("width","70%");
		$icon->set_tag_attribute("align","right");
		  
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
		$from = html_td("", "", html_b($from_to));
		$from->set_tag_attribute("bgcolor","#808080");
		$subject = html_td("", "", html_b('Subject'));
		$subject->set_tag_attribute("bgcolor","#808080");
		$date = html_td("", "", html_b('Time'));
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

		if ($arrMessages[0]['user.user_alias']!=null) {
			$table->add($this->add_mailHead('From'));
			for ($i=0; $i<count($arrMessages); $i++) {
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

	function add_noticeHead($from_to)
	{
        //$check = html_input('radio','');
		$row = html_tr();
        $row->set_class('');
        $row->set_id('');
		$from = html_td("", "", html_b($from_to));
		$from->set_tag_attribute("bgcolor","#808080");
		$subject = html_td("", "", html_b('Subject'));
		$subject->set_tag_attribute("bgcolor","#808080");
		$date = html_td("", "", html_b('Time'));
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
		$table->add($this->add_noticeHead('From'));
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
		
		$fieldset = html_fieldset();
		$fieldset->add(html_b('Para hoy'));
		$fieldset->add($table);

		$ret_val->add($fieldset);		

		return $ret_val;
	}

	function right_section()
	{
		$ret_val = html_div();
		$ret_val->set_id('content');		
		
        $div = html_div();
		$status = $this->getViewVariable('status');

		switch($status)
		{
			case 'menu':
			default:  
				$div->add($this->add_head());      	

				$div->add(html_br(2));
				$div->add(html_hr());
				$arrMessages = $this->getViewVariable('arrMessages');
				$unreaded=count($arrMessages);
				//Si es 1 hay que mirar si no es nulo
				if ($unreaded == 1 && $arrMessages[0]['message.id']==null) {
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