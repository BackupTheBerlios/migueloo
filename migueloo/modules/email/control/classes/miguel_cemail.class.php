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
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

//El controlador hereda de miguel_Controller la superclase controlador de miguelOO
class miguel_CEmail extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CEmail() 
	{	

    //Ejecuta el constructor de la clase padre
		$this->miguel_Controller();

    //Inicializamos algunas propiedades del módulo
    //Nombre del módulo, ha de coincidir con registry.xml
		$this->setModuleName('email');

    //Nombre de la clase del Modelo, el fichero será miguel_mtodo.class.php
		$this->setModelClass('miguel_MEmail');

    //Nombre de la clase Vista por defecto, como la página no se renderiza hasta el final de la ejecución esta puede cambiar en cualquier momento
		$this->setViewClass('miguel_VEmail');

     //Indicamos si deseamos Cachear la página
		$this->setCacheFlag(false);
	}
    
  /*=========================================================================
		Devuelve si la variable está inicializada y no es vacía
		=========================================================================*/
	function IsSetVar($var) 
	{
		return ($this->issetViewVariable($var) && $this->getViewVariable($var) != '');
	}

	/*=========================================================================
		Convierte una cadena de direcciones separadas por ';' en un array de identificadores de usuarios
		=========================================================================*/
	function ParserTo($strTo)
	{
			$arrRet = explode (";", $strTo); 
			for ($i=0; $i<count($arrRet); $i++)
			{
				//Quito los espacios
				$arrRet[$i] = trim($arrRet[$i]);
				
				//Convierto el alias en su identificador numérico
				$arrRet[$i] = $this->obj_data->getUserFromAlias($arrRet[$i]);
			}
			return($arrRet);
	}
	
	/*=========================================================================
		Envia un mensaje
		=========================================================================*/
	function SendMessage()
	{
        //Debug::oneVar($this->arr_form, __FILE__, __LINE__);
        
				$bSended = false;
		 		if($this->IsSetVar('to') && $this->IsSetVar('body') && $this->IsSetVar('subject'))
				{
					//Debug::oneVar($this->getViewVariable('to'), __FILE__, __LINE__);
					$arrId = $this->ParserTo($this->getViewVariable('to'));
					//Debug::oneVar($arrId, __FILE__, __LINE__);
	 	      if (count($arrId)>0)
 		      {       
              //Realizamos una llamada al Modelo $this->obj_data->Método(Parámetros);
		  	      if ($this->obj_data->sendMessage($arrId, 
																				$this->getViewVariable('subject'),
																				$this->getViewVariable('body')) != null)
							{
										$bSended = true;
				  					$this->setViewVariable('strResult','El mensaje fue enviado correctamente.');
				  		}
				  		else
				  		{
							  		$this->setViewVariable('strResult','Error enviando mensaje.');
				  		}
					}
					else
					{
				  		$this->setViewVariable('strResult','Destinatario desconocido.');
					}
	 	    }
	 	    return($bSended);	  
	}

	/*=========================================================================
		Obtiene información de un mensaje para mostrar su contenido
		=========================================================================*/
	function getShowData($id_msg)	
	{
 	      $arrMsg = $this->obj_data->getMessage($id_msg);
 	      $arrReceivers = $this->obj_data->getMessageReceivers($id_msg);
				
				//Componer la cadena de destinatarios
				for ($i=0; $i<count($arrReceivers); $i++)
				{
					$userAlias = $this->obj_data->getAliasFromUser($arrReceivers[$i]['receiver_message.id_receiver']); 
					$strTo = $strTo . $userAlias . ';';
				}
						
 	      if ($arrMsg != null)
 	      {	      	
 	      	//Cambiamos el estado del mensaje a leído.
 					$this->obj_data->changeMessageStatus($id_msg, 1);

 	      	$from=$this->obj_data->getAliasFromUser($arrMsg[0]['message.sender']);      	
					$this->setViewVariable('from', $from);	      	
 	      	//Debug::oneVar($from, __FILE__, __LINE__);
 	      	$this->setViewVariable('to', $strTo);
 	      	$this->setViewVariable('date', $arrMsg[0]['message.date']);
 	      	$this->setViewVariable('subject', $arrMsg[0]['message.subject']);
 	      	$this->setViewVariable('body', $arrMsg[0]['message.body']);
 	      }
 	      
	}
   
  /*=========================================================================
		Esta función ejecuta el Controlador 
		=========================================================================*/
	function processPetition() 	
	{
	
    //En la barra de navegación superior, la que se usa para no perdernos. Añade un enlace a esta barra de enlaces.

		//Consultar la variable status. Si no existe se establece a 'menú' 
	  if ($this->issetViewVariable('status'))
	  {
	  	$status = $this->getViewVariable('status');
	  }
	  else
	  {
	  	$status = 'menu';
	  	$status = $this->setViewVariable('status', 'menu');
	  }
	  $this->addNavElement(Util::format_URLPath('email/index.php'), 'Mensajería');	
		  
    
    switch($status)
	  {
	  	case 'new': //Nuevo comentario
	  		$strResult = $this->setViewVariable('bSended', $this->SendMessage());	
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=new'),'Enviar');
	  		break;
	  	case 'show':
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=show'),'Lectura'); 
	   		$this->getShowData($this->getViewVariable('id'));
	   		break; 		
	  	case 'inbox': //Listar comentarios
	  		//Si es necesario borrar algún correo se hace de forma lógica
		    if ($this->issetViewVariable('delete_id'))
    		{
	 					$this->obj_data->changeMessageStatus($this->getViewVariable('delete_id'), 2);
    		}
    		
				$arrMessages = $this->obj_data->getUserMessages();
	  		$this->setViewVariable('arrMessages', $arrMessages);
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=inbox'),'Bandeja de entrada');
	  		break;
	  	case 'outbox': //Listar comentarios
	  		//Si es necesario borrar algún correo se hace de forma lógica
		    if ($this->issetViewVariable('delete_id'))
    		{
	 					$this->obj_data->changeMessageStatus($this->getViewVariable('delete_id'), 2);
    		}

	  		$arrMessages = $this->obj_data->getSendedMessages();
	  		$this->setViewVariable('arrMessages', $arrMessages);
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=outbox'),'Bandeja de salida');
	  		break;
	  	case 'bin': //Listar comentarios
	  		//Si es necesario borrar algún correo se hace de forma definitiva
		    if ($this->issetViewVariable('delete_id'))
    		{
	 					$this->obj_data->deleteMessage($this->getViewVariable('delete_id'), 2);
    		}

	  		$arrMessages = $this->obj_data->getDeletedMessages();
	  		$this->setViewVariable('arrMessages', $arrMessages);
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=bin'),'Papelera');
	  		break;
	  	case 'menu': //Ver menú de opciones
	  	default:
	  		$this->setViewVariable('countUnreaded', $this->obj_data->getCountUnreaded());
	  		break;
		}
	
 
  	//Establecer el título de la página
		$this->setPageTitle("miguel Email Page");
	  $this->setMessage("Mensajería de miguel");

    //Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
	  $this->setHelp("");

	}
	
}
?>
