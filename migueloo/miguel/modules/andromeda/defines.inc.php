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

/* Check cache defines */
/*
if(!@constant("MIGUELBASE_CACHEABLE")){
	define("MIGUELBASE_CACHEABLE", 0);
}

if(MIGUELBASE_CACHEABLE == 1) {
	if(!@constant("MIGUELBASE_CACHE_TIME")){
		define("MIGUELBASE_CACHE_TIME", 3600); // Default: 1 hour
	}
	
	if(!@constant("MIGUELBASE_CACHE_DIR")){
		//define("MIGUELBASE_CACHE_DIR", $_SERVER['DOCUMENT_ROOT']."/".MIGUEL_LOCALPATH."/cache/"); // Path to cahe dir 		echo "ERROR: MIGUELBASE_CACHE_DIR not defined\n";
		exit;
	}
}
*/

/**
  * Determines platform (OS), browser and version of the user
  * Based on a phpBuilder article:
  *   see http://www.phpbuilder.net/columns/tim20000821.php
  */
if (!defined('MIGUELBASE_USR_OS')) {
    // loic1 - 2001/25/11: use the new globals arrays defined with
    // php 4.1+
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    } else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
    } else if (!isset($HTTP_USER_AGENT)) {
        $HTTP_USER_AGENT = '';
    }

    // 1. Platform
    if (strstr($HTTP_USER_AGENT, 'Win')) {
        define('MIGUELBASE_USR_OS', 'Win');
    } else if (strstr($HTTP_USER_AGENT, 'Mac')) {
        define('MIGUELBASE_USR_OS', 'Mac');
    } else if (strstr($HTTP_USER_AGENT, 'Linux')) {
        define('MIGUELBASE_USR_OS', 'Linux');
    } else if (strstr($HTTP_USER_AGENT, 'Unix')) {
        define('MIGUELBASE_USR_OS', 'Unix');
    } else if (strstr($HTTP_USER_AGENT, 'OS/2')) {
        define('MIGUELBASE_USR_OS', 'OS/2');
    } else {
        define('MIGUELBASE_USR_OS', 'Other');
    }

    // 2. browser and version
    if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) {
        define('MIGUELBASE_USR_BROWSER_VER', $log_version[2]);
        define('MIGUELBASE_USR_BROWSER_AGENT', 'OPERA');
    } else if (ereg('MSIE ([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) {
        define('MIGUELBASE_USR_BROWSER_VER', $log_version[1]);
        define('MIGUELBASE_USR_BROWSER_AGENT', 'IE');
    } else if (ereg('OmniWeb/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) {
        define('MIGUELBASE_USR_BROWSER_VER', $log_version[1]);
        define('MIGUELBASE_USR_BROWSER_AGENT', 'OMNIWEB');
    } else if (ereg('Mozilla/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) {
        define('MIGUELBASE_USR_BROWSER_VER', $log_version[1]);
        define('MIGUELBASE_USR_BROWSER_AGENT', 'MOZILLA');
    } else if (ereg('Konqueror/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) {
        define('MIGUELBASE_USR_BROWSER_VER', $log_version[1]);
        define('MIGUELBASE_USR_BROWSER_AGENT', 'KONQUEROR');
    } else {
        define('MIGUELBASE_USR_BROWSER_VER', 0);
        define('MIGUELBASE_USR_BROWSER_AGENT', 'OTHER');
    }
}

/**
  * php version
  */

if (!defined('MIGUELBASE_PHP_INT_VERSION')) {
    if (!ereg('([0-9]{1,2}).([0-9]{1,2}).([0-9]{1,2})', phpversion(), $match)) {
        $result = ereg('([0-9]{1,2}).([0-9]{1,2})', phpversion(), $match);
    }
    if (isset($match) && !empty($match[1])) {
        if (!isset($match[2])) {
            $match[2] = 0;
        }
        if (!isset($match[3])) {
            $match[3] = 0;
        }
        define('MIGUELBASE_PHP_INT_VERSION', (int)sprintf('%d%02d%02d', $match[1], $match[2], $match[3]));
        unset($match);
    } else {
        define('MIGUELBASE_PHP_INT_VERSION', 0);
    }
}

/** 
 * Encapsula el uso de gettext. Si no existe la traducción, presenta un valor por defecto
 * @param string $char Cadena a traducir
 */
function agt($char)
{
   	if(gettext($char) == $char) {
   		return gettext("Sin traducir:: ").$char;
   	} else {
   		return gettext($char);
   	}
}
?>
