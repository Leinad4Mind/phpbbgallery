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

namespace phpbbgallery\core\album;

class display
{
	protected \phpbb\auth\auth $auth;
	protected \phpbb\config\config $config;
	protected \phpbb\db\driver\driver_interface $db;
	protected \phpbb\controller\helper $helper;
	protected \phpbb\pagination $pagination;
	protected \phpbb\request\request_interface $request;
	protected \phpbb\symfony_request $symfony_request;
	protected \phpbb\template\template $template;
	protected \phpbb\user $user;
	protected \phpbbgallery\core\auth\auth $gallery_auth;
	protected \phpbbgallery\core\config $gallery_config;
	protected \phpbbgallery\core\user $gallery_user;
	protected \phpbbgallery\core\misc $misc;
	protected \phpbbgallery\core\unread_counter $unread_counter;
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;
	protected data_enricher $data_enricher;
	protected string $root_path;
	protected string $php_ext;
	protected string $table_albums;
	protected string $table_images;
	protected string $table_moderators;
	protected \phpbb\language\language $language;

	/**
	 * Pagination offset for the current album list.
	 */
	public int $album_start = 0;

	/**
	 * Pagination limit for the current album list.
	 */
	public int $album_limit = 0;

	/**
	 * Total number of visible albums from the last display operation.
	 */
	public int $albums_total = 0;

	/** Number of direct, uncategorised albums in the current root scope. */
	public int $album_root_total = 0;

	/** Whether the last display operation found any visible album or category row. */
	public bool $has_album_rows = false;

	/** Enable independent pagination for every direct category on the Gallery index. */
	protected bool $paginate_categories = false;

	/** @var array<string, mixed> Route definition for category album pages. */
	protected array $category_pagination_base_url = [];

	/** @var array<int, array{param: string, page: int, start: int, total: int}> */
	protected array $category_pagination = [];

	/**
	 * Whether any rendered album list in this request uses a custom icon.
	 */
	public bool $has_album_custom_icons = false;

