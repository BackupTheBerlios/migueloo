<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This library is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU Library General Public        |
      |   License as published by the Free Software Foundation; either       | 
      |   version 2 of the License, or (at your option) any later version.   |
      |                                                                      |
      |   This library is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU  |
      |   Library General Public License for more details.                   |
      |                                                                      |
      |   You should have received a copy of the GNU Library General Public  |
      |   License along with this program; if not, write to the Free         |
      |   Software Foundation, Inc., 59 Temple Place - Suite 330, Boston,    |
      |   MA 02111-1307, USA.                                                |      
      +----------------------------------------------------------------------+
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrÛn MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage view
 */
/**
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 * Utiliza la libreria phphtmllib.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */

class base_FormContent extends FormContent 
{
    /**
	 * @access private
	 */
	var $arr_commarea = null;
	
	function base_FormContent($arr_commarea = null)
    {   
        $this->arr_commarea = $arr_commarea;
        
        $this->FormContent();
    }
    
    function form_action() {
        return true;
    }
    /**
     * This method gets called after the FormElement data has
     * passed the validation.  This enables you to validate the
     * data against some backend mechanism, say a DB.
     *
     */
    function form_backend_validation() 
    {
        //La validación se hacen en el controlador
        return TRUE;
    }

    /**
	 * Recupera el valor de una variable que se usar· en la vista.
	 * @param string $str_name Nombre de la variable
	 * @return mixto Valor de la variable
	 */
	function getViewVariable($str_name)
	{
    	if($str_name != ''){
    		return $this->arr_commarea["$str_name"];
    	} else {
    		return null;
    	}     	
    }
    
    /**
     * @access private
     */
    function _tableRow($name, $style = '')
    {
    	$row = html_tr($style);
        $row->add($this->element_label($name), $this->element_form($name));
    	
    	return($row);
    }
    
    /**
     * @access private
     */
    function _formatElem($classname) 
    {
	    $phpcode = "return new {$classname}(";
	    
	    if (func_num_args() > 2) {
	       $newparams = array_slice(func_get_args(),1);

	       for($i=1; $i<count($newparams) ; $i++) {
		   if ($i > 1) {
		       $phpcode .= ',';
		   }
		   $phpcode .= '$newparams[' . $i . ']';
	       }
	   }
	   
	   $phpcode .= ');';
	   
	   //echo "<pre>"; print_r($newparams); echo $phpcode; echo "</pre>";
	   $elem = eval($phpcode);
	   $elem->set_label_text($newparams[0]);
	   
	   return($elem);
    }
    
    /**
     * @access private
     */
    function _submitButton($value, $label)
    {
	    $button = new  FESubmitButton($value, $label);
	    $button->set_style_attribute('id');
	    $button->set_attribute('loc');
	    $button->onClick("disable=false");
	   
	    return($button);
    }
}

?>
