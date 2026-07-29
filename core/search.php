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

	/** @var string */
	protected string $contests_table;

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
	 * @param \phpbb\pagination                                         $pagination
	 * @param \phpbb\user_loader                                        $user_loader
	 * @param string                                                    $images_table
	 * @param string                                                    $albums_table
	 * @param string                                                    $comments_table
	 * @param string                                                    $contests_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\controller\helper $helper, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\album\album $album, \phpbbgallery\core\image\image $image,
		\phpbb\pagination $pagination, \phpbb\user_loader $user_loader,
		string $images_table, string $albums_table, string $comments_table, string $contests_table)
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
		$this->pagination = $pagination;
		$this->user_loader = $user_loader;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
		$this->comments_table = $comments_table;
		$this->contests_table = $contests_table;
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
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN;
		if ($user > 0)
		{
			$sql .= ' and image_user_id = ' . (int) $user;
			$sql .= ' AND ' . \phpbbgallery\core\contest::private_data_visibility_sql(
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
			'GROUP_BY'	=> 'i.image_id, a.album_name, a.album_status, a.album_user_id, a.album_id',
			'ORDER_BY'		=> $sql_order,
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);

		$show_options = $this->gallery_config->get($fields);
		$thumbnail_link = $this->gallery_config->get('link_thumbnail');
		$imagename_link = $this->gallery_config->get('link_image_name');

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->image->assign_block('imageblock.image', $row, $show_options, $thumbnail_link, $imagename_link);
		}

		$this->db->sql_freeresult($result);
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
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN;

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
	 * Count a member's images without exposing private active-contest entries.
	 *
	 * @param int $image_user_id Member whose images are being counted
	 * @return int
	 */
	public function user_image_count(int $image_user_id): int
	{
		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$excluded_albums = $this->gallery_auth->get_exclude_zebra();
		$viewable_albums = array_diff($this->gallery_auth->acl_album_ids('i_view'), $excluded_albums);
		$moderated_albums = array_diff($this->gallery_auth->acl_album_ids('m_status'), $excluded_albums);
		$viewer_id = (int) $this->user->data['user_id'];

		$sql = 'SELECT COUNT(image_id) AS count
			FROM ' . $this->images_table . '
			WHERE image_user_id = ' . (int) $image_user_id . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND ' . \phpbbgallery\core\contest::private_data_visibility_sql('', $viewer_id, $moderated_albums) . '
				AND (
					(' . $this->db->sql_in_set('image_album_id', $viewable_albums, false, true) . '
						AND (image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
							OR image_user_id = ' . $viewer_id . '))
					OR ' . $this->db->sql_in_set('image_album_id', $moderated_albums, false, true) . '
				)';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($row) ? (int) $row['count'] : 0;
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
			'GROUP_BY'	=> 'c.comment_id, c.comment_time, i.image_id',
			'ORDER_BY'	=> 'comment_time DESC'
		];
		$sql_array['WHERE'] .= ' AND ((' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('i_view'), $exclude_albums), false, true) . ' AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ')
					OR ' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('m_status'), $exclude_albums), false, true) . ')';
		$sql_array['WHERE'] .= ' AND ' . \phpbbgallery\core\contest::results_visibility_sql(
			'i',
			$this->gallery_auth->acl_album_ids('m_status')
		);

		$sql_array_count = $sql_array;
		$sql_array_count['SELECT'] = 'COUNT(c.comment_id) as count';
		unset($sql_array_count['GROUP_BY'], $sql_array_count['ORDER_BY']);
		$sql = $this->db->sql_build_query('SELECT', $sql_array_count);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$count = ($row) ? (int) $row['count'] : 0;

		$sql_array['SELECT'] = '*';
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
	 * Generate recent images and populate template
	 * @param int $limit How many images to query
	 * @param int $start
	 * @param int $user
	 * @param string $fields
	 * @param string|false $block_name
	 * @param string|false $u_block
	 * @param bool|null    $include_personal Override the Gallery-index personal-album setting
	 * @param bool         $show_empty       Whether an empty result should create a message block
	 */
	public function recent(int $limit, int $start = 0, int $user = 0, string $fields = 'rrc_gindex_display', string|false $block_name = false, string|false $u_block = false, ?bool $include_personal = null, bool $show_empty = true): void
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
		$sql_ary = [
			'FROM'	=>	[
				$this->images_table	=> 'i'
			],
			'WHERE'	=> 'image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN
		];
		if ($user > 0)
		{
			$sql_ary['WHERE'] .= ' and image_user_id = ' . (int) $user;
			$sql_ary['WHERE'] .= ' AND ' . \phpbbgallery\core\contest::private_data_visibility_sql(
				'i',
				(int) $this->user->data['user_id'],
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		if ($default_sort_key === 'u' && $user <= 0)
		{
			$sql_ary['WHERE'] .= ' AND ' . \phpbbgallery\core\contest::private_data_visibility_sql(
				'i',
				(int) $this->user->data['user_id'],
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		else if (in_array($default_sort_key, ['ra', 'r', 'c', 'lc'], true))
		{
			$sql_ary['WHERE'] .= ' AND ' . \phpbbgallery\core\contest::results_visibility_sql(
				'i',
				$this->gallery_auth->acl_album_ids('m_status')
			);
		}
		$user_id = (int) $this->user->data['user_id'];
		$sql_ary['WHERE'] .= ' AND ((' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('i_view'), $exclude_albums), false, true) . ' AND (image_status <> ' . \phpbbgallery\core\block::STATUS_UNAPPROVED . ' OR image_user_id = ' . $user_id . '))
					OR ' . $this->db->sql_in_set('image_album_id', array_diff($this->gallery_auth->acl_album_ids('m_status'), $exclude_albums), false, true) . ')';

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
				'U_BLOCK'	=> $u_block ? $u_block : $this->helper->route('phpbbgallery_core_search_recent'),
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

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->image->assign_block('imageblock.image', $row, $show_options, $thumbnail_link, $imagename_link);
		}
		$this->db->sql_freeresult($result);

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
			$this->db->sql_in_set('i.image_id', array_map('intval', $image_ids)),
		]);
	}

	/**
	 * Check whether the current user can see a completed contest with a valid winner.
	 */
	public function has_visible_contest_winners(): bool
	{
		$visible_album_ids = $this->get_visible_public_contest_album_ids();

		return $visible_album_ids !== [] && $this->count_visible_contests($visible_album_ids, time()) > 0;
	}

	/**
	 * Display completed contest winners, paginated by contest.
	 *
	 * @param int $limit Number of contests per page
	 * @param int $start Contest offset
	 */
	public function contest_winners(int $limit, int $start = 0): void
	{
		$limit = max(1, $limit);
		$start = max(0, $start);
		$visible_album_ids = $this->get_visible_public_contest_album_ids();
		$now = time();
		$count = $visible_album_ids === [] ? 0 : $this->count_visible_contests($visible_album_ids, $now);

		if ($count === 0)
		{
			trigger_error('NO_SEARCH_RESULTS');
			return;
		}

		$sql_array = [
			'SELECT' => 'c.contest_id, c.contest_album_id, c.contest_start, c.contest_end,
				c.contest_first, c.contest_second, c.contest_third, a.album_name',
			'FROM' => [
				$this->contests_table => 'c',
				$this->albums_table => 'a',
			],
			'WHERE' => $this->get_visible_contest_where($visible_album_ids, $now),
			'ORDER_BY' => 'c.contest_start + c.contest_end DESC, c.contest_id DESC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$contests = [];
		$winner_ids = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$row['contest_album_id'] = (int) $row['contest_album_id'];
			$row['contest_scheduled_end'] = (int) $row['contest_start'] + (int) $row['contest_end'];
			foreach (['contest_first', 'contest_second', 'contest_third'] as $winner_column)
			{
				$row[$winner_column] = (int) $row[$winner_column];
				if ($row[$winner_column] > 0)
				{
					$winner_ids[] = $row[$winner_column];
				}
			}
			$contests[] = $row;
		}
		$this->db->sql_freeresult($result);

		if ($contests === [])
		{
			trigger_error('NO_SEARCH_RESULTS');
			return;
		}

		$winner_rows = $this->get_valid_winner_rows($winner_ids, $visible_album_ids);
		$show_options = (int) $this->gallery_config->get('search_display');
		$thumbnail_link = (string) $this->gallery_config->get('link_thumbnail');
		$imagename_link = (string) $this->gallery_config->get('link_image_name');
		$winner_columns = [
			1 => 'contest_first',
			2 => 'contest_second',
			3 => 'contest_third',
		];

		foreach ($contests as $contest)
		{
			$album_id = (int) $contest['contest_album_id'];
			$this->template->assign_block_vars('imageblock', [
				'BLOCK_NAME' => $this->language->lang('CONTEST_WINNERS_OF', $contest['album_name']),
				'U_BLOCK' => $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]),
				'S_CONTEST_BLOCK' => true,
			]);

			$used_winner_ids = [];
			foreach ($winner_columns as $rank => $winner_column)
			{
				$image_id = (int) $contest[$winner_column];
				$is_valid = $image_id > 0
					&& isset($winner_rows[$image_id])
					&& (int) $winner_rows[$image_id]['image_album_id'] === $album_id
					&& (int) $winner_rows[$image_id]['image_contest_end'] === (int) $contest['contest_scheduled_end']
					&& !isset($used_winner_ids[$image_id]);

				if (!$is_valid)
				{
					$this->template->assign_block_vars('imageblock.image', [
						'S_CONTEST_PLACEHOLDER' => true,
						'S_CONTEST_RANK' => $rank,
					]);
					continue;
				}

				$used_winner_ids[$image_id] = true;
				$winner_rows[$image_id]['image_contest_rank'] = $rank;
				$this->image->assign_block(
					'imageblock.image',
					$winner_rows[$image_id],
					$show_options,
					$thumbnail_link,
					$imagename_link
				);
			}
		}

		$this->template->assign_vars([
			'SEARCH_MATCHES' => $this->language->lang('FOUND_SEARCH_MATCHES', $count),
			'SEARCH_TITLE' => $this->language->lang('SEARCH_CONTEST'),
			'SEARCH_IN_RESULTS' => false,
			'S_SEARCH_ACTION' => $this->helper->route('phpbbgallery_core_search_contests'),
			'U_GALLERY_SEARCH' => $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->pagination->generate_template_pagination([
			'routes' => [
				'phpbbgallery_core_search_contests',
				'phpbbgallery_core_search_contests_page',
			],
			'params' => [],
		], 'pagination', 'page', $count, $limit, $start);
	}

	/**
	 * Restrict contest discovery to visible, non-zebra, public contest albums.
	 *
	 * @return int[]
	 */
	private function get_visible_public_contest_album_ids(): array
	{
		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$viewable_album_ids = $this->normalize_ids((array) $this->gallery_auth->acl_album_ids('i_view'));
		$excluded_album_ids = $this->normalize_ids((array) $this->gallery_auth->get_exclude_zebra());
		$viewable_album_ids = array_values(array_diff($viewable_album_ids, $excluded_album_ids));

		if ($viewable_album_ids === [])
		{
			return [];
		}

		$sql = 'SELECT album_id
			FROM ' . $this->albums_table . '
			WHERE ' . $this->db->sql_in_set('album_id', $viewable_album_ids) . '
				AND album_user_id = ' . (int) \phpbbgallery\core\auth\auth::PUBLIC_ALBUM . '
				AND album_type = ' . (int) \phpbbgallery\core\block::TYPE_CONTEST . '
			ORDER BY album_id ASC';
		$result = $this->db->sql_query($sql);
		$contest_album_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contest_album_ids[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);

		return $this->normalize_ids($contest_album_ids);
	}

	/**
	 * Count completed visible contests that still have a valid winner.
	 *
	 * @param int[] $visible_album_ids Visible public contest album IDs
	 * @param int   $now               Current Unix timestamp
	 */
	private function count_visible_contests(array $visible_album_ids, int $now): int
	{
		$sql_array = [
			'SELECT' => 'COUNT(c.contest_id) AS count',
			'FROM' => [
				$this->contests_table => 'c',
				$this->albums_table => 'a',
			],
			'WHERE' => $this->get_visible_contest_where($visible_album_ids, $now),
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($row) ? (int) $row['count'] : 0;
	}

	/**
	 * Build the fail-closed completed-contest boundary.
	 *
	 * @param int[] $visible_album_ids Visible public contest album IDs
	 * @param int   $now               Current Unix timestamp
	 */
	private function get_visible_contest_where(array $visible_album_ids, int $now): string
	{
		$valid_statuses = [
			\phpbbgallery\core\block::STATUS_APPROVED,
			\phpbbgallery\core\block::STATUS_LOCKED,
		];

		return implode(' AND ', [
			'a.album_id = c.contest_album_id',
			'a.album_user_id = ' . (int) \phpbbgallery\core\auth\auth::PUBLIC_ALBUM,
			'a.album_type = ' . (int) \phpbbgallery\core\block::TYPE_CONTEST,
			$this->db->sql_in_set('c.contest_album_id', $visible_album_ids),
			'c.contest_marked = ' . (int) \phpbbgallery\core\block::NO_CONTEST,
			'c.contest_start + c.contest_end <= ' . $now,
			'EXISTS (SELECT 1
				FROM ' . $this->images_table . ' cw
				WHERE cw.image_album_id = c.contest_album_id
					AND cw.image_contest = ' . (int) \phpbbgallery\core\block::NO_CONTEST . '
					AND cw.image_contest_end = c.contest_start + c.contest_end
					AND ' . $this->db->sql_in_set('cw.image_status', $valid_statuses) . '
					AND (cw.image_id = c.contest_first
						OR cw.image_id = c.contest_second
						OR cw.image_id = c.contest_third))',
		]);
	}

	/**
	 * Load winner rows while revalidating album ownership and image status.
	 *
	 * @param int[] $winner_ids        Stored winner image IDs
	 * @param int[] $visible_album_ids Visible public contest album IDs
	 * @return array<int, array>
	 */
	private function get_valid_winner_rows(array $winner_ids, array $visible_album_ids): array
	{
		$winner_ids = $this->normalize_ids($winner_ids);
		if ($winner_ids === [])
		{
			return [];
		}

		$sql_array = [
			'SELECT' => 'i.*, a.album_name, a.album_status, a.album_user_id, a.album_id',
			'FROM' => [
				$this->images_table => 'i',
				$this->albums_table => 'a',
			],
			'WHERE' => implode(' AND ', [
				'a.album_id = i.image_album_id',
				'a.album_user_id = ' . (int) \phpbbgallery\core\auth\auth::PUBLIC_ALBUM,
				'a.album_type = ' . (int) \phpbbgallery\core\block::TYPE_CONTEST,
				'i.image_contest = ' . (int) \phpbbgallery\core\block::NO_CONTEST,
				$this->db->sql_in_set('i.image_album_id', $visible_album_ids),
				$this->db->sql_in_set('i.image_id', $winner_ids),
				$this->db->sql_in_set('i.image_status', [
					\phpbbgallery\core\block::STATUS_APPROVED,
					\phpbbgallery\core\block::STATUS_LOCKED,
				]),
			]),
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$winner_rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$winner_rows[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $winner_rows;
	}

	/**
	 * Normalize database and ACL identifier lists.
	 *
	 * @param array $ids Identifier values
	 * @return int[]
	 */
	private function normalize_ids(array $ids): array
	{
		$ids = array_map('intval', $ids);
		$ids = array_filter($ids, static fn (int $id): bool => $id > 0);

		return array_values(array_unique($ids));
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
			' and image_rate_avg <> 0 AND ' . \phpbbgallery\core\contest::results_visibility_sql(
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
		foreach ($rowset as $row)
		{
			$this->image->assign_block('imageblock.image', $row, $show_options, $thumbnail_link, $imagename_link);
		}

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
