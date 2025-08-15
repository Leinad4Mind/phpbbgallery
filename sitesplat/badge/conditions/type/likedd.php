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
 * Badge Award Likedd class
 */
class likedd extends \sitesplat\badge\conditions\type\base
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type()
	{
		return 'sitesplat.badge.type.likedd';
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
		return 'likedd';
	}

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name()
	{
		return $this->user->lang('BADGE_TYPE_LIKEDD');
	}

	/**
	 * Get users to apply to this condition
	 * Likedd is typically called via cron with no $options arguments.
	 * By default, get all users, otherwise use user_id(s) supplied in $options arg.
	 *
	 * @param array $options Array of optional data
	 * @return array Array of users ids as keys and their condition data as values
	 * @access public
	 */
	 
	/**	 
	 * DISLIKE RECEIVED - Option = 0
	 * DISLIKE GIVEN - Option = 1
	 * LIKE RECEIVED - Option = 2
	 * LIKE GIVEN - Option = 3
	*/

	public function get_users_for_condition($options = array())
	{
		$user_data = array();
		$manager = $this->container->get('ext.manager');
		if ($manager->is_enabled('sitesplat/likedd'))
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
	
			$this->likes_table = $this->container->getParameter('sitesplat.likedd.tables.likes');
	
			$option = (int) $options['option'];
			$like_dislike =  $option < 2;
			$give_recieve = ($option % 2) ? 0 : 1;
	
			// Get data for the users to be checked (exclude bots, guests and inactive users)
			$sql = ($give_recieve) ? 'SELECT u.user_id, COUNT(CASE WHEN l.ld = ' . (($like_dislike) ? 0 : 1) . ' THEN l.user_id END) AS likedd
				FROM ' . USERS_TABLE . ' u
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.poster_id = u.user_id
				LEFT JOIN ' . $this->likes_table . ' l ON l.post_id = p.post_id
				WHERE 
				' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
					AND ' . $this->db->sql_in_set('u.user_id', $user_ids, !sizeof($user_ids), true) . '
				group by u.user_id' :
				'SELECT u.user_id, (SELECT COUNT(ld) FROM ' . $this->likes_table . ' WHERE ld = ' . (($like_dislike) ? 0 : 1) . ' AND user_id = u.user_id) AS likedd
				FROM ' . USERS_TABLE . ' u 
				WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
					AND ' . $this->db->sql_in_set('u.user_id', $user_ids, !sizeof($user_ids), true);
			$result = $this->db->sql_query($sql);
	
			$user_data = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$user_data[$row['user_id']] = array(
					$this->get_condition_field() => $row['likedd']
				);
			}
			$this->db->sql_freeresult($result);
		}
		return $user_data;
	}
}
