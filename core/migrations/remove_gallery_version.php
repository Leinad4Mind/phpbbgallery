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
 * Remove the Gallery version configuration once the 3.4.0 chain is complete.
 *
 * Shared with the 3.4 line under the same name, so boards upgrading from 3.4 already
 * have it installed and no later migration expects the configuration to exist.
 */
class remove_gallery_version extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_3_4_0'];
	}

	public function update_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_version']],
		];
	}
}
