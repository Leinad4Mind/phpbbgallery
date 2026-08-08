<?php
/**
 * phpBB Gallery - Favorite listing setting
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\migrations;

use phpbb\db\migration\migration;

class m3_listing_setting extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\favorite\\migrations\\m2_ucp_module'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_favorite_listings', 1]],
		];
	}
}
