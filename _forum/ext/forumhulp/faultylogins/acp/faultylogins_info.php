<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\acp;

class faultylogins_info
{
	public function module()
	{
		return [
			'filename' => '\forumhulp\faultylogins\acp\faultylogins_module',
			'title' => 'ACP_FAULTYLOGINS_TITLE',
			'modes' => [
				'logs' => [
					'title' => 'ACP_FAULTYLOGINS_LOGS',
					'auth' => 'ext_forumhulp/faultylogins && acl_a_board',
					'cat' => ['ACP_FAULTYLOGINS_TITLE'],
				],
				'security' => [
					'title' => 'ACP_FAULTYLOGINS_SECURITY',
					'auth' => 'ext_forumhulp/faultylogins && acl_a_board',
					'cat' => ['ACP_FAULTYLOGINS_TITLE'],
				],
			],
		];
	}
}
