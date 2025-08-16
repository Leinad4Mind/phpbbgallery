<?php
/*
* @name post_view_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class post_view_block extends base
{
	static $icon = 'blg-icon-file-text-o';

	public function init()
	{
		$this->tpl_name = 'post_view_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		switch($data['mode'])
		{
			case 'custom':
				$sql_ary = array(
					'SELECT'	=> 'p.*',
					'FROM'		=> array(POSTS_TABLE => 'p'),
					'WHERE'		=> 'p.post_id = ' . (int)$data['item_id']
				);
			break;

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
						AND f.forum_id = ' . (int)$data['item_id']
				);
			break;
			
			case 'topic_first':
			case 'topic_last':
				$sql_ary = array(
					'SELECT'	=> 'p.*',
					'FROM'		=> array(TOPICS_TABLE => 't'),
					
					'LEFT_JOIN'	=> array(
						array(
							'FROM' => array(POSTS_TABLE => 'p'),
							'ON'	=> 'p.post_id = t.' . $data['mode'] . '_post_id'
						)
					),
					
					'WHERE'		=> 't.topic_visibility = ' . ITEM_APPROVED . '
						AND t.topic_id = ' . (int)$data['item_id']
				);
			break;

			default:
				return false;
			break;
		}

		/**
		* @event block.post_view_query
		* @var array	sql_ary		The SQL data
		* @var array	data		The block data
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

		if(!empty($attachments))
		{
			parse_attachments($post_data['forum_id'], $message, $attachments, $update_count);
		}

		$this->template->assign_vars(array(
			'PV_HAS_ATTACHMENTS'	=> (!empty($attachments) ? true : false),
			'PV_CONTENT'			=> $message,
		));
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('pv_attachment');

		// Display not already displayed Attachments for this post, we already parsed them. ;)
		if(!empty($attachments))
		{
			foreach($attachments as $attachment)
			{
				$this->template->assign_block_vars('pv_attachment', array(
					'DISPLAY_ATTACHMENT'	=> $attachment
				));
			}
		}

		unset($data, $post_data, $attachments);
		return true;
	}

	public function get_config()
	{
		$modes = array(
			'forum'			=> 'PV_MODE_FORUM',
			'topic_first'	=> 'PV_MODE_TOPIC_FIRST',
			'topic_last'	=> 'PV_MODE_TOPIC_LAST',
			'custom'		=> 'PV_MODE_CUSTOM',
		);
		
		$this->display_vars = array(
			'mode'			=> array('lang' => 'PV_MODE',		'type' => 'select',		'method' => 'helper',		'params' => array('make_select', $modes, '{CONFIG_VALUE}'),	'default' => 'custom'),
			'item_id'		=> array('lang' => 'PV_ITEM_ID',	'validate' => 'int:1',	'type' => 'text:5:8'),
			'ignore_auth'	=> array('lang' => 'IGNORE_AUTH',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
		);

		return true;
	}
}
