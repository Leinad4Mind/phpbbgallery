<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
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
			
		$sql_ary = array(
			'SELECT'	=> 'u.user_id, u.username, u.user_regdate, u.user_colour',
			'FROM'		=> array(USERS_TABLE => 'u'),
			'WHERE'		=> $this->db->sql_in_set('u.user_type', array(USER_IGNORE, USER_INACTIVE), true),
			'ORDER_BY'	=> 'u.user_regdate DESC',
		);

		/**
		 * @event block.latest_members_query
		 * @var array	sql_ary		The SQL data
		 * @var	array	data		Block Configuration
		 * @since 2.0.0
		 */
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.latest_members_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, $data['max_users']);
		while($row = $this->db->sql_fetchrow($result))
		{
			$member_row = array(
				'S_USER_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'JOINED'		=> $this->helper->format_short_date($row['user_regdate']),
			);

			/**
			 * @event block.latest_members_row
			 * @var array	member_row		The output array
			 * @var array	row				The original data
			 * @var	array	data			Block Configuration
			 * @since 2.0.0
			 */
			$vars = array('member_row', 'row', 'data');
			extract($this->dispatcher->trigger_event('block.latest_members_row', compact($vars)));
			
			$this->template->assign_block_vars('member', $member_row);
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
		$this->display_vars = array(
			'max_users'		=> array('lang' => 'MEMBERS_NUMBER',	'validate' => 'int:1',	'type' => 'number:1:999',	'default' => 10),
		);

		return true;
	}
}
