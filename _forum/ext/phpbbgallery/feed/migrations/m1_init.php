<?php
/**
 * phpBB Gallery - Feed Extension
 *
 * @package   phpbbgallery/feed
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\feed\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_feed_enable', 1]],
			['config.add', ['phpbb_gallery_feed_enable_pegas', 1]],
			['config.add', ['phpbb_gallery_feed_limit', 10]],
		];
	}
}
