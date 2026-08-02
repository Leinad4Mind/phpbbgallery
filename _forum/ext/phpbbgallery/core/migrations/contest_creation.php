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

/**
 * Add the switch controlling creation of new contest albums.
 */
class contest_creation extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\image_subtitle'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_allow_contests', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_allow_contests']],
		];
	}
}
