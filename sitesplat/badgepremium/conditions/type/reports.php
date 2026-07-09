<?php
/**
*
* BBAwards premium rule PAK.
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
**/

namespace sitesplat\badgepremium\conditions\type;

/**
 * Badge Award Topics class
 */
class reports extends \sitesplat\badge\conditions\type\base
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type()
	{
		return 'sitesplat.badge.type.reports';
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
		return 'reports';
	}

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name()
	{
		return $this->user->lang('BADGE_TYPE_REPORTS');
	}

	/**
	 * Get users to apply to this condition
	 * Posts expects to receive user_id(s) or it will return empty,
	 * except during a 'sync' action which will return all users.
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
			'action'	=> 'sync',
		), $options);

		// Prepare the user ids data for use in the query
		$user_ids = $this->helper->prepare_users_for_query($options['users']);

		// Is this a sync action? If so, we want to get all users
		// by setting the $negate arg to true in sql_in_set for 1=1
		$sync = $options['action'] == 'sync';

		// Get data for the users to be checked (exclude bots and guests)
		$sql = 'SELECT u.user_id, COUNT(r.report_id) AS reports
			FROM ' . USERS_TABLE . ' u
			LEFT JOIN ' . REPORTS_TABLE .  ' r ON r.user_id = u.user_id
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids, $sync, true) . '
				AND user_type <> ' . USER_IGNORE . '
			GROUP BY u.user_id';
		$result = $this->db->sql_query($sql);

		$user_data = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_data[$row['user_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $user_data;
	}
}
