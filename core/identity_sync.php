<?php
/**
 * phpBB Gallery - Identity synchronization service
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

/**
 * Keep denormalized Gallery identity data aligned with phpBB users and groups.
 */
class identity_sync
{
	/** @var \phpbb\db\driver\driver_interface Database connection */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbbgallery\core\config Gallery configuration */
	protected \phpbbgallery\core\config $config;

	/** @var \phpbbgallery\core\cache Gallery cache */
	protected \phpbbgallery\core\cache $cache;

	/** @var string Albums table */
	protected string $albums_table;

	/** @var string Images table */
	protected string $images_table;

	/** @var string Comments table */
	protected string $comments_table;

	/** @var string Moderator cache table */
	protected string $moderators_table;

	/** @var string Gallery permissions table */
	protected string $permissions_table;

	/**
	 * @param \phpbb\db\driver\driver_interface $db Database connection
	 * @param \phpbbgallery\core\config $config Gallery configuration
	 * @param \phpbbgallery\core\cache $cache Gallery cache
	 * @param string $albums_table Albums table
	 * @param string $images_table Images table
	 * @param string $comments_table Comments table
	 * @param string $moderators_table Moderator cache table
	 * @param string $permissions_table Gallery permissions table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbbgallery\core\config $config,
								\phpbbgallery\core\cache $cache, string $albums_table, string $images_table,
								string $comments_table, string $moderators_table, string $permissions_table)
	{
		$this->db = $db;
		$this->config = $config;
		$this->cache = $cache;
		$this->albums_table = $albums_table;
		$this->images_table = $images_table;
		$this->comments_table = $comments_table;
		$this->moderators_table = $moderators_table;
		$this->permissions_table = $permissions_table;
	}

	/**
	 * Synchronize every stored display name after phpBB renames a user.
	 *
	 * Resolving the renamed account first lets every update use its immutable ID.
	 * This avoids changing guest records which happen to use the previous name.
	 *
	 * @param string $old_name Previous username
	 * @param string $new_name Current username
	 * @return void
	 */
	public function rename_user(string $old_name, string $new_name): void
	{
		if ($old_name === '' || $new_name === '' || $old_name === $new_name)
		{
			return;
		}

		$user_id = $this->resolve_user_id($new_name);
		if ($user_id <= (int) ANONYMOUS)
		{
			return;
		}

		$username = $this->db->sql_escape($new_name);
		$username_clean = $this->db->sql_escape(utf8_clean_string($new_name));

		$sql = 'UPDATE ' . $this->images_table . "
			SET image_username = '" . $username . "',
				image_username_clean = '" . $username_clean . "'
			WHERE image_user_id = " . $user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->comments_table . "
			SET comment_username = '" . $username . "'
			WHERE comment_user_id = " . $user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->albums_table . "
			SET album_last_username = '" . $username . "'
			WHERE album_last_user_id = " . $user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->albums_table . "
			SET album_name = CASE WHEN parent_id = 0 THEN '" . $username . "' ELSE album_name END,
				album_parents = ''
			WHERE album_user_id = " . $user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->moderators_table . "
			SET username = '" . $username . "'
			WHERE user_id = " . $user_id;
		$this->db->sql_query($sql);

		if ((int) $this->config->get('newest_pega_user_id') === $user_id)
		{
			$this->config->set('newest_pega_username', $new_name);
		}

		$this->clear_identity_caches();
	}

	/**
	 * Synchronize cached colours after phpBB changes a default group.
	 *
	 * @param array|int $user_ids Affected phpBB user identifiers
	 * @param string $user_colour Current phpBB user colour
	 * @return void
	 */
	public function recolour_users(array|int $user_ids, string $user_colour): void
	{
		$user_ids = $this->normalize_user_ids($user_ids);
		if (!$user_ids)
		{
			return;
		}

		$user_colour_sql = $this->db->sql_escape($user_colour);
		$updates = [
			[$this->albums_table, 'album_last_user_colour', 'album_last_user_id'],
			[$this->comments_table, 'comment_user_colour', 'comment_user_id'],
			[$this->images_table, 'image_user_colour', 'image_user_id'],
		];

		foreach ($updates as [$table, $colour_field, $user_field])
		{
			$sql = 'UPDATE ' . $table . '
				SET ' . $colour_field . " = '" . $user_colour_sql . "'
				WHERE " . $this->db->sql_in_set($user_field, $user_ids);
			$this->db->sql_query($sql);
		}

		if (in_array((int) $this->config->get('newest_pega_user_id'), $user_ids, true))
		{
			$this->config->set('newest_pega_user_colour', $user_colour);
		}

		$this->clear_identity_caches();
	}

	/**
	 * Remove derived moderator and direct-permission rows for deleted users.
	 *
	 * @param array|int $user_ids Deleted phpBB user identifiers
	 * @return void
	 */
	public function delete_users(array|int $user_ids): void
	{
		$user_ids = $this->normalize_user_ids($user_ids);
		if (!$user_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->moderators_table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$this->db->sql_query($sql);

		$sql = 'DELETE FROM ' . $this->permissions_table . '
			WHERE ' . $this->db->sql_in_set('perm_user_id', $user_ids);
		$this->db->sql_query($sql);

		$this->clear_moderator_permission_caches();
	}

	/**
	 * Remove derived moderator and permission rows for a deleted group.
	 *
	 * @param int $group_id Deleted phpBB group identifier
	 * @return void
	 */
	public function delete_group(int $group_id): void
	{
		if ($group_id <= 0)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->moderators_table . '
			WHERE group_id = ' . $group_id;
		$this->db->sql_query($sql);

		$sql = 'DELETE FROM ' . $this->permissions_table . '
			WHERE perm_group_id = ' . $group_id;
		$this->db->sql_query($sql);

		$this->clear_moderator_permission_caches();
	}

	/**
	 * Resolve a renamed account without relying on a mutable old display name.
	 *
	 * @param string $username Current username
	 * @return int phpBB user identifier, or zero when it cannot be resolved
	 */
	protected function resolve_user_id(string $username): int
	{
		$sql = 'SELECT user_id
			FROM ' . USERS_TABLE . "
			WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return (int) ($row['user_id'] ?? 0);
	}

	/**
	 * Normalize user identifiers before constructing targeted SQL predicates.
	 *
	 * @param array|int $user_ids One or more phpBB user identifiers
	 * @return array<int>
	 */
	protected function normalize_user_ids(array|int $user_ids): array
	{
		$user_ids = is_array($user_ids) ? $user_ids : [$user_ids];
		$user_ids = array_values(array_unique(array_filter(array_map('intval', $user_ids),
			static fn (int $user_id): bool => $user_id > (int) ANONYMOUS)));
		sort($user_ids);

		return $user_ids;
	}

	/**
	 * Clear every cache containing denormalized user identity fields.
	 *
	 * @return void
	 */
	protected function clear_identity_caches(): void
	{
		$this->cache->destroy_images();
		$this->cache->destroy_albums();
		foreach ([$this->albums_table, $this->comments_table, $this->images_table, $this->moderators_table] as $table)
		{
			$this->cache->destroy('sql', $table);
		}
	}

	/**
	 * Clear caches derived from Gallery moderator and permission rows.
	 *
	 * @return void
	 */
	protected function clear_moderator_permission_caches(): void
	{
		$this->cache->destroy('sql', $this->moderators_table);
		$this->cache->destroy('sql', $this->permissions_table);
	}
}
