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
 * @subpackage view
 * @version 1.0.0
 *
 */ 

/**
 * Include classes library
 */
include_once(Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VForum extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string - $title - the title for the page and the
	 *                 titlebar object.
	 * @param - string - The render type (HTML, XHTML, etc. )	
	 *                   default value = HTML
     *
	 */
    function miguel_VForum($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }


		function addNewForumInfo()
		{
				$elem1 = html_b('Foro creado correctamente.');
				return($elem1);
		}
		
		function addForumList()
		{
			$arrForums = $this->getViewVariable('arrForums');
			$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
			$table->set_class('simple');		
			for ($i=0; $i<count($arrForums); $i++)
			{
				$id_forum = $arrForums[$i]['forum.forum_id'];
				$table->add_row($arrForums[$i]['forum.forum_name'], 
			   								html_a(Util::format_URLPath('forum/index.php',"status=list_topic&id_forum=$id_forum"),
															 $arrForums[$i]['forum.forum_description']
															 )
												);
			}
			
			return($table);	
		}
	
		function addTopic($title, $poster, $date, $post_poster, $post_time, $id_topic)
		{
				$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
				$table->set_class('simple');		
				$id_forum = $this->getViewVariable('id_forum');
				$table->add_row(html_a(Util::format_URLPath('forum/index.php',"status=list_post&id_forum=$id_forum&id_topic=$id_topic"),$title));
				$table->add_row('Creador: ' . $poster);
				$table->add_row('Fecha de Creación: ' . $date);
				$table->add_row("Ultimo mensaje: $post_poster ( $post_time )");
		
				return($table);	
		}

		function addTopicList(&$div)
		{
			$arrUsers = $this->getViewVariable('arrUsers');
			//$arrForumData = $this->getViewVariable('arrForumData');
			$arrTopics = $this->getViewVariable('arrTopics');
			if ($arrTopics[0]['forum_topic.forum_topic_title']!=null)
			{
				for ($i=0; $i<count($arrTopics); $i++)
				{
					$div->add($this->addTopic($arrTopics[$i]['forum_topic.forum_topic_title'],
																		$arrUsers[$arrTopics[$i]['forum_topic.forum_topic_poster']],
																		$arrTopics[$i]['forum_topic.forum_topic_date'],
																		$arrTopics[$i]['forum_post.forum_post_poster'],
																		$arrTopics[$i]['forum_post.forum_post_time'],
																		$arrTopics[$i]['forum_topic.forum_topic_id']));
					$div->add(html_hr());														 
				}
			}	
		}

		
		function addPost($poster, $time, $text, $ip, $id_post)
		{
			$arrUsers = $this->getViewVariable('arrUsers');
			$poster_alias = $arrUsers[$poster];
			$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
			$table->set_class('simple');		
			$table->add_row($poster_alias, $ip, $time);
			$table->add_row($text);
			$table->add_row(html_a(Util::format_URLPath('forum/index.php',"status=new_post&id_post=$id_post"),'Responder'));
			return($table);
		}
		
		function addPostList(&$div)
		{
			$arrPosts = $this->getViewVariable('arrPosts');
			for ($i=0; $i<count($arrPosts); $i++)
			{
				if ($arrPosts[$i]['forum_post.forum_post_poster']!=NULL)
				{
					$div->add($this->addPost($arrPosts[$i]['forum_post.forum_post_poster'], 
																 $arrPosts[$i]['forum_post.forum_post_time'],
																 $arrPosts[$i]['forum_post.forum_post_text'],
																 $arrPosts[$i]['forum_post.forum_post_ip'],
																 $arrPosts[$i]['forum_post.forum_post_id']));
					$div->add(html_hr());														 
				}
			}	
		}

    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */

 		function right_block() 
    {

	        //Crea el contenedor del right_block
  	      $main = container();
		
		      $hr = html_hr();
       	  $hr->set_tag_attribute('noshade');
          $hr->set_tag_attribute('size', 2);

          //AÃ±ade la linea horizontal al contenedor principal
          $main->add($hr);
          
					$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
					$table->set_class('simple');		
		
					$elem1 = html_td('', '', $this->left_section());
					$elem1->set_tag_attribute('width', '20%');
					$elem1->set_tag_attribute('valign', 'top');
					$elem2 = html_td('', '',$this->right_section());
					$elem2->set_tag_attribute('valign', 'top');
        
					$row = html_tr();
					$row->add($elem1);
					$row->add($elem2);

					$table->add_row($row);
        
        	$main->add( $table );

					return $main;
    }

    function left_section()
    {
			$div = html_div();
			$div->set_id('content');		
			$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
			$table->set_class('simple');
			$table->add_row(html_a(Util::format_URLPath('forum/index.php','status=new'),'Nuevo Debate'));
			$table->add_row(html_a(Util::format_URLPath('forum/index.php','status=list'),'Listado de Debates'));
			//$table->add_row(html_a(Util::format_URLPath('forum/index.php','status=new_post'),'Nueva Opinión'));
			$div->add($table);
			if ($this->issetViewVariable('id_forum')) 
			{
					$div->add($this->addForm('forum', 'miguel_forumMenuform'));
 			}
			return($div);
    }

    function right_section()
    {

			$div = html_div();
			$div->set_id('content');		
				
	    $status = $this->getViewVariable('status');  
			switch($status)
 			{
 					case 'new_post':
 								$div->add($this->addForm('forum', 'miguel_newpostform')); 					
					break;
 					case 'list_forum':
 					default:
 								$div->add($this->addForumList());
 								break;
 					case 'list_topic':
 								$this->addTopicList($div);
 								$div->add($this->addForm('forum', 'miguel_newtopicform'));
 								break;
 					case 'list_post':
 								$this->addPostList($div);
 								$div->add($this->addForm('forum', 'miguel_newpostform'));
 								break;
   				case 'new':
						if ($this->issetViewVariable('submit'))
						{
								$div->add($this->addNewForumInfo());
						} 
						else
						{
								$div->add($this->addForm('forum', 'miguel_forumform'));
						}
						break;
			}

			return $div;
    }
    /*
    function _getFileContent($filename)
    {
		//Debug::oneVar($filename, __FILE__, __LINE__);
        $data = 'Fichero vacio o no existe';
        
        if(file_exists($filename)) {
            //error_reporting(0);
            ob_start();
            include_once("$filename");
            $data = ob_get_contents();
            ob_end_clean();
        }
        //Debug::oneVar($data, __FILE__, __LINE__);

        return $data;
    }*/
 
}

?>
