<?php
/*
* @name birthdays_block.php
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

class birthdays_block extends base
{
	static $icon = 'blg-icon-birthday-cake';

	public function init()
	{
		$this->tpl_name = 'birthdays_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Generate birthday list if required ...
		if(!$this->config['load_birthdays'] || !$this->config['allow_birthdays'])
		{
			return false;
		}

		$birthday_ary = array();

		$time		= $this->user->create_datetime();
		$time_now	= $time->getTimestamp() + $time->getOffset();
		$now 		= phpbb_gmgetdate($time_now);
		$tomorrow	= phpbb_gmgetdate(strtotime('+1 day', $time_now));

		$days_sql = '';
		for($i = 0; $i < (int)$data['next_days']+1; $i++)
		{
			$day = phpbb_gmgetdate($time_now + (86400 * $i));
			$days_sql .= (($days_sql) ? ' OR ' : '') . 'u.user_birthday ' . $this->db->sql_like_expression(sprintf('%2d-%2d-', $day['mday'], $day['mon']) . $this->db->get_any_char());
		}
			
		$sql_ary = array(
			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_birthday',
			'FROM'		=> array(USERS_TABLE => 'u'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(BANLIST_TABLE => 'b'),	'ON' => 'u.user_id = b.ban_userid')
			),
			
			'WHERE'		=> "(b.ban_id IS NULL OR b.ban_exclude = 1)
				AND $days_sql
				AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')',
			'ORDER_BY'	=> 'u.username_clean ASC'
		);

		/**
		* @event block.birthdays_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.birthdays_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			list($bday, $bmonth, $byear) = explode('-', str_replace(' ', '', $row['user_birthday']));

			if(!(int)$byear)
			{
				$byear = $now['year'];
			}

			$ttime = "{$bday}_$bmonth";
			if(!isset($birthday_ary[$ttime]))
			{
				$birthday_ary[$ttime] = array();
			}

			$btext = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
			if(($age = ($now['year'] - (int)$byear)))
			{
				$btext .= " ($age)";
			}

			$birthday_ary[$ttime][] = array_merge($row, array(
				'bday'		=> $bday,
				'bmonth'	=> $bmonth,
				'byear'		=> $byear,
			));
		}
		$this->db->sql_freeresult($result);

		asort($birthday_ary);

		foreach($birthday_ary as $btime => $users_row)
		{
			$users = array();
			list($bday, $bmon) = explode('_', $btime);

			$btitle = 'BIRTHDAYS_FOR';

			if($bday == $now['mday'] && $bmon == $now['mon'])
			{
				$btitle = 'TODAY_BIRTHDAYS';
			}
			
			if($bday == $tomorrow['mday'] && $bmon == $tomorrow['mon'])
			{
				$btitle = 'TOMORROW_BIRTHDAYS';
			}

			list($bday, $bmon) = explode('-', strtr(date('d-F', strtotime("$bmon/$bday")), array_filter($this->lang->get_raw('datetime'), 'is_string')));

			foreach($users_row as $row)
			{
				$text = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
				if(($age = ($now['year'] - (int)$row['byear'])))
				{
					$text .= " ($age)";
				}

				/**
				* @event block.birthdays_user_row
				* @var string	text		The output text
				* @var array	row			The original data
				* @since 2.0.0
				*/
				$vars = array('text', 'row');
				extract($this->dispatcher->trigger_event('block.birthdays_user_row', compact($vars)));

				$users[] = $text;
			}
			
			$this->template->assign_block_vars('birthday', array(
				'S_TITLE'	=> $this->lang->get($btitle, $bday, $bmon),
				'S_USERS'	=> implode(', ', $users),
			));
		}

		unset($data, $birthday_ary, $users);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'next_days'		=> array('lang' => 'NEXT_BIRTHDAYS',	'validate' => 'int:0:30',	'type' => 'text:3:2',	'default' => 0),
		);

		return true;
	}
}