	/**
	 * Album listing mode selected by the controller.
	 */
	public string $album_mode = '';

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\controller\helper $helper,
								\phpbb\db\driver\driver_interface $db, \phpbb\pagination $pagination,
								\phpbb\request\request_interface $request, \phpbb\symfony_request $symfony_request,
								\phpbb\template\template $template,
								\phpbb\user $user, \phpbb\language\language $language, \phpbbgallery\core\auth\auth $gallery_auth,
								\phpbbgallery\core\config $gallery_config,
								\phpbbgallery\core\user $gallery_user, \phpbbgallery\core\misc $misc,
								\phpbbgallery\core\unread_counter $unread_counter,
								\phpbbgallery\core\policy\image_visibility $image_visibility,
								data_enricher $data_enricher,
								string $root_path, string $php_ext, string $albums_table, string $images_table,
								string $moderators_table)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->request = $request;
		$this->symfony_request = $symfony_request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_config = $gallery_config;
		$this->gallery_user = $gallery_user;
		$this->misc = $misc;
		$this->unread_counter = $unread_counter;
		$this->image_visibility = $image_visibility;
		$this->data_enricher = $data_enricher;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->table_albums = $albums_table;
		$this->table_images = $images_table;
		$this->table_moderators = $moderators_table;
	}

	/** Enable per-category pagination for the next public album list. */
	public function configure_category_pagination(array $base_url): void
	{
		$this->paginate_categories = true;
		$this->category_pagination_base_url = $base_url;
	}

	/** Restore the regular single-list pagination behaviour. */
	public function disable_category_pagination(): void
	{
		$this->paginate_categories = false;
		$this->category_pagination_base_url = [];
		$this->category_pagination = [];
	}

	/** @return array<string, int> Active category pages retained by sibling pagers. */
	public function category_page_params(): array
	{
		$params = [];
		foreach ($this->category_pagination as $pagination)
		{
			if ($pagination['page'] > 1)
			{
				$params[$pagination['param']] = $pagination['page'];
			}
		}

		return $params;
	}

	/**
	 * Get album branch
	 *
	 * borrowed from phpBB3
	 * @author phpBB Group
	 * @param int $branch_user_id
	 * @param int $album_id
	 * @param string $type
	 * @param string $order
	 * @param bool $include_album
	 * @return array
	 */
	public function get_branch(int $branch_user_id, int $album_id, string $type = 'all', string $order = 'descending', bool $include_album = true): array
	{
		switch ($type)
		{
			case 'parents':
				$condition = 'a1.left_id BETWEEN a2.left_id AND a2.right_id';
			break;

			case 'children':
				$condition = 'a2.left_id BETWEEN a1.left_id AND a1.right_id';
			break;

			default:
				$condition = 'a2.left_id BETWEEN a1.left_id AND a1.right_id OR a1.left_id BETWEEN a2.left_id AND a2.right_id';
			break;
		}

		$rows = [];

		$sql = 'SELECT a2.*
			FROM ' . $this->table_albums . ' a1
			LEFT JOIN ' . $this->table_albums . ' a2 ON (' . $condition .') AND a2.album_user_id = ' . (int) $branch_user_id .'
			WHERE a1.album_id = ' . (int) $album_id . '
				AND a1.album_user_id = ' . (int) $branch_user_id . '
			ORDER BY a2.left_id ' . (($order == 'descending') ? 'ASC' : 'DESC');
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if (!$include_album && $row['album_id'] == $album_id)
			{
				continue;
			}

			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}

	/**
	 * Create album navigation links for given album, create parent
	 * list if currently null, assign basic album info to template
	 *
	 * borrowed from phpBB3
	 * @author phpBB Group
	 * @param array $album_data
	 */
	public function generate_navigation(array $album_data): void
	{
		// Add gallery menu entry
		// TO DO !!! THIS SHOULD BE MOVED TO MENU CREATOR!!
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'   => $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'   => $this->helper->route('phpbbgallery_core_index'),
		]);
		// Get album parents
		$album_parents = $this->get_parents($album_data);

		// Display username for personal albums
		if ($album_data['album_user_id'] > (int) \phpbbgallery\core\block::PUBLIC_ALBUM)
		{
			$sql = 'SELECT user_id, username, user_colour
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $album_data['album_user_id'];
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('navlinks', [
					'FORUM_NAME'	=> $this->language->lang('PERSONAL_ALBUMS'),
					'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_personal'),
				]);
			}
			$this->db->sql_freeresult($result);
		}

		// Build navigation links
		if (!empty($album_parents))
		{
			foreach ($album_parents as $parent_album_id => $parent_data)
			{
				list($parent_name, $parent_type) = array_values($parent_data);

				$this->template->assign_block_vars('navlinks', [
					'FORUM_NAME'	=> $parent_name,
					'FORUM_ID'		=> $parent_album_id,
					'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $parent_album_id]),
				]);
			}
		}

		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $album_data['album_name'],
			'FORUM_ID'		=> $album_data['album_id'],
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $album_data['album_id']]),
		]);

		$template_vars = [
			'ALBUM_ID' 		=> $album_data['album_id'],
			'ALBUM_NAME'	=> $album_data['album_name'],
			'ALBUM_DESC'	=> generate_text_for_display($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_bitfield'], $album_data['album_desc_options']),
			'U_VIEW_ALBUM'	=> $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $album_data['album_id']]),
		];
		$this->template->assign_vars($this->data_enricher->enrich_template_vars(
			'navigation',
			$album_data,
			$template_vars
		));

		return;
	}

	/**
	 * Returns album parents as an array. Get them from album_data if available, or update the database otherwise
	 *
	 * borrowed from phpBB3
	 * @author phpBB Group
	 * @param array $album_data
	 * @return array
	 */
	public function get_parents(array $album_data): array
	{
		$album_parents = [];

		if ($album_data['parent_id'] <= 0)
		{
			return $album_parents;
		}

		if ($album_data['album_parents'] !== '')
		{
			try
			{
				$stored_parents = json_decode($album_data['album_parents'], true, 512, JSON_THROW_ON_ERROR);
				if (is_array($stored_parents))
				{
					return $stored_parents;
				}
			}
			catch (\JsonException)
			{
				// Legacy serialized or malformed cache values are rebuilt below.
			}
		}

		$sql = 'SELECT album_id, album_name, album_type
			FROM ' . $this->table_albums . '
			WHERE left_id < ' . (int) $album_data['left_id'] . '
				AND right_id > ' . (int) $album_data['right_id'] . '
				AND album_user_id = ' . (int) $album_data['album_user_id'] . '
			ORDER BY left_id ASC';

		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_parents[$row['album_id']] = [$row['album_name'], (int) $row['album_type']];
		}
		$this->db->sql_freeresult($result);

		$parent_cache = json_encode($album_parents, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
		$sql = 'UPDATE ' . $this->table_albums . "
			SET album_parents = '" . $this->db->sql_escape($parent_cache) . "'
			WHERE parent_id = " . (int) $album_data['parent_id'];
		$this->db->sql_query($sql);

		return $album_parents;
	}


	/**
	 * Obtain list of moderators of each album
	 *
	 * borrowed from phpBB3
	 * @author phpBB Group
	 * @param array|int|false $album_id
	 * @return array
	 */
	public function get_moderators(array|int|false $album_id = false): array
	{
		$album_id_ary = $album_moderators = [];

		if ($album_id !== false)
		{
			if (!is_array($album_id))
			{
				$album_id = [$album_id];
			}

			// Exchange key/value pair to be able to faster check for the album id existence
			$album_id_ary = array_flip($album_id);
		}

		$sql_array = [
			'SELECT'	=> 'm.*, u.username AS current_username, u.user_colour, g.group_name AS current_group_name, g.group_colour, g.group_type',
			'FROM'		=> [$this->table_moderators => 'm'],

			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [USERS_TABLE => 'u'],
					'ON'	=> 'm.user_id = u.user_id',
				],
				[
					'FROM'	=> [GROUPS_TABLE => 'g'],
					'ON'	=> 'm.group_id = g.group_id',
				],
			],

			'WHERE'		=> 'm.display_on_index = 1',
			'ORDER_BY'	=> 'm.group_id ASC, m.user_id ASC',
		];

		// We query every album here because for caching we should not have any parameter.
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql, 3600);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$a_id = (int) $row['album_id'];

			if ($album_id !== false && !isset($album_id_ary[$a_id]))
			{
				continue;
			}

			if (!empty($row['user_id']))
			{
				if (!isset($row['current_username']))
				{
					continue;
				}

				$album_moderators[$a_id][] = get_username_string('full', $row['user_id'], $row['current_username'], $row['user_colour']);
			}
			else
			{
				if (empty($row['group_id']) || !isset($row['current_group_name']))
				{
					continue;
				}

				$group_name = (($row['group_type'] == GROUP_SPECIAL) ? $this->language->lang('G_' . $row['current_group_name']) : $row['current_group_name']);

				if ($this->user->data['user_id'] != ANONYMOUS && !$this->auth->acl_get('u_viewprofile'))
				{
					$album_moderators[$a_id][] = '<span' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . '>' . $group_name . '</span>';
				}
				else
				{
					$album_moderators[$a_id][] = '<a' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . ' href="' . append_sid($this->root_path . 'memberlist.' . $this->php_ext, 'mode=group&amp;g=' . $row['group_id']) . '">' . $group_name . '</a>';
				}
			}
		}
		$this->db->sql_freeresult($result);

		return $album_moderators;
	}

	/**
	 * Display albums
	 *
	 * borrowed from phpBB3
	 * @author phpBB Group
	 * @param array|string|false $root_data
	 * @param bool $display_moderators
	 * @param bool $return_moderators
	 * @param string $block_name Template block that receives the album rows
	 * @return array
	 */
	public function display_albums(array|string|false $root_data = '', bool $display_moderators = true, bool $return_moderators = false, string $block_name = 'albumrow'): array
	{
		$album_rows = $subalbums = $album_ids = $album_ids_moderator = $album_moderators = $active_album_ary = [];
		$visible_albums = 0;
		$mode = $this->album_mode;
		$index_section = !$root_data ? 'public' : (($root_data === 'personal' && $mode !== 'personal') ? 'personal' : '');
		$section_start_pending = $index_section !== '';
		// Mark albums read?
		$mark_read = $this->request->variable('mark', '');

		if ($mark_read == 'all')
		{
			$mark_read = '';
		}

		if (!$root_data)
		{
			if ($mark_read == 'albums')
			{
				$mark_read = 'all';
			}
			$root_data = ['album_id' => (int) \phpbbgallery\core\block::PUBLIC_ALBUM];
			$sql_where = 'a.album_user_id = ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM;
		}
		else if ($root_data == 'personal')
		{
			if ($mark_read == 'albums')
			{
				$mark_read = 'all';
			}
			$root_data = ['album_id' => 0];
			$sql_where = 'a.album_user_id > ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM;
			$num_pegas = $this->config['phpbb_gallery_num_pegas'];
			$first_char = strtolower($this->request->variable('first_char', ''));

			if ($first_char == 'other')
			{
				// Loop the ASCII: a-z
				for ($i = 97; $i < 123; $i++)
				{
					$sql_where .= ' AND u.username_clean NOT ' . $this->db->sql_like_expression(chr($i) . $this->db->get_any_char());
				}
			}
			else if ($first_char)
			{
				$sql_where .= ' AND u.username_clean ' . $this->db->sql_like_expression(substr($first_char, 0, 1) . $this->db->get_any_char());
			}

			if ($first_char)
			{
				// We do not view all personal albums, so we need to recount, for the pagination.
				$sql_array = [
					'SELECT'		=> 'count(a.album_id) as pgalleries',
					'FROM'			=> [$this->table_albums => 'a'],

					'LEFT_JOIN'		=> [
						[
							'FROM'		=> [USERS_TABLE => 'u'],
							'ON'		=> 'u.user_id = a.album_user_id',
						],
					],

					'WHERE'			=> implode(' AND ', ['a.parent_id = 0', $sql_where]),
				];
				$sql = $this->db->sql_build_query('SELECT', $sql_array);
				$result = $this->db->sql_query($sql);
				$num_pegas = $this->db->sql_fetchfield('pgalleries');
				$this->db->sql_freeresult($result);
			}

			$mode_personal = true;
		}
		else
		{
			$sql_where = 'a.left_id > ' . (int) $root_data['left_id'] . ' AND a.left_id < ' . (int) $root_data['right_id'] . ' AND a.album_user_id = ' . (int) $root_data['album_user_id'];
		}

		$last_image_projection = 'last_image_visibility_marker';
		$sql_array = [
			'SELECT'	=> 'a.*, ' . $this->image_visibility->projection_sql('li', $last_image_projection),
			'FROM'		=> [$this->table_albums => 'a'],

			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->table_images => 'li'],
					'ON'	=> 'li.image_id = a.album_last_image_id',
				],
			],

			'ORDER_BY'	=> 'a.album_user_id, a.left_id',
		];

		if (isset($mode_personal))
		{
			$sql_array['LEFT_JOIN'][] = [
				'FROM'	=> [USERS_TABLE => 'u'],
				'ON'	=> 'u.user_id = a.album_user_id',
			];
			$sql_array['ORDER_BY'] = 'u.username_clean, a.album_user_id, a.left_id';
		}

		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT'	=> $sql_array['SELECT'],
			'FROM'		=> $sql_array['FROM'],
			'LEFT_JOIN'	=> $sql_array['LEFT_JOIN'],
			'WHERE'		=> $sql_where,
			'ORDER_BY'	=> $sql_array['ORDER_BY'],
		]);

		$result = $this->db->sql_query($sql);

		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);
		$rows = $this->data_enricher->enrich_many($rows);

		$zebra_array = $this->gallery_auth->get_user_zebra($this->user->data['user_id']);
		$listable = $this->gallery_auth->acl_album_ids('a_list');
		$rows = $this->filter_visible_hierarchy_rows($rows, $listable, $zebra_array, (int) $root_data['album_id']);
		$unread_album_ids = array_fill_keys($this->unread_counter->album_ids(array_column($rows, 'album_id')), true);
		$owner_states = [];
		foreach ($rows as $row)
		{
			$album_id = (int) $row['album_id'];
			// Mark albums read?
			if ($mark_read == 'albums' || $mark_read == 'all')
			{
				if ($this->gallery_auth->acl_check('a_list', $album_id, $row['album_user_id']))
				{
					$album_ids[] = $album_id;
					continue;
				}
			}

			$display_parent_id = $this->resolve_album_display_parent($row, (int) $root_data['album_id'], $owner_states);
			if ($display_parent_id === false)
			{
				continue;
			}

			$active_album_ary[] = (int) $album_id;

			if ($display_parent_id === $album_id)
			{
				if ($row['album_type'])
				{
					$album_ids_moderator[] = (int) $album_id;
				}

				// Direct child of current branch
				$album_rows[$album_id] = $row;
				$album_rows[$album_id]['album_id_last_image'] = $row['album_id'];
				$album_rows[$album_id][$last_image_projection] = (int) ($row[$last_image_projection] ?? 0);
				$album_rows[$album_id]['orig_album_last_image_time'] = $row['album_last_image_time'];
			}
			else if ($row['album_type'])
			{
				$parent_id = $display_parent_id;
				$subalbums[$parent_id][$album_id]['display'] = ($row['display_on_index']) ? true : false;
				$subalbums[$parent_id][$album_id]['name'] = $row['album_name'];
				$subalbums[$parent_id][$album_id]['image'] = trim((string) ($row['album_image'] ?? ''));
				$subalbums[$parent_id][$album_id]['orig_album_last_image_time'] = $row['album_last_image_time'];
				$subalbums[$parent_id][$album_id]['children'] = [];

				if (isset($subalbums[$parent_id][$row['parent_id']]) && !$row['display_on_index'])
				{
					$subalbums[$parent_id][$row['parent_id']]['children'][] = $album_id;
				}

				$album_rows[$parent_id]['album_images'] += $row['album_images'];
				$album_rows[$parent_id]['album_images_real'] += $row['album_images_real'];

				if ($row['album_last_image_time'] > $album_rows[$parent_id]['album_last_image_time'])
				{
					$album_rows[$parent_id]['album_last_image_id'] = $row['album_last_image_id'];
					$album_rows[$parent_id]['album_last_image_name'] = $row['album_last_image_name'];
					$album_rows[$parent_id]['album_last_image_time'] = $row['album_last_image_time'];
					$album_rows[$parent_id]['album_last_user_id'] = $row['album_last_user_id'];
					$album_rows[$parent_id]['album_last_username'] = $row['album_last_username'];
					$album_rows[$parent_id]['album_last_user_colour'] = $row['album_last_user_colour'];
					$album_rows[$parent_id][$last_image_projection] = (int) ($row[$last_image_projection] ?? 0);
					$album_rows[$parent_id]['album_id_last_image'] = $album_id;
				}
			}
		}
		// Handle marking albums
		if ($mark_read == 'albums' || $mark_read == 'all')
		{
			$redirect = build_url('mark');
			$token = $this->request->variable('hash', '');
			if (check_link_hash($token, 'global'))
			{
				if ($mark_read == 'all')
				{
					$this->misc->markread('all');
					$message = $this->language->lang('RETURN_INDEX', '<a href="' . $redirect . '">', '</a>');
				}
				else
				{
					$this->misc->markread('albums', $album_ids);
					$message = $this->language->lang('RETURN_ALBUM', '<a href="' . $redirect . '">', '</a>');
				}
				meta_refresh(3, $redirect);
				trigger_error($this->language->lang('ALBUMS_MARKED') . '<br /><br />' . $message);
			}
			else
			{
				$message = $this->language->lang('RETURN_PAGE', '<a href="' . $redirect . '">', '</a>');
				meta_refresh(3, $redirect);
				trigger_error($message);
			}
		}

		// Grab moderators ... if necessary
		if ($display_moderators)
		{
			if ($return_moderators)
			{
				$album_ids_moderator[] = $root_data['album_id'];
			}
			$album_moderators = $this->get_moderators($album_ids_moderator);
		}
		$this->has_album_rows = !empty($album_rows);
		[$album_rows, $visible_albums] = $this->paginate_album_rows($album_rows, (int) $root_data['album_id']);

		// Used to tell whatever we have to create a dummy category or not.
		$board_path = rtrim($this->symfony_request->getBasePath(), '/');
		$last_catless = true;
		$has_album_custom_icons = false;
		foreach ($album_rows as $row)
		{
			$album_image = trim((string) ($row['album_image'] ?? ''));
			$album_image_src = $album_image !== ''
				? $board_path . '/' . ltrim($album_image, '/')
				: '';

			// Empty category
			if (($row['parent_id'] == $root_data['album_id']) && ($row['album_type'] == (int) \phpbbgallery\core\block::TYPE_CAT))
			{
				$category_pagination = $this->category_pagination[(int) $row['album_id']] ?? null;
				$category_total = $category_pagination !== null ? $category_pagination['total'] : 0;
				$category_total_label = $category_total . ' ' . $this->language->lang(
					$category_total === 1 ? 'ALBUM' : 'ALBUMS'
				);

				$this->template->assign_block_vars($block_name, [
					'S_IS_CAT'				=> true,
					'S_PERSONAL_ALBUM'		=> (int) $row['album_user_id'] > (int) \phpbbgallery\core\block::PUBLIC_ALBUM,
					'S_PUBLIC_SECTION_START'	=> $section_start_pending && $index_section === 'public',
					'S_PERSONAL_SECTION_START'	=> $section_start_pending && $index_section === 'personal',
					'S_CATEGORY_ALBUM_LIST'	=> $category_pagination !== null,
					'CATEGORY_ALBUM_TOTAL'	=> $category_total_label,
					'ALBUM_ID'				=> $row['album_id'],
					'ALBUM_NAME'			=> $row['album_name'],
					'ALBUM_DESC'			=> generate_text_for_display($row['album_desc'], $row['album_desc_uid'], $row['album_desc_bitfield'], $row['album_desc_options']),
					'ALBUM_FOLDER_IMG'		=> '',
					'ALBUM_FOLDER_IMG_SRC'	=> '',
					'ALBUM_IMAGE'			=> $album_image,
					'ALBUM_IMAGE_SRC'		=> $album_image_src,
					'U_VIEWALBUM'			=> $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $row['album_id']]),
				]);
				if ($category_pagination !== null)
				{
					$this->generate_category_pagination($block_name, $category_pagination);
				}
				$section_start_pending = false;

				continue;
			}

			$album_id = $row['album_id'];
			$album_unread = isset($unread_album_ids[$album_id]);

			$folder_alt = $l_subalbums = '';
			$subalbums_list = [];

			// Generate list of subalbums if we need to
			if (isset($subalbums[$album_id]))
			{
				foreach ($subalbums[$album_id] as $subalbum_id => $subalbum_row)
				{
					$subalbum_unread = isset($unread_album_ids[$subalbum_id]);

					if (!$subalbum_unread && !empty($subalbum_row['children']) && ($this->user->data['user_id'] != ANONYMOUS))
					{
						foreach ($subalbum_row['children'] as $child_id)
						{
							if (isset($unread_album_ids[$child_id]))
							{
								// Once we found an unread child album, we can drop out of this loop
								$subalbum_unread = true;
								break;
							}
						}
					}

					if ($subalbum_row['display'] && $subalbum_row['name'])
					{
						$subalbums_list[] = [
							'link'		=> $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $subalbum_id]),
							'name'		=> $subalbum_row['name'],
							'unread'	=> $subalbum_unread,
							'image_src'	=> $subalbum_row['image'] !== '' ? $board_path . '/' . ltrim($subalbum_row['image'], '/') : '',
						];
					}
					else
					{
						unset($subalbums[$album_id][$subalbum_id]);
					}

					if ($subalbum_unread)
					{
						$album_unread = true;
					}
				}

				$l_subalbums = (sizeof($subalbums[$album_id]) == 1) ? $this->language->lang('SUBALBUM') : $this->language->lang('SUBALBUMS');
				$folder_image = ($album_unread) ? 'forum_unread_subforum' : 'forum_read_subforum';
			}
			else
			{
				$folder_alt = ($album_unread) ? 'NEW_IMAGES' : 'NO_NEW_IMAGES';
				$folder_image = ($album_unread) ? 'forum_unread' : 'forum_read';
			}
			if ($row['album_status'] == (int) \phpbbgallery\core\block::ALBUM_LOCKED)
			{
				$folder_image = ($album_unread) ? 'forum_unread_locked' : 'forum_read_locked';
				$folder_alt = 'ALBUM_LOCKED';
			}

			// Create last post link information, if appropriate
			if ($row['album_last_image_id'])
			{
				$lastimage_time = $this->user->format_date($row['album_last_image_time']);
				$lastimage_uc_last_thumbnail = $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $row['album_last_image_id']]);
				$lastimage_u_last_image = $this->helper->route('phpbbgallery_core_image', ['image_id' => $row['album_last_image_id']]);
				$lastimage_uc_fake_thumbnail = $album_image_src ?: $lastimage_uc_last_thumbnail;
				$lastimage_uc_fake_thumbnail_url = $album_image_src ?: $lastimage_u_last_image;
				$lastimage_uc_thumbnail = $album_image_src ?: $lastimage_uc_last_thumbnail;
				$lastimage_uc_name = '';
				$lastimage_uc_icon = '';
			}
			else
			{
				$lastimage_time = 0;
				$lastimage_uc_last_thumbnail = $lastimage_u_last_image = '';
				$lastimage_uc_fake_thumbnail = $lastimage_uc_fake_thumbnail_url = $lastimage_uc_thumbnail = $lastimage_uc_name = $lastimage_uc_icon = '';
				$lastimage_uc_fake_thumbnail = $lastimage_uc_fake_thumbnail_url = $lastimage_uc_thumbnail = $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => 0]);
			}

			// Output moderator listing ... if applicable
			$l_moderator = $moderators_list = '';
			if ($display_moderators && !empty($album_moderators[$album_id]))
			{
				$l_moderator = (sizeof($album_moderators[$album_id]) == 1) ? $this->language->lang('MODERATOR') : $this->language->lang('MODERATORS');
				$moderators_list = implode(', ', $album_moderators[$album_id]);
			}

			$s_subalbums_list = [];
			foreach ($subalbums_list as $subalbum)
			{
				$s_subalbums_list[] = '<a href="' . $subalbum['link'] . '" class="subforum ' . (($subalbum['unread']) ? 'unread' : 'read') . '" title="' . (($subalbum['unread']) ? $this->language->lang('NEW_IMAGES') : $this->language->lang('NO_NEW_IMAGES')) . '">' . $subalbum['name'] . '</a>';
			}
			$s_subalbums_list = (string) implode(', ', $s_subalbums_list);
			$subalbum_display_mode = \phpbbgallery\core\block::normalise_subalbum_display_mode((int) $row['display_subalbum_list']);
			$catless = ($row['parent_id'] == $root_data['album_id']) ? true : false;

			$last_image_data = $this->image_visibility->projected_data($row, $last_image_projection, [
				'image_user_id' => (int) $row['album_last_user_id'],
			]);
			$can_moderate = $this->gallery_auth->acl_check('m_status', $album_id, $row['album_user_id']);
			$s_username_hidden = $this->image_visibility->hides_private_data(
				$last_image_data,
				(int) $this->user->data['user_id'],
				$can_moderate
			);
			$last_image_label = $s_username_hidden ? $this->image_visibility->private_data_label(
				$last_image_data,
				(int) $this->user->data['user_id'],
				$can_moderate,
				$this->language->lang('GALLERY_PRIVATE_USER')
			) : '';

			$album_template_vars = [
				'S_IS_CAT'			=> false,
				'S_PERSONAL_ALBUM'	=> (int) $row['album_user_id'] > (int) \phpbbgallery\core\block::PUBLIC_ALBUM,
				'S_PUBLIC_SECTION_START'	=> $section_start_pending && $index_section === 'public',
				'S_PERSONAL_SECTION_START'	=> $section_start_pending && $index_section === 'personal',
				'S_NO_CAT'			=> $catless && !$last_catless,
				'S_LOCKED_ALBUM'	=> ($row['album_status'] == (int) \phpbbgallery\core\block::ALBUM_LOCKED) ? true : false,
				'S_UNREAD_ALBUM'	=> ($album_unread) ? true : false,
				'S_LIST_SUBALBUMS'	=> $subalbum_display_mode !== (int) \phpbbgallery\core\block::SUBALBUM_DISPLAY_HIDDEN,
				'S_SUBALBUMS_AS_TEXT'	=> $subalbum_display_mode === (int) \phpbbgallery\core\block::SUBALBUM_DISPLAY_TEXT,
				'S_SUBALBUMS_AS_ICONS'	=> $subalbum_display_mode === (int) \phpbbgallery\core\block::SUBALBUM_DISPLAY_ICONS,
				'SUBALBUM_DISPLAY_MODE'	=> $subalbum_display_mode,
				'S_SUBALBUMS'		=> (sizeof($subalbums_list)) ? true : false,
				'S_ALBUM_VISUAL_IS_LAST_IMAGE' => !$row['album_image'] && (int) $row['album_last_image_id'] > 0,

				'ALBUM_ID'				=> (int) $row['album_id'],
				'ALBUM_NAME'			=> $row['album_name'],
				'ALBUM_DESC'			=> generate_text_for_display($row['album_desc'], $row['album_desc_uid'], $row['album_desc_bitfield'], $row['album_desc_options']),
				'IMAGES'				=> (int) $row['album_images'],
				'UNAPPROVED_IMAGES'		=> ($this->gallery_auth->acl_check('m_status', $album_id, $row['album_user_id'])) ? ($row['album_images_real'] - $row['album_images']) : 0,
				'ALBUM_IMG_STYLE'		=> $folder_image,
				'ALBUM_FOLDER_IMG'		=> $this->user->img($folder_image, $folder_alt),
				'ALBUM_FOLDER_IMG_ALT'	=> $this->language->lang($folder_alt) ? $this->language->lang($folder_alt) : '',
				'ALBUM_IMAGE'			=> $album_image,
				'ALBUM_IMAGE_SRC'		=> $album_image_src,
				'LAST_IMAGE_ID'			=> (int) $row['album_last_image_id'],
				'LAST_IMAGE_TIME'		=> $lastimage_time,
				'LAST_USER_FULL'		=> ($s_username_hidden) ? $last_image_label : get_username_string('full', $row['album_last_user_id'], $row['album_last_username'], $row['album_last_user_colour']),
				'UC_THUMBNAIL'			=> $lastimage_uc_thumbnail,
				'UC_FAKE_THUMBNAIL'		=> $this->config['phpbb_gallery_mini_thumbnail_disp'] ? $lastimage_uc_fake_thumbnail : '',
				'UC_IMAGE_URL'			=> $this->config['phpbb_gallery_mini_thumbnail_disp'] ? $lastimage_uc_fake_thumbnail_url : '',
				'UC_LAST_IMAGE_THUMBNAIL' => $this->config['phpbb_gallery_mini_thumbnail_disp'] ? $lastimage_uc_last_thumbnail : '',
				'U_LAST_IMAGE'			=> $this->config['phpbb_gallery_mini_thumbnail_disp'] ? $lastimage_u_last_image : '',
				'UC_IMAGE_NAME'			=> $lastimage_uc_name,
				'UC_LASTIMAGE_ICON'		=> $lastimage_uc_icon,
				'ALBUM_COLOUR'			=> get_username_string('colour', $row['album_last_user_id'], $row['album_last_username'], $row['album_last_user_colour']),
				'MODERATORS'			=> $moderators_list,
				'SUBALBUMS'				=> $s_subalbums_list,

				'L_SUBALBUM_STR'		=> $l_subalbums,
				'L_ALBUM_FOLDER_ALT'	=> $folder_alt,
				'L_MODERATOR_STR'		=> $l_moderator,

				'U_VIEWALBUM'			=> $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $row['album_id']]),
			];
			$album_template_vars = $this->data_enricher->enrich_template_vars(
				'album_list',
				$row,
				$album_template_vars
			);
			$has_album_custom_icons = $has_album_custom_icons || $album_image_src !== '';
			$this->template->assign_block_vars($block_name, $album_template_vars);
			$section_start_pending = false;

			// Assign subforums loop for style authors
			foreach ($subalbums_list as $subalbum)
			{
				$this->template->assign_block_vars($block_name . '.subalbum', [
					'U_SUBALBUM'	=> $subalbum['link'],
					'SUBALBUM_NAME'	=> $subalbum['name'],
					'SUBALBUM_IMAGE_SRC' => $subalbum['image_src'],
					'S_UNREAD'		=> $subalbum['unread'],
				]);
			}

			$last_catless = $catless;
		}

		$this->has_album_custom_icons = $this->has_album_custom_icons || $has_album_custom_icons;

		$this->template->assign_vars([
			'U_MARK_ALBUMS'		=> ($this->user->data['is_registered']) ? $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $root_data['album_id'], 'hash' => generate_link_hash('global'), 'mark' => 'albums']) : '',
			'S_ALBUM_LIST_HAS_CUSTOM_ICONS' => $this->has_album_custom_icons,
			'S_HAS_SUBALBUM'	=> ($visible_albums) ? true : false,
			'L_SUBFORUM'		=> ($visible_albums == 1) ? $this->language->lang('SUBALBUM') : $this->language->lang('SUBALBUMS'),
			'LAST_POST_IMG'		=> $this->user->img('icon_topic_latest', 'VIEW_LATEST_POST'),
			'FAKE_THUMB_SIZE'	=> $this->config['phpbb_gallery_mini_thumbnail_size'],
		]);

		if ($return_moderators)
		{
			return [$active_album_ary, $album_moderators];
		}

		$this->albums_total = $visible_albums;

		return [$active_album_ary, []];
	}

	/**
	 * Select one bounded page of displayed album cards without separating category headings.
	 *
	 * Nested descendants are already attached to their displayed card and therefore never
	 * consume a second slot. A category heading is repeated when one of its cards appears
	 * on the requested page.
	 *
	 * @param array $album_rows Ordered displayed rows
	 * @param int   $root_album_id Root album outside the selected rows
	 * @return array{0: array, 1: int} Selected rows and total visible cards
	 */
	protected function paginate_album_rows(array $album_rows, int $root_album_id): array
	{
		$this->album_root_total = 0;
		$this->category_pagination = [];
		if ($this->paginate_categories)
		{
			return $this->paginate_category_album_rows($album_rows, $root_album_id);
		}

		$total = 0;
		foreach ($album_rows as $row)
		{
			if (!$this->is_album_category_heading($row, $root_album_id))
			{
				$total++;
			}
		}
		$this->album_root_total = $total;

		$limit = max(0, $this->album_limit);
		if ($limit === 0)
		{
			return [$album_rows, $total];
		}

		$start = max(0, $this->album_start);
		$position = 0;
		$current_category = null;
		$selected = [];
		foreach ($album_rows as $album_id => $row)
		{
			if ($this->is_album_category_heading($row, $root_album_id))
			{
				$current_category = [$album_id => $row];
				continue;
			}

			if ((int) $row['parent_id'] === $root_album_id)
			{
				$current_category = null;
			}

			$position++;
			if ($position <= $start || $position > $start + $limit)
			{
				continue;
			}

			if ($current_category !== null)
			{
				$selected += $current_category;
				$current_category = null;
			}
			$selected[$album_id] = $row;
		}

		return [$selected, $total];
	}

	/**
	 * Apply the configured limit independently to root albums and every category.
	 *
	 * @param array $album_rows Ordered category headings and displayed album cards
	 * @param int   $root_album_id Root album outside the selected rows
	 * @return array{0: array, 1: int} Selected rows and total cards across all groups
	 */
	protected function paginate_category_album_rows(array $album_rows, int $root_album_id): array
	{
		$groups = [0 => []];
		$current_group = 0;
		foreach ($album_rows as $album_id => $row)
		{
			if ($this->is_album_category_heading($row, $root_album_id))
			{
				$current_group = (int) $album_id;
				$groups[$current_group] = [];
				continue;
			}

			if ((int) $row['parent_id'] === $root_album_id)
			{
				$current_group = 0;
			}

			$groups[$current_group][$album_id] = $row;
		}

		$limit = max(0, $this->album_limit);
		$selected_ids = [];
		$total = 0;
		foreach ($groups as $category_id => $rows)
		{
			$group_total = count($rows);
			$total += $group_total;

			if ($category_id === 0)
			{
				$this->album_root_total = $group_total;
				$start = max(0, $this->album_start);
			}
			else
			{
				$param = 'category_page_' . $category_id;
				$page = 1;
				if (isset($this->request))
				{
					$page = max(1, $this->request->variable($param, 1));
				}
				if ($limit > 0 && $group_total > 0)
				{
					$page = min($page, (int) ceil($group_total / $limit));
				}
				else
				{
					$page = 1;
				}
				$start = $limit > 0 ? ($page - 1) * $limit : 0;
				$this->category_pagination[$category_id] = [
					'param' => $param,
					'page' => $page,
					'start' => $start,
					'total' => $group_total,
				];
			}

			$group_ids = array_keys($rows);
			if ($limit > 0)
			{
				$group_ids = array_slice($group_ids, $start, $limit);
			}
			foreach ($group_ids as $album_id)
			{
				$selected_ids[(int) $album_id] = true;
			}
		}

		$selected = [];
		foreach ($album_rows as $album_id => $row)
		{
			if ($this->is_album_category_heading($row, $root_album_id)
				|| isset($selected_ids[(int) $album_id]))
			{
				$selected[$album_id] = $row;
			}
		}

		return [$selected, $total];
	}

	/** Add a nested phpBB pagination block to the current category heading. */
	protected function generate_category_pagination(string $block_name, array $pagination): void
	{
		if (empty($this->category_pagination_base_url))
		{
			return;
		}

		$base_url = $this->category_pagination_base_url;
		$params = $base_url['params'] ?? [];
		$params = array_merge($params, $this->category_page_params());
		unset($params[$pagination['param']]);
		$base_url['params'] = $params;

		$this->pagination->generate_template_pagination(
			$base_url,
			$block_name . '.pagination',
			$pagination['param'],
			$pagination['total'],
			max(1, $this->album_limit),
			$pagination['start']
		);
	}

	/** Whether a row is a direct category heading rather than a paginated album card. */
	protected function is_album_category_heading(array $row, int $root_album_id): bool
	{
		return (int) $row['parent_id'] === $root_album_id
			&& (int) $row['album_type'] === (int) \phpbbgallery\core\block::TYPE_CAT;
	}

	/**
	 * Keep only albums whose complete same-owner parent chain is visible.
	 *
	 * @param array $rows          Ordered album rows
	 * @param array $listable      Album IDs granted by the Gallery ACL
	 * @param array $zebra_array   Friendship state for the current viewer
	 * @param int   $root_album_id Root outside the selected result set
	 * @return array Visible rows with no orphaned descendants
	 */
	protected function filter_visible_hierarchy_rows(array $rows, array $listable, array $zebra_array, int $root_album_id): array
	{
		$listable_lookup = array_fill_keys(array_map('intval', $listable), true);
		$visible_album_ids = [];
		$visible_rows = [];

		foreach ($rows as $row)
		{
			$album_id = (int) $row['album_id'];
			$owner_id = (int) $row['album_user_id'];
			$parent_id = (int) $row['parent_id'];
			$parent_is_visible = $parent_id === $root_album_id
				|| isset($visible_album_ids[$owner_id][$parent_id]);

			if (!$parent_is_visible
				|| !isset($listable_lookup[$album_id])
				|| $this->gallery_auth->get_zebra_state($zebra_array, $owner_id, $album_id) < (int) $row['album_auth_access'])
			{
				continue;
			}

			$visible_album_ids[$owner_id][$album_id] = true;
			$visible_rows[] = $row;
		}

		return $visible_rows;
	}

	/**
	 * Resolve the displayed card that owns an album without crossing owners.
	 *
	 * @param array $row           Visible album row
	 * @param int   $root_album_id Root outside the selected result set
	 * @param array $owner_states  Mutable display state isolated by owner ID
	 * @return int|false Album card ID, or false when no safe card exists
	 */
	protected function resolve_album_display_parent(array $row, int $root_album_id, array &$owner_states): int|false
	{
		$album_id = (int) $row['album_id'];
		$owner_id = (int) $row['album_user_id'];
		$parent_id = (int) $row['parent_id'];

		if (!isset($owner_states[$owner_id]))
		{
			$owner_states[$owner_id] = [
				'card_id' => 0,
				'branch_root_id' => $root_album_id,
			];
		}

		if ($parent_id === $root_album_id || $parent_id === $owner_states[$owner_id]['branch_root_id'])
		{
			$owner_states[$owner_id]['card_id'] = $album_id;
			if (!(int) $row['album_type'] && $parent_id === $root_album_id)
			{
				$owner_states[$owner_id]['branch_root_id'] = $album_id;
			}

			return $album_id;
		}

		return $owner_states[$owner_id]['card_id'] > 0
			? (int) $owner_states[$owner_id]['card_id']
			: false;
	}
}
