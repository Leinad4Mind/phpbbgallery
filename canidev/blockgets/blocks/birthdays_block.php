<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class birthdays_block extends base
{
	static $icon = 'fa-birthday-cake';

	/**
	 * {@inheritDoc}
	 */
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

		$birthday_ary = [];

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
		 * @var	array	data		Block Configuration
		 * @since 2.0.0
		 */
		$vars = array('sql_ary', 'data');
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

			$ttime 		= "{$bday}_$bmonth";
			$age_str 	= '';

			if(!isset($birthday_ary[$ttime]))
			{
				$birthday_ary[$ttime] = array(
					'day'		=> $bday,
					'month'		=> $bmonth,
					'year'		=> $byear,
					'users'		=> [],
				);
			}
			
			if(($age = ($now['year'] - (int)$byear)))
			{
				$age_str = "($age)";
			}

			$birthday_ary[$ttime]['users'][] = array_merge($row, array(
				'age'			=> $age_str,
				'username_full'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'])
			));
		}
		$this->db->sql_freeresult($result);

		asort($birthday_ary);

		foreach($birthday_ary as $btime => $row)
		{
			$users = $user_str = [];

			$btitle = 'BIRTHDAYS_FOR';

			if($row['day'] == $now['mday'] && $row['month'] == $now['mon'])
			{
				$btitle = 'TODAY_BIRTHDAYS';
			}
			
			if($row['day'] == $tomorrow['mday'] && $row['month'] == $tomorrow['mon'])
			{
				$btitle = 'TOMORROW_BIRTHDAYS';
			}

			list($bday, $bmon) = explode('-', strtr(date('d-F', strtotime($row['month'] . '/' . $row['day'])), array_filter($this->language->lang_raw('datetime'), 'is_string')));

			foreach($row['users'] as $user)
			{
				$user_ary = array(
					'AGE'				=> $user['age'],
					'USERNAME_FULL'		=> $user['username_full'],
				);

				/**
				 * @event block.birthdays_user_row
				 * @var array	user_ary		The output data
				 * @var array	user			The original data
				 * @since 2.0.0
				 */
				$vars = array('user_ary', 'user');
				extract($this->dispatcher->trigger_event('block.birthdays_user_row', compact($vars)));

				$users[] = $user_ary;
				$user_str[] = $user_ary['USERNAME_FULL'] . ' ' . $user_ary['AGE'];
			}
			
			$this->template->assign_block_vars('birthday', array(
				'S_TITLE'		=> $this->language->lang($btitle, $bday, $bmon),
				'S_USERS_STR'	=> implode(', ', $user_str),
			));

			$this->template->assign_block_vars_array('birthday.user', $users);
		}

		unset($data, $birthday_ary, $user_ary);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = array(
			'next_days'		=> array('lang' => 'NEXT_BIRTHDAYS',	'validate' => 'int:0:30',	'type' => 'number:0:30',	'default' => 0),
		);

		return true;
	}
}
