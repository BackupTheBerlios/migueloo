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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla com˙n para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentar· la informaciÛn
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
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
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

class miguel_VCourse extends miguel_VMenu 
{

	/**
	 * This is the constructor.
	 *
	 * @param string - $title - the title for the page and the
	 *                 titlebar object.
	 * @param - string - The render type (HTML, XHTML, etc. )	
	 *                   default value = HTML
     *
	 */
    function miguel_VCourse($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }
    
    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */
    function right_block() 
    {
        $ret_val = container();
		
        $hr = html_hr();
        $hr->set_tag_attribute("noshade");
        $hr->set_tag_attribute("size", 2);
	      $ret_val->add($hr);
		
	      $div = html_div();
 	      $div->add( Theme::getThemeImage('edcenters.png') );
        
        $infoCourse = $this->getViewVariable('infoCourse');
        $path_arr = $infoCourse['path'];       
        $strPath = $path_arr['institution'];
        if ( $path_arr['faculty'] != '' ) {
            $strPath .= '&nbsp;>&nbsp;';
        }
        $strPath .= $path_arr['faculty'];        
        if ( $path_arr['department'] != '' ) {
            $strPath .= '&nbsp;>&nbsp;';
        }
        $strPath .= $path_arr['department'];
        if ( $path_arr['area'] != '' ) {
            $strPath .= '&nbsp;>&nbsp;';
        }
        $strPath .= $path_arr['area'];
        $div->add( $strPath );
		
        $div->add(html_br());

        
        $div->add(Theme::getThemeImage('info.png', $infoCourse['name']) );
        $div->add(html_b(html_a(Util::format_URLPath("course/index.php", 'course=' . $infoCourse['course_id']), $infoCourse['name'])));
        $div->add(html_br());
        
        $mailLink = Theme::getMailURL($infoCourse['email'], Session::getValue('migueloo_userinfo_user_id') );        
        $div->add(html_b( agt('miguel_responsable') . ' '), html_a( $mailLink,  $infoCourse['user_responsable']));
        $div->add(html_br(2));
		
        $table = html_table("100%",0,8,0);
        $table->set_class("simple");
        $table->set_id("modules");
        $table->set_tag_attribute("valign", "top"); 
		
        $arr_elem = $this->_getModuleElements();
        $int_elem = count($arr_elem);

        for($i=0; $i<$int_elem; $i = $i+2){
            $row = html_tr();
			      $col = html_td("","left"); 
            $col->add( $this->imag_ref( Util::format_URLPath( $arr_elem[$i][0]), Theme::getThemeImagePath( $arr_elem[$i][1] ), agt('miguel_Module' . $arr_elem[$i][2]) ) );
            $row->add($col);

            $col = html_td("","left");
            if ( $arr_elem[$i+1][0] != ''  ){
			        $col->add( $this->imag_ref(Util::format_URLPath( $arr_elem[$i+1][0]), Theme::getThemeImagePath( $arr_elem[$i+1][1] ), agt( 'miguel_Module' . $arr_elem[$i+1][2]) ));
			        $row->add($col);
        	  }
       	    $table->add_row($row);      
    	  }
    	
        $div->add( $table );
        $ret_val->add($div);
            	
        return $ret_val;
    }
    
    /**
     * Obtiene los modulos a incluiren el ·rea principal
     * @internal
     */
    function _getModuleElements()
    {
    	$ret_val = null;
    	if(file_exists(Util::app_Path("course/include/moduleelements.data"))){
    		$str_content = File::Read(Util::app_Path("course/include/moduleelements.data"));
    	}
    	
    	$arr_elem = explode ("\n", $str_content);
    	$int_elem = count($arr_elem);
    	for($i=0; $i<$int_elem; $i++){
    		$ret_val[] = explode(",", $arr_elem[$i]);
    	}
    	return $ret_val;
    }
}

?>
