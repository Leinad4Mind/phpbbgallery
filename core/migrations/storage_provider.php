<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class storage_provider extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\local_storage_layout'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_storage_provider', 'local']],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_storage_provider']],
		];
	}
}
