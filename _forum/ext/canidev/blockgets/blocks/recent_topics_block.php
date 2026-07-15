<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class recent_topics_block extends base
{
	const TAB_TOPICS 	= 1;
	const TAB_ANN 		= 2;
	const TAB_ACTIVITY	= 3;
	
	static $icon = 'fa-history';

	public static $default_sections = array(
		self::TAB_TOPICS	=> true,
		self::TAB_ANN		=> true,
		self::TAB_ACTIVITY	=> true,
	);

	public function init()
	{
		$this->tpl_name = 'recent_topics_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(!function_exists('topic_status'))
		{
			include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		}
		
		$forum_ids = $topic_list = $rowset = array();
		
		// Use selected forums if set, else, use all forums
		if(!empty($data['forums']))
		{
			foreach($data['forums'] as $forum_id)
			{
				if($this->auth->acl_get('f_read', $forum_id))
				{
					$forum_ids[] = $forum_id;
				}
			}
		}
		else
		{
			$forum_ids = array_keys($this->auth->acl_getf('f_read', true));
		}

		if(!sizeof($forum_ids))
		{
			return false;
		}

		$tab_ary = array(
			self::TAB_TOPICS => array(
				'title'			=> 'BLG_RECENT_TOPICS',
				'icon'			=> 'fa-comment',
				'where'			=> '',
				'order_by'		=> 't.topic_time DESC',
			),

			self::TAB_ANN => array(
				'title'			=> 'BLG_RECENT_ANN',
				'icon'			=> 'fa-newspaper-o',
				'where'			=> 'AND t.topic_type = ' . POST_ANNOUNCE . ')
					OR (t.forum_id = 0 AND t.topic_type = ' . POST_GLOBAL . ')',
				'order_by'		=> 't.topic_time DESC',
			),

			self::TAB_ACTIVITY => array(
				'title'			=> 'BLG_RECENT_ACTIVITY',
				'icon'			=> 'fa-comments-o',
				'where'			=> 'AND t.topic_posts_approved > 1)',
				'order_by'		=> 't.topic_last_post_time DESC',
			),
		);

		/*
		* @event block.recent_topics_tabs
		* @var array	tab_ary		Tabs info
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('tab_ary', 'data');
		extract($this->dispatcher->trigger_event('block.recent_topics_tabs', compact($vars)));
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('recent_tab');

		foreach($data['sections'] as $tab_id => $tab_enabled)
		{
			if(!$tab_enabled)
			{
				continue;
			}

			$tab_data = $tab_ary[$tab_id];

			$tab_ary[$tab_id]['topic_list'] = array();

			$sql_array = array(
				'SELECT'	=> 't.*, f.forum_name, f.enable_icons',
				'FROM'		=> array(TOPICS_TABLE => 't'),

				'LEFT_JOIN' => array(
					array('FROM' => array(FORUMS_TABLE => 'f'), 	'ON' => 'f.forum_id = t.forum_id')
				),
				
				'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
					AND t.topic_visibility = ' . ITEM_APPROVED . '
					AND (' . $this->db->sql_in_set('t.forum_id', $forum_ids) . (!empty($tab_data['where']) ? ' ' . $tab_data['where'] : ')'),
					
				'ORDER_BY'	=> $tab_data['order_by'],
			);

			if($this->config['load_db_lastread'])
			{
				$sql_array['SELECT'] .= ', tt.mark_time, ft.mark_time as f_mark_time';

				$sql_array['LEFT_JOIN'][] = array(
					'FROM'		=> array(TOPICS_TRACK_TABLE => 'tt'),
					'ON'		=> 'tt.topic_id = t.topic_id AND tt.user_id = ' . $this->user->data['user_id'],
				);

				$sql_array['LEFT_JOIN'][] = array(
					'FROM'		=> array(FORUMS_TRACK_TABLE => 'ft'),
					'ON'		=> 'ft.forum_id = t.forum_id AND ft.user_id = ' . $this->user->data['user_id'],
				);
			}

			/*
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
			$forum_data 	= array();
			$sort_dir 		= 'd';

			$sort_days = $sort_key = '';
			$topics_count = $total_topic_count = $forum_id = 0;

			$vars = array(
				'forum_data',
				'sql_array',
				'forum_id',
				'topics_count',
				'sort_days',
				'sort_key',
				'sort_dir',
			);
			extract($this->dispatcher->trigger_event('core.viewforum_get_topic_data', compact($vars)));

			/*
			* @event block.recent_topics_tab_query
			* @var array	sql_array		The SQL data
			* @var int		tab_id			ID of current Tab
			* @var array	tab_data		Data of current Tab
			* @var	array	data			Block Configuration
			* @since 2.0.0
			*/
			$vars = array('sql_array', 'tab_id', 'tab_data', 'data');
			extract($this->dispatcher->trigger_event('block.recent_topics_tab_query', compact($vars)));

			$sql_array 	= $this->helper->filter_query($sql_array);
			$sql 		= $this->db->sql_build_query('SELECT', $sql_array);
			$result 	= $this->db->sql_query_limit($sql, (int)$data['topic_limit']);
			
			while($row = $this->db->sql_fetchrow($result))
			{
				$topic_list[] = $row['topic_id'];
				$rowset[$row['topic_id']] = $row;

				$tab_ary[$tab_id]['topic_list'][] = $row['topic_id'];
			}
			$this->db->sql_freeresult($result);

			/*
			* For compatibility with other extension
			*
			* @event core.viewforum_modify_topics_data
			* @var	array	topic_list			Array with current topic ids
			* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
			* @var	int		total_topic_count	Forum's total topic count
			* @var	int		forum_id			Forum identifier
			*/
			$vars = array('topic_list', 'rowset', 'total_topic_count', 'forum_id');
			extract($this->dispatcher->trigger_event('core.viewforum_modify_topics_data', compact($vars)));

			/*
			* @event block.recent_topics_modify_data
			* @var	array	topic_list			Array with current topic ids
			* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
			* @var	array	data				Block Configuration
			* @since 2.0.1
			*/
			$vars = array('topic_list', 'rowset', 'data');
			extract($this->dispatcher->trigger_event('block.recent_topics_modify_data', compact($vars)));
		}

		$icons 		= $this->container->get('cache')->obtain_icons();
		$tab_count 	= 0;

		$topic_tracking_info = $this->helper->get_rowset_tracking($rowset);

		foreach($data['sections'] as $tab_id => $tab_enabled)
		{
			if(!$tab_enabled)
			{
				continue;
			}

			$tab_data = $tab_ary[$tab_id];

			$tab_count++;

			$this->template->assign_block_vars('recent_tab', array(
				'TITLE'		=> $this->lang->lang($tab_data['title']),
				'IS_EMPTY'	=> empty($tab_data['topic_list']),
				'ID'		=> strtolower($tab_data['title']),
				'ICON'		=> $tab_data['icon'],
			));
			
			if(empty($tab_data['topic_list']))
			{
				continue;
			}

			foreach($tab_data['topic_list'] as $topic_id)
			{
				$row = &$rowset[$topic_id];

				$unread_topic 			= false;
				$replies 				= (int)$row['topic_posts_approved'] - 1;
				$view_topic_url_params 	= 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'];
				$topic_title 			= censor_text($row['topic_title']);

				if($row['topic_status'] != ITEM_MOVED)
				{
					$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;
				}
				
				// Get folder img, topic status/type related information
				$row['topic_posted'] = ($row['topic_poster'] == $this->user->data['user_id']);

				$folder_img = $folder_alt = $topic_type = '';
				\topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

				$topic_row = array(
					'FORUM_NAME'			=> $row['forum_name'],
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
					'TOPIC_FOLDER_IMG_ALT'	=> $this->lang->lang($folder_alt),
					'TOPIC_TYPE'			=> $topic_type,

					'S_TOPIC_REPORTED'	=> (!empty($row['topic_reported']) && $this->auth->acl_get('m_report', $row['forum_id'])),
					'S_POST_ANNOUNCE'	=> ($row['topic_type'] == POST_ANNOUNCE),
					'S_POST_GLOBAL'		=> ($row['topic_type'] == POST_GLOBAL),
					'S_POST_STICKY'		=> ($row['topic_type'] == POST_STICKY),
					'S_UNREAD_TOPIC'	=> $unread_topic,

					'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
					'U_VIEW_FORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id']),
					'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
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

				$this->template->assign_block_vars('recent_tab.rows', $topic_row);
			}
		}

		$this->template->assign_vars(array(
			'SHOW_TABS'			=> $tab_count > 1,
			'SHOW_TOPIC_PARENT'	=> $data['show_parent'],
			'TOPIC_DESIGN' 		=> $data['topic_design'],
		));

		unset($data, $tab_ary);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['forums'] 		= $this->request->variable('forums', array(0));
			$new['sections'] 	= array();

			$sections 			= $this->request->variable('section', array(0));
			$section_enabled 	= $this->request->variable('section_enabled', array(0));

			foreach($sections as $tab_id)
			{
				$new['sections'][$tab_id] = in_array($tab_id, $section_enabled);
			}
		}
	}

	public function get_config()
	{
		$this->display_vars = array(
			'sections'		=> array('lang' => 'RECENT_SECTIONS',		'type' => 'custom',			'function' => array($this, 'build_sections_selector'),	'params' => array('{CONFIG_VALUE}'),	'default' => self::$default_sections),
			'topic_limit'	=> array('lang' => 'RECENT_TOPIC_LIMIT',	'validate' => 'int:1:100',	'type' => 'number:1:100',	'default' => 5),
			'forums'		=> array('lang' => 'RECENT_FORUMS',			'type' => 'custom',			'method' => 'helper',		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'topic_design'	=> array('lang' => 'TOPIC_DESIGN',			'type' => 'select',			'method' => 'helper', 		'params' => array('block_design_select', '{CONFIG_VALUE}')),
			'show_parent'	=> array('lang' => 'TOPIC_PARENT_SHOW',		'validate' => 'bool',		'type' => 'radio:yes_no'),
		);

		$this->tpl_name = 'acp_recent_topics_block';

		return true;
	}

	public function build_sections_selector($sections_saved)
	{
		$sections = array(
			self::TAB_TOPICS 	=> 'BLG_RECENT_TOPICS',
			self::TAB_ANN 		=> 'BLG_RECENT_ANN',
			self::TAB_ACTIVITY 	=> 'BLG_RECENT_ACTIVITY',
		);

		foreach($sections_saved as $tab_id => $tab_enabled)
		{
			$this->template->assign_block_vars('sections', array(
				'CHECKED'	=> $tab_enabled,
				'ID'		=> $tab_id,
				'TITLE'		=> $this->lang->lang($sections[$tab_id]),
			));
		}

		return false;
	}
}
