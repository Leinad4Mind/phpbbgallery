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

/** Add an independent switch for the original image file type. */
class disp_image_type extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\statistics_permission'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_disp_image_type', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_disp_image_type']],
		];
	}
}
