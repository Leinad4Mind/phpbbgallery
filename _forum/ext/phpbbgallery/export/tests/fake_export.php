<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

/**
 * Stand in for the data layer so the batching can be exercised without a database.
 *
 * The parent constructor is skipped on purpose: nothing below reads the database
 * handle, the auth service or the cache.
 */
class fake_export extends \phpbbgallery\export\export
{
	/** @var array Rows indexed by image id */
	public array $rows = [];

	public function __construct(array $rows = [])
	{
		foreach ($rows as $row)
		{
			$this->rows[(int) $row['image_id']] = $row;
		}
	}

	public function get_rows(array $image_ids): array
	{
		$found = [];
		foreach ($image_ids as $image_id)
		{
			if (isset($this->rows[(int) $image_id]))
			{
				$found[] = $this->rows[(int) $image_id];
			}
		}

		return $found;
	}
}
