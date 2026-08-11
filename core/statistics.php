<?php
/**
 * phpBB Gallery statistics aggregation and rankings.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

/** Record bounded annual aggregates and build permission-filtered rankings. */
final class statistics
{
	public const TYPE_VIEW = 1;
	public const TYPE_DOWNLOAD = 2;
	public const DEFAULT_LIMIT = 10;
	public const PERIOD_ALL_TIME = 0;
	public const PERIOD_LEGACY = -1;

	public function __construct(
		private \phpbb\db\driver\driver_interface $db,
		private \phpbb\config\config $config,
		private string $images_table,
		private string $statistics_table,
		private string $users_table
	)
	{
	}

	/** Record one image-page view in the current board year. */
	public function record_view(int $image_id, ?int $timestamp = null): void
	{
		if ($image_id < 1)
		{
			return;
		}

		$this->increment(self::TYPE_VIEW, $this->year_for_timestamp($timestamp ?? time()), $image_id, 0);
	}

	/** Record one delivered original source and increment its lifetime total. */
	public function record_download(int $image_id, int $user_id, ?int $timestamp = null): void
	{
		if ($image_id < 1)
		{
			return;
		}

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_download_count = image_download_count + 1
			WHERE image_id = ' . (int) $image_id;
		$this->db->sql_query($sql);
		$this->increment(
			self::TYPE_DOWNLOAD,
			$this->year_for_timestamp($timestamp ?? time()),
			$image_id,
			max(0, $user_id)
		);
	}

