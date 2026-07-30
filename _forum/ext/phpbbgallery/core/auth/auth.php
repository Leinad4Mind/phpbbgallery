<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\auth;

class auth
{
	public const SETTING_PERMISSIONS	= -39839;
	public const PERSONAL_ALBUM		= -3;
	public const OWN_ALBUM				= -2;
	public const PUBLIC_ALBUM			= 0;

	public const ACCESS_ALL			= 0;
	public const ACCESS_REGISTERED		= 1;
	public const ACCESS_NOT_FOES		= 2;
	public const ACCESS_FRIENDS		= 3;
	public const ACCESS_SPECIAL_FRIENDS	= 4;

	// ACL - slightly different
	public const ACL_NO		= 0;
	public const ACL_YES		= 1;
	public const ACL_NEVER		= 2;

	protected static array $_permission_i = ['i_view', 'i_watermark', 'i_upload', 'i_approve', 'i_edit', 'i_delete', 'i_report', 'i_rate'];
	protected static array $_permission_c = ['c_read', 'c_post', 'c_edit', 'c_delete'];
	protected static array $_permission_m = ['m_comments', 'm_delete', 'm_edit', 'm_move', 'm_report', 'm_status'];
	protected static array $_permission_misc = ['a_list', 'i_count', 'i_unlimited', 'a_count', 'a_unlimited', 'a_restrict'];

	/**
	 * Core permissions introduced after the original serialized bit layout.
	 * Keep these appended after every legacy permission.
	 */
	protected static array $_permission_core_additions = ['i_move'];

	/**
	 * Permissions contributed by add-ons, always merged last when their owner
	 * is enabled.
	 *
	 * A permission's bit number is its position in the merged list, and those
	 * numbers are already stored in every board's roles and cached user
	 * permissions. Appending here keeps the existing numbering intact; moving
	 * any of these names into one of the lists above would shift every later
	 * bit and silently hand out the wrong permissions.
	 */
	protected static array $_permission_addon = ['i_favorite'];
	protected static array $_permissions = [];
	protected static array $_permissions_flipped = [];

	protected array $_auth_data = [];
	protected array $_auth_data_never = [];

	protected array $acl_cache = [];

	/**
	* Cache object
	* @var \phpbbgallery\core\cache
	*/
	protected \phpbbgallery\core\cache $cache;

	/**
	* Database object
	* @var \phpbb\db\driver\driver
	*/
	protected \phpbb\db\driver\driver_interface $db;

	/**
	* Gallery user object
	* @var \phpbbgallery\core\user
	*/
	protected \phpbbgallery\core\user $user;

	/**
	* phpBB user object
	* @var \phpbb\user
	*/
	protected \phpbb\user $phpbb_user;

	/**
	* phpBB auth object
	* @var \phpbb\auth\auth
	*/
	protected \phpbb\auth\auth $auth;

	/**
	* Gallery permissions table
	* @var string
	*/
	protected string $table_permissions;

	/**
	* Gallery permission roles table
	* @var string
	*/
	protected string $table_roles;

	/**
	* Gallery users table
	* @var string
	*/
	protected string $table_users;

	/**
	* Gallery albums table
	* @var string
	*/
	protected string $table_albums;

