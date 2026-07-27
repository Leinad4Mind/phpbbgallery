<?php
/**
 * phpBB Gallery - ACP Import Extension
 *
 * @package   phpbbgallery/acpimport
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\migrations;

use phpbb\db\migration\migration;

class m3_zip_import extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\acpimport\migrations\m2_remove_php_state'];
	}

	public function update_data(): array
	{
		return [
			// How many images an administrator may take out of a single archive.
			// The front-end upload keeps its own, much lower, allowance.
			['config.add', ['phpbb_gallery_import_zip_max_images', 1000]],
		];
	}
}
