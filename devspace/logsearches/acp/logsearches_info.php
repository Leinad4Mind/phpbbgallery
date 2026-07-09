<?php
/**
 *
 * @package Log Searches Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\logsearches\acp;

class logsearches_info
{
	public function module()
	{
		return [
			'filename' => '\devspace\logsearches\acp\logsearches_module',
			'title' => 'SEARCH_LOG',
			'modes' => [
				'main' => ['title' => 'SEARCH_LOG', 'auth' => 'ext_devspace/logsearches && acl_a_board', 'cat' => ['ACP_FORUM_LOGS']],
			],
		];
	}
}
