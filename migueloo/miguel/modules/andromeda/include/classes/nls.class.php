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
 * @subpackage include
 */
/**
 *
 */
 
 /**
 * Define la clase para ofrecer Native Language Support.
 * Se plantea un manejador del sistema de lenguaje nativo.
 *
 * La idea, como otras, ha sido tomada del framework Horde
 *       http://www.horde.org/horde/
 * Esta clase es una adaptación de NLS.class del proyecto Horde.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */
class NLS 
{
    /**
     * Toma el valor para el idioma.
     * @param optional string $lang     The language abbriviation.
     *
     * @access public
     *
     */
    function setLang($lang = null)
    {
        include_once(Util::base_Path('include/classes/nls.inc.php'));
        //Debug::oneVar($lang, __FILE__, __LINE__);
        if(empty($lang) || !NLS::isValid($lang)) {
        	if(Session::getValue("lang") != null) {
				$lang = Session::getValue("lang");
			} else if(Session::getContextValue("gettext_lang") != null) {
				$lang = Session::getContextValue("gettext_lang");
			} else {
				$lang = 'es_ES';
			}
		}

        Session::setValue('language', $lang);
        //Debug::oneVar($lang, __FILE__, __LINE__);
        
        /* First try language with the current charset. */
        $lang_charset = $lang . '.' . NLS::getCharset();
        if ($lang_charset != setlocale(LC_ALL, $lang_charset)) {
            /* Next try language with its default charset. */
            global $nls;
            $charset = !empty($nls['charsets'][$lang]) ? $nls['charsets'][$lang] : $nls['defaults']['charset'];
            $lang_charset = $lang . '.' . $charset;
            NLS::_cachedCharset(0, $charset);
            if ($lang_charset != setlocale(LC_ALL, $lang_charset)) {
                /* At last try language solely. */
                $lang_charset = $lang;
                setlocale(LC_ALL, $lang_charset);
            }
        }
        @putenv('LANG=' . $lang_charset);
        @putenv('LANGUAGE=' . $lang_charset);
    }

    /**
     * Fija el dominio para gettext.
     * @param string $app        Nombre de al palicación.
     * @param string $directory  Directorio para gettext
     * @param string $charset    El charset.
     *
     * @access public
     */
    function setTextdomain($app, $directory, $charset)
    {
        bindtextdomain($app, $directory);
        textdomain($app);

        /* The existence of this function depends on the platform. */
        if (function_exists('bind_textdomain_codeset')) {
           bind_textdomain_codeset($app, $charset);
        }
    }


    /**
     * Devuelve el valor del charset para el lenguaje seleccionado
     *
     * @param optional boolean $no_utf  Do not use UTF-8?
     *
     * @return string  The character set that should be used with the current
     *                 locale settings.
     * @access public
     */
    function getCharset($no_utf = false)
    {
        global $nls;
        
        $language = Session::getValue('language');

        /* Get cached results. */
        $cacheKey = intval($no_utf);
        $charset = NLS::_cachedCharset($cacheKey);
        if (!is_null($charset)) {
            return $charset;
        }

        $lang_charset = setlocale(LC_ALL, 0);
        if (!strstr($lang_charset, ';') && !strstr($lang_charset, '/')) {
            $lang_charset = explode('.', $lang_charset);
            if ((count($lang_charset) == 2) && !empty($lang_charset[1]) &&
                (!$no_utf || ($lang_charset[1] != 'UTF-8'))) {
                NLS::_cachedCharset($cacheKey, $lang_charset[1]);
                return $lang_charset[1];
            }
        }

        return (!empty($nls['charsets'][$language])) ? $nls['charsets'][$language] : $nls['defaults']['charset'];
    }

    function _cachedCharset($index, $charset = null)
    {
        static $cache;

        if (!isset($cache)) {
            $cache = array();
        }

        if ($charset == null) {
            return isset($cache[$index]) ? $cache[$index] : null;
        } else {
            $cache[$index] = $charset;
        }
    }
    
    /**
     *
     */
    function isValid($lang)
    {
    	return !empty($GLOBALS['nls']['languages'][$lang]);
    } 
    
    /**
     *
     */
    function getLangLabel($lang)
    {
    	return $GLOBALS['nls']['languages'][$lang];
    }
}
?>
