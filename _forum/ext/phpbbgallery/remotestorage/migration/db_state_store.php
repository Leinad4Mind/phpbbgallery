<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migration;

use phpbb\db\driver\driver_interface;

final class db_state_store implements state_store_interface
{
	public function __construct(private driver_interface $db, private string $table)
	{
	}

	public function load(): ?array
	{
		$sql = 'SELECT *
			FROM ' . $this->table . '
			WHERE migration_id = 1';
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($row) ? $row : null;
	}

	public function save(array $state): void
	{
		$sql_ary = [
			'source_provider' => (string) $state['source_provider'],
			'target_provider' => (string) $state['target_provider'],
			'variant' => (string) $state['variant'],
			'migration_cursor' => (string) $state['migration_cursor'],
			'copied' => (int) $state['copied'],
			'skipped' => (int) $state['skipped'],
			'failed' => (int) $state['failed'],
			'status' => (string) $state['status'],
			'started' => (int) $state['started'],
			'updated' => (int) $state['updated'],
			'last_error' => (string) $state['last_error'],
		];

		if ($this->load() === null)
		{
			$sql_ary['migration_id'] = 1;
			$this->db->sql_query('INSERT INTO ' . $this->table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));

			return;
		}

		$this->db->sql_query('UPDATE ' . $this->table . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE migration_id = 1');
	}

	public function clear(): void
	{
		$this->db->sql_query('DELETE FROM ' . $this->table . '
			WHERE migration_id = 1');
	}
}
