<?php
/*
      +----------------------------------------------------------------------+
      |forum                                                                 |
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
/**
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package forum
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MForum extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MForum() 
    { 
        //Llama al constructor de la superclase del Modelo	
        $this->base_Model();
    }
    
    //Devuelve información de un foro
    function getForums()
    {
				$ret_val = $this->Select('forum', 
                                 'forum_id, forum_name, forum_description, forum_moderator, forum_access, forum_cat_id',
                                 ''); 				      
        if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
        
				return($ret_val);			 		
    }
    
    //Crea un foro
    function insertForum($name, $descripcion)
    {
				$ret_val = $this->Insert('forum', 
                                 'forum_name, forum_description',
                                 "$name,$descripcion"); 	
	      if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
				return($ret_val);			 			
    }

    function insertTopic($forum_id, $title)
    {
    
        $now = date('Y-m-d H:i:s');
				$iMyId = Session::getValue('USERINFO_USER_ID');
				$ret_val = $this->Insert('forum_topic', 
                                 'forum_id, forum_topic_title, forum_topic_poster, forum_topic_date',
                                 array($forum_id,$title,$iMyId,$now)); 	
	      if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
				return($ret_val);			 			
    }
   
     
		//Inserta un mensaje
    function insertPost($topic_id, $forum_id, $text, $ip)
    {
    
        $now = date("Y-m-d H:i:s");
				$iMyId = Session::getValue('USERINFO_USER_ID');
				
    		$post_id = $this->Insert('forum_post', 
                                 'forum_topic_id, forum_id, forum_post_text, forum_post_poster, forum_post_time, forum_post_ip',
                                 "$topic_id,$forum_id,$text,$iMyId,$now,$ip"); 	
	      if ($this->hasError()) 
				{
        	$post_id = null;
        } 
        
        //Actualizamos el último mensaje del foro
        $this->Update ('forum_topic', 
											'last_post_id',
											"$post_id", 
											"forum_id = $forum_id");
											
				return($post_id);			 			
    }
   
	 	//Inserta un mensaje
    function getPostForum($forum_id, $topic_id, $orden=null)
    {
    		switch($orden)
    		{
    			case 'tema': 
    						$campo_orden = 'forum_id';
    						break;
    			case 'autor': 
     						$campo_orden = 'forum_post_poster';
 	  						break;
    			case 'fecha': 
    			default:
    						$campo_orden = 'forum_post_time';
    						break;
    		}

				$ret_val = $this->SelectOrder('forum_post',
                                 'forum_topic_id, forum_post_text, forum_post_poster, forum_post_time, forum_post_ip, forum_post_id, forum_id',
                                 $campo_orden,
                                 "forum_id = $forum_id AND forum_topic_id = $topic_id"); 	

	      if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
				return($ret_val);			 			
    }
    
     function getUsers()
    {
		 	$arrUsers = $this->Select('user', 'user_id, user_alias', '');


    	if ($this->hasError() || count($arrUsers) == 0) 
			{
    		$ret_val = null;
    	}
    	else
    	{
    			for ($i=0; $i<count($arrUsers);$i++)
    			{
    				$id = $arrUsers[$i]['user.user_id'];
    				$ret_val[$id]=$arrUsers[$i]['user.user_alias'];
    			}
    	}
    	return ($ret_val);
    }
 
     function getTopics($forum_id)
    {
		 	$ret_val = $this->SelectMultiTable('forum,forum_topic,forum_post', 
			 'forum.forum_name,forum.forum_description,forum.forum_moderator,forum.forum_access,forum.forum_cat_id,forum_topic.forum_topic_id,forum_topic.forum_topic_title,forum_topic.forum_topic_numview,forum_topic.forum_topic_replies,forum_topic.forum_topic_notify,forum_topic.forum_topic_status,forum_topic.forum_topic_poster,forum_topic.forum_topic_date,forum_topic.number_of_visits,forum_topic.number_of_posts,forum_topic.last_post_id, forum_post.forum_post_poster,forum_post.forum_post_time',
			 "forum_topic.forum_id = forum.forum_id AND forum.forum_id = $forum_id AND forum_post.forum_post_id = forum_topic.last_post_id");

    	if ($this->hasError()) 
			{
    		$ret_val = null;
    	}
/*    	else
    	{
    		$ret_val['name']=$arr_forum[0]['forum.forum_name'];
    		$ret_val['description']=$arr_forum[0]['forum.forum_description'];
    		//$ret_val['Moderator']=$arr_forum[0]['forum.forum_moderator'];
				//$ret_val['Access']=$arr_forum[0]['forum.forum_access'];
				//$ret_val['cat_id']=$arr_forum[0]['forum.forum_cat_id'];
				//$ret_val['topic_id']=$arr_forum[0]['forum_topic.forum_topic_id'];
				$ret_val['title']=$arr_forum[0]['forum_topic.forum_topic_title'];
				//$ret_val['numView']=$arr_forum[0]['forum_topic.forum_topic_numview'];
				//$ret_val['replies']=$arr_forum[0]['forum_topic.forum_topic_replies'];
				//$ret_val['notify']=$arr_forum[0]['forum_topic.forum_topic_notify'];
				//$ret_val['status']=$arr_forum[0]['forum_topic.forum_topic_status'];
				$ret_val['poster']=$arr_forum[0]['forum_topic.forum_topic_poster'];
				$ret_val['date']=$arr_forum[0]['forum_topic.forum_topic_date'];
				//$ret_val['number_of_visits']=$arr_forum[0]['forum_topic.number_of_visits'];
				//$ret_val['number_of_posts']=$arr_forum[0]['forum_topic.number_of_posts'];
				//$ret_val['last_post_id']=$arr_forum[0]['forum_topic.last_post_id'];
				$ret_val['last_post_poster']=$arr_forum[0]['forum_post.forum_post_poster'];
				$ret_val['last_post_time']=$arr_forum[0]['forum_post.forum_post_time'];
    	}
*/    	
    	return ($ret_val);
    }
    
    
    
    


    
}    
