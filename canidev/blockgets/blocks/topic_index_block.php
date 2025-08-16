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

class topic_index_block extends base
{
	static $icon = 'fa-list-alt';

	public function init($method = '')
	{
		$this->tpl_name = 'topic_index_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$data['topics_per_page'] = 2;

		if(empty($data['forums']))
		{
			return false;
		}

		$topic_list = $rowset = array();
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
		
		$sql_ary = array(
			'SELECT'	=> 't.*, f.enable_icons',
			'FROM'		=> array(TOPICS_TABLE => 't'),
			'LEFT_JOIN' => array(
				array('FROM' => array(FORUMS_TABLE => 'f'), 	'ON' => 'f.forum_id = t.forum_id')
			),
			'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . '
				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums'])
		);
		
		switch($data['sort_mode'])
		{
			case 'topic_title';
				if($first_char)
				{
					$sql_ary['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression(substr($first_char, 0, 1) . $this->db->get_any_char());
				}

				$sql_ary['ORDER_BY'] = 'LOWER(t.topic_title) ASC';
			break;
			
			case 'topic_time':
			case 'topic_last_post_time':
				$sql_ary['ORDER_BY'] = 't.' . $data['sort_mode'] . ' DESC';
			break;
		}

		/*
		* @event block.topic_index_query
		* @var array	sql_ary		The SQL data
		* @var array	data		The Block configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.topic_index_query', compact($vars)));
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('topic');
		$this->template->destroy_block_vars('block_pagination');
		
		// Count total of topics
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'COUNT(t.topic_id) AS topic_count',
			'FROM'		=> $sql_ary['FROM'],
			'WHERE'		=> $sql_ary['WHERE']
		));

		$result = $this->db->sql_query($sql);
		$total_topic_count = (int)$this->db->sql_fetchfield('topic_count');
		$this->db->sql_freeresult($result);

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = ($data['topics_per_page']) ? $this->db->sql_query_limit($sql, (int)$data['topics_per_page'], $start) : $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$topic_list[] = $row['topic_id'];
			$rowset[$row['topic_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		/*
		* @event block.topic_index_modify_data
		* @var	array	topic_list			Array with current topic ids
		* @var	array	rowset				Array with topics data (in topic_id => topic_data format)
		* @var	array	data				Block Configuration
		* @since 2.0.1
		*/
		$vars = array('topic_list', 'rowset', 'data');
		extract($this->dispatcher->trigger_event('block.topic_index_modify_data', compact($vars)));

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
			$topic_title 	= censor_text($row['topic_title']);
			$unread_topic 	= false;
			$replies 		= (int)$row['topic_posts_approved'] - 1;
			$view_topic_url_params = 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'];
			
			// Get folder img, topic status/type related information
			$row['topic_posted'] = ($row['topic_poster'] == $this->user->data['user_id']);

			$folder_img = $folder_alt = $topic_type = '';
			\topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);
			
			$topic_row = array(
				'TOPIC_TITLE'			=> $topic_title,
				'TITLE_TRUNCATED' 		=> \canidev\core\tools::html_truncate($topic_title, $data['title_limit'], '...'),
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
				'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params),
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

			$this->template->assign_block_vars('topic', $topic_row);
		}

		if($data['char_select'])
		{
			$first_characters = array('' => $this->lang->lang('CHAR_ALL'));

			for($i = 97; $i < 123; $i++)
			{
				$first_characters[chr($i)] = chr($i - 32);
			}

			foreach($first_characters as $char => $desc)
			{
				$this->template->assign_block_vars('first_char', array(
					'DESC'			=> $desc,
					'VALUE'			=> $char,
					'S_SELECTED'	=> ($first_char == $char) ? true : false,
				));
			}
		}
		
		$pagination = $this->container->get('pagination');
		
		// Make sure $start is set to the last page if it exceeds the amount
		$start = $pagination->validate_start($start, $data['topics_per_page'], $total_topic_count);
		
		$pagination->generate_template_pagination('#', 'block_pagination', 'start', $total_topic_count, $data['topics_per_page'], $start);
		
		$this->template->assign_vars(array(
			'S_CHAR_SELECT'			=> ($data['sort_mode'] == 'topic_title' && $data['char_select']) ? true : false,
			'S_FIRST_CHAR'			=> $first_char,
			'TOPIC_DESIGN' 			=> $data['topic_design'],
			
			'U_ACTION'				=> $this->helper->current_url(array(), false, array('start')),
		));

		unset($data);
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
		$sort_options = array(
			'topic_title'			=> 'TOPIC_TITLE',
			'topic_time'			=> 'TOPIC_TIME',
			'topic_last_post_time'	=> 'LAST_POST_TIME',
		);

		$this->display_vars = array(
			'forums'			=> array('lang' => 'FORUMS',				'type' => 'custom',			'method' => 'helper',		'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'topics_per_page'	=> array('lang' => 'TINDEX_PER_PAGE',		'validate' => 'int:0:1000',	'type' => 'number:0:1000',	'default' => 25),
			'sort_mode'			=> array('lang' => 'TINDEX_SORT_MODE',		'valitate' => 'string',		'type' => 'custom',			'method' => 'helper',	'params' => array('make_select', $sort_options, '{CONFIG_VALUE}'),	'default' => 'topic_title'),
			'title_limit'		=> array('lang' => 'TITLE_LIMIT',			'validate' => 'int:0:255',	'type' => 'number:0:255',	'default' => 50),
			'char_select'		=> array('lang' => 'TINDEX_CHAR_SELECT',	'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1),
			'topic_design'		=> array('lang' => 'TOPIC_DESIGN',			'type' => 'select',			'method' => 'helper', 		'params' => array('block_design_select', '{CONFIG_VALUE}')),
		);

		return true;
	}
}
