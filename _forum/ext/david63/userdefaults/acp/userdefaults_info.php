<?php
/**
 * @package User Defaults
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\userdefaults\acp;

class userdefaults_info
{
	public function module()
	{
		return array(
			'filename' => '\\david63\\userdefaults\\acp\\userdefaults_module',
			'title' => 'USER_DEFAULTS',
			'modes' => array(
				'manage' => array(
					'title' => 'MANAGE_DEFAULTS',
					'auth' => 'ext_david63/userdefaults && acl_a_user',
					'cat' => array('USER_DEFAULTS'),
				),
			),
		);
	}
}
