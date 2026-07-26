<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\migrations;

use phpbb\db\migration\migration;

class m2_ucp_module extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\favorite\migrations\m1_init',
			'\phpbbgallery\core\migrations\release_1_2_0',
		];
	}

	public function update_data(): array
	{
		return [
			['module.add', ['ucp', 'UCP_GALLERY', [
				'module_basename'	=> '\phpbbgallery\favorite\ucp\main_module',
				'module_langname'	=> 'UCP_GALLERY_FAVORITES',
				'module_mode'		=> 'manage_favorites',
				'module_auth'		=> 'ext_phpbbgallery/favorite',
			]]],
		];
	}
}
