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

class miguel_CTodo extends base_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CTodo() 
	{	
		$this->base_Controller();
		$this->setModuleName('todo');
		$this->setModelClass('miguel_MTodo');
		$this->setViewClass('miguel_VTodo');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 	
	{
	   $bol_insert = false;
	   //dbg_var($this->arr_form, __FILE__, __LINE__);
        if(isset($this->arr_form['nombre']) && $this->arr_form['nombre'] != ''){
            if(isset($this->arr_form['email']) && $this->arr_form['email'] != ''){
		  	   if(isset($this->arr_form['comentario']) && $this->arr_form['comentario'] != ''){
		  	       $this->obj_data->insertSugestion($this->arr_form['nombre'], $this->arr_form['email'], $this->arr_form['comentario']);
		  	       //Poner control
		  	       $bol_insert = true;
		  	       $this->setViewVariable('sug_nombre', $this->arr_form['nombre']);
		  	       $this->setViewVariable('sug_email', $this->arr_form['email']);
		  	       $this->setViewVariable('sug_comentario', $this->arr_form['comentario']);
                   //Debug::oneVar($this->obj_data, __FILE__, __LINE__);
		      }
		    }
		}
		
		if($bol_insert){
		  $this->setPageTitle("miguel Todo Page");
		  $this->setMessage("Gracias por su colaboración");
		  $this->setViewVariable('bol_cuestion', false);
		} else {
		  $this->setPageTitle("miguel Todo Page");
		  $this->setMessage("Aquí puede presentar su sugerencia, comentario, protesta,... sobre miguel");
		  $this->setViewVariable('bol_cuestion', true);
		}
		$this->setHelp("");	
		$this->addNavElement(Util::format_URLPath("todo/index.php"), "Sugerencia");	
	}
    
}
