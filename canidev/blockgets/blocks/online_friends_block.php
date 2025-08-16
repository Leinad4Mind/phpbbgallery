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

class online_friends_block extends base
{
	static $icon = 'fa-group';

	public function init()
	{
		$this->tpl_name = 'online_friends_block';

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('friends_online');
		$this->template->destroy_block_vars('friends_offline');

		$users	= array();
		$time	= (time() - (intval($this->config['load_online_time']) * 60));
			
		$sql_ary = array(
			'SELECT'	=> 'u.user_id, u.username, u.username_clean, u.user_colour,
				s.session_time, s.session_viewonline',

			'FROM'		=> array(ZEBRA_TABLE => 'z'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(USERS_TABLE => 'u'),		'ON' => 'u.user_id = z.zebra_id'),
				array('FROM' => array(SESSIONS_TABLE => 's'),	'ON' => 's.session_user_id = z.zebra_id'),
			),
			
			'WHERE'	=> 'z.user_id = ' . $this->user->data['user_id'] . ' AND z.friend = 1'
		);

		/*
		* @event block.online_friends_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.online_friends_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$users[$row['username_clean']] = $row;
		}
		$this->db->sql_freeresult($result);

		if(empty($users))
		{
			$this->template->assign_var('S_ZEBRA', false);
			return true;
		}

		ksort($users);

		foreach($users as $clean => $row)
		{
			$switch = ($row['session_time'] >= ($time - ((int) ($time % 30))) && $row['session_viewonline']) ? 'online' : 'offline';

			$user_row = array(
				'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'])
			);

			/*
			* @event block.online_friends_row
			* @var array	user_row		The output array
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('user_row', 'row');
			extract($this->dispatcher->trigger_event('block.online_friends_row', compact($vars)));
	
			$this->template->assign_block_vars("friends_$switch", $user_row);
		}

		$this->template->assign_var('S_ZEBRA', true);

		return true;
	}
}
