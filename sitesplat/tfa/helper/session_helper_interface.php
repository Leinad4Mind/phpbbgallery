<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\helper;

use sitesplat\tfa\modules\module_interface;

interface session_helper_interface
{
	const MODE_DISABLED = 0;
	const MODE_NOT_REQUIRED = 1;
	const MODE_REQUIRED_FOR_ACP_LOGIN = 2;
	const MODE_REQUIRED_FOR_ADMIN = 3;
	const MODE_REQUIRED_FOR_MODERATOR = 4;
	const MODE_REQUIRED = 5;

	/**
	 * {@inheritdoc}
	 */
	public function isTfaRequired($user_id, $admin = false, $userdata = array(), $try = false);

	/**
	 * {@inheritdoc}
	 */
	public function isTfaRegistered($user_id);

	/**
	 * {@inheritdoc}
	 */
	public function generate_page($user_id, $admin, $auto_login, $viewonline, $redirect);
}
