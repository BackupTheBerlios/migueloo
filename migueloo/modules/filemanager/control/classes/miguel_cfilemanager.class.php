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
 * Define la clase base de miguel.
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 *
 */

class miguel_CFileManager extends miguel_Controller
{	
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CFileManager()
	{	
		$this->miguel_Controller();
		$this->setModuleName('filemanager');
		$this->setModelClass('miguel_MFileManager');
		$this->setViewClass('miguel_VFileManager');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
		/* ----------------- COMPRUEBA EL ACCESO AL MODULO E INICIALIZA --------------- */
		//Se controla que el usuario no tenga acceso.
		$bol_hasaccess = false;


		//Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
		$user_id = $this->getSessionElement( 'userinfo', 'user_id' );
        $course_id = $this->getSessionElement( 'courseinfo', 'course_id');
		//Para maqueta
		if(empty($course_id)){
			$course_id = 7;
		}

		if ( isset($user_id) && $user_id != '' ) {
			$bol_hasaccess = true;
			$user = $this->getSessionElement( 'userinfo', 'user_alias' );
		} 

		$this->clearNavBarr();

		if($bol_hasaccess) {
			if ( $this->issetViewVariable('submit') ) {
				/* ----------- CREA UN DIRECTORIO -------------- */
				if ( $this->issetViewVariable('foldername') ) {
						$this->setViewVariable('folder_id', $this->obj_data->insertFolder( $this->getViewVariable('folder_id'), $course_id, $this->getViewVariable('foldername'), $user_id ));
				}
	
				/* ----------- ENVÍO DE FICHEROS -------------- */
				if ( $_FILES['filename']['tmp_name'] != null ) {
					include_once (Util::app_Path("filemanager/include/classes/filemanager.class.php"));
					if ( !$this->getViewVariable('filezip') ) {
						fileManager::uploadFile($_FILES['filename']);
						$this->obj_data->insertFile($_FILES['filename']['name'], $_FILES['filename']['type'], $course_id, $this->getViewVariable('folder_id'), $user_id, $_FILES['filename']['size']);
					} else {
						$listUploadFiles = fileManager::uploadFileZip( $_FILES['filename'] );
						$listCount = count( $listUploadFiles );
						for ($i = 0; $i < $listCount; $i++) {
							if ( !$listUploadFiles[$i]['folder'] ) {
								//$parent_folder_id -> se busca dirname() en $listFolder[ruta_completa] y obtenemos el id y el nombre
								$this->obj_data->insertFile(basename($listUploadFiles[$i]['stored_filename']), '', $course_id, $this->getViewVariable('folder_id'), $user_id );
							} else {
								$this->obj_data->insertFolder( $this->getViewVariable('folder_id'), $course_id, $this->getViewVariable('foldername'), $user_id );
								//Creamos una lista folder - (id - folder_name - folder_ruta_completa), necesaria para mantener la profundidad
								//folder_name -> basename( ruta ), parent_folder_name -> basename( dirname(ruta) )
								$listFolder[] = array( basename( dirname($listUploadFiles[$i]['stored_filename']) ), $lastIdFolder );
							}
						}
					}
				}
	
				/* ------------ OTRAS OPERACIONES ARCHIVOS Y DIRECTORIOS CON FORMULARIO INTERMEDIO-------------- */
				/* Eliminar, Renombrar, Comentar, Mover, Hacer visible, Bloquear, Compartir, ¿Actualizar y guardar un log de cambios o control de versiones? */
                                if ( $this->issetViewVariable('status') ) {
                                    $status = $this->getViewVariable('status');
                                    switch ( $status ) {
                                        case 'rename':
                                            if($this->getViewVariable('tp') == 'f'){
                                                    $this->obj_data->renameFolder($this->getViewVariable('id'), $this->getViewVariable('newname'));
                                            } else {
                                                    $this->obj_data->renameFile($this->getViewVariable('id'), $this->getViewVariable('newname'));
                                            }
                                            break;
                                    }
                                    $status = null;
                                    unset( $status );
                                }
				/* Debería retornar un valor error o estado de la operación y notificarlo en la carga del módulo */
			}

			/* ------------------ OPERACIONES REALIZADAS DIRECTAMENTE ---------*/
			if ( $this->issetViewVariable('status') ) {
                            $status = $this->getViewVariable('status');
                            switch ( $status ) {
				case 'del':
					if($this->getViewVariable('tp') == 'f'){
						$this->obj_data->deleteFolder($this->getViewVariable('id'));
					} else {
						$this->obj_data->deleteFile($this->getViewVariable('id'));
					}
                                        break;
                                case 'visible':
                                        if($this->getViewVariable('tp') == 'f'){
                                                $this->obj_data->visibleElement($this->getViewVariable('id'), 1, 'folder');
                                        } else {
                                                $this->obj_data->visibleElement($this->getViewVariable('id'), 1, 'document');
                                        }
                                        break;
                                case 'invisible':
                                        if($this->getViewVariable('tp') == 'f'){
                                                $this->obj_data->visibleElement($this->getViewVariable('id'), 0, 'folder');
                                        } else {
                                                $this->obj_data->visibleElement($this->getViewVariable('id'), 0, 'document');
                                        }       
                                        break;
                                case 'lock':
                                        $this->obj_data->lockDocument($this->getViewVariable('id'), 1);
                                        break;
                                case 'unlock':
                                        $this->obj_data->lockDocument($this->getViewVariable('id'), 0);
                                        break;
                                case 'share':
                                        $this->obj_data->shareDocument($this->getViewVariable('id'), 1);
                                        break;
                                case 'unshare':
                                        $this->obj_data->shareDocument($this->getViewVariable('id'), 0);
                                        break;
                            }
                        }
			if ( $this->issetViewVariable("folder_id") != "" ) {
				$current_folder_id = $this->getViewVariable("folder_id");
			} else {
				//$current_folder_id = $this->obj_data->getFolderId($course_id);//0;
                                $current_folder_id = 0;
			}
			$current_folder_info = $this->obj_data->getFolderName( $current_folder_id );
				
			$this->setViewVariable('current_folder_name', $current_folder_info[0]['folder_name']);
			$this->setViewVariable('folder_parent_id', $current_folder_info[0]['folder_parent_id']); 

			$this->setViewVariable('arr_files', $this->obj_data->getFileList( $course_id, $current_folder_id) );
			$this->setViewVariable('arr_folders', $this->obj_data->getFolderList( $course_id, $current_folder_id) );

			$this->setViewVariable('folder_id', $current_folder_id);
			$this->setViewVariable('operation_id', $this->getViewVariable('operation_id') );
		
			$this->setCacheFile("miguel_VFileManager" . $this->getSessionElement("userinfo", "user_id"));
			//$this->setMessage(agt("miguel_fileManager"));
			$this->setPageTitle("miguel_fileManager");
		} else {
			$this->giveControl('main', 'miguel_CMain');
		}
		
		$this->addNavElement(Util::format_URLPath('filemanager/index.php'), agt("Mis documentos") );
		$this->setCacheFlag(true);
		$this->setHelp("EducFileManager");                
    }
}
?>
