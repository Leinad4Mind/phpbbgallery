<?php
/**
 * phpBB Gallery - Permission trace
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\auth;

/**
 * Resolve the Gallery permission sources that contribute to a user's result.
 */
final class permission_trace
{
	public const SOURCE_GROUP = 'group';
	public const SOURCE_USER = 'user';

	private \phpbb\db\driver\driver_interface $db;
	private auth $gallery_auth;
	private string $permissions_table;
	private string $roles_table;

	public function __construct(\phpbb\db\driver\driver_interface $db, auth $gallery_auth, string $permissions_table, string $roles_table)
	{
		$this->db = $db;
		$this->gallery_auth = $gallery_auth;
		$this->permissions_table = $permissions_table;
		$this->roles_table = $roles_table;
	}

	/**
	 * Trace one boolean Gallery permission in one album or personal-album scope.
	 *
	 * @return array{username:string, rows:list<array{source:string,name:string,group_type:int,setting:int,previous_total:int,total:int}>, total:int}
	 */
	public function trace(int $user_id, string $permission, int $album_id, int $permission_system): array
	{
		if ($user_id <= 0 || !preg_match('/^[a-z][a-z0-9_]*$/D', $permission) || str_ends_with($permission, '_count') || !$this->gallery_auth->has_permission($permission))
		{
			throw new \InvalidArgumentException('Invalid Gallery permission trace request.');
		}

		$is_public_album = $permission_system === auth::PUBLIC_ALBUM && $album_id > 0;
		$is_personal_scope = $album_id === 0 && in_array($permission_system, [auth::OWN_ALBUM, auth::PERSONAL_ALBUM], true);
		if (!$is_public_album && !$is_personal_scope)
		{
			throw new \InvalidArgumentException('Invalid Gallery permission scope.');
		}

		$sql = 'SELECT user_id, username
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$user_row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$user_row)
		{
			throw new \OutOfBoundsException('The Gallery permission trace user does not exist.');
		}

		$group_ids = array_values(array_unique(array_map('intval', $this->gallery_auth->get_usergroups($user_id))));
		$groups = $this->load_groups($group_ids);
		[$group_settings, $user_setting] = $this->load_settings($user_id, $group_ids, $permission, $album_id, $permission_system);

		$total = auth::ACL_NO;
		$rows = [];
		foreach ($groups as $group_id => $group)
		{
			$setting = $group_settings[$group_id] ?? auth::ACL_NO;
			$previous_total = $total;
			$total = $this->merge_setting($total, $setting);
			$rows[] = [
				'source' => self::SOURCE_GROUP,
				'name' => $group['name'],
				'group_type' => $group['group_type'],
				'setting' => $setting,
				'previous_total' => $previous_total,
				'total' => $total,
			];
		}

		$previous_total = $total;
		$total = $this->merge_setting($total, $user_setting);
		$rows[] = [
			'source' => self::SOURCE_USER,
			'name' => (string) $user_row['username'],
			'group_type' => 0,
			'setting' => $user_setting,
			'previous_total' => $previous_total,
			'total' => $total,
		];

		return ['username' => (string) $user_row['username'], 'rows' => $rows, 'total' => $total];
	}

	/** @return array<int, array{name:string, group_type:int}> */
	private function load_groups(array $group_ids): array
	{
		if (!$group_ids)
		{
			return [];
		}

		$sql = 'SELECT group_id, group_name, group_type
			FROM ' . GROUPS_TABLE . '
			WHERE ' . $this->db->sql_in_set('group_id', $group_ids) . '
			ORDER BY group_type DESC, group_name ASC';
		$result = $this->db->sql_query($sql);
		$groups = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$groups[(int) $row['group_id']] = ['name' => (string) $row['group_name'], 'group_type' => (int) $row['group_type']];
		}
		$this->db->sql_freeresult($result);

		return $groups;
	}

	/** @return array{0:array<int, int>, 1:int} */
	private function load_settings(int $user_id, array $group_ids, string $permission, int $album_id, int $permission_system): array
	{
		$assignment_where = 'p.perm_user_id = ' . (int) $user_id;
		if ($group_ids)
		{
			$assignment_where .= ' OR ' . $this->db->sql_in_set('p.perm_group_id', $group_ids);
		}
		$scope_where = $permission_system === auth::PUBLIC_ALBUM
			? 'p.perm_system = 0 AND p.perm_album_id = ' . (int) $album_id
			: 'p.perm_system = ' . (int) $permission_system;
		$sql = 'SELECT p.perm_user_id, p.perm_group_id, pr.*
			FROM ' . $this->permissions_table . ' p
			LEFT JOIN ' . $this->roles_table . ' pr
				ON p.perm_role_id = pr.role_id
			WHERE ' . $scope_where . '
				AND (' . $assignment_where . ')';
		$result = $this->db->sql_query($sql);
		$group_settings = array_fill_keys($group_ids, auth::ACL_NO);
		$user_setting = auth::ACL_NO;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$setting = $this->normalize_setting((int) ($row[$permission] ?? auth::ACL_NO));
			if ((int) $row['perm_user_id'] === $user_id)
			{
				$user_setting = max($user_setting, $setting);
				continue;
			}

			$group_id = (int) $row['perm_group_id'];
			if (array_key_exists($group_id, $group_settings))
			{
				$group_settings[$group_id] = max($group_settings[$group_id], $setting);
			}
		}
		$this->db->sql_freeresult($result);

		return [$group_settings, $user_setting];
	}

	private function normalize_setting(int $setting): int
	{
		return in_array($setting, [auth::ACL_NO, auth::ACL_YES, auth::ACL_NEVER], true) ? $setting : auth::ACL_NO;
	}

	private function merge_setting(int $total, int $setting): int
	{
		if ($setting === auth::ACL_NEVER)
		{
			return auth::ACL_NEVER;
		}

		if ($setting === auth::ACL_YES && $total === auth::ACL_NO)
		{
			return auth::ACL_YES;
		}

		return $total;
	}
}