	/**
	 * Construct
	 *
	 * @param    \phpbbgallery\core\cache $cache Cache object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db Database object
	 * @param    \phpbbgallery\core\user $user Gallery user object
	 * @param \phpbb\user $phpbb_user
	 * @param \phpbb\auth\auth $auth
	 * @param    string $permissions_table Gallery permissions table
	 * @param    string $roles_table Gallery permission roles table
	 * @param    string $users_table Gallery users table
	 * @param string                     $albums_table      Gallery albums table
	 * @param \phpbb\extension\manager $extension_manager phpBB extension manager
	 */
	public function __construct(\phpbbgallery\core\cache $cache, \phpbb\db\driver\driver_interface $db, \phpbbgallery\core\user $user, \phpbb\user $phpbb_user, \phpbb\auth\auth $auth,
	string $permissions_table, string $roles_table, string $users_table, string $albums_table, \phpbb\extension\manager $extension_manager)
	{
		$this->cache = $cache;
		$this->db = $db;
		$this->user = $user;
		$this->phpbb_user = $phpbb_user;
		$this->auth = $auth;
		$this->table_permissions = $permissions_table;
		$this->table_roles = $roles_table;
		$this->table_users = $users_table;
		$this->table_albums = $albums_table;

		$addon_permissions = $extension_manager->is_enabled('phpbbgallery/favorite') ? self::$_permission_addon : [];
		self::$_permissions = array_merge(self::$_permission_i, self::$_permission_c, self::$_permission_m, self::$_permission_misc, self::$_permission_core_additions, $addon_permissions);
		self::$_permissions_flipped = array_flip(array_merge(self::$_permissions, ['m_']));
		self::$_permissions_flipped['i_count'] = 'i_count';
		self::$_permissions_flipped['a_count'] = 'a_count';
	}

	/**
	 * Whether a permission is currently provided by the Core or an enabled add-on.
	 *
	 * @param string $permission Permission name
	 * @return bool
	 */
	public function has_permission(string $permission): bool
	{
		return array_key_exists($permission, self::$_permissions_flipped);
	}

	public function get_setting_permissions(): int
	{
		return self::SETTING_PERMISSIONS;
	}

	public function get_personal_album(): int
	{
		return self::PERSONAL_ALBUM;
	}

	public function get_own_album(): int
	{
		return self::OWN_ALBUM;
	}

	/**
	 * Load Gallery permissions for the active or phpBB-impersonated user.
	 *
	 * @param int       $user_id  Requested user identifier
	 * @param int|false $album_id Legacy album scope, retained for API compatibility
	 * @return void
	 */
	public function load_user_permissions(int $user_id, int|false $album_id = false): void
	{
		$this->_auth_data = [];
		$this->_auth_data_never = [];
		$this->acl_cache = [];
		$user_id = $this->get_effective_user_id($user_id);

		if ($user_id != $this->user->user_id)
		{
			$this->user->set_user_id($user_id);
		}

		$cached_permissions = $this->user->get_data('user_permissions');
		if (!empty($cached_permissions))
		{
			$this->unserialize_auth_data($cached_permissions);
			return;
		}
		$this->query_auth_data($user_id);
	}

	/**
	 * Resolve phpBB's temporary permission-test identity without affecting explicit lookups.
	 *
	 * @param int $user_id Requested user identifier
	 * @return int Effective Gallery permission owner
	 */
	protected function get_effective_user_id(int $user_id): int
	{
		$current_user_id = (int) ($this->phpbb_user->data['user_id'] ?? 0);
		$permission_user_id = (int) ($this->phpbb_user->data['user_perm_from'] ?? 0);

		return $user_id === $current_user_id && $permission_user_id > 0 ? $permission_user_id : $user_id;
	}

