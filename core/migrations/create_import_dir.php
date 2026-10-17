<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Create the directory ZIP uploads are extracted into.
 *
 * It was previously only created by the acpimport extension, so ZIP uploads failed on
 * boards running Core alone. Purging Core archives it together with files/phpbbgallery.
 */
class create_import_dir extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\featured_images'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'create_import_dir']]],
		];
	}

	public function create_import_dir(): void
	{
		global $phpbb_root_path;

		$import_dir = $phpbb_root_path . 'files/phpbbgallery/import';

		if (!is_dir($import_dir) && is_writable($phpbb_root_path . 'files'))
		{
			@mkdir($import_dir, 0755, true);
		}
	}
}
