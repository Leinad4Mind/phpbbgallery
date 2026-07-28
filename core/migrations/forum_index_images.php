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

class forum_index_images extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\disp_resolution'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_forum_index_display', 45]],
			['config.add', ['phpbb_gallery_forum_index_mode', 0]],
			['config.add', ['phpbb_gallery_forum_index_personal', 0]],
			['config.add', ['phpbb_gallery_forum_index_random_count', 4]],
			['config.add', ['phpbb_gallery_forum_index_recent_count', 4]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_forum_index_display']],
			['config.remove', ['phpbb_gallery_forum_index_mode']],
			['config.remove', ['phpbb_gallery_forum_index_personal']],
			['config.remove', ['phpbb_gallery_forum_index_random_count']],
			['config.remove', ['phpbb_gallery_forum_index_recent_count']],
		];
	}
}
