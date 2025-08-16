<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class most_poster_block extends base
{
	static $icon = 'fa-edit';

	/**
	 * {@inheritDoc}
	 */
	function init()
	{
		$this->tpl_name = 'most_poster_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('most_poster');

		if($data['poster_range'] == 'none')
		{
			$sql_ary = [
				'SELECT'	=> 'u.*',
				'FROM'		=> [USERS_TABLE => 'u'],
				
				'WHERE'	=> 'u.user_type <> ' . USER_IGNORE . '
					AND u.user_posts <> 0',
					
				'ORDER_BY'	=> 'u.user_posts DESC',
			];
		}
		else
		{
			$stamp = strtotime('-1 ' . $data['poster_range'], $this->user->time_now);
			
			$sql_ary = [
				'SELECT'	=> 'COUNT(p.post_id) AS post_count, u.*',
				'FROM'		=> [POSTS_TABLE => 'p'],
				
				'LEFT_JOIN'	=> [
					['FROM' => [USERS_TABLE => 'u'],	'ON' => 'u.user_id = p.poster_id']
				],
				
				'WHERE'	=> 'p.post_visibility = ' . ITEM_APPROVED . '
					AND p.poster_id <> ' . ANONYMOUS . '
					AND p.post_time >= ' . $stamp,
					
				'GROUP_BY'	=> 'p.poster_id',
				'ORDER_BY'	=> 'post_count DESC',
			];
		}

		/**
		 * @event block.most_poster_query
		 * @var array	sql_ary		The SQL data
		 * @var	array	data		Block Configuration
		 * @since 2.0.0
		 */
		$vars = ['sql_ary', 'data'];
		extract($this->dispatcher->trigger_event('block.most_poster_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, (int)$data['poster_limit']);
		while($row = $this->db->sql_fetchrow($result))
		{
			// Do the relevant calculations
			$memberdays		= max(1, round((time() - $row['user_regdate']) / 86400));
			$posts_per_day	= $row['user_posts'] / $memberdays;

			$poster_row = [
				'USERNAME'		=> get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']),
				'USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'AVATAR'		=> phpbb_get_user_avatar($row),
				'POSTS'			=> $this->language->lang('MEMBER_POSTS', $row['user_posts'], $posts_per_day),
				'REGDATE'		=> $this->helper->format_short_date($row['user_regdate']),

				'U_FIND_POSTS'	=> $this->helper->url('search', [
					'author_id'	=> $row['user_id'],
					'sr'		=> 'posts',
				])
			];

			/**
			 * @event block.most_poster_row
			 * @var array	poster_row		The output array
			 * @var array	row				The original data
			 * @var	array	data			Block Configuration
			 * @since 2.0.0
			 */
			$vars = ['poster_row', 'row', 'data'];
			extract($this->dispatcher->trigger_event('block.most_poster_row', compact($vars)));
			
			$this->template->assign_block_vars('most_poster', $poster_row);
		}
		$this->db->sql_freeresult($result);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	function get_config()
	{
		$options = [
			'none'	=> 'ALL_POSTS',
			'day'	=> 'LAST_DAY',
			'week' 	=> 'LAST_WEEK',
			'month'	=> 'LAST_MONTH',
			'year'	=> 'LAST_YEAR',
		];

		$this->display_vars = [
			'poster_limit'		=> ['lang' => 'POSTER_LIMIT',	'validate' => 'int:1:20',	'type' => 'number:1:20',	'default' => 5],
			'poster_range'		=> ['lang' => 'POST_RANGE',		'validate' => 'string',		'type' => 'select',			'method' => 'helper',	'params' =>	['make_select', $options, false, '{CONFIG_VALUE}'],	'default' => 'none'],
		];

		return true;
	}
}
