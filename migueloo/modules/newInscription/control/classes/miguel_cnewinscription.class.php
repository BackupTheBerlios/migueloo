<?php
/*
      +----------------------------------------------------------------------+
      |newInscription/controller                                             |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, SHS Polar Sistemas Informáticos, S.L.            |
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
      | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_CNewInscription extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CNewInscription()
	{	
		$this->miguel_Controller();
		$this->setModuleName('newInscription');
		$this->setModelClass('miguel_MNewInscription');
		$this->setViewClass('miguel_VNewInscription');
		$this->setCacheFlag(false);
	}
    
	function checkVar($nom_var, $textoError)
	{
		$bRet = $this->issetViewVariable($nom_var) && $this->getViewVariable($nom_var) != '';
		
		if (!$bRet){
			$strError = "El campo $textoError es obligatorio. Debe rellenarlo:";
			//$this->setMessage($strError);
			$this->setViewVariable('strError', $strError);
		}
		return($bRet);
	}	
		 
	function processPetition() 
	{
	
		$this->setViewVariable('treatmentList', $this->obj_data->getTreatmentList());
        if ($this->issetViewVariable("submit") ){
			if ($this->checkVar('nom_form', 'nombre') &&
				$this->checkVar('prenom_form', 'primer apellido') &&
				$this->checkVar('localidad', 'localidad') &&
				$this->checkVar('pais', 'país') &&
				$this->checkVar('telefono','teléfono')){
					 $fecha = $this->getViewVariable('_years') . '-' . $this->getViewVariable('_months') . '-' . $this->getViewVariable('_days');
	                //if($this->getViewVariable('passwd') == $this->getViewVariable('passwd2')){
    				$this->obj_data->newInscription($this->getViewVariable('nom_form'), $this->getViewVariable('prenom_form'),
                                            $this->getViewVariable('prenom_form2'), $this->getViewVariable('nif'),
                                            $fecha, $this->getViewVariable('calle'),
                                            $this->getViewVariable('localidad'), $this->getViewVariable('provincia'), $this->getViewVariable('email'),
                                            $this->getViewVariable('pais'), $this->getViewVariable('cp'), $this->getViewVariable('telefono'),
                                            $this->getViewVariable('fax'),
																						$this->getViewVariable('treatment'));
                   	$this->setViewVariable('newclient', 'ok');
					$this->addNavElement(Util::format_URLPath('../index.php'), "Inscripción completada --> Ir a página principal");
					$this->setMessage('Inscripción de usuario OK');
		            //$this->setViewClass("miguel_VAuthStep2");
                	$this->setCacheFile("miguel_VAuth2_".$this->getSessionElement("userinfo","username"));
					 $this->setCacheFlag(true);
            } else {
				$this->setCacheFile("miguel_VAuth_".$this->getSessionElement("userinfo","username"));
				$this->setCacheFlag(false);
            }   
		} else {
			if(!$this->issetViewVariable("back")) {
          		$this->addNavElement(Util::format_URLPath('../index.php'), "página principal");
				
				//Informamos variables para la vista
				/*$this->setViewVariable('themes', $this->registry->listThemes());
				$this->setViewVariable('profiles', $this->obj_data->getProfileList());
				$this->setViewVariable('treatment', $this->obj_data->getTreatmentList());*/

			    //$this->setMessage("Inscripción al Campus Virtual");
			    $this->setMessage("Nueva Inscripción en barra");
			    $this->setCacheFile("miguel_VAuth1_".$this->getSessionElement("userinfo","username"));
			    $this->setCacheFlag(true);
			} else {
				$this->addNavElement(Util::format_URLPath('../index.php'), "Página principal");
			
			    $this->setMessage("En está página puede rellenar su inscripción al Campus Virtual");
			    $this->setCacheFile("miguel_VAuthStep2_".$this->getSessionElement("userinfo","username"));
			    $this->setCacheFlag(true);
			}
		}
		$this->setPageTitle("miguel Authentification Page");
		$this->setHelp("EducUser");
	}
    
}
?>