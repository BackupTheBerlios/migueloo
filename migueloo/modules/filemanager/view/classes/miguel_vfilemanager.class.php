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
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla comË™n para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentarÂÂ· la informaciÃ›n
 *  + Bloque de pie en la parte inferior
 *
 * --------------------------------
 * |         header block         |
 * --------------------------------
 * |                              |
 * |         data block           |
 * |                              |
 * --------------------------------
 * |         footer block         |
 * --------------------------------
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Antonio F. Cano Damas  <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VFileManager extends miguel_VMenu
{
        function miguel_VFileManager($title, $arr_commarea)
        {
                $this->miguel_VMenu($title, $arr_commarea);
        }

        function addDocuments()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $table->add($this->addDocumentTitle());

                $arr_data = $this->getViewVariable('arr_folders');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);
                if ($arr_data[0]['folder_name'] != null) {
                        for ($i=0; $i<count($arr_data); $i++) {
                                //Debug::oneVar($arr_data[$i], __FILE__, __LINE__);
                                $table->add($this->addDocumentInfo($arr_data[$i]['folder_id'],
                                                                                        $arr_data[$i]['folder_name'],
                                                                                        $arr_data[$i]['folder_date'],
                                                                                        $arr_data[$i]['folder_autor'],
                                                                                        0,
                                                                                        $arr_data[$i]['folder_count_element'],
                                                                                        true));
                        }
                        //$bol_hasFolders = true;
                } /*else {
                        $bol_hasFolders = false;
                }*/

                $arr_data = $this->getViewVariable('arr_files');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);
                if ($arr_data[0]['document_name'] != null) {
                        for ($i=0; $i<count($arr_data); $i++) {
                                //Debug::oneVar($arr_data[$i], __FILE__, __LINE__);
                                $table->add($this->addDocumentInfo($arr_data[$i]['document_id'],
                                                                                        $arr_data[$i]['document_name'],
                                                                                        $arr_data[$i]['document_date'],
                                                                                        $arr_data[$i]['document_autor'],
                                                                                        0,
                                                                                        $arr_data[$i]['document_size']));
                        }
                } /*else {
                        if(!$bol_hasFolders){
                                $table->add(html_td('ptabla02', '', 'El directorio está vacio'));
                        }
                }*/

                return $table;
        }

        function addDocumentTitle()
        {
                $folder_parent_id = $this->getViewVariable('folder_parent_id');
                if($folder_parent_id != 0 ){
                        $link = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id, 'folder_id=' . $folder_parent_id),
                                                                                                                Theme::getThemeImagePath('img_carpeta_up.png'), agt('Subir'), 15, 12); //filemanager/parentdir.png
                        //$image = Theme::getThemeImage("filemanager/parentdir.png"); //img_carpeta.jpg //boton_arriba.gif
                        //$link = html_a(Util::format_URLPath('filemanager/index.php', 'folder_id=' . $folder_parent_id), $image, null, '_top');
                } else {
                        $link = _HTML_SPACE;
                }

                //Titulo de tabla
                $row = html_tr();
                $row->set_class('ptabla02');
                $elem1 = html_td('ptabla02', "", $link);
                $elem2 = html_td('ptabla02', "", html_p(agt('Tipo')));
                $elem3 = html_td('ptabla02', "", html_p(agt('Nombre')));
                $elem4 = html_td('ptabla02', "", html_p(agt('Fecha')));
                $elem5 = html_td('ptabla02', "", html_p(agt('Autor')));
                $elem6 = html_td('ptabla02', "", html_p(agt('Descargas')));
                $elem7 = html_td('ptabla02', "", html_p(agt('Tamaño')));
                $elem8 = html_td('ptabla02', "", _HTML_SPACE);
                $elem9 = html_td('ptabla02', "",_HTML_SPACE);

                $elem1->set_tag_attribute('width', '1%');
                $elem2->set_tag_attribute('width', '1%');
                $elem3->set_tag_attribute('width', '20%');
                $elem4->set_tag_attribute('width', '10%');
                $elem5->set_tag_attribute('width', '20%');
                $elem6->set_tag_attribute('width', '5%');
                $elem7->set_tag_attribute('width', '5%');
                $elem8->set_tag_attribute('width', '1%');
                $elem9->set_tag_attribute('width', '1%');

                $row->add($elem1);
                $row->add($elem2);
                $row->add($elem3);
                $row->add($elem4);
                $row->add($elem5);
                $row->add($elem6);
                $row->add($elem7);
                $row->add($elem8);
                $row->add($elem9);

                return $row;
        }

        function addDocumentInfo($_id, $_name, $_date, $_owner, $_downs, $_size, $_folder = false)
        {
                $row = html_tr();

                $elem1 = html_td('ptabla03', '', _HTML_SPACE);

                if($_folder){
                        $link = $this->imag_alone(Util::format_URLPath('filemanager/index.php',"folder_id=$_id"),
                                                                                                                Theme::getThemeImagePath('img_carpeta.jpg'), agt('Entrar'));
                } else {
                        include_once (Util::app_Path("filemanager/include/classes/filedisplay.class.php"));
                        $image =  Theme::getThemeImagePath("filemanager/" . fileDisplay::choose_image($_name));

                        $link = html_a("#","");
                        $link->add(html_img($image,16,16,null,agt('Ver')));
                        $path_action = Util::main_URLPath('var/data/'.$_name);
                        $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."',750,400,25,100)");
                }
                $elem2 = html_td('ptabla03', '', $link);
                $elem2->set_tag_attribute('align', 'center');

                $elem3 = html_td('ptabla03', '', $_name);
                $elem4 = html_td('ptabla03', '', $_date);
                $elem5 = html_td('ptabla03', '', $_owner);
                $elem6 = html_td('ptabla03', '', $_downs);
                $elem7 = html_td('ptabla03', '', $_size);

                if(!$_folder){
                        $link = html_a("#","");
                        $link->add(html_img(Theme::getThemeImagePath('disquette.jpg'),null,null,null,agt('Descargar')));
                        $path_action = Util::main_URLPath('var/data/'.$_name);
                        $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."',750,400,25,100)");
                } else {
                        $link = _HTML_SPACE;
                }
                $elem8 = html_td('ptabla03', '', $link);
                $elem8->set_tag_attribute('align', 'center');

                $_fid = $this->getViewVariable('folder_id');

                if($_folder){
                        $status = 'folder_id='.$_fid.'&status=del&tp=f&id=';
                } else {
                        $status = 'folder_id='.$_fid.'&status=del&tp=d&id=';
                }
                $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                                                                                                Theme::getThemeImagePath('boton_papelera.gif'), agt('Borrar'));
                $elem9 = html_td('ptabla03', '', $img); //eliminar.jpg //html_img(Theme::getThemeImagePath('boton_papelera.gif'))
                $elem9->set_tag_attribute('align', 'center');

                $row->add($elem1);
                $row->add($elem2);
                $row->add($elem3);
                $row->add($elem4);
                $row->add($elem5);
                $row->add($elem6);
                $row->add($elem7);
                $row->add($elem8);
                $row->add($elem9);

                return $row;
        }

        function _operationForm()
        {
                if ($this->issetViewVariable('operation_id') ) {
                        switch ($this->getViewVariable('operation_id') ) {
                                case 'newFolder':
                                        $ret_val = $this->addForm('filemanager', 'miguel_newFolderForm');
                                        break;
                                case 'submitFile':
                                        $ret_val = $this->addForm('filemanager', 'miguel_submitFileForm');
                                        break;
                        }
                } else {
                        $ret_val = $this->addOperationBar();
                }

                return $ret_val;
    }

        function addOperationBar()
        {
                $current_folder_id = $this->getViewVariable('folder_id');
                $ret_val = html_tr();

                $content = container();

                $link1 = html_a(Util::format_URLPath('filemanager/index.php', 'folder_id=' . $current_folder_id . '&amp;operation_id=newFolder'), agt('Nueva carpeta'), 'p', '_top');
                $link2 = html_a(Util::format_URLPath('filemanager/index.php', 'folder_id=' . $current_folder_id . '&amp;operation_id=submitFile'), agt('Añadir documento'), 'p', '_top');

                $content->add( $link1);
                $content->add(_HTML_SPACE);
                $content->add($link2);

                $ret_val->add(html_td('ptabla03', '', $content));
                return $ret_val;
        }


    function content_section()
    {
        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
        $title = agt('Mis documentos');//.'/'.$this->getViewVariable('current_folder_name');

        $table->add_row(html_td('ptabla01', '', $title));

        $table->add_row(html_td('ptabla03', '', $this->addDocuments() ));
        //$table->add_row(html_td('ptabla03', '', $this->init_content() ));
        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row($this->_operationForm());
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row(html_td('ptabla01pie', '', $title));

        return $table;
    }

    function right_block()
        {
                //Crea el contenedor del right_block
                $main = container();

                // $main->add(html_hr());
                $main->add($this->add_mainMenu());

                //Titulo

                //$titulo = html_p(agt('Biblioteca'));
                $titulo = html_br();
                //$titulo->set_class('ptabla01');
                $main->add($titulo);

                $main->add($this->content_section());

                $main->add(html_br());

                $div_line = html_div();
                $div_line->set_tag_attribute('align', 'left');
                $div_line->add(html_img(Theme::getThemeImagePath("hr01.gif"), 400, 15));
                $main->add($div_line);

                $main->add(html_br());


                return $main;
        }

        function add_mainMenu()
        {
                $div = html_div('');
                $div->add(html_br());

                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $row = html_tr();
                $blank = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif"),10,10));
                //$blank->set_tag_attribute('colspan','4');

                $image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif"), 20, 14));
                $image->set_tag_attribute('align', 'right');
                $image->set_tag_attribute('width', '40%');
		
		$item1 = html_td('', '', 'Mi progreso');
                $item1->set_tag_attribute('width', '12%');
		$item2 = html_td('', '', 'Mis accesos directos' );
                $item2->set_tag_attribute('width', '16%');
		$item3 = html_td('', '', 'Mis contactos');
                $item3->set_tag_attribute('width', '12%');
		$item4 = html_td('', '', 'Mis notas');
                $item4->set_tag_attribute('width', '10%');

                $link = html_a(Util::format_URLPath("filemanager/index.php"), agt('Mis documentos'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item5 = html_td('', '', $link);
                $item5->set_tag_attribute('width', '12%');

                $row->add($blank);
                $row->add($image);
                $row->add($item1);
                $row->add($item2);
                $row->add($item3);
		$row->add($item4);
		$row->add($item5);

                $table->add_row($row);

                $div->add($table);

                return $div;
        }
}

?>
