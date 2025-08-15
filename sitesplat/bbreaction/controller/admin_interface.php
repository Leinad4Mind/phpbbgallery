<?php
/**
*
* BB reaction.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\controller;

/**
 * Interface for our admin controller
 *
 * This describes all of the methods we'll use for the admin front-end of this extension
 */
interface admin_interface
{
	/**
	 * Display the reaction types
	 *
	 * @return null
	 * @access public
	 */
	public function display_reward_types();

	/**
	 * Set page url
	 *
	 * @param string $u_action Custom form action
	 * @return null
	 * @access public
	 */
	public function set_page_url($u_action);
}
