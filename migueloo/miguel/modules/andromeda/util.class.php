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
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage util
 */

/**
 * Define funciones útiles para miguel.
 * Se definen funciones de uso común para miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage util
 * @version 1.0.0
 *
 */
class Util
{
    function formatPath($str_path)
    {
        $str_val = chop($str_path);

        switch (MIGUELBASE_USR_OS) {
            case 'Win':
                $ret_val = str_replace("/", "\\", $str_val);
                break;
            default:
                $ret_val = str_replace('\\', '/', $str_val);
        }

        return $ret_val;
    }

    /*
     * Formatea una dirección interna
     * Relativo a la dirección del framework modules/andromeda/
     */
    function base_Path($str_path)
    {
        return Util::formatPath(MIGUELBASE_DIR.chop($str_path));
    }
    
    /*
     * Formatea una dirección interna
     * Relativo a la dirección donde estan los modulos: modules/
     */
    function app_Path($str_path)
    {
        return Util::formatPath(MIGUELBASE_MAINDIR.chop($str_path));
    }
    
    /*
     * Formatea una dirección URL, sin sesión.
     */
    function app_URLPath($str_path)
    {
        return str_replace('\\', '/', MIGUELBASE_MODULES_URL.chop($str_path));
    }
    
    /*
     * Formatea una dirección URL, sin sesión, relativa al superdirectorio de la aplicación.
     */
    function main_URLPath($str_path)
    {
        return str_replace('\\', '/', MIGUELBASE_URL.chop($str_path));
    }
    
    /*
     * Formatea una dirección URL, añadiendo sesión.
     * Relativo a dirección module/
     */
    function format_URLPath($str_path, $str_param = '')
    {
        return Util::session_URLPath(MIGUELBASE_MODULES_URL.$str_path, $str_param);
    }
    
    /*
     * Formatea una dirección URL, añadiendo sesión.
     * Relativo a dirección lib/
     */
    function session_URLPath($str_path, $str_param = '')
    {
        if ($str_path == '') {
            $ret_val = '';
        } else {
            //No nos sirve usar SID. Se cambia la sesión de forma dinámica.
            $sid = session_name().'='.session_id();
            
        	if($str_param == ''){
        		$ret_val = chop($str_path)."?$sid";
        	} else {
        		$ret_val = chop($str_path)."?$sid&".chop($str_param);
        	}
        }

        return str_replace('\\', '/', $ret_val);
    }
    
    /*
     * Formatea una direcciÃ³n interna
     * Relativo a direcciÃ³n lib/
     */
    function format_pathApp($str_path)
    {
        return Util::formatPath(MIGUELBASE_MAINDIR.chop($str_path));
    }

	/*
	 * Genera una clave de forma aleatoria
	 */
	function newPasswd($num_char = 8)
	{
		$chars  = 'abcdefghijklmnopqrstuvwxyzABDCEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$passwd = '';

		for($i=0; $i<$num_char; $i++)
		{
			$passwd .= $chars[rand()%strlen($chars)];
		}

		return $passwd;
	}
}
?>
