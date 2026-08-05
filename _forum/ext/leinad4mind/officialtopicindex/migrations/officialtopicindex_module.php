<?php
/**
 *
 * @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\officialtopicindex\migrations;

class officialtopicindex_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_OFFICIALINDEX']],
			['module.add', [
				'acp',
				'ACP_CAT_OFFICIALINDEX',
				[
					'module_basename' => '\leinad4mind\officialtopicindex\acp\officialtopicindex_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
