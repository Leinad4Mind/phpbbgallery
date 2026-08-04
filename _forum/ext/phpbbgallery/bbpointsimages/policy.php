<?php
/**
 * phpBB Gallery - BBPoints Images policy resolver
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;

/**
 * Resolve the nearest per-album points rule with a global fallback.
 */
final class policy
{
	public const INHERIT = -1;
	public const MAX_POINTS = 2147483647;

	public function __construct(
		private driver_interface $db,
		private config $config,
		private string $albums_table,
		private string $rules_table
	)
	{
	}

	/**
	 * @return array{upload_reward: int, source_cost: int, contributors_enabled: int}
	 */
	public function resolve(int $album_id): array
	{
		if ($album_id <= 0)
		{
			throw new \OutOfBoundsException('A valid Gallery album is required.');
		}

		$resolved = [
			'upload_reward' => null,
			'source_cost' => null,
			'contributors_enabled' => null,
		];
		$sql = 'SELECT rules.upload_reward, rules.source_cost, rules.contributors_enabled
			FROM ' . $this->albums_table . ' current_album
			INNER JOIN ' . $this->albums_table . ' ancestor
				ON ancestor.left_id <= current_album.left_id
				AND ancestor.right_id >= current_album.right_id
				AND ancestor.album_user_id = current_album.album_user_id
			LEFT JOIN ' . $this->rules_table . ' rules
				ON rules.album_id = ancestor.album_id
			WHERE current_album.album_id = ' . (int) $album_id . '
			ORDER BY ancestor.left_id DESC';
		$result = $this->db->sql_query($sql);
		$album_exists = false;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_exists = true;
			foreach (array_keys($resolved) as $setting)
			{
				$row_value = $row[$setting] ?? null;
				if ($setting === 'contributors_enabled' && $row_value !== null
					&& !in_array((int) $row_value, [0, 1], true))
				{
					continue;
				}
				if ($resolved[$setting] === null && $row_value !== null
					&& (int) $row_value >= 0)
				{
					$resolved[$setting] = (int) $row_value;
				}
			}
		}
		$this->db->sql_freeresult($result);

		if (!$album_exists)
		{
			throw new \OutOfBoundsException('The Gallery album does not exist.');
		}

