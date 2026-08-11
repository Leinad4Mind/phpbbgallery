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

/** Add the optional subalbum icon strip to supported album layouts. */
class subalbum_icon_display extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\image_card_bbcode_id'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_disp_subalbum_icons', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_disp_subalbum_icons']],
		];
	}
}
