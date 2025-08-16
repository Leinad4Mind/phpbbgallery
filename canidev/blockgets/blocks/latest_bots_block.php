<?php
/*
* @name latest_bots_block.php
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

class latest_bots_block extends base
{
	static $icon = 'blg-icon-bug';

	public function init()
	{
		$this->tpl_name = 'latest_bots_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
			
		$sql_ary = array(
			'SELECT'	=> 'u.username, u.user_colour, u.user_lastvisit',
			'FROM'		=> array(USERS_TABLE => 'u'),

			'WHERE'	=> 'u.user_type = ' . USER_IGNORE . '
				AND u.user_id <> ' . ANONYMOUS . '
				AND u.user_lastvisit > 0',
				
			'ORDER_BY'	=> 'u.user_lastvisit DESC',
		);

		/**
		* @event block.latest_bots_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.latest_bots_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, $data['max_bots']);
		while($row = $this->db->sql_fetchrow($result))
		{
			$bot_row = array(
				'BOT_NAME'		=> get_username_string('no_profile', 0, $row['username'], $row['user_colour']),
				'BOT_VISIT'		=> $this->user->format_date($row['user_lastvisit']),
			);

			/**
			* @event block.latest_bots_row
			* @var array	bot_row		The output array
			* @var array	row			The original data
			* @since 2.0.0
			*/
			$vars = array('bot_row', 'row');
			extract($this->dispatcher->trigger_event('block.latest_bots_row', compact($vars)));
			
			$this->template->assign_block_vars('bots', $bot_row);
		}
		$this->db->sql_freeresult($result);

		unset($data, $sql_ary);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'max_bots'		=> array('lang' => 'BOTS_NUMBER',	'validate' => 'int:1',	'type' => 'text:4:3',	'default' => 5),
		);

		return true;
	}
}
