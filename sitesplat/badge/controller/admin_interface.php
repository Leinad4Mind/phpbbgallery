<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\controller;

/**
 * Interface for our admin controller
 *
 * This describes all of the methods we'll use for the admin front-end of this extension
 */
interface admin_interface
{
	/**
	 * Display the badge rules
	 *
	 * @return null
	 * @access public
	 */
	public function display_badge_rules();

	/**
	 * Save an Badge Award rule
	 *
	 * @param int $rule_id The badge rule identifier to edit
	 * @return null
	 * @access public
	 */
	public function save_badge_rule($rule_id);

	/**
	 * Delete the Badge Award rule
	 *
	 * @param int $rule_id The badge rule identifier to delete
	 * @return null
	 * @access public
	 */
	public function delete_badge_rule($rule_id);

	/**
	 * Sync an Badge Award by running it's check against all users
	 *
	 * @param int $rule_id The badge rule identifier to delete
	 * @return null
	 * @access public
	 */
	public function resync_badge_rule($rule_id);

	/**
	 * Set page url
	 *
	 * @param string $u_action Custom form action
	 * @return null
	 * @access public
	 */
	public function set_page_url($u_action);
}
