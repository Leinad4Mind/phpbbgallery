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
 * Restore Gallery data in topic and private-message mini profiles.
 */
class viewtopic_profiles extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\gallery_bbcodes'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_viewtopic_icon', 1]],
			['config.add', ['phpbb_gallery_viewtopic_images', 1]],
			['config.add', ['phpbb_gallery_viewtopic_link', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_viewtopic_icon']],
			['config.remove', ['phpbb_gallery_viewtopic_images']],
			['config.remove', ['phpbb_gallery_viewtopic_link']],
		];
	}
}
