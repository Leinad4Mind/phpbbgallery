<?php
/**
 * phpBB Gallery - BBPoints Images storage
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\migrations;

use phpbb\db\migration\migration;

final class m1_init extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\core\migrations\remove_legacy_image_plugins',
			'\sitesplat\bbpoints\migrations\v13x\m1_ledger_api',
		];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_bbpoints_album_rules' => [
					'COLUMNS' => [
						'album_id'      => ['UINT', 0],
						'upload_reward' => ['INT:11', -1],
						'source_cost'   => ['INT:11', -1],
					],
					'PRIMARY_KEY' => 'album_id',
				],
				$this->table_prefix . 'gallery_bbpoints_contributors' => [
					'COLUMNS' => [
						'image_id'          => ['UINT', 0],
						'user_id'           => ['UINT', 0],
						'contributor_order' => ['UINT:11', 0],
					],
					'PRIMARY_KEY' => ['image_id', 'user_id'],
					'KEYS' => [
						'user_id' => ['INDEX', ['user_id']],
					],
				],
				$this->table_prefix . 'gallery_bbpoints_rewards' => [
					'COLUMNS' => [
						'image_id'      => ['UINT', 0],
						'user_id'       => ['UINT', 0],
						'amount'        => ['UINT:20', 0],
						'operation_key' => ['VCHAR:191', ''],
						'reward_time'   => ['UINT:11', 0],
					],
					'PRIMARY_KEY' => 'image_id',
					'KEYS' => [
						'user_id' => ['INDEX', ['user_id']],
					],
				],
				$this->table_prefix . 'gallery_bbpoints_purchases' => [
					'COLUMNS' => [
						'image_id'           => ['UINT', 0],
						'buyer_id'           => ['UINT', 0],
						'amount'             => ['UINT:20', 0],
						'operation_key'      => ['VCHAR:191', ''],
						'purchase_time'      => ['UINT:11', 0],
						'last_download_time' => ['UINT:11', 0],
						'download_count'     => ['UINT:20', 0],
					],
					'PRIMARY_KEY' => ['image_id', 'buyer_id'],
					'KEYS' => [
						'buyer_id' => ['INDEX', ['buyer_id']],
					],
				],
				$this->table_prefix . 'gallery_bbpoints_image_stats' => [
					'COLUMNS' => [
						'image_id'        => ['UINT', 0],
						'source_sha256'   => ['VCHAR:64', ''],
						'download_count'  => ['UINT:20', 0],
					],
					'PRIMARY_KEY' => 'image_id',
					'KEYS' => [
						'source_sha256' => ['INDEX', ['source_sha256']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'gallery_bbpoints_image_stats',
				$this->table_prefix . 'gallery_bbpoints_purchases',
				$this->table_prefix . 'gallery_bbpoints_rewards',
				$this->table_prefix . 'gallery_bbpoints_contributors',
				$this->table_prefix . 'gallery_bbpoints_album_rules',
			],
		];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_bbpoints_upload_reward', 0]],
			['config.add', ['phpbb_gallery_bbpoints_source_cost', 0]],
			['config.add', ['phpbb_gallery_bbpoints_contributors_enabled', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_bbpoints_contributors_enabled']],
			['config.remove', ['phpbb_gallery_bbpoints_source_cost']],
			['config.remove', ['phpbb_gallery_bbpoints_upload_reward']],
		];
	}
}
