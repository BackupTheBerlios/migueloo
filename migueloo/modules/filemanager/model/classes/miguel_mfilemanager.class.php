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
class miguel_MFileManager extends base_Model
{
    function miguel_MFileManager()
    {
                $this->base_Model();
    }

    function getFileList( $current_course, $current_folder_id)
    {
        $document = $this->SelectMultiTable('fm_course_document_folder, fm_document',
                                           "fm_course_document_folder.document_id, fm_document.document_name, fm_document.document_size, fm_document.user_id,  fm_document.date_publish",
                                           'fm_course_document_folder.course_id = ' . $current_course . ' AND fm_course_document_folder.folder_id = ' . $current_folder_id . ' AND fm_course_document_folder.document_id = fm_document.document_id');
            if ($this->hasError()) {
                    $ret_val = null;
            }
        $countDocument = count($document);
        for ($i=0; $i < $countDocument; $i++) {
             $ret_val[] = array ( 'document_id' => $document[$i]['fm_course_document_folder.document_id'],
                                  'document_name' => $document[$i]['fm_document.document_name'],
                                  'document_size' => $document[$i]['fm_document.document_size'],
                                  'document_date' => $document[$i]['fm_document.date_publish'],
                                  'document_autor' => $this->_getNameFromUser($document[$i]['fm_document.user_id'])
                                );
        }

            return ($ret_val);
    }

    function _getFileCount($course_id, $folder_id)
    {
            $ret_val = $this->SelectCount('fm_course_document_folder', "course_id = $course_id AND folder_id = $folder_id");

            if ($this->hasError()) {
                    $ret_val = 0;
            }

            return $ret_val;
    }

    function _getFolderCount($course_id, $folder_id)
    {
                  $ret_val = $this->SelectCount('fm_folder', "course_id = $course_id AND folder_parent_id = $folder_id");

                if ($this->hasError()) {
                $ret_val = 0;
        }

        return $ret_val;
    }

    function getFolderList( $current_course, $current_folder_id)
    {
        //$current_course = 0;
        $folder = $this->Select("fm_folder", "folder_id, folder_name, folder_parent_id, folder_date, user_id",
                                "course_id = $current_course AND folder_parent_id = $current_folder_id");

        if ($this->hasError()) {
                $ret_val = null;
        }

        $countFolder = count($folder);
        for ($i=0; $i < $countFolder; $i++) {
             $fileCount = $this->_getFileCount( $current_course, $folder[$i]['fm_folder.folder_id']);
             $currentFolderCount = $this->_getFolderCount( $current_course, $folder[$i]['fm_folder.folder_id']);

             $ret_val[] = array ( 'folder_id' => $folder[$i]['fm_folder.folder_id'],
                                  'folder_name' => $folder[$i]['fm_folder.folder_name'],
                                  'folder_parent_id' => $folder[$i]['fm_folder.folder_parent_id'],
                                  'folder_date' => $folder[$i]['fm_folder.folder_date'],
                                  'folder_count_element' => $fileCount + $currentFolderCount,
                                  'folder_autor' => $this->_getNameFromUser($folder[$i]['fm_folder.user_id'])
                                );
        }

        return ($ret_val);
    }

        //Maqueta
        function getFolderId( $course_id )
    {
        $folder = $this->Select("fm_folder", "folder_id",
                                "course_id = $course_id and folder_parent_id = 0");

        if ($this->hasError()) {
                $ret_val = null;
        } else {
                              $ret_val = $folder[0]['fm_folder.folder_id'];
                }

        return ($ret_val);

    }
        //Maqueta

    function getFolderName( $folder_id )
    {
        $folder = $this->Select("fm_folder", "folder_name, folder_parent_id",
                                "folder_id = $folder_id");

        if ($this->hasError()) {
                $ret_val = null;
        }

        $countFolder = count($folder);
        for ($i=0; $i < $countFolder; $i++) {
             $ret_val[] = array ( 'folder_name' => $folder[$i]['fm_folder.folder_name'],
                                  'folder_parent_id' => $folder[$i]['fm_folder.folder_parent_id']);
        }

        return ($ret_val);

    }

    function insertFolder($parent_folder_id, $course_id, $folder_name, $user_id)
    {
		$now = date("Y-m-d");

		$ret_val = $this->Insert('fm_folder',
									'folder_parent_id, course_id, folder_name, user_id, folder_date',
									"$parent_folder_id,$course_id,$folder_name, $user_id, $now");
		
		
		if ($this->hasError()) {
				$ret_val = null;
		}
	
		return ($ret_val);

    }

    function insertFile($document_name, $document_mime, $course_id, $folder_id, $user_id, $size = 0)
    {
		$now = date("Y-m-d");

        $documentID = $this->Insert('fm_document',
                                 'document_mime, document_name, user_id, document_size, date_publish',
                                 "$document_mime, $document_name, $user_id, $size, $now");

        if ($this->hasError()) {
                $ret_val = null;
        } else {
            $ret_val = $this->Insert('fm_course_document_folder',
                                     'course_id, document_id, folder_id',
                                     "$course_id, $documentID , $folder_id");

            if ($this->hasError()) {
                    $ret_val = null;
            }
        }
        return ($ret_val);

    }
	
	function deleteFile($_id)
	{
		$show_sql = $this->Select('fm_document', 'document_name', "document_id = $_id");
				
		if ($this->hasError()) {
			$ret_val = null;
		} else {
			$sql_ret = $this->Delete('fm_document', "document_id = $_id");
	
			if ($this->hasError()) {
				$ret_val = null;
			} else {
				$file = Util::main_Path('var/data/'.$show_sql[0]['fm_document.document_name']);

				if(file_exists($file)){
					unlink($file);
				}
			}
		}
		
		return ($ret_val);	
	}
	
	function deleteFolder($_id)
	{
		$sql_ret = $this->Delete('fm_folder', "folder_id = $_id");
	
		if ($this->hasError()) {
			$ret_val = null;
		} else {
			$sql2_ret = $this->Delete('fm_course_document_folder', "folder_id = $_id");
			
			if ($this->hasError()) {
				$ret_val = null;
			}
		}
		
		return ($ret_val);	
	}


    function _getNameFromUser($user_id)
    {
            $arrUsers = $this->SelectMultiTable('user, person',
                                                 'person.person_name, person.person_surname, person.person_surname2',
                                                 "person.person_id = user.person_id and user.user_id = $user_id");

            if ($this->hasError() || count($arrUsers) == 0) {
               $ret_val = null;
            } else {
               $ret_val= $arrUsers[0]['person.person_name'].' '.$arrUsers[0]['person.person_surname'].' '.$arrUsers[0]['person.person_surname2'];
            }

            return $ret_val;
    }
}
?>