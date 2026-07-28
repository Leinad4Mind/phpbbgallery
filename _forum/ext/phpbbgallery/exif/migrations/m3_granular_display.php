<?php
/**
 * phpBB Gallery - Exif Extension
 *
 * @package   phpbbgallery/exif
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\migrations;

use phpbb\db\migration\migration;
use phpbbgallery\exif\event\exif_listener;

/**
 * Give the administrator a switch per displayed Exif field.
 *
 * Every field defaults to enabled so a board that already showed the whole Exif
 * block keeps showing exactly the same thing after upgrading.
 */
class m3_granular_display extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\exif\migrations\m2_fix_exif_field'];
	}

	public function update_data(): array
	{
		$data = [];
		foreach (exif_listener::DISPLAY_FIELDS as $field)
		{
			$data[] = ['config.add', ['phpbb_gallery_' . exif_listener::display_config_name($field), 1]];
		}

		return $data;
	}

	public function revert_data(): array
	{
		$data = [];
		foreach (exif_listener::DISPLAY_FIELDS as $field)
		{
			$data[] = ['config.remove', ['phpbb_gallery_' . exif_listener::display_config_name($field)]];
		}

		return $data;
	}
}
