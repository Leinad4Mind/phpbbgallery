<?php
/*
* @name last_replies_block.php
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

class last_replies_block extends base
{
	static $icon = 'blg-icon-bullhorn';

	public function init($method = '')
	{
		$this->tpl_name = 'last_replies_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$attachments = $attach_list = $rowset = $update_count = array();

		$topic_where 	= array(POST_NORMAL);
		$start			= ($method == 'pagination') ? $this->request->variable('start', 0) : 0;

		if(empty($data['forums']))
		{
			return false;
		}

		// Check forums auth if allowed
		if(!$data['ignore_auth'])
		{
			foreach($data['forums'] as $id => $forum_id)
			{
				if(!$this->auth->acl_get('f_read', $forum_id))
				{
					unset($data['forums'][$id]);
				}
			}
		}

		if(empty($data['forums']))
		{
			return true;
		}

		if($data['show_all'])
		{
			$topic_where = array_merge($topic_where, array(POST_STICKY, POST_ANNOUNCE));
		}
		
		$sql_ary = array(
			'SELECT'	=> 'f.forum_id, f.forum_name,
			t.topic_id, t.topic_time, t.topic_posts_approved, t.topic_views, t.poll_start, t.topic_last_post_time,
			p.post_id, p.post_subject, p.post_attachment, p.post_reported, p.post_username, p.post_text, p.bbcode_uid, p.bbcode_bitfield, p.enable_smilies,
			u.user_id, u.username, u.user_colour',

			'FROM'		=> array(TOPICS_TABLE => 't'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(POSTS_TABLE => 'p'),	'ON' => 't.topic_last_post_id = p.post_id'),
				array('FROM' => array(USERS_TABLE => 'u'),	'ON' => 'u.user_id = t.topic_last_poster_id'),
				array('FROM' => array(FORUMS_TABLE => 'f'),	'ON' => 'f.forum_id = t.forum_id'),
			),
			
			'WHERE'	=> $this->db->sql_in_set('t.topic_type', $topic_where) . '
				AND t.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . '
				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
				
			'ORDER_BY'	=> 't.topic_last_post_time DESC',
		);

		/**
		* @event block.last_replies_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.last_replies_query', compact($vars)));
		
		// Count total of topics
		if($data['pagination'])
		{
			$sql = $this->db->sql_build_query('SELECT', array(
				'SELECT'	=> 'COUNT(t.topic_id) AS topic_count',
				'FROM'		=> $sql_ary['FROM'],
				'WHERE'		=> $sql_ary['WHERE']
			));

			$result = $this->db->sql_query($sql);
			$topic_count = (int)$this->db->sql_fetchfield('topic_count');
			$this->db->sql_freeresult($result);
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, (int)$data['max'], $start);
		while($row = $this->db->sql_fetchrow($result))
		{
			// Does post have an attachment? If so, add it to the list
			if($data['display'] == BLOCK_STYLE_CONTENT_FULL && $row['post_attachment'] && $this->config['allow_attachments'])
			{
				if($this->auth->acl_get('u_download') && ($this->auth->acl_get('f_download', $row['forum_id']) || $data['ignore_auth']))
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
			while($row = $this->db->sql_fetchrow($result))
			{
				$attachments[$row['post_msg_id']][] = $row;
			}
			$this->db->sql_freeresult($result);
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('last_replies_row');
		$this->template->destroy_block_vars('block_pagination');

		foreach($rowset as $row)
		{
			$row_forum_id	= (int)$row['forum_id'];
			$row_topic_id 	= (int)$row['topic_id'];
			$u_view_topic	= $this->helper->url('viewtopic', "f=$row_forum_id&amp;t=$row_topic_id&amp;view=unread#unread");
			$message		= '';
	
			// Parse the message
			if($data['display'] == BLOCK_STYLE_CONTENT_FULL)
			{
				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
				$message = censor_text($row['post_text']);
				$message = generate_text_for_display($message, $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);

				if(!empty($attachments[$row['post_id']]))
				{
					parse_attachments($row['forum_id'], $message, $attachments[$row['post_id']], $update_count);
				}

				$read_more = $this->lang->get('BLG_READ_MORE', '<a class="blg-readmore-link" href="' . $u_view_topic . '">', '</a>');
				$message = $this->helper->html_truncate($message, $data['size'], "... $read_more");
			}
			
			$last_replies_row = array(
				'LAST_REPLIES_ID'				=> $row_topic_id,
				'TITLE'					=> censor_text($row['post_subject']),
				'TIME'					=> $this->user->format_date($row['topic_last_post_time']),
				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['post_id']])) ? true : false,
				'FORUM_NAME'			=> $row['forum_name'],
				'TEXT'					=> $message,
				'TOPIC_VIEWS'			=> $row['topic_views'],
				'S_POLL'				=> ($row['poll_start'] > 0) ? true : false,
				'POST_AUTHOR_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], $row['post_username']),
				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),

				'U_VIEW_TOPIC'			=> $u_view_topic,
				'U_VIEWFORUM'			=> $this->helper->url('viewforum', "f=$row_forum_id"),
				'U_VIEW_COMMENTS'		=> $this->helper->url('viewtopic', "f=$row_forum_id&amp;p=" . $row['post_id'] . '#p' . $row['post_id']),
				'U_POST_REPLY'			=> $this->helper->url('posting', "mode=reply&amp;f=$row_forum_id&amp;t=$row_topic_id"),
			);

			/**
			* @event block.last_replies_row
			* @var array	last_replies_row		The output array
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('last_replies_row', 'row');
			extract($this->dispatcher->trigger_event('block.last_replies_row', compact($vars)));

			$this->template->assign_block_vars('last_replies_row', $last_replies_row);	

			// Display not already displayed Attachments for this post, we already parsed them. ;)
			if(!empty($attachments[$row['post_id']]))
			{
				foreach($attachments[$row['post_id']] as $attachment)
				{
					$this->template->assign_block_vars('last_replies_row.attachment', array(
						'DISPLAY_ATTACHMENT'	=> $attachment)
					);
				}
			}
		}
		
		if($data['pagination'])
		{
			$pagination = $this->container->get('pagination');
			
			// Make sure $start is set to the last page if it exceeds the amount
			$start = $pagination->validate_start($start, $data['max'], $topic_count);

			$pagination->generate_template_pagination('#', 'block_pagination', 'start', $topic_count, $data['max'], $start);
		}

		$this->template->assign_vars(array(
			'S_LAST_REPLIES_COLLAPSE'		=> $data['collapse'],
			'S_LAST_REPLIES_FULL_CONTENT'	=> ($data['display'] == BLOCK_STYLE_CONTENT_FULL),
			
			'U_ACTION'				=> $this->helper->current_url(array(), false, array('start')),
		));

		unset($data, $rowset, $attachments);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['forums'] = $this->request->variable('forums', array(0));
		}
	}

	public function get_config()
	{
		$display_options = array(
			BLOCK_STYLE_CONTENT_FULL	=> 'LAST_REPLIES_SHOW_FULL',
			BLOCK_STYLE_CONTENT_SIMPLE	=> 'LAST_REPLIES_SHOW_SIMPLE',
		);
		
		$this->display_vars = array(
			'max'				=> array('lang' => 'LAST_REPLIES_NUMBER',			'validate' => 'int:1:100',	'type' => 'text:4:3',	'default' => 4),
			'display'			=> array('lang' => 'LAST_REPLIES_DISPLAY',			'type' => 'select',			'method' => 'helper',	'params' => array('make_select', $display_options, '{CONFIG_VALUE}'),	'default' => BLOCK_STYLE_CONTENT_FULL),
			'size'				=> array('lang' => 'LAST_REPLIES_SIZE',				'validate' => 'int:1:1000',	'type' => 'text:5:4',	'default' => 255),
			'forums'			=> array('lang' => 'FORUMS',				'type' => 'custom',		'method' => 'helper',		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'ignore_auth'		=> array('lang' => 'IGNORE_AUTH',			'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
			'show_all'			=> array('lang' => 'LAST_REPLIES_ALL',				'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
			'collapse'			=> array('lang' => 'LAST_REPLIES_COLLAPSE',			'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'pagination'		=> array('lang' => 'SHOW_PAGINATION',		'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
		);

		return true;
	}
}
