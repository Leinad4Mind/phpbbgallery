<?php
/**
 *
 * @package Friends & Foes Extension
 * @copyright (c) 2014 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\friendsandfoes\acp;

class friendsandfoes_info
{
	public function module()
	{
		return [
			'filename'	=> '\devspace\friendsandfoes\acp\friendsandfoes_module',
			'title' 	=> 'FRIENDS_AND_FOES',
			'modes' 	=> [
				'main' => ['title' => 'FRIENDS_AND_FOES', 'auth' => 'ext_devspace/friendsandfoes && acl_a_user', 'cat' => ['ACP_CAT_USERS']],
			],
		];
	}
}
