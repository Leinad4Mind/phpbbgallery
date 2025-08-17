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
interface admin_interface
{
	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options();
}
