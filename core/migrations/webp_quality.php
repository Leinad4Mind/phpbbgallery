<?php
/**
 * phpBB Gallery - configurable WebP encoding quality.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add the WebP encoder quality setting. */
class webp_quality extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\remove_gdlib_version'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_webp_quality', 80]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_webp_quality']],
		];
	}
}
