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
	  |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_MNewUser extends base_Model
{
    function miguel_MNewUser()
    {	
		$this->base_Model();
    }
    
    function getProfileList()
    {
    	$profile = $this->Select('profile', 'id_profile, profile_description');

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	for ($i=0; $i < count($profile); $i++) {
    		$arr_profile[$profile[$i]['profile.profile_description']] = $profile[$i]['profile.id_profile'];
    	}
    	
    	return ($arr_profile);
    }

    function getTreatment($t_id)
    {
    	$treatment = $this->Select('treatment', 'treatment_description',"treatment_id = $t_id");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	return ($treatment);
    }

    function getTreatmentList()
    {
    	$treatment = $this->Select('treatment', 'treatment_id, treatment_description');

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	for ($i=0; $i < count($treatment); $i++) {
    	   if($treatment[$i]['treatment.treatment_description'] == ''){
    	       $treatment[$i]['treatment.treatment_description'] = 'none';
    	   }
    		$arr_treatment[$treatment[$i]['treatment.treatment_description']] = $treatment[$i]['treatment.treatment_id'];
    	}
    	
    	return ($arr_treatment);
    }
    
    function newUser($name, $surname, $treatment, $user, $theme, $lang, $passwd, $profile, $email)
    {
        $person = $this->_insertPerson($name, $surname, $treatment);
        $user = $this->_insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email);
        return($person);
    }
    
    function _insertPerson($name, $surname, $treatment)
    {
        $jabber = 'none';
        $cargo = 'none';

        $ret_val = $this->Insert('person',
                                 'person_name, person_surname, treatment_id',
                                 "$name, $surname, $treatment");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function _insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email)
    {
        $active = '1';
        $hash = '';
        $ret_val = $this->Insert('user',
                                 'user_alias, theme, language, user_password, active, activate_hash, institution_id, forum_type_bb, main_page_id, person_id, id_profile, treatment_id, email',
                                 "$user, $theme, $lang, $passwd, $active, $hash, 0, 0, 0, $person, $profile, $treatment, $email");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function getCandidate($id)
    {		
        $ret_val = $this->SelectMultiTable('candidate,candidate_data',
                                 'candidate.dni,candidate.person_name,candidate.person_surname,candidate.treatment_id,candidate.birthday,candidate_data.email',
                                 "candidate.person_id = $id AND candidate.person_id = candidate_data.person_id");

    	if ($this->hasError()) 
			{
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function getCandidateData($id_cand)
    {   
        $ret_val = $this->Select('candidate_data',
                                 'person_id, street, city, council, country, postalcode, phone, fax, email, jabber',
                                 "person_id = $id_cand");

    		if ($this->hasError()) 
				{
	    		$ret_val = null;
  	  	}

    	return ($ret_val);
    }
    
    function insertPersonData($id_cand, $person, $calle, $localidad, $provincia, $email, $pais, $cp, $telefono, $fax)
    {
		$jabber='none';
		
		$ret_val = $this->Insert('person_data',
								'person_id, street, city, council, country, postalcode, phone, fax, email, jabber',
								array($person,$calle,$localidad,$provincia,$pais,$cp,$telefono,$fax,$email,$jabber));
		
		
		$ret_val = $this->Delete('candidate', "person_id = $id_cand");
		
		$ret_val = $this->Delete('candidate_data', "person_id = $id_cand");
		
		if ($this->hasError()) {
			$ret_val = null;
		}
		
		return ($ret_val);
    }
}
?>