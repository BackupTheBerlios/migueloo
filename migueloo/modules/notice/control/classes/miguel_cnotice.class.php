<?php
/*
      +----------------------------------------------------------------------+
      |notice/controller                                                     |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, SHS Polar Sistemas Inform�ticos, S.L.            |
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

class miguel_CNotice extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CNotice() 
	{	
		$this->miguel_Controller();
		$this->setModuleName('notice');
		$this->setModelClass('miguel_MNotice');
		$this->setViewClass('miguel_VNotice');
		$this->setCacheFlag(false);
	}
	
	function processPetition() 	
	{ 
		//Consultar la variable status. Si no existe se establece a 'men�' 
	  if ($this->issetViewVariable('status'))
	  {
	  	$status = $this->getViewVariable('status');
	  }
	  else
	  {
	  	$status = 'menu';
	  	$status = $this->setViewVariable('status', 'menu');
	  }
	  
	  //Debug::oneVar($status, __FILE__, __LINE__);
	  
    //En la barra de navegaci�n superior, la que se usa para no perdernos. A�ade un enlace a esta barra de enlaces.
	  $this->addNavElement(Util::format_URLPath('notice/index.php'), 'Tabl�n de anuncios');	

	  //Seg�n el valor de status abrir una u otra vista
	  switch($status)
	  {
	  	case 'new': //Nuevo comentario
	   		$this->processPetitionNew();
	   		$this->addNavElement(Util::format_URLPath('notice/index.php', 'status=new'),'Nuevo comentario');
	  		break;
	  	case 'list': //Listar comentarios
  	   	$NoticeArray = $this->obj_data->getNotices();
      	$this->setViewVariable('notice_array', $NoticeArray);
	   		$this->addNavElement(Util::format_URLPath('notice/index.php', 'status=list'),'Ver comentarios');
	  		break;
	  	case 'show':
			  if ($this->issetViewVariable('id'))
			  {
			  	$id = $this->getViewVariable('id');
 		 	   	$NoticeArray = $this->obj_data->getNotice($id);
    	  	$this->setViewVariable('author', $NoticeArray[0]['notice.author']);
      		$this->setViewVariable('subject', $NoticeArray[0]['notice.subject']);
      		$this->setViewVariable('time', $NoticeArray[0]['notice.time']);
      		$this->setViewVariable('text', $NoticeArray[0]['notice.text']); 		
      	}     	
	  		break;
	  	case 'menu': //Ver men� de opciones
	  	default:
	  		break;
		}
  
  	//Establecer el t�tulo de la p�gina
		$this->setPageTitle("miguel Notice Page");
	  $this->setMessage("Tabl�n de anuncios de miguel");

    //Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
	  $this->setHelp("");

	}

	function processPetitionNew()
	{
	  	  $bol_cuestion = true;
        
				//Comprueba el contenido de la Variable nombre. Esta se le pasa como entrada al controlador y puede venir de un formulario o un link
	  		if( $this->issetViewVariable('asunto') && $this->getViewVariable('asunto') != '')
		    {
		     	if( $this->issetViewVariable('comentario') && $this->getViewVariable('comentario') != '')
					{
  	  	       //Poner control
		  	       $bol_cuestion = false;

							 $now = date("Y-m-d H:i:s");
    			  	 $strAuthor = Session::getValue('USERINFO_USER_ALIAS');
    			  	 $strSubject = $this->getViewVariable('asunto');
    			  	 $strText = $this->getViewVariable('comentario');
    			  	 
               //Realizamos una llamada al Modelo $this->obj_data->M�todo(Par�metros);
		  	       $this->obj_data->insertSugestion($strAuthor, $strSubject, $strText, $now);


               //Enviamos a la vista la informaci�n a Mostrar
		  	       //$this->setViewVariable('notice_nombre', $this->arr_form['nombre']);
		  	       //$this->setViewVariable('notice_comentario', $this->arr_form['comentario']);
					} 
	     	}
				
 	      //Si est� relleno se muestra el contenido
 	      if (!$bol_cuestion)
				{
    	  	$this->setViewVariable('author', $strAuthor);
      		$this->setViewVariable('subject', $strSubject);
      		$this->setViewVariable('time', $now);
      		$this->setViewVariable('text', $strText); 	
					$this->setViewVariable('status', 'show');
				}
	}
}
?>