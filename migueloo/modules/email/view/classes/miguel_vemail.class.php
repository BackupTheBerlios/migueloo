<?php
/*
      +----------------------------------------------------------------------+
      |email                                                        |
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
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package email
 * @subpackage view
 * @version 1.0.0
 *
 */ 

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));
class miguel_VEmail extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El tâˆšÃ¥tulo para la pÂ¬âˆ‘gina
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesiâˆšÃµn).
     *
	 */
    function miguel_VEmail($title, $arr_commarea)
    {
        //Ejecuta el constructor de la superclase de la Vista
        $this->miguel_VMenu($title, $arr_commarea);
     }

		/*=======================================================
			Añadir cabecera
			========================================================*/

		function add_head($from_to, $bStatus)
		{
        //$check = html_input('radio','');
		    $row = html_tr();
        $row->set_class('');
        $row->set_id('');
				$from = html_td("", "", html_b($from_to));
			  $from->set_tag_attribute("bgcolor","808080");
				$subject = html_td("", "", html_b('Asunto'));
			  $subject->set_tag_attribute("bgcolor","808080");
				$date = html_td("", "", html_b('Hora'));
			  $date->set_tag_attribute("bgcolor","808080");
				$delete = html_td("", "", '');
			  $delete->set_tag_attribute("bgcolor","808080");
  			if ($bStatus)
  			{
					$status = html_td("", "", html_b('Estado'));
			  	$status->set_tag_attribute("bgcolor","808080");
				  $row->add($status);
				}
			  $row->add($from);
			  $row->add($subject);
			  $row->add($date);
			  $row->add($delete);
 			 	
 			 	return $row;
		}

		/*=======================================================
			Añadir un fila con información de un mensaje
			========================================================*/

		function add_emailInfo($_from, $_subject, $_date, $_id_msg, $_mailStatus)
		{
        //$check = html_input('radio','');
		    $row = html_tr();
        $row->set_class('');
        $row->set_id('');      
        $status=$this->getViewVariable('status');
				$from = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=new&to=$_from"),$_from));
				$subject = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=show&id=$_id_msg"),$_subject));
				//$date = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=show&id=$_id_msg"),$_date));
				$date = html_td('', '', $_date);
				$delete = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=$status&delete_id=$_id_msg"),'Delete'));
			  //$row->add($check);

		  	//$from->set_tag_attribute("bgcolor","#CECE99");
		  	
		  	
		  	
		  	switch ($_mailStatus)
		  	{
					case null: //No se incluye icono de estado.
					default:
					  $date->set_tag_attribute("bgcolor","#99CE99");
					  $subject->set_tag_attribute("bgcolor","#99CE99");
					  $from->set_tag_attribute("bgcolor","#99EE99");
					  break;	  	
		  		case 0: //No leído
					  $date->set_tag_attribute("bgcolor","#FFCE99");
					  $subject->set_tag_attribute("bgcolor","#FFCE99");
					  $from->set_tag_attribute("bgcolor","#FFEE99");
					  $imgStatus=html_img(Theme::getThemeImagePath('modules/noreaded.jpg'));
  					$row->add($imgStatus);		  
					  break;
					case 1: //Leído
					  $date->set_tag_attribute("bgcolor","#99CE99");
					  $subject->set_tag_attribute("bgcolor","#99CE99");
					  $from->set_tag_attribute("bgcolor","#99EE99");
					  $imgStatus=html_img(Theme::getThemeImagePath('modules/readed.jpg'));
  					$row->add($imgStatus);		  
						break;		  
				}

		  	$from->set_tag_attribute("width","20%");
		  	$subject->set_tag_attribute("width","40%");
		  	$date->set_tag_attribute("width","20%");
		
			  $row->add($from);
			  $row->add($subject);
			  $row->add($date);
			  $row->add($delete);
			 	
 			 	return $row;
		}
		
		/*=========================================================
			Muestra la bandeja de entrada
		===========================================================*/
		function add_inbox()
		{
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				$arrMessages = $this->getViewVariable('arrMessages');

				if ($arrMessages[0]['user.user_alias']!=null)
				{			
					$table->add($this->add_head('De', true));
					for ($i=0; $i<count($arrMessages); $i++)
					{
						//Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
						$table->add($this->add_emailInfo($arrMessages[$i]['user.user_alias'],
																					 $arrMessages[$i]['message.subject'],
																					 $arrMessages[$i]['message.date'],
																					 $arrMessages[$i]['message.id'],
																					 $arrMessages[$i]['receiver_message.status']));
					}
				}
				else
				{
					$table->add('La carpeta está vacía');
				}
					
			
				return $table;
		}

		/*=========================================================
			Muestra la bandeja de salida
		===========================================================*/
		function add_outbox()
		{
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				$arrMessages = $this->getViewVariable('arrMessages');
				//Si no está vacía

				if ($arrMessages[0]['user.user_alias']!=null)
				{
					$table->add($this->add_head('Para', false));
				
					for ($i=0; $i<count($arrMessages); $i++)
					{
						//Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
						$table->add($this->add_emailInfo($arrMessages[$i]['user.user_alias'],
																					 $arrMessages[$i]['message.subject'],
																					 $arrMessages[$i]['message.date'],
																					 $arrMessages[$i]['message.id'],
																					 null));
					}
				}
				else
				{
					$table->add('La carpeta está vacía');
				}
			
				return $table;
		}

		/*=========================================================
			Muestra la lectura de un mail
		===========================================================*/
		function add_mailDetails()
		{
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				$table->add(html_b('De: '));
				$table->add($this->getViewVariable('from'));
				$table->add(html_br(2));
				$table->add(html_b('Para: '));
				$table->add($this->getViewVariable('to'));
				$table->add(html_br(2));
				$table->add(html_b('Hora: '));
				$table->add($this->getViewVariable('date'));
				$table->add(html_br(2));
				$table->add(html_b('Asunto: '));
				$table->add($this->getViewVariable('subject'));
				$table->add(html_br(2));
				$table->add(html_b('Cuerpo: '));
				$table->add($this->getViewVariable('body'));	
				return $table;
		}


		/*=========================================================
			Muestra la bandeja de salida
		===========================================================*/
		function add_bin()
		{
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				$arrMessages = $this->getViewVariable('arrMessages');
				
				if ($arrMessages[0]['user.user_alias']!=null)
				{
					$table->add($this->add_head('De/Para',false));
					for ($i=0; $i<count($arrMessages); $i++)
					{
						$table->add($this->add_emailInfo($arrMessages[$i]['user.user_alias'],
																						 $arrMessages[$i]['message.subject'],
																						 $arrMessages[$i]['message.date'],
																						 $arrMessages[$i]['message.id'],
																						 null));
					}
				}
				else
				{
					$table->add('La carpeta está vacía');
				}

				return $table;
		}

		/*=========================================================
			Muestra el formulario para enviar un nuevo mensaje
		===========================================================*/
		function add_menu()
		{
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		 		$table->add($this->icon_link(Util::format_URLPath('email/index.php', 'status=inbox'), 
								 					Theme::getThemeImagePath('modules/mail.jpg'), agt('miguel_Module') . 'Carpeta de entrada'));
				//Metemos el número de mails sin leer
				$table->add(html_b('(' . $this->getViewVariable('countUnreaded') . ')'));				 					
				$table->add(html_br(2));
		 		$table->add($this->icon_link(Util::format_URLPath('email/index.php', 'status=new'), 
								 					Theme::getThemeImagePath('modules/newmail.jpg'), agt('miguel_Module') . 'Enviar'));
				$table->add(html_br(2));
		 		$table->add($this->icon_link(Util::format_URLPath('email/index.php', 'status=outbox'), 
								 					Theme::getThemeImagePath('modules/output.jpg'), agt('miguel_Module') . 'Bandeja de salida'));
				$table->add(html_br(2));
		 		$table->add($this->icon_link(Util::format_URLPath('email/index.php', 'status=bin'), 
								 					Theme::getThemeImagePath('modules/bin.jpg'), agt('miguel_Module') . 'Papelera'));
				return $table;
		}


    /**
     * this function returns the contents
     * of the right block.  It is already wrapped
     * in a TD
     * Solo se define right_block porque heredamos de VMenu y el left_block se encuentra ya definido por defecto con el menË™ del sistema.
     * Si heredara de miguel_VPage entonces habrÃŒa que definir de igual forma right_block y main_block. Esta Ë™ltima es un contenedor de left_block y right_block
     * @return HTMLTag object
     */
    function right_block() 
    {
        //Crea el contenedor del right_block
        $ret_val = container();
		
        //Vamos a ir creando los distintos elementos (Estos a su vez son tambiÃˆn contenedores) del contenedor principal.
        //hr es una linea horizontal de HTML.
        $hr = html_hr();
        $hr->set_tag_attribute('noshade');
        $hr->set_tag_attribute('size', 2);

        //AÃ±ade la linea horizontal al contenedor principal
        $ret_val->add($hr);
		
        $div = html_div();

        //AÃ±ade una imagen del tema
        $div->add(Theme::getThemeImage('modules/email.png'));

        //Incluimos texto en negrita
        $div->add(html_b('Mensajería'));

        //Ahora dos retornos de carro
        $div->add(html_br(2));
    
     		$status = $this->getViewVariable('status');
    		switch($status)
        {
        	case 'menu':
        	default:  
							$div->add($this->add_menu());    
        			break;
        	case 'new':
        			//if ($this->issetViewVariable('bSended') && $this->getViewVariable('bSended'))
        			//{     			
	        			if ($this->issetViewVariable('strResult'))
  	      			{
  	      						$strResult = $this->getViewVariable('strResult');
        				    	$div->add("$strResult");			
        				}
        			//}
        			else
        			{
        					//$this->setViewVariable('from', Session::getValue('USERINFO_USER_ALIAS'));
           				$div->add($this->addForm('email', 'miguel_emailForm'));
    					}
    					break;
    			case 'show':
    						$div->add($this->add_mailDetails());
    					break;
					case 'inbox':
							$div->add($this->add_inbox());
							break;
					case 'outbox':
							$div->add($this->add_outbox());
							break;
					case 'bin':
							$div->add($this->add_bin());
							break;
				}
        	
				$ret_val->add($div);
        
		      
        //EnvÃŒa el contenedor del bloque right para que sea renderizado por el sistema
        return $ret_val;
    }
 
}

?>