	/**
	 * Query the permissions for a given user and store them in the database.
	 * @param int $user_id
	 */
	protected function query_auth_data(int $user_id): void
	{
		$albums = $this->cache->get_albums();
		$user_groups_ary = $this->get_usergroups($user_id);

		$sql_select = '';
		foreach (self::$_permissions as $permission)
		{
			$sql_select .= " MAX($permission) as $permission,";
		}

		$this->_auth_data[self::OWN_ALBUM]				= new \phpbbgallery\core\auth\set();
		$this->_auth_data_never[self::OWN_ALBUM]		= new \phpbbgallery\core\auth\set();
		$this->_auth_data[self::PERSONAL_ALBUM]			= new \phpbbgallery\core\auth\set();
		$this->_auth_data_never[self::PERSONAL_ALBUM]	= new \phpbbgallery\core\auth\set();

		foreach ($albums as $album)
		{
			if ($album['album_user_id'] == self::PUBLIC_ALBUM)
			{
				$this->_auth_data[$album['album_id']]		= new \phpbbgallery\core\auth\set();
				$this->_auth_data_never[$album['album_id']]	= new \phpbbgallery\core\auth\set();
			}
		}

		$sql_array = [
			'SELECT'		=> "p.perm_album_id, $sql_select p.perm_system",
			'FROM'			=> [$this->table_permissions => 'p'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [$this->table_roles => 'pr'],
					'ON'		=> 'p.perm_role_id = pr.role_id',
				],
			],

			'WHERE'			=> 'p.perm_user_id = ' . $user_id . ' OR ' . $this->db->sql_in_set('p.perm_group_id', $user_groups_ary, false, true),
			'GROUP_BY'		=> 'p.perm_system, p.perm_album_id',
			'ORDER_BY'		=> 'p.perm_system DESC, p.perm_album_id ASC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);

		$this->db->sql_return_on_error(true);
		$result = $this->db->sql_query($sql);

		if ($this->db->get_sql_error_triggered())
		{
			trigger_error('DATABASE_NOT_UPTODATE');

		}
		$this->db->sql_return_on_error(false);

		while ($row = $this->db->sql_fetchrow($result))
		{
			switch ($row['perm_system'])
			{
				case self::PERSONAL_ALBUM:
					$this->store_acl_row(self::PERSONAL_ALBUM, $row);
				break;

				case self::OWN_ALBUM:
					$this->store_acl_row(self::OWN_ALBUM, $row);
				break;

				case self::PUBLIC_ALBUM:
					$this->store_acl_row(((int) $row['perm_album_id']), $row);
				break;
			}
		}
		$this->db->sql_freeresult($result);

		$this->merge_acl_row();

		$this->restrict_pegas($user_id);

		$this->set_user_permissions($user_id, $this->_auth_data);
	}

	/**
	 * Serialize the auth-data sop we can store it.
	 *
	 * Line-Format:    bitfields:i_count:a_count::album_id(s)
	 * Samples:        8912837:0:10::-3
	 *                9961469:20:0::1:23:42
	 * @param array $auth_data
	 * @return string
	 */
	protected function serialize_auth_data(array $auth_data): string
	{
		$acl_array = [];

		foreach ($auth_data as $a_id => $obj)
		{
			$key = $obj->get_bits() . ':' . $obj->get_count('i_count') . ':' . $obj->get_count('a_count');
			if (!isset($acl_array[$key]))
			{
				$acl_array[$key] = $key . '::' . $a_id;
			}
			else
			{
				$acl_array[$key] .= ':' . $a_id;
			}
		}

		return implode("\n", $acl_array);
	}

	/**
	 * Unserialize the stored auth-data
	 * @param string $serialized_data
	 */
	protected function unserialize_auth_data(string $serialized_data): void
	{
		if ($serialized_data === '')
		{
			return;
		}

		$acl_array = explode("\n", $serialized_data);

		foreach ($acl_array as $acl_row)
		{
			$sections = explode('::', $acl_row, 2);
			if (count($sections) !== 2)
			{
				continue;
			}

			$counts = explode(':', $sections[0]);
			if (count($counts) !== 3)
			{
				continue;
			}

			[$bits, $i_count, $a_count] = array_map('intval', $counts);

			foreach (explode(':', $sections[1]) as $a_id)
			{
				$a_id = trim($a_id);
				if (!preg_match('/^-?\d+$/D', $a_id))
				{
					continue;
				}

				$this->_auth_data[(int) $a_id] = new \phpbbgallery\core\auth\set($bits, $i_count, $a_count);
			}
		}
	}

