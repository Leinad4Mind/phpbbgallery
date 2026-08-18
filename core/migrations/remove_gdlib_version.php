<?php
/**
 * phpBB Gallery - remove the obsolete GD1/GD2 selector.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Always use the modern GD resampling implementation. */
class remove_gdlib_version extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\gallery_permission_masks'];
	}

	public function update_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_gdlib_version']],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_gdlib_version', 2]],
		];
	}
}
