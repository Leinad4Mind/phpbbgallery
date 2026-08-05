<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\acp;

class acp_whovisitedthistopic_info
{
	public function module()
	{
		return [
			'filename' => '\dmzx\whovisitedthistopic\acp\acp_whovisitedthistopic_module',
			'title' => 'ACP_WHOVISITEDTHISTOPIC_TITLE',
			'modes' => [
				'settings' => [
					'title' => 'ACP_WHOVISITEDTHISTOPIC_SETTINGS',
					'auth' => 'ext_dmzx/whovisitedthistopic && acl_a_board',
					'cat' => ['ACP_WHOVISITEDTHISTOPIC_TITLE'],
				],
			],
		];
	}
}
