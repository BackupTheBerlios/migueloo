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
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */


class miguel_cParser extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_cParser()
	{	
		$this->miguel_Controller();
		$this->setModuleName('parser');
		$this->setViewClass('miguel_vParser');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
	    //Debug::oneVar($this->getViewVariable('url'), __FILE__, __LINE__);
	    //Debug::oneVar($this->issetViewVariable('url'), __FILE__, __LINE__);
        if ($this->issetViewVariable('url')){
			 $this->addNavElement(Util::format_URLPath("parser/index.php", 'url='.$this->getViewVariable('url')), $this->getViewVariable('name'));
		} else {
            $this->addNavElement(Util::format_URLPath("parser/index.php"), 'Lanzador');
        }		

        //$this->addNavElement(Util::format_URLPath("lib/parser/index.php"), 'Lanzador');
        
		$this->setPageTitle("miguel Parser Page ".$this->getViewVariable('url'));
		$this->setMessage("Lanzador de codigo inicial de miguel");
		//$this->setCacheFile("miguel_vParser");
		$this->setCacheFlag(true);
		$this->setHelp("");
	}
}
?>
