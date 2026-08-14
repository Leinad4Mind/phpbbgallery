<?php
/**
 * phpBB Gallery - ACP CleanUp Extension
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup;

/** Diagnoses missing Gallery source objects without changing valid image records. */
class source_diagnostic
{
	private \phpbb\db\driver\driver_interface $db;
	private \phpbbgallery\core\storage\workspace $storage;
	private string $images_table;
	private string $albums_table;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbbgallery\core\storage\workspace $storage,
		string $images_table,
		string $albums_table
	)
	{
		$this->db = $db;
		$this->storage = $storage;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
	}

	public function count_all(): int
	{
		$result = $this->db->sql_query('SELECT COUNT(image_id) AS total
			FROM ' . $this->images_table);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $total;
	}

	public function count_missing(): int
	{
		$result = $this->db->sql_query('SELECT COUNT(image_id) AS total
			FROM ' . $this->images_table . '
			WHERE image_filemissing = 1');
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $total;
	}

	/**
	 * @return array{checked: int, missing: int, last_id: int, has_more: bool}
	 */
	public function scan_batch(int $after_id = 0, int $limit = 25): array
	{
		$after_id = max(0, $after_id);
		$limit = max(1, min(100, $limit));
		$sql = 'SELECT image_id, image_filename
			FROM ' . $this->images_table . '
			WHERE image_id > ' . (int) $after_id . '
			ORDER BY image_id ASC';
		$result = $this->db->sql_query_limit($sql, $limit + 1);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		$has_more = count($rows) > $limit;
		$rows = array_slice($rows, 0, $limit);
		$checked_ids = [];
		$missing_ids = [];
		foreach ($rows as $row)
		{
			$after_id = (int) $row['image_id'];
			$checked_ids[] = $after_id;
			if (!$this->storage->exists(
				\phpbbgallery\core\storage\provider_interface::SOURCE,
				(string) $row['image_filename']
			))
			{
				$missing_ids[] = $after_id;
			}
		}

		if ($checked_ids)
		{
			$this->db->sql_query('UPDATE ' . $this->images_table . '
				SET image_filemissing = 0
				WHERE ' . $this->db->sql_in_set('image_id', $checked_ids));
		}
		if ($missing_ids)
		{
			$this->db->sql_query('UPDATE ' . $this->images_table . '
				SET image_filemissing = 1
				WHERE ' . $this->db->sql_in_set('image_id', $missing_ids));
		}

		return [
			'checked' => count($rows),
			'missing' => count($missing_ids),
			'last_id' => $after_id,
			'has_more' => $has_more,
		];
	}

	/**
	 * @return list<array<string, mixed>>
	 */
	public function missing_page(int $start = 0, int $limit = 100): array
	{
		$start = max(0, $start);
		$limit = max(1, min(100, $limit));
		$sql_array = [
			'SELECT' => 'i.image_id, i.image_name, i.image_filename, i.image_username, i.image_status, a.album_name',
			'FROM' => [$this->images_table => 'i'],
			'LEFT_JOIN' => [
				[
					'FROM' => [$this->albums_table => 'a'],
					'ON' => 'a.album_id = i.image_album_id',
				],
			],
			'WHERE' => 'i.image_filemissing = 1',
			'ORDER_BY' => 'i.image_id ASC',
		];
		$result = $this->db->sql_query_limit(
			$this->db->sql_build_query('SELECT', $sql_array),
			$limit,
			$start
		);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$key = (string) $row['image_filename'];
			$row['medium_exists'] = $this->storage->exists(
				\phpbbgallery\core\storage\provider_interface::MEDIUM,
				$key
			);
			$row['mini_exists'] = $this->storage->exists(
				\phpbbgallery\core\storage\provider_interface::MINI,
				$key
			);
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}
}
