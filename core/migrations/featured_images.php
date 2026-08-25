<?php
/**
 * phpBB Gallery - integrate curated featured images into Core.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Preserve data from the former Featured Images add-on while making Core its owner. */
class featured_images extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\release_4_1_0'];
	}

	public function update_schema(): array
	{
		$table = $this->table_prefix . 'gallery_featured';
		if ($this->db_tools->sql_table_exists($table))
		{
			return [];
		}

		return ['add_tables' => [
			$table => [
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
			['custom', [[$this, 'ensure_featured_location']]],
			['config.remove', ['phpbb_gallery_featured_enable']],
			['config.add', ['phpbb_gallery_featured_count', 8]],
			['config.add', ['phpbb_gallery_featured_slideshow', 1]],
			['config.add', ['phpbb_gallery_featured_autoplay', 0]],
			['config.add', ['phpbb_gallery_featured_interval', 6]],
			['config.add', ['phpbb_gallery_featured_include_personal', 1]],
			['config.add', ['phpbb_gallery_featured_position', 1]],
		];
	}

	public function revert_data(): array
	{
		$steps = [];
		foreach ([
				'featured_enable',
				'featured_location',
				'featured_count',
				'featured_slideshow',
				'featured_autoplay',
				'featured_interval',
				'featured_include_personal',
				'featured_position',
			] as $key)
		{
			$steps[] = ['config.remove', ['phpbb_gallery_' . $key]];
		}

		return $steps;
	}

	/** Preserve the add-on's selector or derive it from its former boolean switch. */
	public function ensure_featured_location(): bool
	{
		if (!isset($this->config['phpbb_gallery_featured_location']))
		{
			$this->config->set(
				'phpbb_gallery_featured_location',
				!isset($this->config['phpbb_gallery_featured_enable']) || !empty($this->config['phpbb_gallery_featured_enable']) ? 1 : 0
			);
		}

		return true;
	}
}
