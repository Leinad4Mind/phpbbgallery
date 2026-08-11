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

/** Add the optional image-ID BBCode control to Gallery cards. */
class image_card_bbcode_id extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\gallery_album_bbcode'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_disp_image_id', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_disp_image_id']],
		];
	}
}
