<?php
/**
 *
 * @package User Defaults Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\userdefaults\acp;

class userdefaults_info
{
	public function module()
	{
		return [
			'filename'	=> '\devspace\userdefaults\acp\userdefaults_module',
			'title' 	=> 'USER_DEFAULTS',
			'modes' 	=> [
				'manage' => ['title' => 'MANAGE_DEFAULTS', 'auth' => 'ext_devspace/userdefaults && acl_a_user', 'cat' => ['USER_DEFAULTS']],
			],
		];
	}
}
