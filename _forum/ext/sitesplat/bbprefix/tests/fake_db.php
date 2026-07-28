<?php
/**
 * BBPrefix tests.
 *
 * @package BBprefix
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbprefix\tests;

/**
 * Serves canned rows per table.
 *
 * The point of interest is `short_rows`: it lets a table hand back fewer rows than
 * its own COUNT(*) reports, which is what an interrupted result set looks like to
 * the manager - the fetch loop just ends early, with no error raised anywhere.
 */
class fake_db
{
	/** @var array Table name => list of rows */
	public array $tables = [];

	/** @var array Table name => how many rows to actually hand out */
	public array $short_rows = [];

	/** @var array Every SQL statement executed, in order */
	public array $queries = [];

	/** @var array Open result sets */
	private array $results = [];

	/** @var int Next result handle */
	private int $handle = 0;

	/** @var int Next auto-increment ID handed out by sql_nextid() */
	private int $next_id = 1000;

	public function sql_query($query, $cache_ttl = 0)
	{
		$this->queries[] = $query;

		$handle = ++$this->handle;

		if (preg_match('/SELECT COUNT\(\*\) AS total FROM (\S+)/', $query, $matches))
		{
			// The count always reflects the whole table, the way the database would.
			$this->results[$handle] = [
				'count' => count($this->tables[$matches[1]] ?? []),
				'rows' => [],
			];

			return $handle;
		}

		preg_match('/FROM (\S+)/', $query, $matches);
		$table = $matches[1] ?? '';
		$rows = $this->tables[$table] ?? [];

		if (isset($this->short_rows[$table]))
		{
			$rows = array_slice($rows, 0, $this->short_rows[$table]);
		}

		$this->results[$handle] = ['count' => null, 'rows' => $rows];

		return $handle;
	}

	public function sql_fetchrow($handle)
	{
		if (empty($this->results[$handle]['rows']))
		{
			return false;
		}

		return array_shift($this->results[$handle]['rows']);
	}

	public function sql_fetchfield($field, $row = false, $handle = false)
	{
		// Only COUNT(*) AS total is fetched this way by the manager.
		foreach ($this->results as $result)
		{
			if ($result['count'] !== null)
			{
				return $result['count'];
			}
		}

		return false;
	}

	public function sql_freeresult($handle = false)
	{
		unset($this->results[$handle]);
	}

	public function sql_escape($value)
	{
		return str_replace(["'", '\\'], ["''", '\\\\'], (string) $value);
	}

	public function sql_build_array($query, $assoc_ary = [])
	{
		return '';
	}

	public function sql_nextid()
	{
		return ++$this->next_id;
	}

	public function sql_in_set($column, $array, $negate = false, $allow_empty_set = false)
	{
		return $column . ($negate ? ' NOT IN (' : ' IN (') . implode(',', (array) $array) . ')';
	}

	/**
	 * @return int How many statements hit the given table
	 */
	public function queries_against($table)
	{
		return count(array_filter($this->queries, static function ($query) use ($table) {
			return strpos($query, $table) !== false;
		}));
	}
}
