<?php
/**
 * phpBB Gallery - BMP support.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add the opt-in BMP upload setting. */
class bmp_support extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\unread_image_badge'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_allow_bmp', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_allow_bmp']],
		];
	}
}
