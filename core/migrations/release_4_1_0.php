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

/** Mark the completed 4.1.0 migration chain. */
class release_4_1_0 extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\subalbum_icon_display'];
	}

	public function update_data(): array
	{
		return [
			['config.update', ['phpbb_gallery_version', '4.1.0']],
		];
	}
}
