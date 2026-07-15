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
 * BB points class
 */
class bbpoints extends \sitesplat\badge\conditions\type\base
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type()
	{
		return 'sitesplat.badge.type.bbpoints';
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
		return 'bbpoints';
	}

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name()
	{
		return $this->user->lang('BADGE_TYPE_BBPOINTS');
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
		$this->bbpoints_table = $this->container->getParameter('sitesplat.bbpoints.table');
		$sql = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";
		$this->db->sql_query($sql);
		$sql = 'SELECT u.user_id, SUM(points) as bbpoints FROM ' . USERS_TABLE . ' u 
				LEFT JOIN ( 
				SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' GROUP BY to_id 
				UNION 
				SELECT from_id AS user_id, SUM(-bbpoints) AS points FROM ' . $this->bbpoints_table . ' GROUP BY from_id 
				UNION 
				SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' GROUP BY topic_poster 
				UNION 
				SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
				ON t1.user_id = u.user_id 
				WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
				AND ' . $this->db->sql_in_set('u.user_id', $user_ids, $sync, true) . '
				GROUP BY user_id 
				ORDER BY bbpoints DESC ';
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
