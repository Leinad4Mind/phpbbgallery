<?php
/**
 * phpBB Gallery - unread image badge.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Enable the permission-filtered unread-image badge by default.
 */
class unread_image_badge extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\avif_support'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_disp_new_image_count', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_disp_new_image_count']],
		];
	}
}
