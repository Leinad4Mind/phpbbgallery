<?php
/**
 * phpBB Gallery - configurable featured-image blocks on the Gallery index.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add ranked Gallery-index modes and their supporting indexes. */
class gallery_index_featured_modes extends migration
{
	public static function depends_on(): array
	{
		return [
			'\\phpbbgallery\\core\\migrations\\index_album_layout',
		];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_pegas_index_viewed_count', 4]],
			['config.add', ['phpbb_gallery_pegas_index_rated_count', 4]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_pegas_index_viewed_count']],
			['config.remove', ['phpbb_gallery_pegas_index_rated_count']],
		];
	}

	public function update_schema(): array
	{
		return [
			'add_index' => [
				$this->table_prefix . 'gallery_images' => [
					'status_views_rank' => ['image_status', 'image_view_count', 'image_id'],
					'status_rating_rank' => ['image_status', 'image_rate_avg', 'image_rates', 'image_id'],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'gallery_images' => [
					'status_views_rank',
					'status_rating_rank',
				],
			],
		];
	}
}
