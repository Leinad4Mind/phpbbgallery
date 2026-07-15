<?php
/*
* @name whos_online_block.php
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

class whos_online_block extends base
{
	static $icon = 'blg-icon-power-off';

	public function init()
	{
		$this->tpl_name = 'whos_online_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Grab an array with all the today users info
		$today_users = $this->helper->obtain_today_visits();
		
		// Force simple view
		if($this->data['autofit'])
		{
			$data['advanced'] = false;
		}

		if($data['advanced'])
		{
			// If online users don't load with page_header, load it
			if(!$this->template->get_var('TOTAL_USERS_ONLINE'))
			{
				$l_online_users = $online_userlist = $l_online_record = $l_online_time = '';

				if($this->config['load_online'] && $this->config['load_online_time'])
				{
					$online_users			= obtain_users_online(0, 'forum');
					$user_online_strings	= obtain_users_online_string($online_users, 0, 'forum');

					$l_online_users		= $user_online_strings['l_online_users'];
					$online_userlist	= $user_online_strings['online_userlist'];
					$total_online_users	= $online_users['total_online'];

					$l_online_record = $this->lang->get('RECORD_ONLINE_USERS', (int) $this->config['record_online_users'], $this->user->format_date($this->config['record_online_date'], false, true));

					$l_online_time = $this->lang->get('VIEW_ONLINE_TIMES', (int) $this->config['load_online_time']);
				}

				$this->template->assign_vars(array(
					'TOTAL_USERS_ONLINE'		=> $l_online_users,
					'LOGGED_IN_USER_LIST'		=> $online_userlist,
					'RECORD_USERS'				=> $l_online_record,
					
					'L_ONLINE_EXPLAIN'			=> $l_online_time,
				));
			}
			
			// Grab group details for legend display
			$sql_ary = array(
				'SELECT'	=> 'g.group_id, g.group_name, g.group_colour, g.group_type',
				'FROM'		=> array(GROUPS_TABLE => 'g'),
				'WHERE'		=> 'g.group_legend = 1',
				'ORDER_BY'	=> 'g.group_name ASC',
			);

			if(!$this->auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
			{
				$sql_ary['LEFT_JOIN'] = array(
					array(
						'FROM'	=> array(USER_GROUP_TABLE => 'ug'),
						'ON'	=> 'g.group_id = ug.group_id
							AND ug.user_id = ' . $this->user->data['user_id'] . '
							AND ug.user_pending = 0'
					)
				);
				
				$sql_ary['WHERE'] .= ' AND (g.group_type <> ' . GROUP_HIDDEN . ' OR ug.user_id = ' . $this->user->data['user_id'] . ')';
			}

			/**
			* @event block.whos_online_groups_query
			* @var array	sql_ary		The SQL data
			* @since 2.0.0
			*/
			$vars = array('sql_ary');
			extract($this->dispatcher->trigger_event('block.whos_online_groups_query', compact($vars)));
			
			$sql = $this->db->sql_build_query('SELECT', $sql_ary);
			$result = $this->db->sql_query($sql);

			$legend = array();
			while($row = $this->db->sql_fetchrow($result))
			{
				$colour_text	= ($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . '"' : '';
				$group_name		= ($row['group_type'] == GROUP_SPECIAL) ? $this->lang->get('G_' . $row['group_name']) : $row['group_name'];
				$u_group		= $this->helper->url('memberlist', 'mode=group&amp;g=' . $row['group_id']);

				/**
				* @event block.whos_online_groups_row
				* @var array	row				The original data
				* @var string	colour_text		The color of the user
				* @var string	group_name		The name of the group
				* @var string	u_group			The group url
				* @since 2.0.0
				*/
				$vars = array('row', 'colour_text', 'group_name', 'u_group');
				extract($this->dispatcher->trigger_event('block.whos_online_groups_row', compact($vars)));
				
				if($row['group_name'] == 'BOTS' || ($this->user->data['user_id'] != ANONYMOUS && !$this->auth->acl_get('u_viewprofile')))
				{
					$legend[] = '<span' . $colour_text . '>' . $group_name . '</span>';
				}
				else
				{
					$legend[] = '<a' . $colour_text . ' href="' . $u_group . '">' . $group_name . '</a>';
				}
			}
			$this->db->sql_freeresult($result);

			$this->template->assign_vars(array(
				'S_TOTAL_USERS_LASTVISIT'	=> $today_users['lastvisit_users'],
				'S_LASTVISIT_USER_LIST'		=> $today_users['userlist'],
				'S_LEGEND'					=> implode(', ', $legend),
			));
		}
		else
		{
			$online_users = obtain_users_online(0, 'forum');

			$this->template->assign_vars(array(
				'S_TOTAL_ONLINE'	=> $online_users['total_online'],
				'S_VISIBLE_ONLINE'	=> $online_users['visible_online'],
				'S_HIDDEN_ONLINE'	=> $online_users['hidden_online'],
				'S_GUEST_ONLINE'	=> $online_users['guests_online'],

				'S_TOTAL_LASTDAY'	=> $today_users['total_today'],
				'S_VISIBLE_LASTDAY'	=> $today_users['visible_today'],
				'S_HIDDEN_LASTDAY'	=> $today_users['hidden_today'],
				'S_GUEST_LASTDAY'	=> $today_users['guests_today'],
			));
		}

		$this->template->assign_vars(array(
			'S_ADVANCED_MODE'	=> $data['advanced'],
			'S_WIO_USERS'		=> $data['usernames'],
		));

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'advanced'		=> array('lang' => 'WHOS_ADVANCED',		'validate' => 'bool',	'type' => 'radio:yes_no', 'default' => 1),
			'usernames'		=> array('lang' => 'WHOS_USERNAMES',	'validate' => 'bool',	'type' => 'radio:yes_no', 'default' => 1),
		);

		return true;
	}
}
