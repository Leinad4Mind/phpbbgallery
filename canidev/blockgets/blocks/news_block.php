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

class news_block extends base
{
	static $icon = 'fa-bullhorn';

	public function init($method = '')
	{
		$this->tpl_name = 'news_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$attachments = $attach_list = $rowset = $topic_list = $update_count = array();

		$total_topic_count 	= 0;
		$forum_id 			= 0;
		$topic_where 		= array(POST_NORMAL);
		$start				= ($this->request->is_set_post('pagination')) ? $this->request->variable('start', 0) : 0;

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
			'SELECT'	=> 'f.forum_name, t.*,
			p.post_subject, p.post_attachment, p.post_reported, p.post_username, p.post_text, p.bbcode_uid, p.bbcode_bitfield, p.enable_smilies,
			u.username, u.user_colour',

			'FROM'		=> array(TOPICS_TABLE => 't'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(POSTS_TABLE => 'p'),	'ON' => 't.topic_first_post_id = p.post_id'),
				array('FROM' => array(USERS_TABLE => 'u'),	'ON' => 'u.user_id = t.topic_poster'),
				array('FROM' => array(FORUMS_TABLE => 'f'),	'ON' => 'f.forum_id = t.forum_id'),
			),
			
			'WHERE'	=> $this->db->sql_in_set('t.topic_type', $topic_where) . '
				AND t.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . '
				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
				
			'ORDER_BY'	=> 't.topic_time DESC',
		);

		/*
		* @event block.news_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.news_query', compact($vars)));
		
		// Count total of topics
		if($data['pagination'])
		{
			$sql = $this->db->sql_build_query('SELECT', array(
				'SELECT'	=> 'COUNT(t.topic_id) AS topic_count',
				'FROM'		=> $sql_ary['FROM'],
				'WHERE'		=> $sql_ary['WHERE']
			));

			$result = $this->db->sql_query($sql);
			$total_topic_count = (int)$this->db->sql_fetchfield('topic_count');
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
			while($row = $this->db->sql_fetchrow($result))
			{
				$attachments[$row['post_msg_id']][] = $row;
			}
			$this->db->sql_freeresult($result);
		}

		/*
		* @event block.news_modify_data
		* @var	array	topic_list			Array with current topic ids
		* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		* @var	array	attach_list			Array with current attachment post ids
		* @var	array	attachments			Array with attachments data (in post_id => attachment_rows format)
		* @var	array	data				Block Configuration
		* @since 2.0.1
		*/
		$vars = array('topic_list', 'rowset', 'attach_list', 'attachments', 'data');
		extract($this->dispatcher->trigger_event('block.news_modify_data', compact($vars)));

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
		$this->template->destroy_block_vars('news_row');
		$this->template->destroy_block_vars('block_pagination');

		foreach($rowset as $topic_id => $row)
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

				if(!empty($attachments[$row['topic_first_post_id']]))
				{
					parse_attachments($row['forum_id'], $message, $attachments[$row['topic_first_post_id']], $update_count);
				}

				$read_more = $this->lang->lang('BLG_READ_MORE', '<a class="blg-readmore-link" href="' . $u_view_topic . '">', '</a>');
				$message = \canidev\core\tools::html_truncate($message, $data['size'], "... $read_more");
			}
			
			$topic_row = array(
				'TOPIC_ID'				=> $row_topic_id,
				'TOPIC_TITLE'			=> censor_text($row['post_subject']),
				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
				'FORUM_NAME'			=> $row['forum_name'],
				'TEXT'					=> $message,
				'VIEWS'					=> $row['topic_views'],
				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),

				'U_VIEW_TOPIC'			=> $u_view_topic,
				'U_VIEW_FORUM'			=> $this->helper->url('viewforum', "f=$row_forum_id"),
				'U_POST_REPLY'			=> $this->helper->url('posting', "mode=reply&amp;f=$row_forum_id&amp;t=$row_topic_id"),
			);

			/*
			* Compatibility with other extensions
			*
			* @event core.viewforum_modify_topicrow
			* @var	array	row					Array with topic data
			* @var	array	topic_row			Template array with topic data
			*/
			$vars = array('row', 'topic_row');
			extract($this->dispatcher->trigger_event('core.viewforum_modify_topicrow', compact($vars)));

			$this->template->assign_block_vars('news_row', $topic_row);	

			// Display not already displayed Attachments for this post, we already parsed them. ;)
			if(!empty($attachments[$row['topic_first_post_id']]))
			{
				foreach($attachments[$row['topic_first_post_id']] as $attachment)
				{
					$this->template->assign_block_vars('news_row.attachment', array(
						'DISPLAY_ATTACHMENT'	=> $attachment)
					);
				}
			}
		}
		
		if($data['pagination'])
		{
			$pagination = $this->container->get('pagination');
			
			// Make sure $start is set to the last page if it exceeds the amount
			$start = $pagination->validate_start($start, $data['max'], $total_topic_count);

			$pagination->generate_template_pagination('#', 'block_pagination', 'start', $total_topic_count, $data['max'], $start);
		}

		$this->template->assign_vars(array(
			'S_NEWS_COLLAPSE'		=> $data['collapse'],
			'S_NEWS_FULL_CONTENT'	=> ($data['display'] == BLOCK_STYLE_CONTENT_FULL),
			
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
			BLOCK_STYLE_CONTENT_FULL	=> 'NEWS_SHOW_FULL',
			BLOCK_STYLE_CONTENT_SIMPLE	=> 'NEWS_SHOW_SIMPLE',
		);
		
		$this->display_vars = array(
			'max'				=> array('lang' => 'NEWS_NUMBER',			'validate' => 'int:1:100',	'type' => 'number:1:100',	'default' => 4),
			'display'			=> array('lang' => 'NEWS_DISPLAY',			'type' => 'select',			'method' => 'helper',		'params' => array('make_select', $display_options, false, '{CONFIG_VALUE}'),	'default' => BLOCK_STYLE_CONTENT_FULL),
			'size'				=> array('lang' => 'NEWS_SIZE',				'validate' => 'int:1:1000',	'type' => 'number:1:1000',	'default' => 255),
			'forums'			=> array('lang' => 'FORUMS',				'type' => 'custom',			'method' => 'helper',		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'ignore_auth'		=> array('lang' => 'IGNORE_AUTH',			'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 0),
			'show_all'			=> array('lang' => 'NEWS_ALL',				'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 0),
			'collapse'			=> array('lang' => 'NEWS_COLLAPSE',			'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1),
			'pagination'		=> array('lang' => 'SHOW_PAGINATION',		'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 0),
		);

		return true;
	}
}