	/**
	 * Stores an acl-row into the _auth_data-array.
	 * @param int   $album_id
	 * @param array $data
	 */
	protected function store_acl_row(int $album_id, array $data): void
	{
		if (!isset($this->_auth_data[$album_id]))
		{
			// The album we have permissions for does not exist any more, so do nothing.
			return;
		}

		foreach (self::$_permissions as $permission)
		{
			if (strpos($permission, '_count') === false)
			{
				if ($data[$permission] == self::ACL_NEVER)
				{
					$this->_auth_data_never[$album_id]->set_bit(self::$_permissions_flipped[$permission], true);
				}
				else if ($data[$permission] == self::ACL_YES)
				{
					$this->_auth_data[$album_id]->set_bit(self::$_permissions_flipped[$permission], true);
					if (substr($permission, 0, 2) == 'm_')
					{
						$this->_auth_data[$album_id]->set_bit(self::$_permissions_flipped['m_'], true);
					}
				}
			}
			else
			{
				$this->_auth_data[$album_id]->set_count($permission, $data[$permission]);
			}
		}
	}

	/**
	* Merge the NEVER-options into the YES-options by removing the YES, if it is set.
	*/
	protected function merge_acl_row(): void
	{
		foreach ($this->_auth_data as $album_id => $obj)
		{
			foreach (self::$_permissions as $acl)
			{
				if (strpos($acl, '_count') === false)
				{
					$bit = self::$_permissions_flipped[$acl];
					// If the yes and the never bit are set, we overwrite the yes with a false.
					if ($obj->get_bit($bit) && $this->_auth_data_never[$album_id]->get_bit($bit))
					{
						$obj->set_bit($bit, false);
					}
				}
			}
		}
	}

	/**
	 * Restrict the access to personal galleries, if the user is not a moderator.
	 * @param int $user_id
	 */
	protected function restrict_pegas(int $user_id): void
	{
		if (($user_id != ANONYMOUS) && ($this->_auth_data[self::PERSONAL_ALBUM]->get_bit(self::$_permissions_flipped['m_']) || $this->auth->acl_get('a_user')))
		{
			// No restrictions for moderators.
			return;
		}

		$zebra = null;

		$albums = $this->cache->get_albums();
		foreach ($albums as $album)
		{
			if (!$album['album_auth_access'] || ($album['album_user_id'] == self::PUBLIC_ALBUM))# || ($album['album_user_id'] == $user_id))
			{
				continue;
			}
			else if ($user_id == ANONYMOUS)
			{
				// Level 1: No guests
				$this->_auth_data[$album['album_id']] = new \phpbbgallery\core\auth\set();
				continue;
			}
			else if ($album['album_auth_access'] == self::ACCESS_NOT_FOES)
			{
				if ($zebra == null)
				{
					$zebra = $this->get_user_zebra($user_id);
				}
				if (in_array($album['album_user_id'], $zebra['foe']))
				{
					// Level 2: No foes allowed
					$this->_auth_data[$album['album_id']] = new \phpbbgallery\core\auth\set();
					continue;
				}
			}
			else if ($album['album_auth_access'] == self::ACCESS_SPECIAL_FRIENDS)
			{
				if ($zebra == null)
				{
					$zebra = $this->get_user_zebra($user_id);
				}
				if (!in_array($album['album_user_id'], $zebra['bff']))
				{
					// Level 4: Only special friends allowed
					$this->_auth_data[$album['album_id']] = new \phpbbgallery\core\auth\set();
					continue;
				}
			}
			else if ($album['album_auth_access'] == self::ACCESS_FRIENDS)
			{
				if ($zebra == null)
				{
					$zebra = $this->get_user_zebra($user_id);
				}
				if (!in_array($album['album_user_id'], $zebra['friend']))
				{
					// Level 3: Only friends allowed
					$this->_auth_data[$album['album_id']] = new \phpbbgallery\core\auth\set();
					continue;
				}
			}
		}
	}

