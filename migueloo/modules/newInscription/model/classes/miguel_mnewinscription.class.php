<?php
/*
      +----------------------------------------------------------------------+
      |newInscription/model                                                  |
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
class miguel_MNewInscription extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MNewInscription()
    {	
		$this->base_Model();
    }
    
    function getProfileList()
    {
    	//Get code cours
    	$profile = $this->Select('profile', 'id_profile, profile_description');
        //Debug::oneVar($this, __FILE__, __LINE__);
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	//Debug::oneVar($profile, __FILE__, __LINE__);
    	for ($i=0; $i < count($profile); $i++) {
			//$profiles = array("Alumno"=>5, "Profesor"=>1);	
    		$arr_profile[$profile[$i]['profile.profile_description']] = $profile[$i]['profile.id_profile'];
    	}
    	
    	return ($arr_profile);
    }
    
    function getTreatmentList()
    {
    	//Get code cours
    	$treatment = $this->Select('treatment', 'treatment_id, treatment_description');
        //Debug::oneVar($this, __FILE__, __LINE__);
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	//Debug::oneVar($treatment, __FILE__, __LINE__);
    	for ($i=0; $i < count($treatment); $i++) {
    	   if($treatment[$i]['treatment.treatment_description'] == ''){
    	       $treatment[$i]['treatment.treatment_description'] = 'none';
    	   }
    		$arr_treatment[$treatment[$i]['treatment.treatment_description']] = $treatment[$i]['treatment.treatment_id'];
    	}
    	
    	return ($arr_treatment);
    }
    
    /*function newUser($name, $surname, $treatment, $user, $theme, $lang, $passwd, $profile, $email)
    {
        $person = $this->_insertPerson($name, $surname, $treatment);
        $user = $this->_insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email);
    } */
    function newInscription($name, $surname1, $surname2, $nif, $birthday, $calle, $localidad, $provincia, $email, $pais, $cp, $telefono, $fax, $treatment)
    {
        //$person = $this->_insertPerson($name, $surname, $treatment);
        $person = $this->_insertPerson($nif,$name, $surname1, $surname2, $birthday, $treatment);
        //$user = $this->_insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email);
        if ($person!=null)
        {
        	$person_data = $this->_insertPersonData($person, $calle, $localidad, $provincia, $email, $pais, $cp, $telefono, $fax);
        }
        return($person);
    }
    
    //function _insertPerson($name, $surname, $treatment)
    function _insertPerson($dni,$name, $surname1, $surname2, $birthday, $treatment)
    {
        $surname=$surname1.' '.$surname2;
			

        /*$ret_val = $this->Insert('person',
                                 'person_jabber, person_name, person_surname, treatment_id, cargo',
                                 "$jabber, $name, $surname, $treatment, $cargo");*/
        $ret_val = $this->Insert('candidate',
                                 'dni, person_name, person_surname, treatment_id, birthday',
                                 "$dni,$name,$surname,$treatment,$birthday");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function _insertPersonData($person, $calle, $localidad, $provincia, $email, $pais, $cp, $telefono, $fax)
    {
    		$jabber='none';
    
    		
        $ret_val = $this->Insert('candidate_data',
                                 'person_id, street, city, council, country, postalcode, phone, fax, email, jabber',
                                 array($person,$calle,$localidad,$provincia,$pais,$cp,$telefono,$fax,$email,$jabber));

    		if ($this->hasError()) 
				{
	    		$ret_val = null;
  	  	}

    	return ($ret_val);
    }
}