	/** Remove aggregates that belong to permanently deleted images. */
	public function remove_images(array $image_ids): void
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids), static fn (int $id): bool => $id > 0)));
		if (!$image_ids)
		{
			return;
		}

		$this->db->sql_query('DELETE FROM ' . $this->statistics_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids));
	}

	/**
	 * Build every section needed by the public statistics page.
	 *
	 * @param array<int> $album_ids Albums the current viewer may see
	 * @return array<string, mixed>
	 */
	public function dashboard(array $album_ids, int $year = 0, int $limit = self::DEFAULT_LIMIT): array
	{
		$album_ids = $this->normalise_ids($album_ids);
		$year = $this->normalise_year($year);
		$limit = min(50, max(1, $limit));

		if (!$album_ids)
		{
			return [
				'year' => $year,
				'years' => [],
				'legacy_start' => 0,
				'tracking_start' => $this->tracking_start(),
				'tracking_year' => $this->tracking_year(),
				'summary' => $this->empty_summary(),
				'top_viewed' => [],
				'top_downloaded' => [],
				'top_uploaders' => [],
				'top_downloaders' => [],
			];
		}

		$periods = $this->available_periods($album_ids);

		return [
			'year' => $year,
			'years' => $periods['years'],
			'legacy_start' => $periods['legacy_start'],
			'tracking_start' => $this->tracking_start(),
			'tracking_year' => $this->tracking_year(),
			'summary' => $this->summary($album_ids, $year),
			'top_viewed' => $this->top_images($album_ids, $year, self::TYPE_VIEW, $limit),
			'top_downloaded' => $this->top_images($album_ids, $year, self::TYPE_DOWNLOAD, $limit),
			'top_uploaders' => $this->top_uploaders($album_ids, $year, $limit),
			'top_downloaders' => $this->top_downloaders($album_ids, $year, $limit),
		];
	}

	/** @param array<int> $album_ids */
	private function summary(array $album_ids, int $year): array
	{
		$where = $this->get_sql_where($album_ids, 'i');
		if ($year === self::PERIOD_LEGACY)
		{
			$where .= ' AND i.image_time < ' . $this->tracking_start();
		}
		else if ($year > 0)
		{
			[$start, $end] = $this->period_bounds($year);
			$where .= ' AND i.image_time >= ' . $start . ' AND i.image_time < ' . $end;
		}

		$sql = 'SELECT COUNT(i.image_id) AS image_count,
				COUNT(DISTINCT i.image_user_id) AS uploader_count,
				SUM(i.image_view_count) AS lifetime_views,
				SUM(i.image_download_count) AS lifetime_downloads
			FROM ' . $this->images_table . ' i
			WHERE ' . $where;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result) ?: [];
		$this->db->sql_freeresult($result);

		$summary = [
			'image_count' => (int) ($row['image_count'] ?? 0),
			'uploader_count' => (int) ($row['uploader_count'] ?? 0),
			'view_count' => $year <= self::PERIOD_ALL_TIME ? (int) ($row['lifetime_views'] ?? 0) : 0,
			'download_count' => $year <= self::PERIOD_ALL_TIME ? (int) ($row['lifetime_downloads'] ?? 0) : 0,
		];

		if ($year === self::PERIOD_LEGACY)
		{
			$sql = 'SELECT s.stat_type, SUM(s.stat_count) AS total
				FROM ' . $this->statistics_table . ' s
				INNER JOIN ' . $this->images_table . ' i ON i.image_id = s.image_id
				WHERE s.stat_year > 0
					AND i.image_time < ' . $this->tracking_start() . '
					AND ' . $this->get_sql_where($album_ids, 'i') . '
				GROUP BY s.stat_type';
			$result = $this->db->sql_query($sql);
			while ($stat = $this->db->sql_fetchrow($result))
			{
				if ((int) $stat['stat_type'] === self::TYPE_VIEW)
				{
					$summary['view_count'] = max(0, $summary['view_count'] - (int) $stat['total']);
				}
				else if ((int) $stat['stat_type'] === self::TYPE_DOWNLOAD)
				{
					$summary['download_count'] = max(0, $summary['download_count'] - (int) $stat['total']);
				}
			}
			$this->db->sql_freeresult($result);
		}
		else if ($year > 0)
		{
			$sql = 'SELECT s.stat_type, SUM(s.stat_count) AS total
				FROM ' . $this->statistics_table . ' s
				INNER JOIN ' . $this->images_table . ' i ON i.image_id = s.image_id
				WHERE s.stat_year = ' . (int) $year . '
					AND ' . $this->get_sql_where($album_ids, 'i') . '
				GROUP BY s.stat_type';
			$result = $this->db->sql_query($sql);
			while ($stat = $this->db->sql_fetchrow($result))
			{
				if ((int) $stat['stat_type'] === self::TYPE_VIEW)
				{
					$summary['view_count'] = (int) $stat['total'];
				}
				else if ((int) $stat['stat_type'] === self::TYPE_DOWNLOAD)
				{
					$summary['download_count'] = (int) $stat['total'];
				}
			}
			$this->db->sql_freeresult($result);
		}

		return $summary;
	}

	/** @param array<int> $album_ids @return array<int, array<string, mixed>> */
	private function top_images(array $album_ids, int $year, int $type, int $limit): array
	{
		$metric_column = $type === self::TYPE_VIEW ? 'image_view_count' : 'image_download_count';
		if ($year === self::PERIOD_ALL_TIME)
		{
			$sql = 'SELECT i.image_id, i.image_name, i.image_user_id, i.image_username,
					i.image_user_colour, i.image_album_id, i.' . $metric_column . ' AS metric
				FROM ' . $this->images_table . ' i
				WHERE ' . $this->get_sql_where($album_ids, 'i') . '
					AND i.' . $metric_column . ' > 0
				ORDER BY i.' . $metric_column . ' DESC, i.image_id DESC';
		}
		else if ($year === self::PERIOD_LEGACY)
		{
			$sql = 'SELECT i.image_id, i.image_name, i.image_user_id, i.image_username,
					i.image_user_colour, i.image_album_id,
					CASE WHEN i.' . $metric_column . ' > COALESCE(SUM(s.stat_count), 0)
						THEN i.' . $metric_column . ' - COALESCE(SUM(s.stat_count), 0)
						ELSE 0 END AS metric
				FROM ' . $this->images_table . ' i
				LEFT JOIN ' . $this->statistics_table . ' s ON s.image_id = i.image_id
					AND s.stat_type = ' . (int) $type . '
					AND s.stat_year > 0
				WHERE ' . $this->get_sql_where($album_ids, 'i') . '
					AND i.image_time < ' . $this->tracking_start() . '
				GROUP BY i.image_id, i.image_name, i.image_user_id, i.image_username,
					i.image_user_colour, i.image_album_id, i.' . $metric_column . '
				HAVING i.' . $metric_column . ' > COALESCE(SUM(s.stat_count), 0)
				ORDER BY metric DESC, i.image_id DESC';
		}
		else if ($type === self::TYPE_VIEW)
		{
			$sql = 'SELECT i.image_id, i.image_name, i.image_user_id, i.image_username,
					i.image_user_colour, i.image_album_id, s.stat_count AS metric
				FROM ' . $this->statistics_table . ' s
				INNER JOIN ' . $this->images_table . ' i ON i.image_id = s.image_id
				WHERE s.stat_type = ' . self::TYPE_VIEW . '
					AND s.stat_year = ' . (int) $year . '
					AND s.user_id = 0
					AND s.stat_count > 0
					AND ' . $this->get_sql_where($album_ids, 'i') . '
				ORDER BY s.stat_count DESC, i.image_id DESC';
		}
		else
		{
			$sql = 'SELECT i.image_id, i.image_name, i.image_user_id, i.image_username,
					i.image_user_colour, i.image_album_id, SUM(s.stat_count) AS metric
				FROM ' . $this->statistics_table . ' s
				INNER JOIN ' . $this->images_table . ' i ON i.image_id = s.image_id
				WHERE s.stat_type = ' . self::TYPE_DOWNLOAD . '
					AND s.stat_year = ' . (int) $year . '
					AND s.stat_count > 0
					AND ' . $this->get_sql_where($album_ids, 'i') . '
				GROUP BY i.image_id, i.image_name, i.image_user_id, i.image_username,
					i.image_user_colour, i.image_album_id
				ORDER BY metric DESC, i.image_id DESC';
		}

		return $this->fetch_rows($sql, $limit);
	}

	/** @param array<int> $album_ids @return array<int, array<string, mixed>> */
	private function top_uploaders(array $album_ids, int $year, int $limit): array
	{
		$where = $this->get_sql_where($album_ids, 'i') . '
			AND u.user_id > ' . $this->anonymous_user_id();
		if ($year === self::PERIOD_LEGACY)
		{
			$where .= ' AND i.image_time < ' . $this->tracking_start();
		}
		else if ($year > 0)
		{
			[$start, $end] = $this->period_bounds($year);
			$where .= ' AND i.image_time >= ' . $start . ' AND i.image_time < ' . $end;
		}

		$sql = 'SELECT u.user_id, u.username, u.user_colour, COUNT(i.image_id) AS metric
			FROM ' . $this->images_table . ' i
			INNER JOIN ' . $this->users_table . ' u ON u.user_id = i.image_user_id
			WHERE ' . $where . '
			GROUP BY u.user_id, u.username, u.user_colour
			ORDER BY metric DESC, u.username_clean ASC';

		return $this->fetch_rows($sql, $limit);
	}

	/** @param array<int> $album_ids @return array<int, array<string, mixed>> */
	private function top_downloaders(array $album_ids, int $year, int $limit): array
	{
		$where = 's.stat_type = ' . self::TYPE_DOWNLOAD . '
			AND s.user_id > ' . $this->anonymous_user_id() . '
			AND s.stat_count > 0
			AND ' . $this->get_sql_where($album_ids, 'i');
		if ($year === self::PERIOD_LEGACY)
		{
			$where .= ' AND s.stat_year = 0
				AND i.image_time < ' . $this->tracking_start();
		}
		else if ($year > 0)
		{
			$where .= ' AND s.stat_year = ' . (int) $year;
		}

		$sql = 'SELECT u.user_id, u.username, u.user_colour, SUM(s.stat_count) AS metric
			FROM ' . $this->statistics_table . ' s
			INNER JOIN ' . $this->images_table . ' i ON i.image_id = s.image_id
			INNER JOIN ' . $this->users_table . ' u ON u.user_id = s.user_id
			WHERE ' . $where . '
			GROUP BY u.user_id, u.username, u.user_colour
			ORDER BY metric DESC, u.username_clean ASC';

		return $this->fetch_rows($sql, $limit);
	}

	/** @param array<int> $album_ids @return array{years: array<int>, legacy_start: int} */
	private function available_periods(array $album_ids): array
	{
		$sql = 'SELECT MIN(i.image_time) AS first_time, MAX(i.image_time) AS last_time
			FROM ' . $this->images_table . ' i
			WHERE ' . $this->get_sql_where($album_ids, 'i');
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result) ?: [];
		$this->db->sql_freeresult($result);

		$years = [];
		$first_time = (int) ($row['first_time'] ?? 0);
		$last_time = (int) ($row['last_time'] ?? 0);
		$tracking_start = $this->tracking_start();
		$tracking_year = $this->tracking_year();
		$current_year = $this->year_for_timestamp(time());
		if ($tracking_start > 0)
		{
			for ($year = $current_year; $year >= $tracking_year; $year--)
			{
				$years[] = $year;
			}
		}
		else if ($first_time > 0 && $last_time >= $first_time)
		{
			$first_year = $this->year_for_timestamp($first_time);
			$last_year = $this->year_for_timestamp($last_time);
			for ($year = $last_year; $year >= $first_year; $year--)
			{
				$years[] = $year;
			}
		}

		$sql = 'SELECT DISTINCT s.stat_year
			FROM ' . $this->statistics_table . ' s
			INNER JOIN ' . $this->images_table . ' i ON i.image_id = s.image_id
			WHERE s.stat_year > 0
				AND ' . $this->get_sql_where($album_ids, 'i');
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$stat_year = (int) $row['stat_year'];
			if ($stat_year >= max(1970, $tracking_year))
			{
				$years[] = $stat_year;
			}
		}
		$this->db->sql_freeresult($result);
		$years = array_values(array_unique($years));
		rsort($years, SORT_NUMERIC);

		return [
			'years' => $years,
			'legacy_start' => $tracking_start > 0 && $first_time > 0 && $first_time < $tracking_start ? $first_time : 0,
		];
	}

	/** @return array<int, array<string, mixed>> */
	private function fetch_rows(string $sql, int $limit): array
	{
		$result = $this->db->sql_query_limit($sql, $limit);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$row['metric'] = (int) ($row['metric'] ?? 0);
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}

	private function increment(int $type, int $year, int $image_id, int $user_id): void
	{
		$where = 'stat_type = ' . (int) $type . '
			AND stat_year = ' . (int) $year . '
			AND image_id = ' . (int) $image_id . '
			AND user_id = ' . (int) $user_id;
		$sql = 'UPDATE ' . $this->statistics_table . '
			SET stat_count = stat_count + 1
			WHERE ' . $where;
		$this->db->sql_query($sql);
		if ((int) $this->db->sql_affectedrows() > 0)
		{
			return;
		}

		$this->db->sql_return_on_error(true);
		$this->db->sql_query('INSERT INTO ' . $this->statistics_table . ' ' . $this->db->sql_build_array('INSERT', [
			'stat_type' => $type,
			'stat_year' => $year,
			'image_id' => $image_id,
			'user_id' => $user_id,
			'stat_count' => 1,
		]));
		$failed = $this->db->get_sql_error_triggered();
		$this->db->sql_return_on_error(false);
		if ($failed)
		{
			$this->db->sql_query($sql);
		}
	}

	/** @param array<int> $album_ids */
	private function get_sql_where(array $album_ids, string $alias): string
	{
		return $this->db->sql_in_set($alias . '.image_album_id', $album_ids) . '
			AND ' . $this->db->sql_in_set($alias . '.image_status', [block::STATUS_APPROVED, block::STATUS_LOCKED]);
	}

	/** @return array{0: int, 1: int} */
	private function period_bounds(int $year): array
	{
		$timezone = $this->board_timezone();
		$start = new \DateTimeImmutable($year . '-01-01 00:00:00', $timezone);
		$end = $start->modify('+1 year');
		$tracking_start = $this->tracking_start();
		if ($year === $this->tracking_year() && $tracking_start > $start->getTimestamp())
		{
			return [$tracking_start, $end->getTimestamp()];
		}

		return [$start->getTimestamp(), $end->getTimestamp()];
	}

	private function year_for_timestamp(int $timestamp): int
	{
		$date = (new \DateTimeImmutable('@' . max(0, $timestamp)))->setTimezone($this->board_timezone());

		return (int) $date->format('Y');
	}

	private function board_timezone(): \DateTimeZone
	{
		try
		{
			return new \DateTimeZone((string) ($this->config['board_timezone'] ?? 'UTC'));
		}
		catch (\Exception)
		{
			return new \DateTimeZone('UTC');
		}
	}

	private function normalise_year(int $year): int
	{
		$current_year = $this->year_for_timestamp(time());
		$tracking_start = $this->tracking_start();
		$tracking_year = $this->tracking_year();
		if ($tracking_start > 0 && ($year === self::PERIOD_LEGACY || ($year >= 1970 && $year < $tracking_year)))
		{
			return self::PERIOD_LEGACY;
		}

		return $year >= max(1970, $tracking_year) && $year <= $current_year ? $year : self::PERIOD_ALL_TIME;
	}

	private function tracking_start(): int
	{
		return max(0, (int) ($this->config['phpbb_gallery_statistics_tracking_start'] ?? 0));
	}

	private function tracking_year(): int
	{
		$tracking_start = $this->tracking_start();

		return $tracking_start > 0 ? $this->year_for_timestamp($tracking_start) : 1970;
	}

	/** @param array<int> $ids @return array<int> */
	private function normalise_ids(array $ids): array
	{
		return array_values(array_unique(array_filter(array_map('intval', $ids), static fn (int $id): bool => $id > 0)));
	}

	/** @return array<string, int> */
	private function empty_summary(): array
	{
		return ['image_count' => 0, 'uploader_count' => 0, 'view_count' => 0, 'download_count' => 0];
	}

	private function anonymous_user_id(): int
	{
		return defined('ANONYMOUS') ? (int) ANONYMOUS : 1;
	}
}
