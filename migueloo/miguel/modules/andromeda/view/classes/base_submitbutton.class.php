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
 * Todo el patr�n MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage view
 */
/**
 * Define un bot�n de tipo submit simple.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 */

class base_SubmitButton extends FEButton 
{

    /**
	 * Constructor.
	 * @param string $label Etiqueta del bot�n
     * @param string $value Texto del bot�n
     */
    function base_SubmitButton($label, $value) 
    {
        $this->FEButton($label, $value, 'submit()');
    }

    /**
     * @access private
     */
    function onClick() {
        return;
    }

    /**
     * Construye el bot�n.
     * @return object
     */
    function get_element() {

        $attributes = $this->_build_element_attributes();
        $attributes["type"] = "submit";

        $attributes["value"] = $this->get_value();

        $tag = new INPUTtag($attributes);

        return $tag;
    }
}
?>