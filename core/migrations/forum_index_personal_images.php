<?php
/**
 * phpBB Gallery - personal-album image block on the forum index.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add the independently bounded personal-album image block. */
class forum_index_personal_images extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\core\migrations\remove_legacy_version_config',
			'\phpbbgallery\core\migrations\variant_storage_providers',
		];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_forum_index_personal_count', 4]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_forum_index_personal_count']],
		];
	}
}
