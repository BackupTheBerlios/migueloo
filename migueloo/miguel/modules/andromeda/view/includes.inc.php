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
 * Include the phphtmllib libraries
 */
//This variable is necessary. Don`t delete next line. 
$phphtmllib = MIGUELBASE_PHPHTMLLIB; 
include_once($phphtmllib."/includes.inc");
include_once($phphtmllib."/form/includes.inc");

/**
 * Include the control libraries
 */
$viewlib = MIGUELBASE_DIR."view/classes/";
$includelib = MIGUELBASE_DIR."include/classes/";

//include($viewlib."base_element.class.php");
//include($viewlib."base_header.class.php");
//include($viewlib."base_footer.class.php");
//include($viewlib."base_layoutpage.class.php");
include($viewlib."base_formcontent.class.php");
include($viewlib."base_submitbutton.class.php");

include_once($includelib."theme.class.php");

//Para tener la versi�n de phpHtmlLib usar la funci�n
//   phphtmllib_get_version()  debe devolver un string
// del tipo '2.3.0'
?>
