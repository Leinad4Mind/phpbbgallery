<?php
/**
 * phpBB Gallery - Favorite test double
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests;

/**
 * Records the statements the favourite service issues.
 *
 * Only the handful of DBAL methods the service actually uses are implemented;
 * SELECTs against the favourites table answer from a preset list so a test can
 * describe what the member has already favourited.
 */
class fake_db implements \phpbb\db\driver\driver_interface
{
	/** @var array Statements issued, in order */
	public array $statements = [];

	/** @var array Rows handed to sql_multi_insert() */
	public array $inserted = [];

	/** @var array Transaction commands issued */
	public array $transactions = [];

	/** @var array Image ids the member has already favourited */
	private array $favorited;

	/** @var array|null Existing Core image ids; null accepts every requested id */
	private ?array $existing_images;

	/** @var array Rows queued for the next fetch */
	private array $pending = [];

	public function __construct(array $favorited = [], ?array $existing_images = null)
	{
		$this->favorited = $favorited;
		$this->existing_images = $existing_images;
	}

	public function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		return $field . ($negate ? ' NOT IN (' : ' IN (') . implode(',', (array) $array) . ')';
	}

	public function sql_query($sql, $cache_ttl = 0)
	{
		$this->statements[] = $sql;

		if (stripos($sql, 'SELECT image_id') !== false && stripos($sql, 'FROM images') !== false)
		{
			$requested = $this->ids_in($sql);
			$matched = $this->existing_images === null
				? $requested
				: array_intersect($this->existing_images, $requested);

			foreach ($matched as $image_id)
			{
				$this->pending[] = ['image_id' => $image_id];
			}
		}
		else if (stripos($sql, 'SELECT image_id') !== false)
		{
			$requested = $this->ids_in($sql);
			$matched = $requested === [] ? $this->favorited : array_intersect($this->favorited, $requested);

			foreach ($matched as $image_id)
			{
				$this->pending[] = ['image_id' => $image_id];
			}
		}

		return 'handle';
	}

	public function sql_multi_insert($table, $rows)
	{
		$this->statements[] = 'INSERT INTO ' . $table;
		$this->inserted = array_merge($this->inserted, $rows);

		return true;
	}

	public function sql_transaction($status = 'begin')
	{
		$this->transactions[] = $status;

		return true;
	}

	public function sql_fetchrow($handle = false)
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_freeresult($handle = false)
	{
		$this->pending = [];

		return true;
	}

	/**
	 * Pull the ids out of the IN (...) clause this double writes.
	 *
	 * @param string $sql Statement to inspect
	 * @return array
	 */
	private function ids_in(string $sql): array
	{
		if (!preg_match('/image_id IN \(([^)]*)\)/', $sql, $matches) || $matches[1] === '')
		{
			return [];
		}

		return array_map('intval', explode(',', $matches[1]));
	}

	/**
	 * Statements matching a fragment.
	 *
	 * @param string $fragment Text to look for
	 * @return array
	 */
	public function matching(string $fragment): array
	{
		return array_values(array_filter(
			$this->statements,
			static fn (string $sql): bool => stripos($sql, $fragment) !== false
		));
	}
}
