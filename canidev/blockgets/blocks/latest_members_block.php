<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class latest_members_block extends base
{
	static $icon = 'fa-user-plus';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'latest_members_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('member');
			
		$sql_ary = [
			'SELECT'	=> 'u.*',
			'FROM'		=> [USERS_TABLE => 'u'],
			'WHERE'		=> $this->db->sql_in_set('u.user_type', [USER_IGNORE, USER_INACTIVE], true),
			'ORDER_BY'	=> 'u.user_regdate DESC',
		];

		/**
		 * @event block.latest_members_query
		 * @var array	sql_ary		The SQL data
		 * @var	array	data		Block Configuration
		 * @since 2.0.0
		 */
		$vars = ['sql_ary', 'data'];
		extract($this->dispatcher->trigger_event('block.latest_members_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, $data['max_users']);
		while($row = $this->db->sql_fetchrow($result))
		{
			$member_row = [
				'AVATAR'		=> phpbb_get_user_avatar($row),
				'S_USER_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'JOINED'		=> $this->helper->format_short_date($row['user_regdate']),
			];

			/**
			 * @event block.latest_members_row
			 * @var array	member_row		The output array
			 * @var array	row				The original data
			 * @var	array	data			Block Configuration
			 * @since 2.0.0
			 */
			$vars = ['member_row', 'row', 'data'];
			extract($this->dispatcher->trigger_event('block.latest_members_row', compact($vars)));
			
			$this->template->assign_block_vars('members', $member_row);
		}
		$this->db->sql_freeresult($result);

		unset($data, $sql_ary);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = [
			'max_users'		=> ['lang' => 'MEMBERS_NUMBER',	'validate' => 'int:1',	'type' => 'number:1:999',	'default' => 10],
		];

		return true;
	}
}
