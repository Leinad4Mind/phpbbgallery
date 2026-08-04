<?php
/**
 * phpBB Gallery - BBPoints image contributor manager
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbb\db\driver\driver_interface;

final class contributor_manager
{
	public const MAX_CONTRIBUTORS = 20;

	public function __construct(
		private driver_interface $db,
		private string $contributors_table,
		private string $users_table,
		private string $images_table
	)
	{
	}

	/**
	 * Resolve the submitted, line-separated usernames to trusted phpBB users.
	 *
	 * @throws \LengthException When the hard contributor limit is exceeded
	 * @throws \InvalidArgumentException When one or more usernames do not resolve
	 */
	public function resolve(string $value): array
	{
		$names = preg_split('/\R+/u', utf8_normalize_nfc($value)) ?: [];
		$names = array_values(array_filter(array_map('trim', $names), static fn (string $name): bool => $name !== ''));
		$requested = [];
		foreach ($names as $name)
		{
			$clean = utf8_clean_string($name);
			if ($clean !== '' && !isset($requested[$clean]))
			{
				$requested[$clean] = $name;
			}
		}
		if (count($requested) > self::MAX_CONTRIBUTORS)
		{
			throw new \LengthException((string) self::MAX_CONTRIBUTORS);
		}
		if (!$requested)
		{
			return [];
		}

		$sql = 'SELECT user_id, username, username_clean, user_colour
			FROM ' . $this->users_table . '
			WHERE ' . $this->db->sql_in_set('username_clean', array_keys($requested)) . '
				AND user_type IN (0, 3)';
		$result = $this->db->sql_query($sql);
		$resolved = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$resolved[(string) $row['username_clean']] = [
				'user_id' => (int) $row['user_id'],
				'username' => (string) $row['username'],
				'user_colour' => (string) $row['user_colour'],
			];
		}
		$this->db->sql_freeresult($result);

		$unknown = array_diff_key($requested, $resolved);
		if ($unknown)
		{
			throw new \InvalidArgumentException(implode(', ', $unknown));
		}

		$users = [];
		foreach (array_keys($requested) as $clean)
		{
			$users[] = $resolved[$clean];
		}

		return $users;
	}

	/**
	 * Replace the ordered contributor list, never retaining the image author.
	 */
	public function replace(int $image_id, int $author_id, array $users): void
	{
		if ($image_id < 1)
		{
			return;
		}
		$this->delete_for_images([$image_id]);
		$rows = [];
		$seen = [];
		foreach ($users as $user)
		{
			$user_id = (int) ($user['user_id'] ?? 0);
			if ($user_id < 1 || $user_id === $author_id || isset($seen[$user_id]))
			{
				continue;
			}
			$seen[$user_id] = true;
			$rows[] = [
				'image_id' => $image_id,
				'user_id' => $user_id,
				'contributor_order' => count($rows),
			];
		}
		if ($rows)
		{
			$this->db->sql_multi_insert($this->contributors_table, $rows);
			if (!$this->image_exists($image_id))
			{
				$this->delete_for_images([$image_id]);
			}
		}
	}

	public function get_for_image(int $image_id): array
	{
		$sql = 'SELECT c.user_id, u.username, u.user_colour
			FROM ' . $this->contributors_table . ' c
			JOIN ' . $this->users_table . ' u
				ON u.user_id = c.user_id
			WHERE c.image_id = ' . (int) $image_id . '
				AND u.user_type IN (0, 3)
			ORDER BY c.contributor_order ASC, c.user_id ASC';
		$result = $this->db->sql_query($sql);
		$users = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = [
				'user_id' => (int) $row['user_id'],
				'username' => (string) $row['username'],
				'user_colour' => (string) $row['user_colour'],
			];
		}
		$this->db->sql_freeresult($result);

		return $users;
	}

	public function format_for_image(int $image_id): string
	{
		return implode("\n", array_column($this->get_for_image($image_id), 'username'));
	}

	public function remove_author(array $image_ids, int $author_id): void
	{
		$image_ids = $this->normalize_ids($image_ids);
		if (!$image_ids || $author_id < 1)
		{
			return;
		}
		$sql = 'DELETE FROM ' . $this->contributors_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids) . '
				AND user_id = ' . (int) $author_id;
		$this->db->sql_query($sql);
	}

	public function delete_for_images(array $image_ids): void
	{
		$image_ids = $this->normalize_ids($image_ids);
		if (!$image_ids)
		{
			return;
		}
		$sql = 'DELETE FROM ' . $this->contributors_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$this->db->sql_query($sql);
	}

	public function reconcile_orphans(): int
	{
		$sql = 'SELECT DISTINCT contributor.image_id
			FROM ' . $this->contributors_table . ' contributor
			LEFT JOIN ' . $this->images_table . ' image
				ON image.image_id = contributor.image_id
			WHERE image.image_id IS NULL';
		$result = $this->db->sql_query($sql);
		$image_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_ids[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);
		$this->delete_for_images($image_ids);

		return count($image_ids);
	}

	private function normalize_ids(array $ids): array
	{
		return array_values(array_unique(array_filter(
			array_map('intval', $ids),
			static fn (int $id): bool => $id > 0
		)));
	}

	private function image_exists(int $image_id): bool
	{
		$sql = 'SELECT image_id
			FROM ' . $this->images_table . '
			WHERE image_id = ' . (int) $image_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return (bool) $row;
	}
}
