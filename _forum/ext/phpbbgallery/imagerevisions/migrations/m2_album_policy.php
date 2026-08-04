<?php
/**
 * phpBB Gallery - Image revision album policies.
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\migrations;

use phpbb\db\migration\migration;

final class m2_album_policy extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\imagerevisions\migrations\m1_init'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_imagerevisions_album_rules' => [
					'COLUMNS' => [
						'album_id' => ['UINT', 0],
						'enabled' => ['INT:11', -1],
						'revision_limit' => ['INT:11', -1],
					],
					'PRIMARY_KEY' => 'album_id',
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return ['drop_tables' => [$this->table_prefix . 'gallery_imagerevisions_album_rules']];
	}
}
