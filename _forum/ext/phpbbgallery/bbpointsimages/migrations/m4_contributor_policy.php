<?php
/**
 * phpBB Gallery - Per-album contributor policy.
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\migrations;

use phpbb\db\migration\migration;

final class m4_contributor_policy extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\bbpointsimages\migrations\m3_acp_settings'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_bbpoints_album_rules' => [
					'contributors_enabled' => ['INT:11', -1],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_bbpoints_album_rules' => [
					'contributors_enabled',
				],
			],
		];
	}
}
