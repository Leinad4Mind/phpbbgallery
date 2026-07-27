<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\migrations;

use phpbb\db\migration\migration;

class m2_ucp_module extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\export\migrations\m1_init',
			'\phpbbgallery\core\migrations\release_1_2_0',
		];
	}

	public function update_data(): array
	{
		return [
			['module.add', ['ucp', 'UCP_GALLERY', [
				'module_basename'	=> '\phpbbgallery\export\ucp\main_module',
				'module_langname'	=> 'UCP_GALLERY_EXPORT',
				'module_mode'		=> 'export_images',
				'module_auth'		=> 'ext_phpbbgallery/export',
			]]],
		];
	}
}
