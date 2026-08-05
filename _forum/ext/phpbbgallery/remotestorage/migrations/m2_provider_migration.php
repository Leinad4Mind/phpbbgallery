<?php
/**
 * phpBB Gallery - Remote Storage provider migration state.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m2_provider_migration extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m1_acp_settings'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_remote_migrations' => [
					'COLUMNS' => [
						'migration_id' => ['UINT', 1],
						'source_provider' => ['VCHAR:64', ''],
						'target_provider' => ['VCHAR:64', ''],
						'variant' => ['VCHAR:16', 'source'],
						'migration_cursor' => ['MTEXT', ''],
						'copied' => ['UINT', 0],
						'skipped' => ['UINT', 0],
						'failed' => ['UINT', 0],
						'status' => ['VCHAR:16', 'running'],
						'started' => ['TIMESTAMP', 0],
						'updated' => ['TIMESTAMP', 0],
						'last_error' => ['MTEXT', ''],
					],
					'PRIMARY_KEY' => 'migration_id',
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return ['drop_tables' => [$this->table_prefix . 'gallery_remote_migrations']];
	}
}
