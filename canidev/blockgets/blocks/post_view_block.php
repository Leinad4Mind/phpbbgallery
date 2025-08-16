<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class post_view_block extends base
{
	static $icon = 'fa-file-text-o';

	public function init()
	{
		$this->tpl_name = 'post_view_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(($config = $this->get_config_from_url($data['item_url'])) === false)
		{
			return false;
		}

		switch($config['mode'])
		{
			case 'forum':
				$sql_ary = array(
					'SELECT'	=> 'p.*',
					'FROM'		=> array(FORUMS_TABLE => 'f'),
					
					'LEFT_JOIN'	=> array(
						array(
							'FROM' => array(POSTS_TABLE => 'p'),
							'ON'	=> 'p.post_id = f.forum_last_post_id'
						)
					),
					
					'WHERE'		=> 'f.forum_type = ' . FORUM_POST . '
						AND f.forum_id = ' . $config['id']
				);
			break;

			case 'post':
				$sql_ary = array(
					'SELECT'	=> 'p.*',
					'FROM'		=> array(POSTS_TABLE => 'p'),
					'WHERE'		=> 'p.post_id = ' . $config['id']
				);
			break;
			
			case 'topic':
				$sql_ary = array(
					'SELECT'	=> 'p.*',
					'FROM'		=> array(TOPICS_TABLE => 't'),
					
					'LEFT_JOIN'	=> array(
						array(
							'FROM' => array(POSTS_TABLE => 'p'),
							'ON'	=> 'p.post_id = t.topic_last_post_id'
						)
					),
					
					'WHERE'		=> 't.topic_visibility = ' . ITEM_APPROVED . '
						AND t.topic_id = ' . $config['id']
				);
			break;

			default:
				return false;
			break;
		}

		/*
		* @event block.post_view_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.post_view_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$post_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		
		if(!$post_data || (!$this->auth->acl_get('f_read', $post_data['forum_id']) && !$data['ignore_auth']))
		{
			return false;
		}
		
		$attachments = $update_count = array();
		
		// Does post have an attachment? If so, add it to the list
		if($post_data['post_attachment'] && $this->config['allow_attachments'] && $this->auth->acl_get('u_download') && 
			($this->auth->acl_get('f_download', $post_data['forum_id']) || $data['ignore_auth']))
		{
			$sql = 'SELECT *
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE ' . $this->db->sql_in_set('post_msg_id', $post_data['post_id']) . '
					AND in_message = 0
				ORDER BY filetime DESC, post_msg_id ASC';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$attachments[] = $row;
			}
			$this->db->sql_freeresult($result);
		}
		
		// Parse the message
		$parse_flags = ($post_data['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
		$message = censor_text($post_data['post_text']);
		$message = generate_text_for_display($message, $post_data['bbcode_uid'], $post_data['bbcode_bitfield'], $parse_flags, true);

		if(sizeof($attachments))
		{
			parse_attachments($post_data['forum_id'], $message, $attachments, $update_count);
		}

		$this->template->assign_vars(array(
			'PV_HAS_ATTACHMENTS'	=> sizeof($attachments) ? true : false,
			'PV_CONTENT'			=> $message,
		));
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('pv_attachment');

		// Display not already displayed Attachments for this post, we already parsed them. ;)
		foreach($attachments as $attachment)
		{
			$this->template->assign_block_vars('pv_attachment', array(
				'DISPLAY_ATTACHMENT'	=> $attachment
			));
		}

		unset($data, $post_data, $attachments);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'item_url'		=> array('lang' => 'PV_ITEM_URL',	'validate' => 'url',	'type' => 'text:40:255'),
			'ignore_auth'	=> array('lang' => 'IGNORE_AUTH',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
		);

		return true;
	}

	protected function get_config_from_url($url)
	{
		if(($url_parts = @parse_url($url)) === false)
		{
			return false;
		}

		// External url is not allowed
		if($url_parts['host'] &&
			stripos($this->request->server('HTTP_HOST', ''), $url_parts['host']) === false)
		{
			return false;
		}

		$filename 	= basename($url_parts['path'], '.' . $this->php_ext);
		$params 	= array();

		parse_str(str_replace('&amp;', '&', $url_parts['query']), $params);

		switch($filename)
		{
			case 'viewforum':
				if(isset($params['f']))
				{
					return array(
						'mode' 	=> 'forum',
						'id'	=> (int)$params['f'],
					);
				}
			break;

			case 'viewtopic':
				if(isset($params['p']))
				{
					return array(
						'mode' 	=> 'post',
						'id'	=> (int)$params['p'],
					);
				}

				if(isset($url_parts['fragment']) && preg_match('#^p([0-9]+)#', $url_parts['fragment'], $match))
				{
					return array(
						'mode' 	=> 'post',
						'id'	=> (int)$match[1],
					);
				}
				
				if(isset($params['t']))
				{
					return array(
						'mode' 	=> 'topic',
						'id'	=> (int)$params['t'],
					);
				}
			break;
		}

		return false;
	}
}