		return [
			'upload_reward' => $resolved['upload_reward']
				?? self::normalize_amount((int) $this->config['phpbb_gallery_bbpoints_upload_reward']),
			'source_cost' => $resolved['source_cost']
				?? self::normalize_amount((int) $this->config['phpbb_gallery_bbpoints_source_cost']),
			'contributors_enabled' => $resolved['contributors_enabled']
				?? (empty($this->config['phpbb_gallery_bbpoints_contributors_enabled']) ? 0 : 1),
		];
	}

	public static function normalize_override(int $value): int
	{
		return min(self::MAX_POINTS, max(self::INHERIT, $value));
	}

	public static function normalize_amount(int $value): int
	{
		return min(self::MAX_POINTS, max(0, $value));
	}

	public static function normalize_toggle_override(int $value): int
	{
		return in_array($value, [self::INHERIT, 0, 1], true) ? $value : self::INHERIT;
	}

	/**
	 * @return array{upload_reward: int, source_cost: int, contributors_enabled: int}
	 */
	public function get_global_rule(): array
	{
		return [
			'upload_reward' => self::normalize_amount((int) $this->config['phpbb_gallery_bbpoints_upload_reward']),
			'source_cost' => self::normalize_amount((int) $this->config['phpbb_gallery_bbpoints_source_cost']),
			'contributors_enabled' => empty($this->config['phpbb_gallery_bbpoints_contributors_enabled']) ? 0 : 1,
		];
	}

	/**
	 * Return the complete album tree with its direct overrides.
	 */
	public function get_album_rules(): array
	{
		$sql = 'SELECT albums.album_id, albums.parent_id, albums.album_user_id, albums.album_name,
				albums.left_id, albums.right_id, rules.upload_reward, rules.source_cost,
				rules.contributors_enabled
			FROM ' . $this->albums_table . ' albums
			LEFT JOIN ' . $this->rules_table . ' rules ON rules.album_id = albums.album_id
			WHERE albums.album_user_id = 0
			ORDER BY albums.left_id ASC';
		$result = $this->db->sql_query($sql);
		$rows = [];
		$parents = [];
		$global = $this->get_global_rule();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$left_id = (int) $row['left_id'];
			while ($parents && (int) end($parents)['right_id'] < $left_id)
			{
				array_pop($parents);
			}
			$inherited = $parents ? end($parents)['effective'] : $global;
			$effective = [];
			foreach (array_keys($global) as $setting)
			{
				$direct = $row[$setting] === null ? self::INHERIT : (int) $row[$setting];
				if ($setting === 'contributors_enabled')
				{
					$direct = self::normalize_toggle_override($direct);
				}
				$effective[$setting] = $direct >= 0 ? $direct : $inherited[$setting];
			}
			$row['depth'] = count($parents);
			$row['effective_upload_reward'] = $effective['upload_reward'];
			$row['effective_source_cost'] = $effective['source_cost'];
			$row['effective_contributors_enabled'] = $effective['contributors_enabled'];
			$rows[] = $row;
			$parents[] = [
				'right_id' => (int) $row['right_id'],
				'effective' => $effective,
			];
		}
		$this->db->sql_freeresult($result);
		return $rows;
	}

	public function get_album_rule(int $album_id): array
	{
		foreach ($this->get_album_rules() as $album)
		{
			if ((int) $album['album_id'] === $album_id)
			{
				return $album;
			}
		}

		throw new \OutOfBoundsException('The public Gallery album does not exist.');
	}

	/**
	 * Replace direct overrides for the submitted, existing albums.
	 *
	 * @param array<int, array{upload_reward: int, source_cost: int, contributors_enabled?: int}> $rules
	 */
	public function save_album_rules(array $rules): void
	{
		$available = [];
		foreach ($this->get_album_rules() as $album)
		{
			$available[(int) $album['album_id']] = true;
		}
		$album_ids = array_values(array_filter(
			array_map('intval', array_keys($rules)),
			static fn (int $album_id): bool => isset($available[$album_id])
		));
		if (!$album_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->rules_table . '
			WHERE ' . $this->db->sql_in_set('album_id', $album_ids);
		$this->db->sql_query($sql);
		$insert = [];
		foreach ($album_ids as $album_id)
		{
			$upload_reward = self::normalize_override((int) ($rules[$album_id]['upload_reward'] ?? self::INHERIT));
			$source_cost = self::normalize_override((int) ($rules[$album_id]['source_cost'] ?? self::INHERIT));
			$contributors_enabled = self::normalize_toggle_override((int) ($rules[$album_id]['contributors_enabled'] ?? self::INHERIT));
			if ($upload_reward !== self::INHERIT || $source_cost !== self::INHERIT
				|| $contributors_enabled !== self::INHERIT)
			{
				$insert[] = compact('album_id', 'upload_reward', 'source_cost', 'contributors_enabled');
			}
		}
		if ($insert)
		{
			$this->db->sql_multi_insert($this->rules_table, $insert);
		}
	}

	/**
	 * Save one public album without changing any sibling rules.
	 *
	 * @param array{upload_reward: int, source_cost: int, contributors_enabled: int} $rule
	 */
	public function save_album_rule(int $album_id, array $rule): void
	{
		$this->save_album_rules([$album_id => $rule]);
	}

	/**
	 * Set the contributor override for every public album while preserving its
	 * reward and source-cost choices.
	 */
	public function set_all_contributors(int $value): void
	{
		$value = self::normalize_toggle_override($value);
		$rules = [];
		foreach ($this->get_album_rules() as $album)
		{
			$rules[(int) $album['album_id']] = [
				'upload_reward' => $album['upload_reward'] === null ? self::INHERIT : (int) $album['upload_reward'],
				'source_cost' => $album['source_cost'] === null ? self::INHERIT : (int) $album['source_cost'],
				'contributors_enabled' => $value,
			];
		}
		$this->save_album_rules($rules);
	}

	public function delete_for_albums(array $album_ids): void
	{
		$album_ids = array_values(array_unique(array_filter(
			array_map('intval', $album_ids),
			static fn (int $album_id): bool => $album_id > 0
		)));
		if (!$album_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->rules_table . '
			WHERE ' . $this->db->sql_in_set('album_id', $album_ids);
		$this->db->sql_query($sql);
	}

	public function reconcile_orphans(): int
	{
		$sql = 'SELECT DISTINCT rules.album_id
			FROM ' . $this->rules_table . ' rules
			LEFT JOIN ' . $this->albums_table . ' albums
				ON albums.album_id = rules.album_id
			WHERE albums.album_id IS NULL';
		$result = $this->db->sql_query($sql);
		$album_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_ids[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);
		$this->delete_for_albums($album_ids);

		return count($album_ids);
	}
}
