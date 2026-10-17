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
 *
 * The version configuration is already gone at this point (remove_gallery_version),
 * so this marker must not touch it.
 */
class release_4_0_0 extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\image_deletion_requests'];
	}

	public function update_data(): array
	{
		return [];
	}
}
