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
use phpbbgallery\acpimport\acp\import_storage;

class m2_remove_php_state extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\acpimport\migrations\m1_init'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'remove_legacy_php_state']]],
		];
	}

	public function remove_legacy_php_state(): void
	{
		global $phpbb_root_path;

		$storage = new import_storage($phpbb_root_path . 'files/phpbbgallery/import');
		$storage->remove_legacy_php_state();
	}
}
