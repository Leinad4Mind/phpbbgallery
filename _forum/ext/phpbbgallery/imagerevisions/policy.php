<?php
/**
 * phpBB Gallery - Image revision policy resolver.
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;

final class policy
{
	public const INHERIT = -1;
	public const MIN_LIMIT = 1;
	public const MAX_LIMIT = 50;

	public function __construct(
		private driver_interface $db,
		private config $config,
		private string $albums_table,
		private string $rules_table
	)
	{
	}

	/** @return array{enabled: int, revision_limit: int} */
	public function resolve(int $album_id): array
	{
		if ($album_id <= 0)
		{
			throw new \OutOfBoundsException('A valid Gallery album is required.');
		}

		$resolved = ['enabled' => null, 'revision_limit' => null];
		$sql = 'SELECT rules.enabled, rules.revision_limit
			FROM ' . $this->albums_table . ' current_album
			INNER JOIN ' . $this->albums_table . ' ancestor
				ON ancestor.left_id <= current_album.left_id
				AND ancestor.right_id >= current_album.right_id
				AND ancestor.album_user_id = current_album.album_user_id
			LEFT JOIN ' . $this->rules_table . ' rules ON rules.album_id = ancestor.album_id
			WHERE current_album.album_id = ' . (int) $album_id . '
			ORDER BY ancestor.left_id DESC';
		$result = $this->db->sql_query($sql);
		$album_exists = false;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_exists = true;
			$enabled = self::normalize_toggle_override((int) ($row['enabled'] ?? self::INHERIT));
			$limit = self::normalize_limit_override((int) ($row['revision_limit'] ?? self::INHERIT));
			if ($resolved['enabled'] === null && $enabled >= 0)
			{
				$resolved['enabled'] = $enabled;
			}
			if ($resolved['revision_limit'] === null && $limit >= self::MIN_LIMIT)
			{
				$resolved['revision_limit'] = $limit;
			}
		}
		$this->db->sql_freeresult($result);
		if (!$album_exists)
		{
			throw new \OutOfBoundsException('The Gallery album does not exist.');
		}

		$global = $this->get_global_rule();
		return [
			'enabled' => $resolved['enabled'] ?? $global['enabled'],
			'revision_limit' => $resolved['revision_limit'] ?? $global['revision_limit'],
		];
	}

	/** @return array{enabled: int, revision_limit: int} */
	public function get_global_rule(): array
	{
		return [
			'enabled' => empty($this->config['phpbb_gallery_imagerevisions_enabled']) ? 0 : 1,
			'revision_limit' => self::normalize_limit((int) ($this->config['phpbb_gallery_imagerevisions_limit'] ?? 5)),
		];
	}

	public static function normalize_toggle_override(int $value): int
	{
		return in_array($value, [self::INHERIT, 0, 1], true) ? $value : self::INHERIT;
	}

	public static function normalize_limit_override(int $value): int
	{
		return $value < self::MIN_LIMIT ? self::INHERIT : self::normalize_limit($value);
	}

	public static function normalize_limit(int $value): int
	{
		return max(self::MIN_LIMIT, min(self::MAX_LIMIT, $value));
	}

	public function get_album_rules(): array
	{
		$sql = 'SELECT albums.album_id, albums.parent_id, albums.album_name, albums.left_id,
				albums.right_id, rules.enabled, rules.revision_limit
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
			$direct_enabled = self::normalize_toggle_override((int) ($row['enabled'] ?? self::INHERIT));
			$direct_limit = self::normalize_limit_override((int) ($row['revision_limit'] ?? self::INHERIT));
			$effective = [
				'enabled' => $direct_enabled >= 0 ? $direct_enabled : $inherited['enabled'],
				'revision_limit' => $direct_limit >= self::MIN_LIMIT ? $direct_limit : $inherited['revision_limit'],
			];
			$row['depth'] = count($parents);
			$row['effective_enabled'] = $effective['enabled'];
			$row['effective_revision_limit'] = $effective['revision_limit'];
			$rows[] = $row;
			$parents[] = ['right_id' => (int) $row['right_id'], 'effective' => $effective];
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

	/** @param array{enabled: int, revision_limit: int} $rule */
	public function save_album_rule(int $album_id, array $rule): void
	{
		$this->get_album_rule($album_id);
		$enabled = self::normalize_toggle_override($rule['enabled']);
		$revision_limit = self::normalize_limit_override($rule['revision_limit']);
		$this->db->sql_query('DELETE FROM ' . $this->rules_table . ' WHERE album_id = ' . (int) $album_id);
		if ($enabled !== self::INHERIT || $revision_limit !== self::INHERIT)
		{
			$this->db->sql_query('INSERT INTO ' . $this->rules_table . ' ' . $this->db->sql_build_array('INSERT', [
				'album_id' => $album_id,
				'enabled' => $enabled,
				'revision_limit' => $revision_limit,
			]));
		}
	}

	public function delete_for_albums(array $album_ids): void
	{
		$album_ids = array_values(array_unique(array_filter(
			array_map('intval', $album_ids),
			static fn (int $id): bool => $id > 0
		)));
		if ($album_ids)
		{
			$this->db->sql_query('DELETE FROM ' . $this->rules_table . ' WHERE ' . $this->db->sql_in_set('album_id', $album_ids));
		}
	}

	public function reconcile_orphans(): int
	{
		$sql = 'SELECT rules.album_id FROM ' . $this->rules_table . ' rules
			LEFT JOIN ' . $this->albums_table . ' albums ON albums.album_id = rules.album_id
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
