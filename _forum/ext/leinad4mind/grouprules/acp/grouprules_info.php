<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\grouprules\acp;

class grouprules_info
{
	/**
	 * @return array
	 */
	public function module()
	{
		return [
			'filename'	=> '\leinad4mind\grouprules\acp\grouprules_module',
			'title'		=> 'ACP_GROUPRULES_TITLE',
			'modes'		=> [
				'main'		=> [
					'title'		=> 'ACP_GROUPRULES_TITLE',
					'auth'		=> 'ext_leinad4mind/grouprules && acl_a_group',
					'cat'		=> ['ACP_GROUPRULES_TITLE'],
					'after'		=> 'ACP_GROUPS_FORUM_PERMISSIONS',
				],
			],
		];
	}
}
