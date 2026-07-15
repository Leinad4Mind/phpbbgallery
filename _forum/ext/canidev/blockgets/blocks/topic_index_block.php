<?php
/*
* @name topic_index_block.php
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

class topic_index_block extends base
{
	static $icon = 'blg-icon-list-alt';

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

		$sql_order		= '';
		$topic_count	= 0;
		
		$start		= ($method == 'pagination') ? $this->request->variable('start', 0) : 0;
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
		
		$sql_ary = array(
			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_posts_approved, t.topic_views, t.topic_time, t.topic_title,
				t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.topic_last_post_id',

			'FROM'		=> array(TOPICS_TABLE => 't'),

			'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
				AND t.topic_visibility = ' . ITEM_APPROVED . '
				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums'])
		);
		//$comparing = preg_replace_callback('!\[\\S+\]\s+(.+)!is', function ($match) use ($pad) { return $match[1]; }, $first_char);
		switch($data['sort_mode'])
		{	
			case 'topic_title':
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

		/**
		* @event block.topic_index_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
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
		$topic_count = (int)$this->db->sql_fetchfield('topic_count');
		$this->db->sql_freeresult($result);

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = ($data['topics_per_page']) ? $this->db->sql_query_limit($sql, (int)$data['topics_per_page'], $start) : $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$row['topic_title'] = censor_text($row['topic_title']);
			
			$topic_row = array(
				'POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),

				'REPLIES'         		=> $row['topic_posts_approved'] - 1,
				'TOPIC_VIEWS'      		=> $row['topic_views'],
				'TOPIC_TIME'   			=> $this->user->format_date($row['topic_time']),
				'TITLE'             	=> truncate_string($row['topic_title'], $data['title_limit'], 255, false, '...'),
				'FULL_TITLE'      		=> str_replace('&quot;', '"', $row['topic_title']),
				
				'U_LAST_COMMENTS'   	=> $this->helper->url('viewtopic', 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']),
				'U_VIEW_TOPIC'      	=> $this->helper->url('viewtopic', 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
			);

			/**
			* @event block.topic_index_row
			* @var array	attach_row		The output array
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('topic_row', 'row');
			extract($this->dispatcher->trigger_event('block.topic_index_row', compact($vars)));

			$this->template->assign_block_vars('topic', $topic_row);
		}
		$this->db->sql_freeresult($result);
		
		if($data['char_select'])
		{
			$first_characters = array('' => $this->lang->get('CHAR_ALL'));

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
		$start = $pagination->validate_start($start, $data['topics_per_page'], $topic_count);
		
		$pagination->generate_template_pagination('#', 'block_pagination', 'start', $topic_count, $data['topics_per_page'], $start);
		
		$this->template->assign_vars(array(
			'S_ADVANCED_DISPLAY'	=> ($this->data['autofit'] || $data['only_title']) ? false : true,
			'S_CHAR_SELECT'			=> ($data['sort_mode'] == 'topic_title' && $data['char_select']) ? true : false,
			'S_FIRST_CHAR'			=> $first_char,
			
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
			'forums'			=> array('lang' => 'FORUMS',				'type' => 'custom',			'method' => 'helper',	'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'topics_per_page'	=> array('lang' => 'TINDEX_PER_PAGE',		'validate' => 'int:0:1000',	'type' => 'text:4:3',	'default' => 25),
			'sort_mode'			=> array('lang' => 'TINDEX_SORT_MODE',		'valitate' => 'string',		'type' => 'select',		'method' => 'helper',	'params' => array('make_select', $sort_options, '{CONFIG_VALUE}'),	'default' => 'topic_title'),
			'title_limit'		=> array('lang' => 'TITLE_LIMIT',			'validate' => 'int:1:255',	'type' => 'text:4:3',	'default' => 50),
			'only_title'		=> array('lang' => 'TINDEX_ONLY_TITLE',		'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 0),
			'char_select'		=> array('lang' => 'TINDEX_CHAR_SELECT',	'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1),
		);

		return true;
	}
}
