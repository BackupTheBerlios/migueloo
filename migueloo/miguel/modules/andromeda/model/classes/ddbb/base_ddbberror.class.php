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
 * @subpackage model
 */
/**
 * Sistema de gesti�n de errores para los accesos a la base de datos
 * Esta clase implementa las funcionalidades b�sicas para un control de los accesos a la 
 * base de datos.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage model
 * @version 1.0.0
 *
 */ 
class base_ddbbError
{
	/**
	 * @access private
	 * @var boolean
	 */
	var $bol_error	= false;
	/**
	 * @access private
	 * @var string
	 */
	var $str_error	= '';
	
	/**
	 * Constructor.
	 */
	function base_ddbbError()
	{
		$this->_clearError();
	}
	
	
	/**
  	 * Informa sobre la ocurrencia de error
  	 * @returns boolean Si error, true
  	 */
	function hasError()
	{
		return $this->bol_error;
	}


	/**
	 * Devuelve el literal asociado al error
	 * @returns string Informaci�n de error
 	 */
	function getError()
	{
		return $this->str_error;
	}


	/**
	 * Se asigna el error.
	 * @access private
     */
	function _setError ($str_error)
	{
    	if ($str_error != '') {
			$this->str_error = $str_error;
			$this->bol_error = true;
        }
	}	 
	
	/**
	 * Se limpian los valores.
	 * @access private
     */
	function _clearError()
	{
        $this->str_error = '';
		$this->bol_error = false;
    }	 
}
?>
