<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class leaders_block extends base
{
	static $icon = 'fa-star';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'leaders_block';
		$this->language->add_lang('groups');
		
		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$groups_ary	= $users_ary = [];
		
		// Get Group's Information
		if(empty($data['groups']))
		{
			$group_sql_where = $this->db->sql_in_set('group_name', ['ADMINISTRATORS', 'GLOBAL_MODERATORS']);
		}
		else
		{
			$group_sql_where = $this->db->sql_in_set('group_id', $data['groups']);
		}

		$sql = 'SELECT *
			FROM ' . GROUPS_TABLE . '
			WHERE ' . $group_sql_where . '
			ORDER BY group_name ASC';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$group_id = (int)$row['group_id'];
			$groups_ary[$group_id] = $row;
			$groups_ary[$group_id]['users'] = [];
		}
		$this->db->sql_freeresult($result);

		if(!sizeof($groups_ary))
		{
			return false;
		}

		// Get users
		$sql_ary = [
			'SELECT'	=> 'u.username, u.user_id, u.group_id, u.user_colour,
				u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height',
			'FROM'		=> [USERS_TABLE => 'u'],
			'WHERE'		=> '',
			'ORDER_BY'	=> 'u.username_clean ASC',
		];

		if($data['only_online'])
		{
			$time = (time() - (intval($this->config['load_online_time']) * 60));

			$sql_ary['LEFT_JOIN'] = [
				[
					'FROM'	=> [SESSIONS_TABLE => 's'],
					'ON'	=> 's.session_user_id = u.user_id AND s.session_time >= ' . ($time - ((int) ($time % 30)))
				]
			];

			$sql_ary['WHERE'] = 's.session_id IS NOT NULL AND ';
		}

		if($data['use_all_groups'])
		{
			$users_ary = [];

			$sql = 'SELECT group_id, user_id 
				FROM ' . USER_GROUP_TABLE . '
				WHERE ' . $this->db->sql_in_set('group_id', array_keys($groups_ary));
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$group_id 	= (int)$row['group_id'];
				$user_id 	= (int)$row['user_id'];
				
				$groups_ary[$group_id]['users'][] = $user_id;
				$users_ary[] = $user_id;
			}
			$this->db->sql_freeresult($result);

			$sql_ary['WHERE'] .= $this->db->sql_in_set('u.user_id', $users_ary);
		}
		else
		{
			$sql_ary['WHERE'] .= $this->db->sql_in_set('u.group_id', array_keys($groups_ary));
		}

		/**
		 * @event block.leaders_query
		 * @var array	sql_ary			The SQL data
		 * @var array	groups_ary		Groups Information
		 * @var array	data			Block configuration
		 * @since 2.0.0
		 */
		$vars = ['sql_ary', 'groups_ary', 'data'];
		extract($this->dispatcher->trigger_event('block.leaders_query', compact($vars)));

		$users_ary = [];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$user_id = (int)$row['user_id'];
			$users_ary[$user_id] = $row;

			if(!$data['use_all_groups'])
			{
				$group_id = (int)$row['group_id'];
				$groups_ary[$group_id]['users'][] = $user_id;
			}
		}
		$this->db->sql_freeresult($result);

		foreach($groups_ary as $group_id => $group)
		{
			if(!sizeof($group['users']))
			{
				continue;
			}

			// The person is moderating several "public" forums, therefore the person should be listed, but not giving the real group name if hidden.
			if($group['group_type'] == GROUP_HIDDEN &&
				!$this->auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel') &&
				!in_array($this->user->data['user_id'], $group['users']))
			{
				$group_name	= $this->language->lang('GROUP_UNDISCLOSED');
				$u_group	= '';
			}
			else
			{
				$group_name	= ($group['group_type'] == GROUP_SPECIAL) ? $this->language->lang('G_' . $group['group_name']) : $group['group_name'];
				$u_group	= $this->helper->url('memberlist', ['mode' => 'group', 'g' => $group_id]);
			}

			$group_row = [
				'GROUP_NAME'		=> $group_name,
				'GROUP_COLOR'		=> $group['group_colour'],
				'U_GROUP'			=> $u_group,
			];

			/**
			 * @event block.leaders_group
			 * @var array	group_row		The output array
			 * @var array	group			The group data
			 * @since 2.0.1
			 */
			$vars = ['group_row', 'group'];
			extract($this->dispatcher->trigger_event('block.leaders_group', compact($vars)));

			$this->template->assign_block_vars('group_row', $group_row);
			
			foreach($group['users'] as $user_id)
			{
				$row = &$users_ary[$user_id];

				$user_row = [
					'AVATAR'			=> phpbb_get_user_avatar($row),
					'USERNAME_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				];

				/**
				 * @event block.leaders_user
				 * @var array	user_row		The output array
				 * @var array	row				The user data
				 * @since 2.0.1
				 */
				$vars = ['user_row', 'row'];
				extract($this->dispatcher->trigger_event('block.leaders_group', compact($vars)));

				$this->template->assign_block_vars('group_row.user', $user_row);
			}
		}

		$this->template->assign_var('S_VIEW', $data['mode']);

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['groups'] = $this->request->variable('groups', [0]);
		}

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$options = [
			'simple'	=> 'LEADERS_MODE_SIMPLE',
			'accordion'	=> 'LEADERS_MODE_ACCORDION',
		];
		
		$this->display_vars = [
			'mode'				=> ['lang' => 'LEADERS_MODE',			'type' => 'select', 		'method' => 'helper',	'params' => ['make_select', $options, false, '{CONFIG_VALUE}'],				'default' => 'simple'],
			'use_all_groups'	=> ['lang' => 'LEADERS_ALL_GROUPS',		'type' => 'radio:yes_no',	'validate' => 'bool',	'default' => 0],
			'groups'			=> ['lang' => 'LEADERS_GROUPS',			'type' => 'custom',			'method' => 'helper',	'params' => ['groups_select', 'groups', '{CONFIG_VALUE}', false, false],	'default' => []],
			'only_online'		=> ['lang' => 'LEADERS_ONLY_ONLINE',	'validate' => 'bool',		'type' => 'radio:yes_no'],
		];

		return true;
	}
}
