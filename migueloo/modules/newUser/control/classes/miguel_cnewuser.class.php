<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004 miguel Development Team                     |
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
	  |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_CNewUser extends miguel_Controller
{
	function miguel_CNewUser()
	{	
		$this->miguel_Controller();
		$this->setModuleName('newUser');
		$this->setModelClass('miguel_MNewUser');
		$this->setViewClass('miguel_VNewUser');
		$this->setCacheFlag(false);
	}
   
	function checkVar($nom_var, $textoError)
	{
		$bRet = $this->issetViewVariable($nom_var) && $this->getViewVariable($nom_var) != '';
		
		if (!$bRet)	{
			$strError = "El campo $textoError es obligatorio. Debe rellenarlo:";
			//$this->setMessage($strError);
			$this->setViewVariable('strError', $strError);
		}
		return($bRet);
	}
	
	function changeCandidate($id_cand, $person)
	{
		$arrCand = $this->obj_data->getCandidateData($id_cand);
		for ($i=0; $i<count($arrCand); $i++) {
			$calle=$arrCand[$i]['candidate_data.street'];
			$localidad=$arrCand[$i]['candidate_data.city'];
			$provincia=$arrCand[$i]['candidate_data.council'];
			$email=$arrCand[$i]['candidate_data.email'];
			$pais=$arrCand[$i]['candidate_data.country'];
			$cp=$arrCand[$i]['candidate_data.postalcode'];
			$telefono=$arrCand[$i]['candidate_data.phone'];
			$fax=$arrCand[$i]['candidate_data.fax'];
			$this->obj_data->insertPersonData($id_cand, $person, $calle, $localidad, $provincia, $email, $pais, $cp, $telefono, $fax);
		}
	}
	
	function loadCandidate()
	{
		$id_cand = $this->getViewVariable('id_cand');
		$arrCand = $this->obj_data->getCandidate($id_cand);
		$this->setViewVariable('dni',$arrCand[0]['candidate.dni']);
		$this->setViewVariable('treatment_id',$arrCand[0]['candidate.treatment_id']);
		$this->setViewVariable('nom_form',$arrCand[0]['candidate.person_name']);
		$this->setViewVariable('prenom_form',$arrCand[0]['candidate.person_surname']);
		$this->setViewVariable('birthday',$arrCand[0]['candidate.birthday']);	
		$this->setViewVariable('email',$arrCand[0]['candidate_data.email']);	
	}
	
		  
	function processPetition() 
	{
        $message = '';
        $insert_ok = false;

        if ($this->issetViewVariable("submit") ){
            $all_Ok = false;
            //Control sobre variables de vista definidas
            if ($this->checkVar('profile') &&
								$this->checkVar('theme') &&
								$this->checkVar('treatment') &&
								$this->checkVar('nom_form') &&
								$this->checkVar('prenom_form') &&
								$this->checkVar('email') &&
								$this->checkVar('uname')){
                if($this->getViewVariable('passwd') == $this->getViewVariable('passwd2')){
                   $person_id = $this->obj_data->newUser($this->getViewVariable('nom_form'), $this->getViewVariable('prenom_form'),
                                            $this->getViewVariable('treatment'), $this->getViewVariable('uname'),
                                            $this->getViewVariable('theme'), 'es_ES', $this->getViewVariable('passwd'),
                                            $this->getViewVariable('profile'), $this->getViewVariable('email'));
                   $this->setViewVariable('newclient', 'ok');
				   
                   	if ($this->issetViewVariable('id_cand') && $this->getViewVariable('id_cand')!=null) {
						$this->changeCandidate($this->getViewVariable('id_cand'), $person_id);
					}
                   
			       	$this->addNavElement(Util::format_URLPath('newUser/index.php'), "Inscripción (Paso 2)");
			       	$insert_ok = true;
        		} else {
					$message = 'Error: Las claves no coinciden.';
				}
			} else {
                 $message = 'Error: Todos los campos son obligatorios.';
            }
            
            if(!$insert_ok) {
                $this->setViewVariable('themes', $this->registry->listThemes());
				$this->setViewVariable('profiles', $this->obj_data->getProfileList());
				$this->setViewVariable('treatment', $this->obj_data->getTreatmentList());
				//$this->setViewClass("miguel_VAuth");
				$this->setCacheFile("miguel_VAuth_".$this->getSessionElement("userinfo","username"));
				$this->setCacheFlag(false);
            } else {
                $message = 'Alta de usuario OK';
                //$this->setViewClass("miguel_VAuthStep2");
                $this->setCacheFile("miguel_VAuth2_".$this->getSessionElement("userinfo","username"));
				$this->setCacheFlag(true);
            }
			$this->setMessage($message);
		} else {
			if(!$this->issetViewVariable("back")) {
 				if ($this->issetViewVariable('id_cand')) {
					$this->loadCandidate();
			 	}

				$this->addNavElement(Util::format_URLPath('newUser/index.php'), "Inscripción (Paso 1)");
				
				//Informamos variables para la vista
				$this->setViewVariable('themes', $this->registry->listThemes());
				$this->setViewVariable('profiles', $this->obj_data->getProfileList());
				$this->setViewVariable('treatment', $this->obj_data->getTreatmentList());

			    $this->setMessage("Inscripción al Campus Virtual");
			    $this->setCacheFile("miguel_VAuth1_".$this->getSessionElement("userinfo","username"));
			    $this->setCacheFlag(true);
			} else {
				//$this->setViewClass("miguel_VAuth");
				$this->addNavElement(Util::format_URLPath('newUser/index.php'), "Inscripción (Paso 1)");
			
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