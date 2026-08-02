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
 * Mark the completed 4.0.0 migration chain.
 */
class release_4_0_0 extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\contest_creation'];
	}

	public function update_data(): array
	{
		return [
			['config.update', ['phpbb_gallery_version', '4.0.0']],
		];
	}
}
