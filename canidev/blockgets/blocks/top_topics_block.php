<?php
/*
* @name top_topics_block.php
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

class top_topics_block extends base
{
	static $icon = 'blg-icon-fire';

	public function init()
	{
		$this->tpl_name = 'top_topics_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('topic_row');
		
		$forum_ids = array_keys($this->auth->acl_getf('f_read', true));
		
		if(!sizeof($forum_ids))
		{
			return true;
		}
		
		$sql_ary = array(
			'SELECT'	=> 't.forum_id, t.topic_title, t.topic_time, t.topic_poster,
				t.topic_first_poster_name, t.topic_first_poster_colour, t.topic_last_post_id',
			'FROM'		=> array(TOPICS_TABLE => 't'),
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

		/**
		* @event block.top_topics_query
		* @var array	sql_ary		The SQL data
		* @var array	data		The block data
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.top_topics_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, (int)$data['topic_limit']);
		while($row = $this->db->sql_fetchrow($result))
		{
			$topic_row = array(
				'S_TITLE'			=> $row['topic_title'],
				'S_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'S_DATE'			=> $this->user->format_date($row['topic_time']),

				'U_VIEWTOPIC'		=> $this->helper->url('viewtopic', 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']),
			);

			/**
			* @event block.top_topics_row
			* @var array	topic_row		The output array
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('topic_row', 'row');
			extract($this->dispatcher->trigger_event('block.top_topics_row', compact($vars)));

			$this->template->assign_block_vars('topic_row', $topic_row);
		}
		$this->db->sql_freeresult($result);

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
			'mode'			=> array('lang' => 'TOPT_MODE',		'type' => 'select',		'method' => 'helper',	'params' => array('make_select', $modes, '{CONFIG_VALUE}'),	'default' => 'unread'),
			'topic_limit'	=> array('lang' => 'TOPT_LIMIT',	'validate' => 'int',	'type' => 'text:4:3',	'default' => 10),
		);

		return true;
	}
}
