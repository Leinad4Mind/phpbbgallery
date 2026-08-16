<?php
/**
*
* @package phpBB Gallery Core
* @copyright (c) 2014 Lucifer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace phpbbgallery\core;

class search
{
	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/** @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\album\album */
	protected \phpbbgallery\core\album\album $album;

	/** @var \phpbbgallery\core\image\image */
	protected \phpbbgallery\core\image\image $image;

	/** @var \phpbbgallery\core\policy\image_visibility */
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;

	/** @var \phpbb\pagination */
	protected \phpbb\pagination $pagination;

	/** @var \phpbb\user_loader */
	protected \phpbb\user_loader $user_loader;

	/** @var string */
	protected string $images_table;

	/** @var string */
	protected string $albums_table;

	/** @var string */
	protected string $comments_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db       Database object
	 * @param \phpbb\template\template                                  $template Template object
	 * @param \phpbb\user                                               $user     User object
	 * @param \phpbb\language\language                                  $language
	 * @param \phpbb\controller\helper                                  $helper   Controller helper object
	 * @param config                                                    $gallery_config
	 * @param auth\auth                                                 $gallery_auth
	 * @param album\album                                               $album
	 * @param image\image                                               $image
	 * @param policy\image_visibility                                  $image_visibility
	 * @param \phpbb\pagination                                         $pagination
	 * @param \phpbb\user_loader                                        $user_loader
	 * @param string                                                    $images_table
	 * @param string                                                    $albums_table
	 * @param string                                                    $comments_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\controller\helper $helper, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\album\album $album, \phpbbgallery\core\image\image $image,
		\phpbbgallery\core\policy\image_visibility $image_visibility, \phpbb\pagination $pagination, \phpbb\user_loader $user_loader,
		string $images_table, string $albums_table, string $comments_table)
	{
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
		$this->album = $album;
		$this->image = $image;
		$this->image_visibility = $image_visibility;
		$this->pagination = $pagination;
		$this->user_loader = $user_loader;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
		$this->comments_table = $comments_table;
	}

	/**
	 * Generate random images and populate template
	 * @param int $limit How many images to generate
	 * @param int $user
	 * @param string $fields
	 * @param string|false $block_name
	 * @param string|false $u_block
	 * @param bool|null    $include_personal Override the Gallery-index personal-album setting
	 * @param bool         $show_empty       Whether an empty result should create a message block
	 */
	public function random(int $limit, int $user = 0, string $fields = 'rrc_gindex_display', string|false $block_name = false, string|false $u_block = false, ?bool $include_personal = null, bool $show_empty = true): void
	{
		// We will do small escape for not devising by 0
		if ($limit == 0)
		{
			return;
		}
		if ($limit < -1)
		{
			$limit = -1;
		}
		// Define some vars
		$images_per_page = $limit;

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		switch ($this->db->get_sql_layer())
		{
			case 'postgres':
			case 'sqlite3':
				$sql_order = 'RANDOM()';
			break;

			case 'mssql':
			case 'mssql_odbc':
				$sql_order = 'NEWID()';
			break;

			default:
				$sql_order = 'RAND()';
			break;
		}
		$sql_limit = $images_per_page;
		$sql = 'SELECT image_id
			FROM ' . $this->images_table . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;
		if ($user > 0)
		{
			$sql .= ' and image_user_id = ' . (int) $user;
			$sql .= ' AND ' . $this->image_visibility->get_visibility_sql_for_private_data(
				'',
				(int) $this->user->data['user_id'],
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		$exclude_albums = [];
		$include_personal ??= (bool) $this->gallery_config->get('rrc_gindex_pegas');
		if (!$include_personal)
		{
			$sql_no_user = 'SELECT album_id FROM ' . $this->albums_table . ' WHERE album_user_id > 0';
			$result = $this->db->sql_query($sql_no_user);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$exclude_albums[] = (int) $row['album_id'];
			}
			$this->db->sql_freeresult($result);
		}
		$exclude_albums = array_merge($exclude_albums, $this->gallery_auth->get_exclude_zebra());
		$sql .= ' AND ((' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('i_view'), $exclude_albums), false, true) . ' AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ')
					OR ' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('m_status'), $exclude_albums), false, true) . ')
			ORDER BY ' . $sql_order;

		if (!$sql_limit)
		{
			$result = $this->db->sql_query($sql);
		}
		else
		{
			$result = $this->db->sql_query_limit($sql, $sql_limit);
		}
		$id_ary = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$id_ary[] = $row['image_id'];
		}
		$this->db->sql_freeresult($result);

		$total_match_count = sizeof($id_ary);

		if (!$id_ary && !$show_empty)
		{
			return;
		}

		$this->template->assign_block_vars('imageblock', [
			'BLOCK_NAME'	=> $block_name ? $block_name : $this->language->lang('RANDOM_IMAGES'),
			'U_BLOCK'	=> $u_block ? $u_block : $this->helper->route('phpbbgallery_core_search_random'),
		]);

		// For some searches we need to print out the "no results" page directly to allow re-sorting/refining the search options.
		if (!sizeof($id_ary))
		{
			$this->template->assign_block_vars('imageblock', [
				'ERROR'	=> $this->language->lang('NO_SEARCH_RESULTS_RANDOM'),
			]);
			return;
		}

		$sql_where = $this->get_image_result_where($id_ary);

		$sql_array = [
			'SELECT'		=> 'i.*, a.album_name, a.album_status, a.album_user_id, album_id',
			'FROM'			=> [$this->images_table => 'i'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [$this->albums_table => 'a'],
					'ON'		=> 'a.album_id = i.image_album_id',
				],
			],

			'WHERE'			=> $sql_where,
			'ORDER_BY'		=> $sql_order,
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);

		$show_options = $this->gallery_config->get($fields);
		$thumbnail_link = $this->gallery_config->get('link_thumbnail');
		$imagename_link = $this->gallery_config->get('link_image_name');

		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);
		$this->assign_image_rows($rows, $show_options, $thumbnail_link, $imagename_link);
	}

	/**
	 * Get the number of recent images the user can access.
	 *
	 * @return int
	 */
	public function recent_count(): int
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		$exclude_albums = [];

		if (!$this->gallery_config->get('rrc_gindex_pegas'))
		{
			$sql_no_user = 'SELECT album_id FROM ' . $this->albums_table . ' WHERE album_user_id > 0';
			$result = $this->db->sql_query($sql_no_user);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$exclude_albums[] = (int) $row['album_id'];
			}
			$this->db->sql_freeresult($result);
		}

		$exclude_albums = array_merge($exclude_albums, $this->gallery_auth->get_exclude_zebra());

		// Get allowed album ids for view and mod permissions excluding excluded albums
		$view_album_ids = array_diff($this->gallery_auth->acl_album_ids('i_view'), $exclude_albums);
		$mod_album_ids = array_diff($this->gallery_auth->acl_album_ids('m_status'), $exclude_albums);

		if (empty($view_album_ids) && empty($mod_album_ids))
		{
			return 0;
		}

		$sql = 'SELECT COUNT(image_id) AS count
			FROM ' . $this->images_table . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;

		$conditions = [];

		if (!empty($view_album_ids))
		{
			$conditions[] = '(' . $this->db->sql_in_set('image_album_id', $view_album_ids) . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ')';
		}

		if (!empty($mod_album_ids))
		{
			$conditions[] = $this->db->sql_in_set('image_album_id', $mod_album_ids);
		}

		if (!empty($conditions))
		{
			$sql .= ' AND (' . implode(' OR ', $conditions) . ')';
		}

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($row) ? (int) $row['count'] : 0;
	}

	/**
	 * Count a member's images without exposing entries hidden by visibility providers.
	 *
	 * @param int $image_user_id Member whose images are being counted
	 * @return int
	 */
	public function user_image_count(int $image_user_id): int
	{
		$counts = $this->user_image_counts([$image_user_id]);

		return $counts[$image_user_id] ?? 0;
	}

	/**
	 * Count visible images for several members in one query.
	 *
	 * Every requested member is returned, including members with a zero count.
	 *
	 * @param array $image_user_ids Members whose images are being counted
	 * @return array<int, int> Image counts keyed by member ID
	 */
	public function user_image_counts(array $image_user_ids): array
	{
		$image_user_ids = array_values(array_unique(array_filter(array_map('intval', $image_user_ids), static fn(int $user_id): bool => $user_id > (int) ANONYMOUS)));
		if (!$image_user_ids)
		{
			return [];
		}

		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$excluded_albums = $this->gallery_auth->get_exclude_zebra();
		$viewable_albums = array_diff($this->gallery_auth->acl_album_ids('i_view'), $excluded_albums);
		$moderated_albums = array_diff($this->gallery_auth->acl_album_ids('m_status'), $excluded_albums);
		$viewer_id = (int) $this->user->data['user_id'];
		$counts = array_fill_keys($image_user_ids, 0);

		$sql = 'SELECT image_user_id, COUNT(image_id) AS count
			FROM ' . $this->images_table . '
			WHERE ' . $this->db->sql_in_set('image_user_id', $image_user_ids) . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->image_visibility->get_visibility_sql_for_private_data('', $viewer_id, $moderated_albums) . '
				AND (
					(' . $this->db->sql_in_set('image_album_id', $viewable_albums, false, true) . '
						AND (image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
							OR image_user_id = ' . $viewer_id . '))
					OR ' . $this->db->sql_in_set('image_album_id', $moderated_albums, false, true) . '
				)
			GROUP BY image_user_id';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_id = (int) $row['image_user_id'];
			if (isset($counts[$user_id]))
			{
				$counts[$user_id] = (int) $row['count'];
			}
		}
		$this->db->sql_freeresult($result);

		return $counts;
	}



	/**
	 * recent comments
	 * @param int $limit How many images to query
	 * @param int $start
	 * @param bool $pagination
	 */
	public function recent_comments(int $limit, int $start = 0, bool $pagination = true): void
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$sql_limit = $limit;
		$exclude_albums = [];
		if (!$this->gallery_config->get('rrc_gindex_pegas'))
		{
			$sql_no_user = 'SELECT album_id FROM ' . $this->albums_table . ' WHERE album_user_id > 0';
			$result = $this->db->sql_query($sql_no_user);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$exclude_albums[] = (int) $row['album_id'];
			}
			$this->db->sql_freeresult($result);
		}
		$exclude_albums = array_merge($exclude_albums, $this->gallery_auth->get_exclude_zebra());
		$sql_array = [
			'FROM' => [
				$this->images_table => 'i',
				$this->comments_table => 'c',
			],
			'WHERE'	=> 'i.image_id = c.comment_image_id and ' . $this->db->sql_in_set('image_album_id', $this->gallery_auth->acl_album_ids('c_read'), false, true),
			'ORDER_BY'	=> 'comment_time DESC'
		];
		$sql_array['WHERE'] .= ' AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
			AND ((' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('i_view'), $exclude_albums), false, true) . ' AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ')
					OR ' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('m_status'), $exclude_albums), false, true) . ')';
		$sql_array['WHERE'] .= ' AND ' . $this->image_visibility->get_visibility_sql_for_results(
			'i',
			$this->gallery_auth->acl_album_ids('m_status')
		);

		$sql_array_count = $sql_array;
		$sql_array_count['SELECT'] = 'COUNT(c.comment_id) as count';
		unset($sql_array_count['ORDER_BY']);
		$sql = $this->db->sql_build_query('SELECT', $sql_array_count);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$count = ($row) ? (int) $row['count'] : 0;

		$sql_array['SELECT'] = 'i.*, c.*';
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $sql_limit, $start);
		$rowset = [];

		$users_array = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[] = $row;
			$users_array[$row['comment_user_id']] = [''];
			$users_array[$row['image_user_id']] = [''];
		}
		$this->db->sql_freeresult($result);
		if (empty($rowset))
		{
			$this->template->assign_vars([
				'ERROR'	=> $this->language->lang('NO_SEARCH_RESULTS_RECENT_COMMENTS'),
			]);
			return;
		}

		$this->user_loader->load_users(array_keys($users_array));
		foreach ($rowset as $var)
		{
			$album_tmp = $this->album->get_info($var['image_album_id']);
			$this->template->assign_block_vars('commentrow', [
				'COMMENT_ID'	=> (int) $var['comment_id'],
				'U_DELETE'	=> ($this->gallery_auth->acl_check('m_comments', $album_tmp['album_id'], $album_tmp['album_user_id']) || ($this->gallery_auth->acl_check('c_delete', $album_tmp['album_id'], $album_tmp['album_user_id']) && ($var['comment_user_id'] == $this->user->data['user_id']) && $this->user->data['is_registered'])) ? $this->helper->route('phpbbgallery_core_comment_delete', ['image_id' => $var['comment_image_id'], 'comment_id' => $var['comment_id']]) : false,
				'U_EDIT'	=> $this->gallery_auth->acl_check('c_edit', $album_tmp['album_id'], $album_tmp['album_user_id'])? $this->helper->route('phpbbgallery_core_comment_edit', ['image_id'	=> $var['comment_image_id'], 'comment_id'	=> $var['comment_id']]) : false,
				'U_QUOTE'	=> ($this->gallery_auth->acl_check('c_post', $album_tmp['album_id'], $album_tmp['album_user_id'])) ? $this->helper->route('phpbbgallery_core_comment_add', ['image_id'	=> $var['comment_image_id'], 'comment_id'	=> $var['comment_id']]) : false,
				'U_COMMENT'	=> $this->helper->route('phpbbgallery_core_image', ['image_id' => $var['comment_image_id']]) . '#comment_' . $var['comment_id'],
				'POST_AUTHOR_FULL'	=> (string) $this->user_loader->get_username($var['comment_user_id'], 'full'),
				'TIME'	=> $this->user->format_date($var['comment_time']),
				'TEXT'	=> generate_text_for_display($var['comment'], $var['comment_uid'], $var['comment_bitfield'], 7),
				'UC_IMAGE_NAME'	=> '<a href="' . $this->helper->route('phpbbgallery_core_image', ['image_id' => $var['comment_image_id']]) . '">' . $var['image_name'] . '</a>',
				// 'UC_THUMBNAIL'		=> $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $var['image_id']]),
				'UC_THUMBNAIL'		=> $this->image->generate_link('thumbnail', $this->gallery_config->get('link_thumbnail'), $var['comment_image_id'], $var['image_name'], $var['image_album_id']),
				'IMAGE_AUTHOR'		=> $this->user_loader->get_username((int) $var['image_user_id'], 'full'),
				'IMAGE_TIME'		=> $this->user->format_date($var['image_time']),
			]);
		}
		$this->template->assign_vars([
			'SEARCH_MATCHES'	=> $this->language->lang('TOTAL_COMMENTS_SPRINTF', $count),
			'SEARCH_TITLE'		=> $this->language->lang('RECENT_COMMENTS'),
		]);
		if ($pagination)
		{
			$this->pagination->generate_template_pagination([
				'routes' => [
						'phpbbgallery_core_search_commented',
						'phpbbgallery_core_search_commented_page'
					],
					'params' => []
				], 'pagination', 'page', $count, $limit, $start
			);
		}
	}

	/**
	 * Populate one aggregated block with recent images from visible personal albums.
	 *
	 * @param int    $limit      Maximum number of images
	 * @param string $fields     Display-options configuration key
	 * @param bool   $show_empty Whether an empty result should create a message block
	 */
	public function recent_personal(int $limit, string $fields = 'rrc_gindex_display', bool $show_empty = true): void
	{
		$this->recent(
			$limit,
			-1,
			0,
			$fields,
			$this->language->lang('PERSONAL_ALBUM_IMAGES'),
			false,
			true,
			$show_empty,
			true
		);
	}

	/**
	 * Generate recent images and populate template
	 * @param int $limit How many images to query
	 * @param int $start
	 * @param int $user
	 * @param string $fields
	 * @param string|false $block_name
	 * @param string|false $u_block
	 * @param bool|null    $include_personal Override the Gallery-index personal-album setting
	 * @param bool         $show_empty       Whether an empty result should create a message block
	 * @param bool         $personal_only    Restrict results to personal albums
	 */
	public function recent(int $limit, int $start = 0, int $user = 0, string $fields = 'rrc_gindex_display', string|false $block_name = false, string|false $u_block = false, ?bool $include_personal = null, bool $show_empty = true, bool $personal_only = false): void
	{
		// We will do small escape for not devising by 0
		if ($limit == 0)
		{
			return;
		}
		if ($limit < -1)
		{
			$limit = -1;
		}
		$pagination = true;
		if ($start == -1)
		{
			$start = 0;
			$pagination = false;
		}
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$sql_order = '';
		$default_sort_key = (string) $this->gallery_config->get('default_sort_key');
		switch ($default_sort_key)
		{
			case 't':
				$sql_order = 'image_time';
				break;
			case 'n':
				$sql_order = 'image_name_clean';
				break;
			case 'vc':
				$sql_order = 'image_view_count';
				break;
			case 'u':
				$sql_order = 'image_username_clean';
				break;
			case 'ra':
				$sql_order = 'image_rate_avg';
				break;
			case 'r':
				$sql_order = 'image_rates';
				break;
			case 'c':
				$sql_order = 'image_comments';
				break;
			case 'lc':
				$sql_order = 'image_last_comment';
				break;
			default:
				$sql_order = 'image_time';
				break;
		}
		$sql_order = $sql_order . ($this->gallery_config->get('default_sort_dir') == 'd' ? ' DESC' : ' ASC');
		$sql_limit = $limit;
		$include_personal ??= (bool) $this->gallery_config->get('rrc_gindex_pegas');
		$view_album_ids = $this->gallery_auth->acl_album_ids('i_view');
		$moderator_album_ids = $this->gallery_auth->acl_album_ids('m_status');
		if ($personal_only)
		{
			$view_album_ids = array_diff($view_album_ids, $this->gallery_auth->acl_album_ids('i_view', 'array', false, false));
			$moderator_album_ids = array_diff($moderator_album_ids, $this->gallery_auth->acl_album_ids('m_status', 'array', false, false));
		}
		else if (!$include_personal)
		{
			$view_album_ids = $this->gallery_auth->acl_album_ids('i_view', 'array', false, false);
			$moderator_album_ids = $this->gallery_auth->acl_album_ids('m_status', 'array', false, false);
		}
		$excluded_albums = $this->gallery_auth->get_exclude_zebra();
		$view_album_ids = array_values(array_diff($view_album_ids, $excluded_albums));
		$moderator_album_ids = array_values(array_diff($moderator_album_ids, $excluded_albums));
		$sql_ary = [
			'FROM'	=>	[
				$this->images_table	=> 'i'
			],
			'WHERE'	=> 'image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED
		];
		if ($user > 0)
		{
			$sql_ary['WHERE'] .= ' and image_user_id = ' . (int) $user;
			$sql_ary['WHERE'] .= ' AND ' . $this->image_visibility->get_visibility_sql_for_private_data(
				'i',
				(int) $this->user->data['user_id'],
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		if ($default_sort_key === 'u' && $user <= 0)
		{
			$sql_ary['WHERE'] .= ' AND ' . $this->image_visibility->get_visibility_sql_for_private_data(
				'i',
				(int) $this->user->data['user_id'],
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		else if (in_array($default_sort_key, ['ra', 'r', 'c', 'lc'], true))
		{
			$sql_ary['WHERE'] .= ' AND ' . $this->image_visibility->get_visibility_sql_for_results(
				'i',
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		$user_id = (int) $this->user->data['user_id'];
		$sql_ary['WHERE'] .= ' AND ((' . $this->db->sql_in_set('image_album_id', $view_album_ids, false, true) . ' AND (image_status <> ' . \phpbbgallery\core\block::STATUS_UNAPPROVED . ' OR image_user_id = ' . $user_id . '))
					OR ' . $this->db->sql_in_set('image_album_id', $moderator_album_ids, false, true) . ')';

		$sql_ary['SELECT'] = 'COUNT(image_id) as count';
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$count = is_array($row) ? (int) $row['count'] : 0;

		$sql_ary['SELECT'] = 'image_id';
		$sql_ary['ORDER_BY'] = $sql_order;
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, $sql_limit, $start);
		$id_ary = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$id_ary[] = $row['image_id'];
		}

		$this->db->sql_freeresult($result);

		$total_match_count = sizeof($id_ary);

		if (!$id_ary && !$show_empty)
		{
			return;
		}

		if ($user > 0)
		{
			$this->template->assign_block_vars('imageblock', [
				'BLOCK_NAME'	=> $block_name ? $block_name : '' ,
				'U_BLOCK'	=> $u_block ? $u_block : $this->helper->route('phpbbgallery_core_search_egosearch'),
			]);
		}
		else
		{
			$this->template->assign_block_vars('imageblock', [
				'BLOCK_NAME'	=>  $block_name ? $block_name : $this->language->lang('RECENT_IMAGES'),
				'U_BLOCK'	=> $u_block ? $u_block : ($personal_only ? false : $this->helper->route('phpbbgallery_core_search_recent')),
			]);
		}

		// For some searches we need to print out the "no results" page directly to allow re-sorting/refining the search options.
		if (!sizeof($id_ary))
		{
			$this->template->assign_block_vars('imageblock', [
				'ERROR'	=> $this->language->lang('NO_SEARCH_RESULTS_RECENT')
			]);
			return;
		}

		$sql_where = $this->get_image_result_where($id_ary);

		$sql_array = [
			'SELECT'		=> 'i.*, a.album_name, a.album_status, a.album_user_id, a.album_id',
			'FROM'			=> [$this->images_table => 'i'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [$this->albums_table => 'a'],
					'ON'		=> 'a.album_id = i.image_album_id',
				],
			],

			'WHERE'			=> $sql_where,
			'ORDER_BY'		=> $sql_order,
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);

		$show_options = $this->gallery_config->get($fields);
		$thumbnail_link = $this->gallery_config->get('link_thumbnail');
		$imagename_link = $this->gallery_config->get('link_image_name');

		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);
		$this->assign_image_rows($rows, $show_options, $thumbnail_link, $imagename_link);

		if ($user > 0)
		{
			$this->template->assign_vars([
				'SEARCH_MATCHES'	=> $this->language->lang('TOTAL_IMAGES_SPRINTF', $count),
				'SEARCH_TITLE'		=> $this->language->lang('SEARCH_USER_IMAGES_OF', $this->user->data['username']),
			]);
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_search_egosearch',
					'phpbbgallery_core_search_egosearch_page',],
					'params' => []], 'pagination', 'page', $count, $limit, $start
			);
		}
		else
		{
			$this->template->assign_vars([
				'TOTAL_IMAGES'				=> $this->language->lang('VIEW_ALBUM_IMAGES', $count),
			]);
			if ($pagination)
			{
				$this->pagination->generate_template_pagination([
					'routes' => [
						'phpbbgallery_core_search_recent',
						'phpbbgallery_core_search_recent_page',],
						'params' => []], 'pagination', 'page', $count, $limit, $start
				);
			}
		}
	}

	/**
	 * Build the common filter for a normalized image result set.
	 *
	 * @param array $image_ids Image identifiers returned by the database
	 * @return string Safe SQL condition
	 */
	private function get_image_result_where(array $image_ids): string
	{
		return implode(' AND ', [
			'i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN,
			'i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED,
			$this->db->sql_in_set('i.image_id', array_map('intval', $image_ids)),
		]);
	}

	/**
	 * Populate a bounded Gallery-index block ordered by a trusted Core metric.
	 *
	 * @param int       $limit            Maximum number of images
	 * @param string    $mode             Either most_viewed or top_rated
	 * @param bool|null $include_personal Override the Gallery-index personal-album setting
	 * @param bool      $show_empty       Whether to render an empty block
	 * @return void
	 */
	public function featured(int $limit, string $mode, ?bool $include_personal = null, bool $show_empty = true): void
	{
		$limit = max(0, min(50, $limit));
		if ($limit === 0)
		{
			return;
		}

		switch ($mode)
		{
			case 'most_viewed':
				$order_by = 'i.image_view_count DESC, i.image_id DESC';
				$block_name = $this->language->lang('MOST_VIEWED_IMAGES');
				$block_url = $this->helper->route('phpbbgallery_core_search', [
					'filtered' => 1,
					'sk' => 'vc',
					'sd' => 'd',
				]);
				$require_rating = false;
				break;

			case 'top_rated':
				$order_by = 'i.image_rate_avg DESC, i.image_rates DESC, i.image_id DESC';
				$block_name = $this->language->lang('SEARCH_TOPRATED');
				$block_url = $this->helper->route('phpbbgallery_core_search_toprated');
				$require_rating = true;
				break;

			default:
				throw new \InvalidArgumentException('Unknown Gallery featured-image mode.');
		}

		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$include_personal ??= (bool) $this->gallery_config->get('rrc_gindex_pegas');
		$exclude_albums = $this->gallery_auth->get_exclude_zebra();
		if (!$include_personal)
		{
			$sql = 'SELECT album_id
				FROM ' . $this->albums_table . '
				WHERE album_user_id > 0';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$exclude_albums[] = (int) $row['album_id'];
			}
			$this->db->sql_freeresult($result);
		}

		$view_albums = array_diff($this->gallery_auth->acl_album_ids('i_view'), $exclude_albums);
		$moderated_albums = array_diff($this->gallery_auth->acl_album_ids('m_status'), $exclude_albums);
		$viewer_id = (int) $this->user->data['user_id'];
		$where = 'i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
			AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
			AND ((' . $this->db->sql_in_set('i.image_album_id', $view_albums, false, true) . '
				AND (i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
					OR i.image_user_id = ' . $viewer_id . '))
				OR ' . $this->db->sql_in_set('i.image_album_id', $moderated_albums, false, true) . ')';
		if ($require_rating)
		{
			$where .= ' AND i.image_rate_avg <> 0
				AND ' . $this->image_visibility->get_visibility_sql_for_results('i', $moderated_albums);
		}

		$sql_array = [
			'SELECT' => 'i.*, a.album_name, a.album_status, a.album_user_id, a.album_id',
			'FROM' => [$this->images_table => 'i'],
			'LEFT_JOIN' => [[
				'FROM' => [$this->albums_table => 'a'],
				'ON' => 'a.album_id = i.image_album_id',
			]],
			'WHERE' => $where,
			'ORDER_BY' => $order_by,
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $limit);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		if (!$rows && !$show_empty)
		{
			return;
		}

		$this->template->assign_block_vars('imageblock', [
			'BLOCK_NAME' => $block_name,
			'U_BLOCK' => $block_url,
		]);
		if (!$rows)
		{
			$this->template->assign_block_vars('imageblock', [
				'ERROR' => $this->language->lang('NO_SEARCH_RESULTS'),
			]);
			return;
		}

		$show_options = (int) $this->gallery_config->get('rrc_gindex_display');
		$thumbnail_link = (string) $this->gallery_config->get('link_thumbnail');
		$imagename_link = (string) $this->gallery_config->get('link_image_name');
		$this->assign_image_rows($rows, $show_options, $thumbnail_link, $imagename_link);
	}

	/**
	 * Assign a bounded image result set after optional add-ons enrich its cards.
	 *
	 * @param array  $images         Image and album rows
	 * @param int    $show_options   Bitmask of image details to display
	 * @param string $thumbnail_link Thumbnail destination mode
	 * @param string $imagename_link Image-name destination mode
	 * @return void
	 */
	private function assign_image_rows(array $images, int $show_options, string $thumbnail_link, string $imagename_link): void
	{
		$image_template_vars = $this->image->enrich_block_template_vars($images);

		foreach ($images as $row)
		{
			$image_id = (int) ($row['image_id'] ?? 0);
			$additional_vars = isset($image_template_vars[$image_id]) && is_array($image_template_vars[$image_id])
				? $image_template_vars[$image_id]
				: [];
			$this->image->assign_block('imageblock.image', $row, $show_options, $thumbnail_link, $imagename_link, $additional_vars);
		}
	}

	/**
	 * Get top rated image
	 * @param int $limit
	 * @param int $start
	 */
	public function rating(int $limit, int $start = 0): void
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$sql_array = [];
		$sql_array['FROM'] = [
			$this->images_table	=> 'i'
		];
		$sql_array['WHERE'] = $this->db->sql_in_set('image_album_id', $this->gallery_auth->acl_album_ids('i_view'), false, true) .
			' and image_rate_avg <> 0 AND ' . $this->image_visibility->get_visibility_sql_for_results(
				'i',
				$this->gallery_auth->acl_album_ids('m_status')
			);
		$sql_array['SELECT'] = 'COUNT(image_id) as count';
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$count = is_array($row) ? (int) $row['count'] : 0;
		$sql_array['SELECT'] = '* , a.album_name, a.album_status, a.album_user_id, a.album_id';
		$sql_array['LEFT_JOIN']	= [
			[
				'FROM'		=> [$this->albums_table => 'a'],
				'ON'		=> 'a.album_id = i.image_album_id',
			]
		];
		$sql_array['ORDER_BY'] = 'image_rate_avg DESC, image_rates DESC';
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$rowset = [];
		$users_array = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[] = $row;
			$users_array[$row['image_user_id']] = [''];
		}
		$this->db->sql_freeresult($result);
		if (empty($rowset))
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
			return;
		}

		$this->template->assign_block_vars('imageblock', [
			'BLOCK_NAME'	=> $this->language->lang('SEARCH_TOPRATED'),
			'U_BLOCK'	=> $this->helper->route('phpbbgallery_core_search_toprated'),
		]);
		$this->user_loader->load_users(array_keys($users_array));
		// Now let's get display options
		$show_options = $this->gallery_config->get('rrc_gindex_display');
		$thumbnail_link = $this->gallery_config->get('link_thumbnail');
		$imagename_link = $this->gallery_config->get('link_image_name');
		$this->assign_image_rows($rowset, $show_options, $thumbnail_link, $imagename_link);

		$this->template->assign_vars([
			'SEARCH_MATCHES'	=> $this->language->lang('TOTAL_IMAGES_SPRINTF', $count),
			'SEARCH_TITLE'		=> $this->language->lang('SEARCH_TOPRATED'),
		]);
		$this->pagination->generate_template_pagination([
			'routes' => [
				'phpbbgallery_core_search_toprated',
				'phpbbgallery_core_search_toprated_page',],
				'params' => []], 'pagination', 'page', $count, $limit, $start
		);
	}
}
