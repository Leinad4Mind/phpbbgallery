<?php
/**
 * phpBB Gallery - Featured Images initial migration.
 *
 * @package   phpbbgallery/featured
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\featured\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\release_4_1_0'];
	}

	public function update_schema(): array
	{
		return ['add_tables' => [
			$this->table_prefix . 'gallery_featured' => [
				'COLUMNS' => [
					'image_id' => ['UINT', 0],
					'featured_by' => ['UINT', 0],
					'featured_time' => ['TIMESTAMP', 0],
				],
				'PRIMARY_KEY' => 'image_id',
				'KEYS' => [
					'featured_time' => ['INDEX', 'featured_time'],
				],
			],
		]];
	}

	public function revert_schema(): array
	{
		return ['drop_tables' => [$this->table_prefix . 'gallery_featured']];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_featured_enable', 1]],
			['config.add', ['phpbb_gallery_featured_count', 8]],
			['config.add', ['phpbb_gallery_featured_slideshow', 1]],
			['config.add', ['phpbb_gallery_featured_autoplay', 0]],
			['config.add', ['phpbb_gallery_featured_interval', 6]],
			['config.add', ['phpbb_gallery_featured_include_personal', 1]],
		];
	}
}
