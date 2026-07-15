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
 * Badge Award interface
 */
interface type_interface
{
	/**
	 * Get condition type
	 *
	 * @return string Condition type
	 * @access public
	 */
	public function get_condition_type();

	/**
	 * Get condition field (this is the field to check)
	 *
	 * @return string Condition field name
	 * @access public
	 */
	public function get_condition_field();

	/**
	 * Get condition type name
	 *
	 * @return string Condition type name
	 * @access public
	 */
	public function get_condition_type_name();

	/**
	 * Get users to apply to this condition
	 *
	 * @param array $options Array of optional data
	 * @return array Array of users ids and their post counts
	 * @access public
	 */
	public function get_users_for_condition($options = array());

	/**
	 * Get badge rules for condition type
	 *
	 * @param string $type condition type name
	 * @return array rule rows
	 * @access public
	 */
	public function get_rules($rule_id);

	/**
	 * Add badges to user
	 *
	 * @param array $user_id_ary     Badge(s) to add to user
	 * @param array $rule_data       Rule data
	 * @return null
	 * @access public
	 */
	public function add_badge_to_user($user_id_ary, $rule_data);

	/**
	 * Remove badges from user
	 *
	 * @param array $user_id_ary     Badge(s) to remove from user
	 * @param array $rule_data		 Rule data
	 * @return null
	 * @access public
	 */
	public function remove_badge_from_user($user_id_ary, $rule_data);

	/**
	 * Check condition
	 *
	 * @param array $user_row Array of user data to perform checks on
	 * @param array $options  Array of optional data
	 * @return null
	 * @access public
	 */
	public function check($user_row, $options = array());
}
