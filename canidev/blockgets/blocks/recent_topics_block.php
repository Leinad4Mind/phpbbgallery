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

class recent_topics_block extends base
{
	static $icon = 'fa-history';

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
			return true;
		}

		$tab_ary = array(
			'BLG_RECENT_TOPICS' => array(
				'icon'			=> 'fa-comment',
				'where'			=> '',
				'order_by'		=> 't.topic_time DESC',
			),

			'BLG_RECENT_ANN' => array(
				'icon'			=> 'fa-newspaper-o',
				'where'			=> 'AND t.topic_type = ' . POST_ANNOUNCE . ')
					OR (t.forum_id = 0 AND t.topic_type = ' . POST_GLOBAL . ')',
				'order_by'		=> 't.topic_time DESC',
			),

			'BLG_RECENT_ACTIVITY' => array(
				'icon'			=> 'fa-comments-o',
				'where'			=> 'AND t.topic_posts_approved > 1)',
				'order_by'		=> 't.topic_last_post_time DESC',
			)
		);

		/*
		* @event block.recent_topics_tabs
		* @var array	sql_ary		Tabs info
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('tab_ary', 'data');
		extract($this->dispatcher->trigger_event('block.recent_topics_tabs', compact($vars)));
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('recent_tab');

		foreach($tab_ary as $tab_title => $tab_data)
		{
			$tab_ary[$tab_title]['topic_list'] = array();

			$sql_ary = array(
				'SELECT'	=> 't.*, f.enable_icons',
				'FROM'		=> array(TOPICS_TABLE => 't'),

				'LEFT_JOIN' => array(
					array('FROM' => array(FORUMS_TABLE => 'f'), 	'ON' => 'f.forum_id = t.forum_id')
				),
				
				'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
					AND t.topic_visibility = ' . ITEM_APPROVED . '
					AND (' . $this->db->sql_in_set('t.forum_id', $forum_ids) . (!empty($tab_data['where']) ? ' ' . $tab_data['where'] : ')'),
					
				'ORDER_BY'	=> $tab_data['order_by'],
			);

			/*
			* @event block.recent_topics_tab_query
			* @var array	sql_ary			The SQL data
			* @var string	tab_title		Title of current Tab
			* @var array	tab_data		Data of current Tab
			* @var	array	data			Block Configuration
			* @since 2.0.0
			*/
			$vars = array('sql_ary', 'tab_title', 'tab_data', 'data');
			extract($this->dispatcher->trigger_event('block.recent_topics_tab_query', compact($vars)));
			
			$sql = $this->db->sql_build_query('SELECT', $sql_ary);
			$result = $this->db->sql_query_limit($sql, (int)$data['topic_limit']);
			while($row = $this->db->sql_fetchrow($result))
			{
				$topic_list[] = $row['topic_id'];
				$rowset[$row['topic_id']] = $row;

				$tab_ary[$tab_title]['topic_list'][] = $row['topic_id'];
			}
			$this->db->sql_freeresult($result);

			/*
			* @event block.recent_topics_modify_data
			* @var	array	topic_list			Array with current topic ids
			* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
			* @var	array	data				Block Configuration
			* @since 2.0.1
			*/
			$vars = array('topic_list', 'rowset', 'data');
			extract($this->dispatcher->trigger_event('block.recent_topics_modify_data', compact($vars)));

			/*
			* For compatibility with other extension
			*
			* @event core.viewforum_modify_topics_data
			* @var	array	topic_list			Array with current topic ids
			* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
			* @var	int		total_topic_count	Forum's total topic count
			* @var	int		forum_id			Forum identifier
			*/
			$total_topic_count = $forum_id = 0;
			$vars = array('topic_list', 'rowset', 'total_topic_count', 'forum_id');
			extract($this->dispatcher->trigger_event('core.viewforum_modify_topics_data', compact($vars)));
		}

		foreach($tab_ary as $tab_title => $tab_data)
		{
			$this->template->assign_block_vars('recent_tab', array(
				'TITLE'		=> $this->lang->lang($tab_title),
				'IS_EMPTY'	=> empty($tab_data['topic_list']),
				'ID'		=> strtolower($tab_title),
				'ICON'		=> $tab_data['icon'],
			));
			
			if(empty($tab_data['topic_list']))
			{
				continue;
			}

			$icons = $this->container->get('cache')->obtain_icons();

			foreach($tab_data['topic_list'] as $topic_id)
			{
				$row = &$rowset[$topic_id];

				$topic_title 	= censor_text($row['topic_title']);
				$unread_topic 	= false;
				$replies 		= (int)$row['topic_posts_approved'] - 1;
				$view_topic_url_params = 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'];
				
				// Get folder img, topic status/type related information
				$row['topic_posted'] = ($row['topic_poster'] == $this->user->data['user_id']);

				$folder_img = $folder_alt = $topic_type = '';
				\topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

				$topic_row = array(
					'TOPIC_TITLE'			=> \canidev\core\tools::html_truncate($topic_title, $data['title_limit'], '...'),
					'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
					'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
					'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),

					'REPLIES'				=> $replies,
					'VIEWS'					=> $row['topic_views'],
					'TOPIC_ICON_IMG'		=> ($row['enable_icons'] && !empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
					'TOPIC_IMG_STYLE'		=> $folder_img,
					'TOPIC_FOLDER_IMG_ALT'	=> $this->lang->lang($folder_alt),

					'S_TOPIC_REPORTED'	=> (!empty($row['topic_reported']) && $this->auth->acl_get('m_report', $row['forum_id'])),
					'S_POST_ANNOUNCE'	=> ($row['topic_type'] == POST_ANNOUNCE),
					'S_POST_GLOBAL'		=> ($row['topic_type'] == POST_GLOBAL),
					'S_POST_STICKY'		=> ($row['topic_type'] == POST_STICKY),

					'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
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

		$this->template->assign_var('TOPIC_DESIGN', $data['topic_design']);

		unset($data, $tab_ary);
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
		$this->display_vars = array(
			'topic_limit'	=> array('lang' => 'RECENT_TOPIC_LIMIT',	'validate' => 'int:1:100',	'type' => 'number:1:100',	'default' => 5),
			'title_limit'	=> array('lang' => 'TITLE_LIMIT',			'validate' => 'int:0:255',	'type' => 'number:0:255',	'default' => 50),
			'forums'		=> array('lang' => 'RECENT_FORUMS',			'type' => 'custom',			'method' => 'helper',		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'topic_design'	=> array('lang' => 'TOPIC_DESIGN',			'type' => 'select',			'method' => 'helper', 		'params' => array('block_design_select', '{CONFIG_VALUE}')),
		);

		return true;
	}
}
