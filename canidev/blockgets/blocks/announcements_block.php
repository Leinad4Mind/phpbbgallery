<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class announcements_block extends base
{
	static $icon = 'fa-newspaper-o';

	public function init()
	{
		$this->tpl_name = 'announcements_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$attachments = $attach_list = $rowset = $topic_list = $update_count = array();
		
		$total_topic_count 	= 0;
		$forum_id 			= 0;
		$sql_where 			= '';

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
			'SELECT'	=> 't.*,
				p.post_subject, p.post_attachment, p.post_reported, p.post_username, p.post_text, p.bbcode_uid, p.bbcode_bitfield, p.enable_smilies,
				u.username, u.user_colour',

			'FROM'		=> array(TOPICS_TABLE => 't'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(POSTS_TABLE => 'p'),	'ON' => 't.topic_first_post_id = p.post_id'),
				array('FROM' => array(USERS_TABLE => 'u'),	'ON' => 'u.user_id = t.topic_poster'),
			),
			
			'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . $sql_where,
			'ORDER_BY'	=> 't.topic_time DESC',
		);

		/*
		* @event block.announcements_query
		* @var array	sql_ary		The SQL array to get the data
		* @var array	data		The Block configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
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
					$attach_list[] = (int) $row['topic_first_post_id'];
				}
			}

			$topic_list[] = $row['topic_id'];
			$rowset[$row['topic_id']] = $row;
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

		/*
		* @event block.announcements_modify_data
		* @var	array	topic_list			Array with current topic ids
		* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		* @var	array	data				Block Configuration
		* @since 2.0.1
		*/
		$vars = array('topic_list', 'rowset', 'data');
		extract($this->dispatcher->trigger_event('block.announcements_modify_data', compact($vars)));

		/*
		* Compatibility with other extensions
		*
		* @event core.viewforum_modify_topics_data
		* @var	array	topic_list			Array with current viewforum page topic ids
		* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		* @var	int		total_topic_count	Forum's total topic count
		* @var	int		forum_id			Forum identifier
		*/
		$vars = array('topic_list', 'rowset', 'total_topic_count', 'forum_id');
		extract($this->dispatcher->trigger_event('core.viewforum_modify_topics_data', compact($vars)));

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('ann_row');

		foreach($rowset as $topic_id => $row)
		{
			$row_forum_id = (int)$row['forum_id'];
			$row_topic_id = (int)$row['topic_id'];
			
			// Parse the message and subject
			$message = censor_text($row['post_text']);
			
			// Parse the message
			$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
			$message = generate_text_for_display($message, $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);

			if(!empty($attachments[$row['topic_first_post_id']]))
			{
				parse_attachments($row_forum_id, $message, $attachments[$row['topic_first_post_id']], $update_count);
			}
			
			$u_view_topic = $this->helper->url('viewtopic', array('f' => $row_forum_id, 't' => $row_topic_id));

			$read_more = $this->lang->lang('BLG_READ_MORE', '<a class="blg-readmore-link" href="' . $u_view_topic . '">', '</a>');
			$message = \canidev\core\tools::html_truncate($message, $data['max_size'], "... $read_more");
			
			$topic_row = array(
				'TOPIC_ID'				=> $row_topic_id,
				'TOPIC_TITLE'			=> censor_text($row['post_subject']),
				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
				'TEXT'					=> $message,
				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
				'U_VIEW_TOPIC'			=> $u_view_topic,
			);

			/*
			* Modify the topic data before it is assigned to the template
			*
			* @event core.viewforum_modify_topicrow
			* @var	array	row					Array with topic data
			* @var	array	topic_row			Template array with topic data
			*/
			$vars = array('row', 'topic_row');
			extract($this->dispatcher->trigger_event('core.viewforum_modify_topicrow', compact($vars)));

			$this->template->assign_block_vars('ann_row', $topic_row);

			// Display not already displayed Attachments for this post, we already parsed them. ;)
			if(!empty($attachments[$row['topic_first_post_id']]))
			{
				foreach($attachments[$row['topic_first_post_id']] as $attachment)
				{
					$this->template->assign_block_vars('ann_row.attachment', array(
						'DISPLAY_ATTACHMENT'	=> $attachment
					));
				}
			}
		}

		$this->template->assign_var('S_ANNS_COLLAPSE', $data['collapse']);

		unset($data, $rowset, $attachments);
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
			'max_number'	=> array('lang' => 'ANN_MAX_NUMBER',	'validate' => 'int:1',	'type' => 'number:1:99',	'default' => 4),
			'max_size'		=> array('lang' => 'ANN_MAX_SIZE',		'validate' => 'int:1',	'type' => 'number',			'default' => 255),
			'forums'		=> array('lang' => 'FORUMS',			'type' => 'custom',		'method' => 'helper', 		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'show_globals'	=> array('lang' => 'ANN_SHOW_GLOBALS',	'validate' => 'bool',	'type' => 'radio:yes_no'),
			'collapse'		=> array('lang' => 'ANN_COLLAPSE',		'validate' => 'bool',	'type' => 'radio:yes_no'),
		);

		return true;
	}
}
