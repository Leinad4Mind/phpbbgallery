<?php
/*
* @name leaders_block.php
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

class leaders_block extends base
{
	static $icon = 'blg-icon-star';

	public function init()
	{
		$this->tpl_name = 'leaders_block';
		$this->lang->add('groups');
		
		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		$defined_groups = (!empty($data['groups'])) ? $data['groups'] : false;
		$group_ary		= array();
		
		$sql_ary = array(
			'SELECT'	=> 'u.user_id, u.group_id as default_group, u.username, u.username_clean,
				g.group_id, g.group_name, g.group_colour, g.group_type, ug.user_id as ug_user_id',

			'FROM'		=> array(
				USERS_TABLE		=> 'u',
				GROUPS_TABLE	=> 'g'
			),

			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(USER_GROUP_TABLE => 'ug'),
					'ON'	=> 'ug.group_id = g.group_id AND ug.user_pending = 0 AND ug.user_id = ' . $this->user->data['user_id']
				)
			),

			'WHERE'		=> 'u.group_id = g.group_id',
			'ORDER_BY'	=> 'g.group_name ASC, u.username_clean ASC'
		);
		
		if($defined_groups === false)
		{
			// Admin group id...
			$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = 'ADMINISTRATORS'";
			$result = $this->db->sql_query($sql);
			$admin_group_id = (int) $this->db->sql_fetchfield('group_id');
			$this->db->sql_freeresult($result);

			$user_ary = $this->auth->acl_get_list(false, array('a_', 'm_'), false);

			$admin_id_ary = $mod_id_ary = array();
			foreach($user_ary as $forum_id => $forum_ary)
			{
				foreach($forum_ary as $auth_option => $id_ary)
				{
					if($auth_option == 'a_')
					{
						$admin_id_ary = array_merge($admin_id_ary, $id_ary);
					}
					else
					{
						$mod_id_ary = array_merge($mod_id_ary, $id_ary);
					}
				}
			}
			unset($user_ary);

			$admin_id_ary	= array_unique($admin_id_ary);
			$mod_id_ary		= array_unique($mod_id_ary);
			
			$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('u.user_id', array_unique(array_merge($admin_id_ary, $mod_id_ary)), false, true);
		}
		else
		{
			$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('u.group_id', $defined_groups);
		}

		/**
		* @event block.leaders_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.leaders_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			if($defined_groups === false)
			{
				$which_row = (in_array($row['user_id'], $admin_id_ary)) ? 'admin' : 'mod';

				// We sort out admins not within the 'Administrators' group.
				// Else, we will list those as admin only having the permission to view logs for example.
				if($which_row == 'admin' && $row['default_group'] != $admin_group_id)
				{
					// Remove from admin_id_ary, because the user may be a mod instead
					unset($admin_id_ary[array_search($row['user_id'], $admin_id_ary)]);

					if(!in_array($row['user_id'], $mod_id_ary))
					{
						continue;
					}

					$which_row = 'mod';
				}
				
				$row_group_id = ($which_row == 'admin') ? $admin_group_id : (int)$row['group_id'];
			}
			else
			{
				$row_group_id = (int)$row['group_id'];
			}

			if(!isset($group_ary[$row_group_id]))
			{
				$group_ary[$row_group_id] = array();
				
				// The person is moderating several "public" forums, therefore the person should be listed, but not giving the real group name if hidden.
				if($row['group_type'] == GROUP_HIDDEN && !$this->auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel') && $row['ug_user_id'] != $this->user->data['user_id'])
				{
					$group_name	= $this->lang->get('GROUP_UNDISCLOSED');
					$u_group	= '';
				}
				else
				{
					$group_name	= ($row['group_type'] == GROUP_SPECIAL) ? $this->lang->get('G_' . $row['group_name']) : $row['group_name'];
					$u_group	= $this->helper->url('memberlist', array('mode' => 'group', 'g' => $row['group_id']));
				}
				
				$group_ary[$row_group_id][] = array(
					'LEGEND'			=> true,
					'GROUP_NAME'		=> $group_name,
					'GROUP_COLOR'		=> $row['group_colour'],
					'U_GROUP'			=> $u_group,
				);
			}
			
			if(!$this->auth->acl_gets('u_viewprofile', 'a_user', 'a_useradd', 'a_userdel'))
			{
				$u_user = $row['username'];
			}
			else
			{
				$u_user = '<a href="' . get_username_string('profile', $row['user_id'], $row['username']) . '">' . $row['username'] . '</a>';
			}
			
			$group_ary[$row_group_id][] = array(
				'LEGEND'			=> false,
				'USERNAME_FULL'		=> $u_user,
			);

			/**
			* @event block.leaders_row
			* @var array	group_ary		The output array
			* @var int		row_group_id	The id of current group
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('group_ary', 'row_group_id', 'row');
			extract($this->dispatcher->trigger_event('block.leaders_row', compact($vars)));
		}
		$this->db->sql_freeresult($result);
		
		foreach($group_ary as $group_id => $rows)
		{
			foreach($rows as $row)
			{
				$this->template->assign_block_vars('group_row', $row);
			}
		}
		
		$this->template->assign_var('S_VIEW', $data['mode']);

		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['groups'] = $this->request->variable('groups', array(0));
		}

		return true;
	}

	public function get_config()
	{
		$options = array(
			'simple'	=> 'LEADERS_MODE_SIMPLE',
			'accordion'	=> 'LEADERS_MODE_ACCORDION',
		);
		
		$this->display_vars = array(
			'mode'		=> array('lang' => 'LEADERS_MODE',		'type' => 'select', 'method' => 'helper',	'params' => array('make_select', $options, '{CONFIG_VALUE}'),					'default' => 'simple'),
			'groups'	=> array('lang' => 'LEADERS_GROUPS',	'type' => 'custom',	'method' => 'helper',	'params' => array('groups_select', 'groups', '{CONFIG_VALUE}', false, false),	'default' => array()),
		);

		return true;
	}
}
