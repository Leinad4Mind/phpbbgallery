<?php
/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\controller;

/**
* Interface for our admin controller
*
* This describes all of the methods we'll use for the admin of this extension
*/
interface data_interface
{
	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_output();

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action);
}
