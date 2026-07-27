<?php
/**
 * phpBB Gallery - BBTags Bridge storage.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\core\migrations\release_1_2_0_db_create',
			'\sitesplat\bbtags\migrations\v33x\m11_tag_moderation',
		];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_image_tags' => [
					'COLUMNS' => [
						'image_id' => ['UINT', 0],
						'tag_id'   => ['UINT', 0],
					],
					'PRIMARY_KEY' => ['image_id', 'tag_id'],
					'KEYS' => [
						'tag_id' => ['INDEX', ['tag_id']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'gallery_image_tags',
			],
		];
	}
}
