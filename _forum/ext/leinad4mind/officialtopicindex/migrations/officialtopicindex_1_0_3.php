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

class officialtopicindex_1_0_3 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\leinad4mind\officialtopicindex\migrations\officialtopicindex_data',
		];
	}

	public function update_data()
	{
		return [
			['permission.add', ['u_officialtopicindex_view', true, 'u_topicindex_view']],
			['permission.permission_set', ['REGISTERED', 'u_officialtopicindex_view', 'group', true]],
		];
	}
}
