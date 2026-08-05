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

class local_storage_layout extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_4_0_0'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_storage_layout', 'flat']],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_storage_layout']],
		];
	}
}
