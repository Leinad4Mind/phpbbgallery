<?php
/**
 * BBPoints Images policy database test double
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

final class fake_db implements \phpbb\db\driver\driver_interface
{
	public array $rows = [];
	public string $last_query = '';
	public array $queries = [];
	public array $inserted = [];
	private int $position = 0;

	public function sql_query(string $sql): string
	{
		$this->last_query = $sql;
		$this->queries[] = $sql;
		$this->position = 0;
		return 'result';
	}

	public function sql_in_set(string $field, array $values): string
	{
		return $field . ' IN (' . implode(',', array_map('intval', $values)) . ')';
	}

	public function sql_multi_insert(string $table, array $rows): void
	{
		$this->inserted[$table] = $rows;
	}

	public function sql_fetchrow(string $result): array|false
	{
		return $this->rows[$this->position++] ?? false;
	}

	public function sql_freeresult(string $result): void
	{
	}
}
