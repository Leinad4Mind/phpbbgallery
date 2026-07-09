<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\ucp;

class badge_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $db, $config, $user, $template, $phpbb_root_path, $phpbb_container;

		$user->add_lang_ext('sitesplat/badge', 'badge_acp');

		$this->page_title = $user->lang['UCP_BADGE_TITLE'];
		$this->tpl_name = 'ucp_profile_badge';
		$this->badge_rules_table = $phpbb_container->getParameter('sitesplat.badge.tables.badge_rules');
		$this->badge_types_table = $phpbb_container->getParameter('sitesplat.badge.tables.badge_types');
		$this->badge_events_table = $phpbb_container->getParameter('sitesplat.badge.tables.badge_events');
		$this->badge_badges_table = $phpbb_container->getParameter('sitesplat.badge.tables.badges');

		$manager = $phpbb_container->get('sitesplat.badge.manager');
		$type_ids = $manager->get_rule_type_ids();
		array_walk($type_ids, function(&$value, $key, $return) {
			$value = $value[$return];
		}, 'id');

		$sql = 'SELECT r.rule_id, r.rule_type_id, r.rule_name, r.rule_description, rule_min_value, rule_max_value, e.user_id, u.username, style_path, 
					   u.user_avatar AS avatar, u.user_avatar_width AS avatar_width, u.user_avatar_height AS avatar_height, u.user_avatar_type AS avatar_type, 
					   e.date, b.badge, t.rule_type_name
				FROM ' . $this->badge_rules_table . ' r
				LEFT OUTER JOIN ' . $this->badge_events_table . ' e ON e.rule_id = r.rule_id
				LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = e.user_id
				LEFT JOIN ' . STYLES_TABLE . ' s ON s.style_id = u.user_style
				LEFT JOIN ' . $this->badge_badges_table . ' b ON b.badge_id = r.badge_id
				WHERE e.user_id = ' . $user->data['user_id'] . ' AND
				r.rule_type_id IN (' . implode(',', $type_ids) . ')
				ORDER BY r.rule_type_id, r.rule_id';
		$result = $db->sql_query($sql);
		$ruleid = $rulename = '0';
		while ($row = $db->sql_fetchrow())
		{
			if ($rulename != $row['username'])
			{
				$template->assign_block_vars('rules', array(
					'CONDITION_NAME'	=>  $row['username'],
				));
			}
			
			if ($ruleid != $row['rule_type_id'])
			{
				$avatar = phpbb_get_user_avatar($row);
				preg_match( '/src="([^"]*)"/i', $avatar, $match);
				$template->assign_block_vars('rules.badge', array(
					'BADGE'			=> ($rulename != $row['username']) ? 
										(($row['avatar'] && isset($match[1])) ? $match[1] : $phpbb_root_path . '/styles/' . $row['style_path'] . '/theme/images/no_avatar.gif') : '',
					'GROUP_NAME'	=> '',
					'DESCRIPTION'	=> $this->get_condition_lang($row['rule_type_name']) . (($row['rule_description']) ? '<br />' . $row['rule_description']: '')
				));
			}
			if ($row['rule_id'])
			{
				$template->assign_block_vars('rules.badge.users', array(
					'USERNAME'	=> '',
					'USER_ID'	=> '',
					'U_URL'		=> '',
					'AVATAR'	=> '<img title="' . (($row['rule_type_name'] != 'sitesplat.badge.type.custom') ? $this->get_condition_lang($row['rule_type_name']) . $this->get_condition_type_lang($row['rule_min_value'], $row['rule_max_value'], $row['rule_type_name']) : '') . '"
									style="margin-top:4px;width:30px;height:30px;" src="' . $phpbb_root_path . '/ext/sitesplat/badge/badges/' . $row['badge'] . '">',
					'DATE'		=> ($row['date']) ? $user->format_date($row['date'], 'j M Y') : '',
				));
			}
			$rulename = $row['username'];
			$ruleid = $row['rule_type_id'];
		}

		$template->assign_vars(array(
			'U_ACTION'					=>	$this->u_action,
		));
	}

	public function get_condition_lang($rule_type_name)
	{
		global $user;
		try
		{
			$condition = strtoupper(str_replace(array('sitesplat.', '.'), array('','_'), $rule_type_name));
		}
		catch (\InvalidArgumentException $e)
		{
			return $user->lang('BADGE_TYPE_NOT_EXIST', $rule_type_name);
		}

		return $user->lang($condition);
	}

	public function get_condition_type_lang($min_value, $max_value, $rule_type_name)
	{
		global $user;
		$return = '';

		if ($this->get_condition_bool($rule_type_name))
		{
			$return = ' ' . $user->lang['BADGE_USED'];
		} else
		{
			if ($max_value > $min_value)
			{
				$return = ' ' . $user->lang['BADGE_BETWEEN'] . ' ' . $min_value . ' ' . $user->lang['BADGE_AND'] . ' ' . $max_value;
			} else if ($max_value == 0)
			{
				$return = ' ' . $user->lang['BADGE_MORE'] . ' ' . $min_value;
			}
		}
		return $return;
	}

	public function get_condition_bool($rule_type_name)
	{
		global $phpbb_container;
		try
		{
			$condition = $phpbb_container->get($rule_type_name);
		}
		catch (\InvalidArgumentException $e)
		{
			return false;
		}

		return $condition->get_condition_boolean();
	}

}
