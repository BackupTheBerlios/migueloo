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

//El controlador hereda de miguel_Controller la superclase controlador de miguelOO
class miguel_CTodo extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CTodo() 
	{	
                //Ejecuta el constructor de la clase padre
		$this->miguel_Controller();

                //Inicializamos algunas propiedades del m�dulo
                //Nombre del m�dulo, ha de coincidir con registry.xml
		$this->setModuleName('todo');

                //Nombre de la clase del Modelo, el fichero ser� miguel_mtodo.class.php
		$this->setModelClass('miguel_MTodo');

                //Nombre de la clase Vista por defecto, como la p�gina no se renderiza hasta el final de la ejecuci�n esta puede cambiar en cualquier momento
		$this->setViewClass('miguel_VTodo');

                //Indicamos si deseamos Cachear la p�gina
		$this->setCacheFlag(false);
	}
    
        //Esta funci�n ejecuta el Controlador 
	function processPetition() 	
	{
	   $bol_insert = false;
           //Comprueba el contenido de la Variable nombre. Esta se le pasa como entrada al controlador y puede venir de un formulario o un link
           if( $this->issetViewVariable('nombre') && $this->getViewVariable('nombre') != ''){
              //Comprobamos la variable email
              if( $this->issetViewVariable('email') && $this->getViewVariable('email') != ''){
		     if( $this->issetViewVariable('comentario') && $this->getViewVariable('comentario') != ''){
                               //Realizamos una llamada al Modelo $this->obj_data->M�todo(Par�metros);
		  	       $this->obj_data->insertSugestion($this->getViewVariable('nombre'), $this->getViewVariable('email'), $this->getViewVariable('comentario'));

		  	       //Poner control
		  	       $bol_insert = true;

                               //Enviamos a la vista la informaci�n a Mostrar
		  	       $this->setViewVariable('sug_nombre', $this->arr_form['nombre']);
		  	       $this->setViewVariable('sug_email', $this->arr_form['email']);
		  	       $this->setViewVariable('sug_comentario', $this->arr_form['comentario']);

                               //Operaci�n de Depuraci�n, necesita tener activadas las ventanas pop-up en el navegador. __FILE__ y __LINE__ son constantes del sistema
                               //Debug::oneVar($this->obj_data, __FILE__, __LINE__);
		      }
	       }
	    }

            //Dependiendo de la acci�n ejecutada se muestra una Vista (Formulario) u otra (Confirmaci�n de la entrada)
            //En este caso se utiliza una �nica vista para dos acciones. Por lo general se hace con setViewClass() y se define una clase vista para cada una de las acciones
	    if($bol_insert){
		  $this->setPageTitle("miguel Todo Page");
		  $this->setMessage("Gracias por su colaboraciÛn");
		  $this->setViewVariable('bol_cuestion', false);
	    } else {
		  $this->setPageTitle("miguel Todo Page");
		  $this->setMessage("AquÌ puede presentar su sugerencia, comentario, protesta,... sobre miguel");
		  $this->setViewVariable('bol_cuestion', true);
	   }

           //Establece cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
	   $this->setHelp("");

           //En la barra de navegaci�n superior, la que se usa para no perdernos. A�ade un enlace a esta barra de enlaces.
	   $this->addNavElement(Util::format_URLPath("todo/index.php"), "Sugerencia");	
	}
}
