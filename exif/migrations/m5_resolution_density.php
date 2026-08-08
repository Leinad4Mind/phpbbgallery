<?php
/**
 * phpBB Gallery - EXIF resolution-density display
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\migrations;

use phpbb\db\migration\migration;

final class m5_resolution_density extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\exif\migrations\m4_capture_sort'];
	}

	public function update_data(): array
	{
		return [[
			'config.add',
			['phpbb_gallery_exif_show_resolution', 1],
		]];
	}

	public function revert_data(): array
	{
		return [[
			'config.remove',
			['phpbb_gallery_exif_show_resolution'],
		]];
	}
}
