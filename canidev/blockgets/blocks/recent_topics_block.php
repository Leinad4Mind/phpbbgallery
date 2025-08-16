<?php
/*
* @name recent_topics_block.php
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

class recent_topics_block extends base
{
	static $icon = 'blg-icon-history';

	public function init()
	{
		$this->tpl_name = 'recent_topics_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		$forum_ids = array();
		
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
			'RECENT_TOPICS' => array(
				'icon'			=> 'blg-icon-comment',
				'where'			=> '',
				'order_by'		=> 't.topic_time DESC',
				'columns'		=> array(
					'TOPIC_TITLE'	=> 'topic_title_full',
					'POSTED_BY'		=> 'topic_author_full',
					'COMMENTS'		=> 'topic_replies',
					'TOPIC_VIEWS'	=> 'topic_views',
				)
			),

			'RECENT_REPLIES' => array(
				'icon'			=> 'blg-icon-comments-o',
				'where'			=> 'AND t.topic_posts_approved > 1)',
				'order_by'		=> 't.topic_last_post_time DESC',
				'columns'		=> array(
					'POST_SUBJECT'	=> 'last_post_subject_full',
					'POSTED_BY'		=> 'last_post_author_full',
					'TOPIC_TITLE'	=> 'topic_title_full',
				)
			),

			'RECENT_ANN' => array(
				'icon'			=> 'blg-icon-newspaper-o',
				'where'			=> 'AND t.topic_type = ' . POST_ANNOUNCE . ')
					OR (t.forum_id = 0 AND t.topic_type = ' . POST_GLOBAL . ')',
				'order_by'		=> 't.topic_time DESC',
				'columns'		=> array(
					'TOPIC_TITLE'	=> 'topic_title_full',
					'POSTED_BY'		=> 'topic_author_full',
					'COMMENTS'		=> 'topic_replies',
					'TOPIC_VIEWS'	=> 'topic_views',
				)
			)
		);

		/**
		* @event block.recent_topics_tabs
		* @var array	sql_ary		Tabs info
		* @since 2.0.0
		*/
		$vars = array('tab_ary');
		extract($this->dispatcher->trigger_event('block.recent_topics_tabs', compact($vars)));
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('recent');

		foreach($tab_ary as $tab_title => $tab_data)
		{
			$tab_ary[$tab_title]['topic_list'] = array();

			$sql_ary = array(
				'SELECT'	=> 't.*',
				'FROM'		=> array(TOPICS_TABLE => 't'),
				
				'WHERE'	=> 't.topic_status <> ' . ITEM_MOVED . '
					AND t.topic_visibility = ' . ITEM_APPROVED . '
					AND (' . $this->db->sql_in_set('t.forum_id', $forum_ids) . (!empty($tab_data['where']) ? ' ' . $tab_data['where'] : ')'),
					
				'ORDER_BY'	=> $tab_data['order_by'],
			);

			/**
			* @event block.recent_topics_tab_query
			* @var array	sql_ary		The SQL data
			* @var string	tab_title	Title of current Tab
			* @var array	tab_data	Data of current Tab
			* @since 2.0.0
			*/
			$vars = array('sql_ary', 'tab_title', 'tab_data');
			extract($this->dispatcher->trigger_event('block.recent_topics_tab_query', compact($vars)));
			
			$sql = $this->db->sql_build_query('SELECT', $sql_ary);
			$result = $this->db->sql_query_limit($sql, (int)$data['topic_limit']);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row['topic_title'] = censor_text($row['topic_title']);

				$topic_row = array_merge($row, array(
					'last_post_author_full'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'topic_author_full'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'topic_replies'			=> max(0, (int)$row['topic_posts_approved'] - 1),
					'u_last_post'			=> $this->helper->url('viewtopic', 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']),
					'u_topic'				=> $this->helper->url('viewtopic', 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
				));

				/**
				* @event block.recent_topics_topic_row
				* @var array	topic_row		The output array
				* @var array	row				The original data
				* @since 2.0.0
				*/
				$vars = array('topic_row', 'row');
				extract($this->dispatcher->trigger_event('block.recent_topics_topic_row', compact($vars)));
				
				$tab_ary[$tab_title]['topic_list'][] = $topic_row;
			}
			$this->db->sql_freeresult($result);
		}

		foreach($tab_ary as $tab_title => $tab_data)
		{
			$this->template->assign_block_vars('recent', array(
				'S_LEGEND'			=> $this->lang->get($tab_title),
				'S_LEGEND_EMPTY'	=> (empty($tab_data['topic_list']) ? $this->lang->get('NO_' . $tab_title) : ''),
				'S_TAB_ID'			=> strtolower($tab_title),
				'S_TAB_ICON'		=> $tab_data['icon'],
			));
			
			if(empty($tab_data['topic_list']))
			{
				continue;
			}
			
			// Parse the columns
			$i = 0;
			
			$th = $td = array();

			foreach($tab_data['topic_list'] as $row)
			{
				$i = 0;
				
				$last_subject = censor_text(str_replace('Re: ', '', $row['topic_last_post_subject']));
				
				$row['last_post_subject_full']	= '<a href="' . $row['u_last_post'] . '">' . $last_subject . '</a>';
				$row['topic_title_full']		= '<a href="' . $row['u_topic'] . '">' . $row['topic_title'] . '</a>';

				foreach($tab_data['columns'] as $column_legend => $column_item)
				{
					if(!isset($th[$column_legend]))
					{
						$th[$column_legend] = array(
							'S_COLUMN_COUNT'	=> $i,
							'S_ID'				=> 'blg-column-' . strtolower(str_replace('_', '-', $column_legend)),
							'S_LEGEND'			=> $this->lang->get($column_legend)
						);
					}

					$td[] = array(
						'S_COLUMN_COUNT'	=> $i,
						'S_ID'				=> 'blg-column-' . strtolower(str_replace('_', '-', $column_legend)),
						'S_ITEM' 			=> (isset($row[$column_item]) ? $row[$column_item] : ''),
					);
					
					$i++;
				}
				
				$td[] = array('S_BREAK' => true);
			}

			/**
			* @event block.recent_topics_column
			* @var array	th		Tab table header rows
			* @var array	td		Tab table body rows
			* @var int		tab_data	Data of current Tab
			* @since 2.0.0
			*/
			$vars = array('th', 'td', 'tab_data');
			extract($this->dispatcher->trigger_event('block.recent_topics_column', compact($vars)));
			
			foreach($th as $row)
			{
				$this->template->assign_block_vars('recent.th', $row);
			}
			
			foreach($td as $row)
			{
				$this->template->assign_block_vars('recent.td', $row);
			}
		}

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
			'topic_limit'	=> array('lang' => 'RECENT_TOPIC_LIMIT',	'validate' => 'int:1:100',	'type' => 'text:4:3',	'default' => 5),
			'title_limit'	=> array('lang' => 'TITLE_LIMIT',			'validate' => 'int:1:255',	'type' => 'text:4:3',	'default' => 50),
			'forums'		=> array('lang' => 'RECENT_FORUMS',			'type' => 'custom',			'method' => 'helper',	'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
		);

		return true;
	}
}
