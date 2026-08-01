<?php
/**
 * phpBB Gallery - BBPoints reward lifecycle
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\migrations;

use phpbb\db\migration\migration;

final class m2_reward_lifecycle extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\bbpointsimages\migrations\m1_init'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_bbpoints_rewards' => [
					'source_sha256'      => ['VCHAR:64', ''],
					'reassignment_count' => ['UINT:11', 0],
				],
			],
			'add_unique_index' => [
				$this->table_prefix . 'gallery_bbpoints_rewards' => [
					'source_sha256' => ['source_sha256'],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'gallery_bbpoints_rewards' => ['source_sha256'],
			],
			'drop_columns' => [
				$this->table_prefix . 'gallery_bbpoints_rewards' => [
					'source_sha256',
					'reassignment_count',
				],
			],
		];
	}
}
