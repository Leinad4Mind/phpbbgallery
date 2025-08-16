<?php
/*
* @name random_member_block.php
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

class random_member_block extends base
{
	static $icon = 'blg-icon-user';

	public function init()
	{
		$this->tpl_name = 'random_member_block';

		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE ' . $this->db->sql_in_set('user_type', array(USER_IGNORE, USER_INACTIVE), true) . '
			ORDER BY RAND()';
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// Do the relevant calculations
		$memberdays = max(1, round((time() - $row['user_regdate']) / 86400));
		$posts_per_day = $row['user_posts'] / $memberdays;

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('random_member');

		$member_row = array(
			'USERNAME'		=> get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']),
			'USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
			'AVATAR'		=> get_user_avatar($row['user_avatar'], $row['user_avatar_type'], $row['user_avatar_width'], $row['user_avatar_height']),
			'POSTS'			=> ($row['user_posts']) ? $this->lang->get('MEMBER_POSTS', $row['user_posts'], $posts_per_day) : '0',
			'REGDATE'		=> $this->helper->format_short_date($row['user_regdate']),

			'U_FIND_POSTS'	=> $this->helper->url('search', 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
		);

		/**
		* @event block.random_member_row
		* @var array	member_row		The output array
		* @var array	row				The original data
		* @since 2.0.0
		*/
		$vars = array('member_row', 'row');
		extract($this->dispatcher->trigger_event('block.random_member_row', compact($vars)));
		
		$this->template->assign_block_vars('random_member', $member_row);

		return true;
	}
}
