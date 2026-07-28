<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class disp_resolution extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\create_gallery_icons_folder'];
	}

	public function update_data(): array
	{
		return [
			// Shown by default: the resolution is read from the stored file, so it is
			// available for every image regardless of format or EXIF support.
			['config.add', ['phpbb_gallery_disp_resolution', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_disp_resolution']],
		];
	}
}
