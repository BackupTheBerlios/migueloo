<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

//Miguel module

$this->modules['install'] = array(
    'path' => 'install',
    'page' => '',
    'icon' => '',
    'name' => 'install',
    'status' => 'active',
    'gettext' => 'install',
    'allow_guests' => true
);

//Miguel module

$this->modules['main'] = array(
    'path' => 'main',
    'page' => '',
    'icon' => '',
    'name' => 'miguel',
    'status' => 'active',
    'gettext' => 'main',
    'allow_guests' => true
);

$this->services['logout'] = array(
    'name' => 'logout',
    'page' => 'main/index.php',
    'param' => 'id=logoff',
    'icon' => 'logout.png',
    'help' => 'Salir',
    'menu' => 'toolbar',
    'place' => 'bottom',
    'module' => 'main'
);

$this->services['listcourses'] = array(
    'name' => 'listcourses',
    'page' => 'main/index.php',
    'param' => 'id=guest',
    'icon' => 'listcourses.png',
    'help' => 'Lista de Cursos',
    'menu' => 'toolbar',
    'place' => 'top',
    'module' => 'main'
);

//Faculty List Module
$this->modules['faculty'] = array(
    'path' => 'faculty',
    'page' => '',
    'icon' => '',
    'name' => 'facultyList',
    'status' => 'active',
    'gettext' => 'faculty',
    'allow_guests' => true
);

//Department List Module
$this->modules['department'] = array(
    'path' => 'department',
    'page' => '',
    'icon' => '',
    'name' => 'departmentList',
    'status' => 'active',
    'gettext' => 'department',
    'allow_guests' => true
);


//Area List Module
$this->modules['area'] = array(
    'path' => 'area',
    'page' => '',
    'icon' => '',
    'name' => 'areaList',
    'status' => 'active',
    'gettext' => 'area',
    'allow_guests' => true
);


//Course List Module
$this->modules['listCourses'] = array(
    'path' => 'listCourses',
    'page' => '',
    'icon' => '',
    'name' => 'listCourses',
    'status' => 'active',
    'gettext' => 'department',
    'allow_guests' => true
);

//common module
$this->modules['common'] = array(
    'path' => 'common',
    'page' => '',
    'icon' => '',
    'name' => 'miguel_common',
    'status' => 'active',
    'gettext' => 'common',
    'allow_guests' => true
);

//common module
$this->modules['error'] = array(
    'path' => 'error',
    'page' => '',
    'icon' => '',
    'name' => 'miguel_error',
    'status' => 'active',
    'gettext' => 'error',
    'allow_guests' => true
);

//Help module

$this->modules['help'] = array(
    'path' => 'help',
    'page' => '',
    'icon' => '',
    'name' => 'miguel_help',
    'status' => 'active',
    'allow_guests' => true
);

$this->services['help'] = array(
    'name' => 'logout',
    'page' => 'help/miguel_help.php',
    'param' => 'help=',
    'icon' => 'image/help_mini.png',
    'help' => 'Ayuda',
    'menu' => 'header',
    'place' => 'middle',
    'module' => 'help'
);

//Todo module

$this->modules['todo'] = array(
    'path' => 'todo',
    'page' => '',
    'icon' => '',
    'name' => 'miguel_todo',
    'status' => 'active',
    'gettext' => 'todo',
    'allow_guests' => true
);

$this->services['todo'] = array(
    'name' => 'todo',
    'page' => 'todo/index.php',
    'param' => '',
    'icon' => 'idea.png',
    'help' => 'Sugerencias',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'todo'
);

$this->services['forum'] = array(
    'name' => 'forum',
    'page' => 'http://hidrogeno.unileon.es/miguel-web/tiki-forums.php',
    'param' => '',
    'icon' => 'forumadmin.png',
    'help' => 'Foros',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'todo'
);

$this->services['admin'] = array(
    'name' => 'admin',
    'page' => 'admin/index.php',
    'param' => '',
    'icon' => 'admin.png',
    'help' => 'Administración',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'main'
);

//Miguel module

$this->modules['course'] = array(
    'path' => 'course',
    'page' => '',
    'icon' => '',
    'name' => 'course',
    'status' => 'active',
    'gettext' => 'course',
    'allow_guests' => true
);

$this->services['newcourse'] = array(
    'name' => 'newcourse',
    'page' => 'newCourse',
    'param' => '',
    'icon' => 'addcourse.png',
    'help' => 'Nuevo Curso',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'course'
);

//Miguel module

$this->modules['auth'] = array(
    'path' => 'auth',
    'page' => '',
    'icon' => '',
    'name' => 'auth',
    'status' => 'active',
    'gettext' => 'auth',
    'allow_guests' => true
);
$this->services['inscrip'] = array(
    'name' => 'inscrip',
    'page' => 'auth/index.php',
    'param' => '',
    'icon' => 'inscription.png',
    'help' => 'Inscripción',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'main'
);

$this->services['prefs'] = array(
    'name' => 'prefs',
    'page' => 'auth/index.php',
    'param' => 'service=profile',
    'icon' => 'profileedit.png',
    'help' => 'Preferencias',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'main'
);

$this->services['askpassword'] = array(
    'name' => 'askpassword',
    'page' => 'auth/index.php',
    'param' => 'service=lostpsswrd',
    'icon' => 'lostpassword.png',
    'help' => 'Recuperar clave',
    'menu' => 'toolbar',
    'place' => 'middle',
    'module' => 'main'
);

//Starter module

$this->modules['parser'] = array(
    'path' => 'parser',
    'page' => '',
    'icon' => '',
    'name' => 'parser',
    'status' => 'active',
    'gettext' => 'main',
    'allow_guests' => true
);
?>
