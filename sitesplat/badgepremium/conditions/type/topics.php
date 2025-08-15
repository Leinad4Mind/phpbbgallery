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
class topics extends \sitesplat\badge\conditions\type\base
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type()
	{
		return 'sitesplat.badge.type.topics';
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
		return 'topics';
	}

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name()
	{
		return $this->user->lang('BADGE_TYPE_TOPICS');
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
		$sql = 'SELECT topic_poster, COUNT(topic_id) AS topics
			FROM ' . TOPICS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_poster', $user_ids, $sync, true) . '
			GROUP BY topic_poster';
		$result = $this->db->sql_query($sql);

		$user_data = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_data[$row['topic_poster']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $user_data;
	}

	/**
	 * Check condition
	 *
	 * @param array $user_row Array of user data to perform checks on
	 * @param array $options  Array of optional data
	 * @return null
	 * @access public
	 */
	public function check($user_row, $rule_id = 0, $options = array())
	{
		// Merge default options
		$options = array_merge(array(
			'action'	=> '',
		), $options);

		// We need to decrease the user's post count during post deletion
		// because the database does not yet have updated post counts.
		if ($options['action'] == 'delete')
		{
			foreach ($user_row as $user_id => &$user_data)
			{
				$user_data['topic_poster']--;
			}

			// Always unset a variable passed by reference in a foreach loop
			unset($user_data);
		}

		parent::check($user_row, $rule_id, $options);
	}
}
