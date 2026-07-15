<?php
/**
 *
 * @package Active Sessions Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\activesessions\acp;

class activesessions_info
{
	public function module()
	{
		return [
			'filename'	=> '\devspace\activesessions\acp\activesessions_module',
			'title'		=> 'ACTIVE_SESSIONS',
			'modes'		=> [
				'main' => ['title' => 'ACTIVE_SESSIONS', 'auth' => 'ext_devspace/activesessions && acl_a_user', 'cat' => ['ACP_CAT_USERS']],
			],
		];
	}
}
