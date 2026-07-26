<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0_db_create'];
	}

	/**
	 * The favourites table and its counter ship with the core schema, so only
	 * the pieces this extension owns are added here: the guard that keeps a
	 * member from favouriting the same image twice, and the permission that
	 * decides who may favourite at all.
	 *
	 * @return array
	 */
	public function update_schema(): array
	{
		return [
			'add_unique_index' => [
				$this->table_prefix . 'gallery_favorites' => [
					'uid_id' => ['user_id', 'image_id'],
				],
			],
			'add_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_favorite' => ['UINT:3', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'gallery_favorites' => [
					'uid_id',
				],
			],
			'drop_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_favorite',
				],
			],
		];
	}
}
