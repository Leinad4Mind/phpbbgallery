<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class topic_index_block extends base
{
	static $icon = 'fa-list-alt';

	/**
	 * {@inheritDoc}
	 */
	public function init($method = '')
	{
		$this->tpl_name = 'topic_index_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(empty($data['forums']))
		{
			return false;
		}

		$topic_list = $rowset = [];
		$sql_order			= '';
		$total_topic_count	= 0;
		$forum_id 			= 0;
		
		$start		= ($this->request->is_set_post('pagination')) ? $this->request->variable('start', 0) : 0;
		$first_char = $this->request->variable('fchar', '');

		foreach($data['forums'] as $id => $forum_id)
		{
			if(!$this->auth->acl_get('f_read', $forum_id))
			{
				unset($data['forums'][$id]);
			}
		}

		if(!sizeof($data['forums']))
		{
			return true;
		}

		if(!function_exists('topic_status'))
		{
			include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		}
		
		$sql_array = [
			'SELECT'	=> 't.*, f.*',
			'FROM'		=> [TOPICS_TABLE => 't'],
			'LEFT_JOIN' => [
				['FROM' => [FORUMS_TABLE => 'f'], 	'ON' => 'f.forum_id = t.forum_id']
			],
			'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . '
				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums'])
		];

		if($this->config['load_db_lastread'])
		{
			$sql_array['SELECT'] .= ', tt.mark_time, ft.mark_time as f_mark_time';

			$sql_array['LEFT_JOIN'][] = [
				'FROM'		=> [TOPICS_TRACK_TABLE => 'tt'],
				'ON'		=> 'tt.topic_id = t.topic_id AND tt.user_id = ' . $this->user->data['user_id'],
			];

			$sql_array['LEFT_JOIN'][] = [
				'FROM'		=> [FORUMS_TRACK_TABLE => 'ft'],
				'ON'		=> 'ft.forum_id = t.forum_id AND ft.user_id = ' . $this->user->data['user_id'],
			];
		}
		
		switch($data['sort_mode'])
		{
			case 'topic_title':
				if($first_char)
				{
					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . substr($first_char, 0, 1) . $this->db->get_any_char());
				}
				else {
					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . $this->db->get_any_char());
				}

				$sql_array['ORDER_BY'] = 'LOWER(t.topic_title) ASC';
			break;
			
			case 'topic_time':
			case 'topic_last_post_time':
				$sql_array['ORDER_BY'] = 't.' . $data['sort_mode'] . ' DESC';
			break;
		}

		$forum_data 	= new \canidev\core\DummyArray;
		$sort_dir 		= 'd';

		$sort_days = $sort_key = '';
		$topics_count = $total_topic_count = $forum_id = 0;

		/**
		 * Compatibility with other extensions
		 *
		 * @event core.viewforum_get_topic_data
		 * @var	array	forum_data			Array with forum data
		 * @var	array	sql_array			The SQL array to get the data of all topics
		 * @var	int		forum_id			The forum_id whose topics are being listed
		 * @var	int		topics_count		The total number of topics for display
		 * @var	int		sort_days			The oldest topic displayable in elapsed days
		 * @var	string	sort_key			The sorting by. It is one of the first character of (in low case):
		 *									Author, Post time, Replies, Subject, Views
		 * @var	string	sort_dir			Either "a" for ascending or "d" for descending
		 */
		$vars = [
			'forum_data',
			'sql_array',
			'forum_id',
			'topics_count',
			'sort_days',
			'sort_key',
			'sort_dir',
		];
		extract($this->dispatcher->trigger_event('core.viewforum_get_topic_data', compact($vars)));

		/**
		 * @event block.topic_index_query
		 * @var array	sql_array	The SQL data
		 * @var array	data		The Block configuration
		 * @since 2.0.0
		 */
		$vars = ['sql_array', 'data'];
		extract($this->dispatcher->trigger_event('block.topic_index_query', compact($vars)));

		$sql_array = \canidev\core\tools::filter_db_query($sql_array);
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('topic');
		$this->template->destroy_block_vars('block_pagination');
		
		// Count total of topics
		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT'	=> 'COUNT(t.topic_id) AS topic_count',
			'FROM'		=> $sql_array['FROM'],
			'WHERE'		=> $sql_array['WHERE']
		]);

		$result = $this->db->sql_query($sql);
		$total_topic_count = (int)$this->db->sql_fetchfield('topic_count');
		$this->db->sql_freeresult($result);

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = ($data['topics_per_page']) ? $this->db->sql_query_limit($sql, (int)$data['topics_per_page'], $start) : $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$topic_list[] = $row['topic_id'];
			$rowset[$row['topic_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		/**
		 * @event block.topic_index_modify_data
		 * @var	array	topic_list			Array with current topic ids
		 * @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		 * @var	array	data				Block Configuration
		 * @since 2.0.1
		 */
		$vars = ['topic_list', 'rowset', 'data'];
		extract($this->dispatcher->trigger_event('block.topic_index_modify_data', compact($vars)));

		/**
		 * Compatibility with other extensions
		 *
		 * @event core.viewforum_modify_topics_data
		 * @var	array	topic_list			Array with current viewforum page topic ids
		 * @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		 * @var	int		total_topic_count	Forum's total topic count
		 * @var	int		forum_id			Forum identifier
		 */
		$vars = ['topic_list', 'rowset', 'total_topic_count', 'forum_id'];
		extract($this->dispatcher->trigger_event('core.viewforum_modify_topics_data', compact($vars)));

		$icons 					= $this->container->get('cache')->obtain_icons();
		$topic_tracking_info 	= $this->helper->get_rowset_tracking($rowset);

		foreach($rowset as $topic_id => $row)
		{
			$topic_title 	= censor_text($row['topic_title']);
			$unread_topic 	= false;
			$replies 		= (int)$row['topic_posts_approved'] - 1;
			$view_topic_url_params = 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'];

			if($row['topic_status'] != ITEM_MOVED)
			{
				$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;
			}
			
			// Get folder img, topic status/type related information
			$row['topic_posted'] = ($row['topic_poster'] == $this->user->data['user_id']);

			$folder_img = $folder_alt = $topic_type = '';
			\topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);
			
			$topic_row = [
				'FORUM_NAME'			=> $row['forum_name'],
				'TOPIC_ID'				=> $row['topic_id'],
				'TOPIC_TITLE'			=> $topic_title,
				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),

				'REPLIES'				=> $replies,
				'VIEWS'					=> $row['topic_views'],
				'TOPIC_ICON_IMG'		=> ($row['enable_icons'] && !empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
				'TOPIC_IMG_STYLE'		=> $folder_img,
				'TOPIC_FOLDER_IMG_ALT'	=> $this->language->lang($folder_alt),
				'TOPIC_TYPE'			=> $topic_type,

				'S_TOPIC_REPORTED'	=> (!empty($row['topic_reported']) && $this->auth->acl_get('m_report', $row['forum_id'])),
				'S_POST_ANNOUNCE'	=> ($row['topic_type'] == POST_ANNOUNCE),
				'S_POST_GLOBAL'		=> ($row['topic_type'] == POST_GLOBAL),
				'S_POST_STICKY'		=> ($row['topic_type'] == POST_STICKY),
				'S_UNREAD_TOPIC'	=> $unread_topic,

				'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
				'U_NEWEST_POST'		=> $this->helper->url('viewtopic', 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '&amp;view=unread#unread'),
				'U_VIEW_FORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id']),
				'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params),
			];

			/**
			 * Compatibility with other extensions
			 *
			 * @event core.viewforum_modify_topicrow
			 * @var	array	row					Array with topic data
			 * @var	array	topic_row			Template array with topic data
			 */
			$vars = ['row', 'topic_row'];
			extract($this->dispatcher->trigger_event('core.viewforum_modify_topicrow', compact($vars)));

			$this->template->assign_block_vars('topic', $topic_row);
		}

		if($data['char_select'])
		{
			$first_characters = ['' => $this->language->lang('CHAR_ALL')];

			for($i = 97; $i < 123; $i++)
			{
				$first_characters[chr($i)] = chr($i - 32);
			}

			foreach($first_characters as $char => $desc)
			{
				$this->template->assign_block_vars('first_char', [
					'DESC'			=> $desc,
					'VALUE'			=> $char,
					'S_SELECTED'	=> ($first_char == $char) ? true : false,
				]);
			}
		}
		
		$pagination = $this->container->get('pagination');
		
		// Make sure $start is set to the last page if it exceeds the amount
		$start = $pagination->validate_start($start, $data['topics_per_page'], $total_topic_count);
		
		$pagination->generate_template_pagination('#', 'block_pagination', 'start', $total_topic_count, $data['topics_per_page'], $start);
		
		$this->template->assign_vars([
			'S_CHAR_SELECT'			=> ($data['sort_mode'] == 'topic_title' && $data['char_select']) ? true : false,
			'S_FIRST_CHAR'			=> $first_char,
			'SHOW_TOPIC_PARENT'		=> $data['show_parent'],
			'TOPIC_DESIGN' 			=> $data['topic_design'],
			
			'U_ACTION'				=> $this->helper->current_url([], false, ['start']),
		]);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['forums'] = $this->request->variable('forums', [0]);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$sort_options = [
			'topic_title'			=> 'TOPIC_TITLE',
			'topic_time'			=> 'TOPIC_TIME',
			'topic_last_post_time'	=> 'LAST_POST_TIME',
		];

		$this->display_vars = [
			'forums'			=> ['lang' => 'FORUMS',					'type' => 'custom',			'function' => ['tools', 'forums_select'],		'params' => ['forums', '{CONFIG_VALUE}', 1],	'default' => []],
			'topics_per_page'	=> ['lang' => 'TINDEX_PER_PAGE',		'validate' => 'int:0:1000',	'type' => 'number:0:1000',	'default' => 25],
			'sort_mode'			=> ['lang' => 'TINDEX_SORT_MODE',		'valitate' => 'string',		'type' => 'select',			'function' => ['tools', 'make_select'],	'params' => [$sort_options, false, '{CONFIG_VALUE}'],	'default' => 'topic_title'],
			'char_select'		=> ['lang' => 'TINDEX_CHAR_SELECT',		'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1],
			'topic_design'		=> ['lang' => 'TOPIC_DESIGN',			'type' => 'select',			'function' => ['helper_acp', 'block_design_select'], 	'params' => ['{CONFIG_VALUE}']],
			'show_parent'		=> ['lang' => 'TOPIC_PARENT_SHOW',		'validate' => 'bool',		'type' => 'radio:yes_no'],
		];

		return true;
	}
}