	/**
	 * Get the users, which added our user as friend and/or foe
	 * @param int $user_id
	 * @return array
	 */
	public function get_user_zebra(int $user_id): array
	{

		$zebra = ['foe' => [], 'friend' => [], 'bff' => []];
		$sql = 'SELECT *
			FROM ' . ZEBRA_TABLE . '
			WHERE zebra_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['foe'])
			{
				$zebra['foe'][] = (int) $row['user_id'];
			}
			else
			{
				if (isset($row['bff']))
				{
					if ($row['bff'])
					{
						$zebra['bff'][] = (int) $row['user_id'];
					}
					else
					{
						$zebra['friend'][] = (int) $row['user_id'];
					}
				}
				else
				{
					$zebra['friend'][] = (int) $row['user_id'];
				}
			}
		}
		$this->db->sql_freeresult($result);
		return $zebra;
	}
	public function get_user_foes(int $user_id): array
	{
		$foes = [];
		$sql = 'SELECT * 
		FROM ' . ZEBRA_TABLE . '
		WHERE user_id = ' . (int) $user_id . '
		AND foe = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$foes[] = (int) $row['zebra_id'];
		}
		$this->db->sql_freeresult($result);
		return $foes;
	}

	/**
	 * Get zebra state
	 * @param array $zebra_array
	 * @param int   $album_author
	 * @param int   $album_id
	 * @return int
	 */
	public function get_zebra_state(array $zebra_array, int $album_author, int $album_id): int
	{
		$state = 0;
		// if we check for ourselves or user is mod or admin - make biggest possible step
		if ($this->phpbb_user->data['user_id'] == $album_author || $this->acl_check('m_', $album_id, $album_author) || $this->auth->acl_get('a_user'))
		{
			$state = 5;
		}
		//If user is not anon - we will check ... else its state is 0
		else if ($this->phpbb_user->data['user_id'] != ANONYMOUS)
		{
			if (in_array($album_author, $zebra_array['foe']))
			{
				$state = 1;
			}
			else if (in_array($album_author, $zebra_array['friend']))
			{
				$state = 3;
			}
			else if (in_array($album_author, $zebra_array['bff']))
			{
				$state = 4;
			}
			else
			{
				$state = 2;
			}
		}
		return (int) $state;
	}

	/**
	 * Get groups a user is member from.
	 * @param int $user_id
	 * @return array
	 */
	public function get_usergroups(int $user_id): array
	{
		$groups_ary = [];

		$sql = 'SELECT ug.group_id
			FROM ' . USER_GROUP_TABLE . ' ug
			LEFT JOIN ' . GROUPS_TABLE . ' g
				ON (ug.group_id = g.group_id)
			WHERE ug.user_id = ' . (int) $user_id . '
				AND ug.user_pending = 0
				AND g.group_skip_auth = 0';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$groups_ary[] = $row['group_id'];
		}
		$this->db->sql_freeresult($result);

		return $groups_ary;
	}

	/**
	 * Sets the permissions-cache in users-table to given array.
	 * @param array|int|string   $user_ids
	 * @param array|string|false $permissions
	 */
	public function set_user_permissions(array|int|string $user_ids, array|string|false $permissions = false): void
	{
		$sql_set = (is_array($permissions)) ? $this->db->sql_escape($this->serialize_auth_data($permissions)) : '';
		$sql_where = '';
		if (is_array($user_ids))
		{
			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_id', array_map('intval', $user_ids));
		}
		else if ($user_ids == 'all')
		{
			$sql_where = '';
		}
		else
		{
			$sql_where = 'WHERE user_id = ' . (int) $user_ids;
		}

		if (!is_array($user_ids) && $user_ids !== 'all' && $this->user->is_user((int) $user_ids))
		{
			$this->user->set_permissions_changed(time());
		}

			$sql = 'UPDATE ' . $this->table_users . "
				SET user_permissions = '" . $sql_set . "',
					user_permissions_changed = " . (int) time() . '
				' . $sql_where;
			$this->db->sql_query($sql);
	}

	/**
	 * Invalidate cached Gallery permissions for selected phpBB users.
	 *
	 * The database snapshot is used across requests, while the Gallery user and
	 * ACL arrays may already be loaded in the current request. Both layers must
	 * be cleared when phpBB group membership changes.
	 *
	 * @param array|int $user_ids One or more phpBB user identifiers
	 * @return void
	 */
	public function invalidate_user_permissions(array|int $user_ids): void
	{
		$user_ids = is_array($user_ids) ? $user_ids : [$user_ids];
		$user_ids = array_values(array_unique(array_filter(array_map('intval', $user_ids), static fn (int $user_id): bool => $user_id > 0)));
		sort($user_ids);
		if (!$user_ids)
		{
			return;
		}

		$changed_time = time();
		$sql = 'UPDATE ' . $this->table_users . '
			SET user_permissions = \'\',
				user_permissions_changed = ' . $changed_time . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$this->db->sql_query($sql);

		if ($this->user->user_id !== null && in_array($this->user->user_id, $user_ids, true))
		{
			$this->user->invalidate_permissions($changed_time);
			$this->_auth_data = [];
			$this->_auth_data_never = [];
			$this->acl_cache = [];
		}
	}

	/**
	 * Invalidate Gallery permissions for every approved member of a group.
	 *
	 * phpBB can change group_skip_auth without emitting a membership event.
	 * Resolve the current approved members so their Gallery snapshots cannot
	 * continue using the previous group-authentication state.
	 *
	 * @param int $group_id phpBB group identifier
	 * @return void
	 */
	public function invalidate_group_permissions(int $group_id): void
	{
		if ($group_id <= 0)
		{
			return;
		}

		$sql = 'SELECT user_id
			FROM ' . USER_GROUP_TABLE . '
			WHERE group_id = ' . (int) $group_id . '
				AND user_pending = 0';
		$result = $this->db->sql_query($sql);
		$user_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_ids[] = (int) $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		$this->invalidate_user_permissions($user_ids);
	}

	/**
	* Get permission
	*
	* @param	string	$acl	One of the permissions, Exp: i_view
	* @param	int		$a_id	The album_id, from which we want to have the permissions
	* @param	int		$u_id	The user_id from the album-owner. If not specified we need to get it from the cache.
	*
	* @return	bool			Is the user allowed to do the $acl?
	*/
	public function acl_check(string $acl, int $a_id, int $u_id = -1): bool|int
	{
		if (!array_key_exists($acl, self::$_permissions_flipped))
		{
			return false;
		}

		$bit = self::$_permissions_flipped[$acl];

		if ($bit < 0)
		{
			$bit = $acl;
		}

		if (isset($this->acl_cache[$a_id][$bit]))
		{
			return $this->acl_cache[$a_id][$bit];
		}

		// Do we have a function call without $album_user_id ?
		if (($u_id < self::PUBLIC_ALBUM) && ($a_id > 0))
		{
			static $_album_list;
			// Yes, from viewonline.php
			if (!$_album_list)
			{
				$_album_list = $this->cache->get_albums();
			}
			if (!isset($_album_list[$a_id]))
			{
				// Do not give permissions, if the album does not exist.
				return false;
			}
			$u_id = $_album_list[$a_id]['album_user_id'];
		}

		$get_acl = 'get_bit';
		if (!is_int($bit))
		{
			$get_acl = 'get_count';
		}
		$p_id = $a_id;
		if ($u_id)
		{
			$this->user->set_user_id($this->phpbb_user->data['user_id']);
			if ($this->user->is_user($u_id))
			{
				$p_id = self::OWN_ALBUM;
			}
			else
			{
				if (!isset($this->_auth_data[$a_id]))
				{
					$p_id = self::PERSONAL_ALBUM;
				}
			}
		}

		if (isset($this->_auth_data[$p_id]))
		{
			$this->acl_cache[$a_id][$bit] = $this->_auth_data[$p_id]->$get_acl($bit);
			return $this->acl_cache[$a_id][$bit];
		}
		return false;
	}

	/**
	* Does the user have the permission for any album?
	*
	* @param	string	$acl			One of the permissions, Exp: i_view; *_count permissions are not allowed!
	*
	* @return	bool			Is the user allowed to do the $acl?
	*/
	public function acl_check_global(string $acl): bool
	{
		if (!array_key_exists($acl, self::$_permissions_flipped))
		{
			return false;
		}

		$bit = self::$_permissions_flipped[$acl];
		if (!is_int($bit))
		{
			// No support for *_count permissions.
			return false;
		}

		if (isset($this->_auth_data[self::OWN_ALBUM]) && $this->_auth_data[self::OWN_ALBUM]->get_bit($bit))
		{
			return true;
		}
		if (isset($this->_auth_data[self::PERSONAL_ALBUM]) && $this->_auth_data[self::PERSONAL_ALBUM]->get_bit($bit))
		{
			return true;
		}

		$albums = $this->cache->get_albums();
		foreach ($albums as $album)
		{
			if (!$album['album_user_id'] && isset($this->_auth_data[$album['album_id']]) && $this->_auth_data[$album['album_id']]->get_bit($bit))
			{
				return true;
			}
		}

		return false;
	}

	/**
	* Get albums by permission
	*
	* @param	string	$acl			One of the permissions, Exp: i_view; *_count permissions are not allowed!
	* @param	string	$return			Type of the return value. array returns an array, else it's a string.
	*									bool means it only checks whether the user has the permission anywhere.
	* @param	bool	$display_in_rrc	Only return albums, that have the display_in_rrc-flag set.
	* @param	bool	$display_pegas	Include personal galleries in the list.
	*
	* @return	mixed					$album_ids, either as list or array.
	*/
	public function acl_album_ids(string $acl, string $return = 'array', bool $display_in_rrc = false, bool $display_pegas = true): array|string|bool
	{
		if (!array_key_exists($acl, self::$_permissions_flipped))
		{
			return ($return === 'bool') ? false : (($return === 'array') ? [] : '');
		}

		$bit = self::$_permissions_flipped[$acl];
		if (!is_int($bit))
		{
			// No support for *_count permissions.
			return ($return == 'array') ? [] : '';
		}

		$album_list = '';
		$album_array = [];
		$albums = $this->cache->get_albums();
		foreach ($albums as $album)
		{
			if ($this->user->is_user($album['album_user_id']))
			{
				$a_id = self::OWN_ALBUM;
			}
			else if ($album['album_user_id'] > self::PUBLIC_ALBUM)
			{
				$a_id = self::PERSONAL_ALBUM;
			}
			else
			{
				$a_id = $album['album_id'];
			}
			if (isset($this->_auth_data[$a_id]) && $this->_auth_data[$a_id]->get_bit($bit) && (!$display_in_rrc || ($display_in_rrc && $album['display_in_rrc'])) && ($display_pegas || ($album['album_user_id'] == self::PUBLIC_ALBUM)))
			{
				if ($return == 'bool')
				{
					return true;
				}
				$album_list .= (($album_list) ? ', ' : '') . $album['album_id'];
				$album_array[] = (int) $album['album_id'];
			}
		}

		if ($return == 'bool')
		{
			return false;
		}

		return ($return == 'array') ? $album_array : $album_list;
	}

	/**
	 * Get all user IDs that have specific ACL for album
	 *
	 * @param    string $acl      One of the permissions, Exp: i_view; *_count permissions are not allowed!
	 * @param    int    $album_id Album ID we want info for
	 *
	 * @return array
	 */
	public function acl_users_ids(string $acl, int $album_id): array
	{
		if (!in_array($acl, self::$_permissions, true) || str_contains($acl, '_count'))
		{
			return [];
		}

		// Let's load album data
		$sql = 'SELECT * FROM ' . $this->table_albums . ' WHERE album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$album_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$album_data)
		{
			return [];
		}

		// Let's request roles
		// If album user_id is different then 0 then this is user album.
		// So we need to request all roles for perm_system -2(own) and -3(user)
		if ($album_data['album_user_id'] != 0)
		{
			$sql = 'SELECT * FROM ' . $this->table_permissions . ' WHERE ' . $this->db->sql_in_set('perm_system', [-2, -3]);
		}
		else
		{
			$sql = 'SELECT * FROM ' . $this->table_permissions . ' WHERE perm_album_id = ' . (int) $album_id;
		}

		$result = $this->db->sql_query($sql);
		$roles_id = ['roles' => []];
		// Now we build the array to test
		while ($row = $this->db->sql_fetchrow($result))
		{
			$role_id = (int) $row['perm_role_id'];
			$roles_id['roles'][] = $role_id;
			$roles_id[$role_id]['user_id'][] = (int) $row['perm_user_id'];
			$roles_id[$role_id]['group_id'][] = (int) $row['perm_group_id'];
		}
		$this->db->sql_freeresult($result);
		$roles_id['roles'] = array_values(array_unique($roles_id['roles']));
		if (empty($roles_id['roles']))
		{
			return [];
		}

		// Now we will select the roles that have the set ACL
		$sql = 'SELECT role_id FROM ' . $this->table_roles . ' WHERE ' . $acl . ' = 1 AND ' . $this->db->sql_in_set('role_id', $roles_id['roles'], false, true);
		$result = $this->db->sql_query($sql);
		$roles = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$roles[] = (int) $row['role_id'];
		}
		$this->db->sql_freeresult($result);

		// Build the direct-user and group assignments for all matching roles
		$user_ids = [];
		$group_ids = [];
		foreach ($roles as $id)
		{
			$user_ids = array_merge($user_ids, $roles_id[$id]['user_id'] ?? []);
			$group_ids = array_merge($group_ids, $roles_id[$id]['group_id'] ?? []);
		}
		$group_ids = array_values(array_unique(array_filter(array_map('intval', $group_ids))));

		if ($group_ids)
		{
			// Resolve all matching group memberships in one query
			$sql = 'SELECT * FROM ' . USER_GROUP_TABLE . ' WHERE ' . $this->db->sql_in_set('group_id', $group_ids, false, true);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($row['user_pending'] == 0)
				{
					$user_ids[] = (int) $row['user_id'];
				}
			}
			$this->db->sql_freeresult($result);
		}

		// Now we cycle the $user_ids to remove 0 and make ids unique
		$returning_value = [];
		foreach ($user_ids as $id)
		{
			if ($id != 0)
			{
				$returning_value[$id] = (int) $id;
			}
		}

		return array_values($returning_value);
	}

	/**
	 * Get all albums the user cannot access due to zebra restrictions.
	 *
	 * @return array
	 */
	public function get_exclude_zebra(): array
	{
		$zebra_array = $this->get_user_zebra($this->phpbb_user->data['user_id']);
		$foes = [];
		if ($this->user->get_data('rrc_zebra'))
		{
			$foes = $this->get_user_foes($this->phpbb_user->data['user_id']);
		}
		$albums = $this->cache->get_albums();
		$exclude = [];
		foreach ($albums as $album)
		{
			// There is zebra only for users
			if ($album['album_type'] == 1 && $album['album_user_id'] > 0 && ($this->get_zebra_state($zebra_array, $album['album_user_id'], $album['album_id']) < $album['album_auth_access'] || in_array($album['album_user_id'], $foes)))
			{
				$exclude[] = (int) $album['album_id'];
			}
		}
		return $exclude;
	}
}
