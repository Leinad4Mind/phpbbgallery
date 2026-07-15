<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\conditions\type;

/**
 * Badge Award Warnings class
 */
class warnings extends \sitesplat\badge\conditions\type\base
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type()
	{
		return 'sitesplat.badge.type.warnings';
	}

	/**
	 * Get condition boolean (either boolean or min max value)
	 *
	 * @return bool Condition boolean
	 * @access public
	 */
	public function get_condition_boolean()
	{
		return false;
	}
		/**
	 * Get condition field (this is the field to check)
	 *
	 * @return string Condition field name
	 * @access public
	 */
	public function get_condition_field()
	{
		return 'user_warnings';
	}

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name()
	{
		return $this->user->lang('BADGE_TYPE_WARNINGS');
	}

	/**
	 * Get users to apply to this condition
	 * Warnings is typically called via cron with no $options arguments.
	 * By default, get all users, otherwise use user_id(s) supplied in $options arg.
	 *
	 * @param array $options Array of optional data
	 * @return array Array of users ids as keys and their condition data as values
	 * @access public
	 */
	public function get_users_for_condition($options = array())
	{
		// The user data this condition needs to check
		$condition_data = array(
			$this->get_condition_field(),
		);

		// Merge default options, empty user array as the default
		$options = array_merge(array(
			'users'		=> array(),
		), $options);

		// Prepare the user ids data for use in the query
		$user_ids = $this->helper->prepare_users_for_query($options['users']);

		// Get data for the users to be checked (exclude bots, guests and inactive users)
		$sql = 'SELECT user_id, ' . implode(', ', $condition_data) . '
			FROM ' . USERS_TABLE . '
			WHERE ' . $this->db->sql_in_set('user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
				AND ' . $this->db->sql_in_set('user_id', $user_ids, !sizeof($user_ids), true);
		$result = $this->db->sql_query($sql);

		$user_data = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_data[$row['user_id']] = array(
				$this->get_condition_field() => $row['user_warnings']
			);
		}
		$this->db->sql_freeresult($result);

		return $user_data;
	}
}
