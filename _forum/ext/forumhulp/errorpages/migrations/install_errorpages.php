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

class install_errorpages extends migration
{
	public function effectively_installed()
	{
		return isset($this->config['error_pages_log'], $this->config['error_pages_explain']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v310\gold'];
	}

	public function update_data()
	{
		return [
			['config.add', ['error_pages_log', 0]],
			['config.add', ['error_pages_explain', 1]],
		];
	}
}
