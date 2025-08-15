<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badgeautogroups\conditions\type;

/**
 * Badge Award Zebra Foes class
 */
class zebra_foes extends \phpbb\autogroups\conditions\type\base
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type()
	{
		return 'sitesplat.badgeautogroups.type.zebra.foes';
	}

	/**
	 * Get condition field (this is the field to check)
	 *
	 * @return string Condition field name
	 * @access public
	 */
	public function get_condition_field()
	{
		return 'badges_awarded';
	}

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name()
	{
		return $this->user->lang('BADGEAUTO_TYPE_ZEBRA_FOES');
	}

	/**
	 * Get users to apply to this condition
	 * Zebra is typically called via cron with no $options arguments.
	 * By default, get all users, otherwise use user_id(s) supplied in $options arg.
	 *
	 * @param array $options Array of optional data
	 * @return array Array of users ids as keys and their condition data as values
	 * @access public
	 */
	public function get_users_for_condition($options = array())
	{
		$ids = $user_data = array();
		$manager = $this->container->get('ext.manager');

		if ($manager->is_enabled('sitesplat/badge'))
		{
			$this->badge_type_table = $this->container->getParameter('sitesplat.badge.tables.badge_types');
			$this->badge_rule_table = $this->container->getParameter('sitesplat.badge.tables.badge_rules');
			$this->badge_event_table = $this->container->getParameter('sitesplat.badge.tables.badge_events');
			
			$sql = 'SELECT r.rule_id 
					FROM ' . $this->badge_rule_table . ' r	
					LEFT JOIN ' . $this->badge_type_table . ' t ON t.rule_type_id = r.rule_type_id
					WHERE t.rule_type_name = "sitesplat.badge.type.zebra.foes"'; 
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ids[] = $row['rule_id'];
			}
	
			// The user data this condition needs to check
			$condition_data = array(
				$this->get_condition_field(),
			);
	
			// Merge default options, empty user array as the default
			$options = array_merge(array(
				'users'		=> array(),
				'action'	=> '',
			), $options);
	
			// Prepare the user ids data for use in the query
			$user_ids = $this->helper->prepare_users_for_query($options['users']);
	
			// Is this a sync action? If so, we want to get all users
			// by setting the $negate arg to true in sql_in_set for 1=1
			$sync = $options['action'] == 'sync';
	
			if (sizeof($ids))
			{
				// This query simply grabs all users and their example_data field
				$sql = 'SELECT u.user_id, (SELECT COUNT(rule_id) FROM ' . $this->badge_event_table . ' WHERE user_id = u.user_id AND ' . 
						$this->db->sql_in_set('rule_id', $ids) . ') AS badges_awarded
						FROM ' . USERS_TABLE . ' u
						WHERE ' . $this->db->sql_in_set('u.user_id', $user_ids, $sync, true) . '
						AND ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true);
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$user_data[$row['user_id']] = $row;
				}
				$this->db->sql_freeresult($result);
			}
		}
		return $user_data;
	}
}
