<?php
/**
 * phpBB Gallery - AVIF support
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Add opt-in AVIF upload and encoding settings.
 */
class avif_support extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\storage_provider'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_allow_avif', 0]],
			['config.add', ['phpbb_gallery_avif_quality', 75]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_avif_quality']],
			['config.remove', ['phpbb_gallery_allow_avif']],
		];
	}
}
