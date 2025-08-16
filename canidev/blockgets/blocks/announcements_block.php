<?php
/*
* @name announcements_block.php
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

class announcements_block extends base
{
	static $icon = 'blg-icon-newspaper-o';

	public function init()
	{
		$this->tpl_name = 'announcements_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$attachments = $attach_list = $rowset = $update_count = array();
		$sql_where = '';

		if(!empty($data['forums']))
		{
			foreach($data['forums'] as $id => $forum_id)
			{
				if(!$this->auth->acl_get('f_read', $forum_id))
				{
					unset($data['forums'][$id]);
				}
			}
		}

		if(!empty($data['forums']))
		{
			$sql_where = ' AND ((t.topic_type = ' .  POST_ANNOUNCE . ' AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']) . ')' . 
				(($data['show_globals']) ? ' OR t.topic_type = ' .  POST_GLOBAL : '') . ')';

		}
		else if($data['show_globals'])
		{
			$sql_where = ' AND t.topic_type = ' .  POST_GLOBAL;
		}

		if(!$sql_where)
		{
			return true;
		}
			
		$sql_ary = array(
			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_time, t.topic_posts_approved, t.topic_views, t.poll_start,
				p.post_id, p.post_subject, p.post_attachment, p.post_reported, p.post_username, p.post_text, p.bbcode_uid, p.bbcode_bitfield, p.enable_smilies,
				u.user_id, u.username, u.user_colour',

			'FROM'		=> array(TOPICS_TABLE => 't'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(POSTS_TABLE => 'p'),	'ON' => 't.topic_first_post_id = p.post_id'),
				array('FROM' => array(USERS_TABLE => 'u'),	'ON' => 'u.user_id = t.topic_poster'),
			),
			
			'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . $sql_where,
			'ORDER_BY'	=> 't.topic_time DESC',
		);

		/**
		* @event block.announcements_query
		* @var array	sql_ary		The SQL array to get the data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.announcements_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, (int)$data['max_number']);
		while($row = $this->db->sql_fetchrow($result))
		{
			// Does post have an attachment? If so, add it to the list
			if($row['post_attachment'] && $this->config['allow_attachments'])
			{
				if($this->auth->acl_get('u_download') && $this->auth->acl_get('f_download', $row['forum_id']))
				{
					$attach_list[] = (int) $row['post_id'];
				}
			}

			$rowset[] = $row;
		}
		$this->db->sql_freeresult($result);

		// Pull attachment data
		if(sizeof($attach_list))
		{
			$sql = 'SELECT *
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE ' . $this->db->sql_in_set('post_msg_id', $attach_list) . '
					AND in_message = 0
				ORDER BY filetime DESC, post_msg_id ASC';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$attachments[$row['post_msg_id']][] = $row;
			}
			$this->db->sql_freeresult($result);
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('ann_row');

		foreach($rowset as $row)
		{
			$row_forum_id = (int)$row['forum_id'];
			$row_topic_id = (int)$row['topic_id'];
			
			// Parse the message and subject
			$message = censor_text($row['post_text']);
			
			// Parse the message
			$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
			$message = generate_text_for_display($message, $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);

			if(!empty($attachments[$row['post_id']]))
			{
				parse_attachments($row_forum_id, $message, $attachments[$row['post_id']], $update_count);
			}
			
			$u_view_topic = $this->helper->url('viewtopic', array('f' => $row_forum_id, 't' => $row_topic_id));

			$read_more = $this->lang->get('BLG_READ_MORE', '<a class="blg-readmore-link" href="' . $u_view_topic . '">', '</a>');
			$message = $this->helper->html_truncate($message, $data['max_size'], "... $read_more");
			
			$ann_row = array(
				'ID'					=> $row_topic_id,
				'TITLE'					=> censor_text($row['post_subject']),
				'TIME'					=> $this->user->format_date($row['topic_time']),
				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['post_id']])) ? true : false,
				'TEXT'					=> $message,
				'POST_AUTHOR_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], $row['post_username']),
				'U_VIEW_TOPIC'			=> $u_view_topic,
			);

			/**
			* @event block.announcements_row
			* @var array	ann_row		The output array
			* @var array	row			The original data array
			* @since 2.0.0
			*/
			$vars = array('ann_row', 'row');
			extract($this->dispatcher->trigger_event('block.announcements_row', compact($vars)));

			$this->template->assign_block_vars('ann_row', $ann_row);

			// Display not already displayed Attachments for this post, we already parsed them. ;)
			if(!empty($attachments[$row['post_id']]))
			{
				foreach ($attachments[$row['post_id']] as $attachment)
				{
					$this->template->assign_block_vars('ann_row.attachment', array(
						'DISPLAY_ATTACHMENT'	=> $attachment
					));
				}
			}

			unset($rowset[$row['post_id']]);
			unset($attachments[$row['post_id']]);
		}

		$this->template->assign_var('S_ANNS_COLLAPSE', $data['collapse']);

		unset($data, $rowset, $user_cache);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['forums'] = $this->request->variable('forums', array(0));
		}

		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'max_number'	=> array('lang' => 'ANN_MAX_NUMBER',	'validate' => 'int:1',	'type' => 'text:4:3',	'default' => 4),
			'max_size'		=> array('lang' => 'ANN_MAX_SIZE',		'validate' => 'int:1',	'type' => 'text:4:3',	'default' => 255),
			'forums'		=> array('lang' => 'FORUMS',			'type' => 'custom',		'method' => 'helper', 	'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'show_globals'	=> array('lang' => 'ANN_SHOW_GLOBALS',	'validate' => 'bool',	'type' => 'radio:yes_no'),
			'collapse'		=> array('lang' => 'ANN_COLLAPSE',		'validate' => 'bool',	'type' => 'radio:yes_no'),
		);

		return true;
	}
}
