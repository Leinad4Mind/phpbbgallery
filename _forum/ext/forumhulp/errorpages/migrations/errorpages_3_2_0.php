<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\migrations;

use phpbb\db\migration\migration;

class errorpages_3_2_0 extends migration
{
	public static function depends_on()
	{
		return ['\forumhulp\errorpages\migrations\install_errorpages'];
	}

	public function update_data()
	{
		return [
			['config.add', ['error_pages_log', 0]],
			['config.add', ['error_pages_explain', 1]],
		];
	}
}
