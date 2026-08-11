<?php
/**
 * phpBB Gallery - annual statistics dashboard storage.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add bounded annual engagement aggregates and source download totals. */
class statistics_dashboard extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\subalbum_display_modes'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_statistics_tracking_start', time()]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_statistics_tracking_start']],
		];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_download_count' => ['UINT:20', 0],
				],
			],
			'add_tables' => [
				$this->table_prefix . 'gallery_statistics' => [
					'COLUMNS' => [
						'stat_type'  => ['TINT:1', 0],
						'stat_year'  => ['UINT:4', 0],
						'image_id'   => ['UINT', 0],
						'user_id'    => ['UINT', 0],
						'stat_count' => ['UINT:20', 0],
					],
					'PRIMARY_KEY' => ['stat_type', 'stat_year', 'image_id', 'user_id'],
					'KEYS' => [
						'stat_year_type' => ['INDEX', ['stat_year', 'stat_type']],
						'stat_image'     => ['INDEX', ['image_id', 'stat_type']],
						'stat_user'      => ['INDEX', ['user_id', 'stat_type', 'stat_year']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'gallery_statistics',
			],
			'drop_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_download_count',
				],
			],
		];
	}
}
