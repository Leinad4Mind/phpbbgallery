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

/** Add automatic EXIF orientation correction. */
class image_orientation extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\release_4_0_0'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_auto_orient', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_auto_orient']],
		];
	}
}
