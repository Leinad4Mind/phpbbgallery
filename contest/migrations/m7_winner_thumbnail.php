<?php
/**
 * phpBB Gallery - Contest winner-thumbnail policy.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\migrations;

use phpbb\db\migration\migration;

class m7_winner_thumbnail extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\contest\migrations\m6_contest_storage'];
	}

	public function effectively_installed(): bool
	{
		return isset($this->config['phpbb_gallery_contest_winner_thumbnail'])
			&& $this->db_tools->sql_column_exists(
				$this->table_prefix . 'gallery_contests',
				'contest_winner_thumbnail'
			);
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_contest_winner_thumbnail', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_contest_winner_thumbnail']],
		];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_contests' => [
					'contest_winner_thumbnail' => ['INT:11', -1],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_contests' => [
					'contest_winner_thumbnail',
				],
			],
		];
	}
}
