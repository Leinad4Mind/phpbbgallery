<?php
/**
 *
 * @package User Details Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\userdetails\acp;

class userdetails_info
{
	public function module()
	{
		return [
			'filename' => '\devspace\userdetails\acp\userdetails_module',
			'title' => 'ACP_USER_DETAILS',
			'modes' => [
				'main' => ['title' => 'ACP_USER_DETAILS', 'auth' => 'ext_devspace/userdetails && acl_a_user', 'cat' => ['ACP_CAT_USERS']],
			],
		];
	}
}
