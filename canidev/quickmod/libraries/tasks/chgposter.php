<?php
/**
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\quickmod\libraries\tasks;

class chgposter extends base
{
	public $permissions = 'm_chgposter';
	public $category 	= 'OPTIONS_ADVANCED';
	public $icon 		= 'fa-user';
	public $order 		= 1;
	public $title 		= 'CHANGE_POSTER_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if($this->core->modal_dialog(true))
		{
			$post_ids = array();
			$username = $this->request->variable('username', '', true);
			
			$sql = 'SELECT *
				FROM ' . USERS_TABLE . "
				WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'";
			$result = $this->db->sql_query($sql);
			$userdata = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			
			if(!$userdata)
			{
				return false;
			}
			
			// Get the posts ids
			$sql = 'SELECT topic_first_post_id
				FROM ' . TOPICS_TABLE . '
				WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$post_ids[] = $row['topic_first_post_id'];
			}
			$this->db->sql_freeresult($result);
			
			// Get posts data
			$posts_info = phpbb_get_post_data($post_ids, $this->permissions, true);
	
			if(sizeof($posts_info))
			{
				// Update all posts
				$sql = 'UPDATE ' . POSTS_TABLE . '
					SET poster_id = ' . $userdata['user_id'] . '
					WHERE ' . $this->db->sql_in_set('post_id', array_keys($posts_info));
				$this->db->sql_query($sql);
				
				// sync the posts info
				foreach($posts_info as $post_id => $post_info)
				{
					$this->change_post_author($post_info, $userdata);
				}

				$this->response->add('message', $this->language->lang('AUTHOR_CHANGE_SUCCESS'));
				
				return true;
			}

			return false;
		}

		$this->template->assign_vars(array(
			'DIALOG_CONTENT'	=> true,
			'S_CHGPOSTER'		=> true,
			'U_FIND_USERNAME'	=> append_sid($this->phpbb_root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=qm-dialog-form&amp;field=username&amp;select_single=true'),
		));

		$this->core->modal_dialog(
			false,
			'CHANGE_POSTER',
			array(
				'action'		=> 'chgposter',
				'topic_id_list'	=> $topic_ids,
			),
			'@canidev_quickmod/quickmod_ajax.html'
		);
	}

	/**
	 * Change author of post
	 * 
	 * @param array 	$post_info
	 * @param array 	$userdata
	 */
	protected function change_post_author($post_info, $userdata)
	{
		if($userdata['user_id'] == $post_info['user_id'])
		{
			return;
		}

		$post_id = $post_info['post_id'];

		// Resync topic/forum if needed
		if($post_info['topic_last_post_id'] == $post_id || $post_info['forum_last_post_id'] == $post_id || $post_info['topic_first_post_id'] == $post_id)
		{
			sync('topic', 'topic_id', $post_info['topic_id'], false, false);
			sync('forum', 'forum_id', $post_info['forum_id'], false, false);
		}

		// Adjust post counts... only if the post is approved (else, it was not added the users post count anyway)
		if($post_info['post_postcount'] && $post_info['post_visibility'] == ITEM_APPROVED)
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_posts = user_posts - 1
				WHERE user_id = ' . $post_info['user_id'] .'
				AND user_posts > 0';
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_posts = user_posts + 1
				WHERE user_id = ' . $userdata['user_id'];
			$this->db->sql_query($sql);
		}

		// Add posted to information for this topic for the new user
		markread('post', $post_info['forum_id'], $post_info['topic_id'], time(), $userdata['user_id']);

		// Remove the dotted topic option if the old user has no more posts within this topic
		if($this->config['load_db_track'] && $post_info['user_id'] != ANONYMOUS)
		{
			$sql = 'SELECT topic_id
				FROM ' . POSTS_TABLE . '
				WHERE topic_id = ' . $post_info['topic_id'] . '
					AND poster_id = ' . $post_info['user_id'];
			$result = $this->db->sql_query_limit($sql, 1);
			$topic_id = (int) $this->db->sql_fetchfield('topic_id');
			$this->db->sql_freeresult($result);

			if(!$topic_id)
			{
				$sql = 'DELETE FROM ' . TOPICS_POSTED_TABLE . '
					WHERE user_id = ' . $post_info['user_id'] . '
						AND topic_id = ' . $post_info['topic_id'];
				$this->db->sql_query($sql);
			}
		}

		// change the poster_id within the attachments table, else the data becomes out of sync and errors displayed because of wrong ownership
		if($post_info['post_attachment'])
		{
			$sql = 'UPDATE ' . ATTACHMENTS_TABLE . '
				SET poster_id = ' . $userdata['user_id'] . '
				WHERE poster_id = ' . $post_info['user_id'] . '
					AND post_msg_id = ' . $post_info['post_id'] . '
					AND topic_id = ' . $post_info['topic_id'];
			$this->db->sql_query($sql);
		}

		// refresh search cache of this post
		$search_type = $this->config['search_type'];

		if(class_exists($search_type))
		{
			// We do some additional checks in the module to ensure it can actually be utilised
			$error = false;
			$search = new $search_type(
				$error,
				$this->phpbb_root_path,
				$this->php_ext,
				$this->auth,
				$this->config,
				$this->db,
				$this->user,
				$this->dispatcher
			);

			if(!$error && method_exists($search, 'destroy_cache'))
			{
				$search->destroy_cache(array(), array($post_info['user_id'], $userdata['user_id']));
			}
		}
		
		/**
		* This event allows you to perform additional tasks after changing a post's poster
		*
		* @event core.mcp_change_poster_after
		* @var	array	userdata	Information on a post's new poster
		* @var	array	post_info	Information on the affected post
		* @since 3.1.6-RC1
		* @changed 3.1.7-RC1		Change location to prevent post_info from being set to the new post information
		*/
		$vars = array('userdata', 'post_info');
		extract($this->dispatcher->trigger_event('core.mcp_change_poster_after', compact($vars)));

		// Now add log entry
		$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_MCP_CHANGE_POSTER', false, array(
			'forum_id'	=> $post_info['forum_id'],
			'topic_id'	=> $post_info['topic_id'],
			$post_info['topic_title'],
			$post_info['username'],
			$userdata['username'],
		));	
	}
}
