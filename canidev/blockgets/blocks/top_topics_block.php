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

class top_topics_block extends base
{
	static $icon = 'fa-fire';

	public function init()
	{
		$this->tpl_name = 'top_topics_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(!function_exists('topic_status'))
		{
			include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('topic_row');
		
		$forum_ids 			= array_keys($this->auth->acl_getf('f_read', true));
		$rowset = $topic_list = array();
		
		if(!sizeof($forum_ids))
		{
			return true;
		}
		
		$sql_ary = array(
			'SELECT'	=> 't.*, f.enable_icons',
			'FROM'		=> array(TOPICS_TABLE => 't'),
			'LEFT_JOIN' => array(
				array('FROM' => array(FORUMS_TABLE => 'f'), 	'ON' => 'f.forum_id = t.forum_id')
			),
			'WHERE'		=> 't.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . '
				AND ' . $this->db->sql_in_set('t.forum_id', $forum_ids)
		);
		
		switch($data['mode'])
		{
			case 'active':
				$sql_ary['WHERE'] .= ' AND t.topic_posts_approved > 1';
				$sql_ary['ORDER_BY'] = 't.topic_last_post_time DESC, t.topic_posts_approved DESC';
			break;

			case 'unread':
				$topics = array_keys(get_unread_topics(false));
				
				if(empty($topics))
				{
					return true;
				}
					
				$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('t.topic_id', $topics);
				$sql_ary['ORDER_BY'] = 't.topic_time DESC';
			break;
			
			case 'viewed':
				$sql_ary['WHERE'] .= ' AND t.topic_views > 1';
				$sql_ary['ORDER_BY'] = 't.topic_views DESC';
			break;
			
			default:
				return false;
			break;
		}

		/*
		* @event block.top_topics_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.top_topics_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, (int)$data['topic_limit']);
		while($row = $this->db->sql_fetchrow($result))
		{
			$topic_list[] = $row['topic_id'];
			$rowset[$row['topic_id']] = $row;
		}

		$total_topic_count 	= sizeof($topic_list);
		$forum_id 			= 0;

		/*
		* @event block.top_topics_modify_data
		* @var	array	topic_list			Array with current topic ids
		* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		* @var	array	data				Block Configuration
		* @since 2.0.1
		*/
		$vars = array('topic_list', 'rowset', 'data');
		extract($this->dispatcher->trigger_event('block.top_topics_modify_data', compact($vars)));

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

		$icons = $this->container->get('cache')->obtain_icons();

		foreach($rowset as $topic_id => $row)
		{
			$unread_topic 	= false;
			$replies 		= (int)$row['topic_posts_approved'] - 1;
			$view_topic_url_params = 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'];
			
			// Get folder img, topic status/type related information
			$row['topic_posted'] = ($row['topic_poster'] == $this->user->data['user_id']);

			$folder_img = $folder_alt = $topic_type = '';
			\topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

			$topic_row = array(
				'TOPIC_TITLE'			=> censor_text($row['topic_title']),
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
			* For compatibility with other extensions
			*
			* @event core.viewforum_modify_topicrow
			* @var	array	row					Array with topic data
			* @var	array	topic_row			Template array with topic data
			*/
			$vars = array('row', 'topic_row');
			extract($this->dispatcher->trigger_event('core.viewforum_modify_topicrow', compact($vars)));

			$this->template->assign_block_vars('top_topic', $topic_row);
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_var('TOPIC_DESIGN', $data['topic_design']);

		unset($data);
		return true;
	}

	public function get_config()
	{
		$modes = array(
			'unread'	=> 'TOPT_MODE_UNREAD',
			'active'	=> 'TOPT_MODE_ACTIVE',
			'viewed'	=> 'TOPT_MODE_VIEWED',
		);

		$this->display_vars = array(
			'mode'			=> array('lang' => 'TOPT_MODE',		'type' => 'select',			'method' => 'helper',		'params' => array('make_select', $modes, false, '{CONFIG_VALUE}'),	'default' => 'unread'),
			'topic_limit'	=> array('lang' => 'TOPT_LIMIT',	'validate' => 'int:1:50',	'type' => 'number:1:50',	'default' => 10),
			'topic_design'	=> array('lang' => 'TOPIC_DESIGN',	'type' => 'select',			'method' => 'helper', 		'params' => array('block_design_select', '{CONFIG_VALUE}')),
		);

		return true;
	}
}
