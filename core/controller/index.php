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

namespace phpbbgallery\core\controller;

class index
{
	/** @var \phpbb\auth\auth */
	protected \phpbb\auth\auth $auth;

	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\request\request */
	protected \phpbb\request\request $request;

	/** @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language  */
	protected \phpbb\language\language $language;

	/** @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\album\display */
	protected \phpbbgallery\core\album\display $display;

	/** @var \phpbbgallery\core\config  */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\auth\auth  */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\search  */
	protected \phpbbgallery\core\search $gallery_search;

	/** @var \phpbb\pagination  */
	protected \phpbb\pagination $pagination;

	/** @var \phpbb\event\dispatcher_interface */
	protected \phpbb\event\dispatcher_interface $dispatcher;

	/** @var \phpbbgallery\core\notification\helper */
	protected \phpbbgallery\core\notification\helper $notifications_helper;

	/** @var string */
	protected string $table_albums;

	/** @var string */
	protected string $root_path;

	/** @var string */
	protected string $php_ext;

	public const RRC_MODE_RECENT_COMMENTS = 4;
	public const RRC_MODE_RANDOM_IMAGES   = 2;
	public const RRC_MODE_RECENT_IMAGES   = 1;
	public const RRC_MODE_MOST_VIEWED     = 8;
	public const RRC_MODE_TOP_RATED       = 16;
	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                                          $auth      Auth object
	 * @param \phpbb\config\config                                      $config    Config object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db        Database object
	 * @param \phpbb\request\request                                    $request   Request object
	 * @param \phpbb\template\template                                  $template  Template object
	 * @param \phpbb\user                                               $user      User object
	 * @param \phpbb\language\language                                  $language
	 * @param \phpbb\controller\helper                                  $helper    Controller helper object
	 * @param \phpbbgallery\core\album\display                          $display   Albums display object
	 * @param \phpbbgallery\core\config                                 $gallery_config
	 * @param \phpbbgallery\core\auth\auth                              $gallery_auth
	 * @param \phpbb\pagination                                         $pagination
	 * @param \phpbbgallery\core\search                                 $gallery_search
	 * @param \phpbb\event\dispatcher_interface                        $dispatcher
	 * @param \phpbbgallery\core\notification\helper                   $notifications_helper
	 * @param string                                                    $table_albums
	 * @param string                                                    $root_path Root path
	 * @param string                                                    $php_ext   php file extension
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language,
		\phpbb\controller\helper $helper, \phpbbgallery\core\album\display $display, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\search $gallery_search, \phpbb\pagination $pagination,
		\phpbb\event\dispatcher_interface $dispatcher, \phpbbgallery\core\notification\helper $notifications_helper,
		string $table_albums, string $root_path, string $php_ext)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->display = $display;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_search = $gallery_search;
		$this->pagination = $pagination;
		$this->dispatcher = $dispatcher;
		$this->notifications_helper = $notifications_helper;
		$this->table_albums = $table_albums;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Index Controller
	*	Route: gallery
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function base(): \Symfony\Component\HttpFoundation\Response
	{
		// Display login box for guests and an error for users
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$get_albums = $this->gallery_auth->acl_album_ids('a_list');
		if (empty($get_albums) && !$this->user->data['is_registered'])
		{
			login_box();
		}
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$show_personal_albums = (bool) $this->gallery_config->get('pegas_index_album');
		$album_limit = max(1, (int) $this->gallery_config->get('albums_per_page'));
		$public_page = $this->normalize_page($this->request->variable('public_page', 1));
		$personal_page = $this->normalize_page($this->request->variable('personal_page', 1));
		$this->template->assign_vars([
			'GALLERY_INDEX_ALBUM_LAYOUT' => $this->gallery_config->get_index_album_layout(),
			'GALLERY_PUBLIC_ALBUMS_LABEL' => $this->language->lang($show_personal_albums ? 'PUBLIC_ALBUMS' : 'ALBUMS'),
			'S_AJAX_LIST_NAVIGATION' => (bool) $this->gallery_config->get('ajax_list_navigation'),
			'S_SHOW_PERSONAL_ALBUMS' => $show_personal_albums,
		]);

		$category_base_params = [];
		if ($public_page > 1)
		{
			$category_base_params['public_page'] = $public_page;
		}
		if ($personal_page > 1)
		{
			$category_base_params['personal_page'] = $personal_page;
		}
		$this->display->configure_category_pagination([
			'routes' => ['phpbbgallery_core_index', 'phpbbgallery_core_index'],
			'params' => $category_base_params,
		]);
		$this->display->album_start = ($public_page - 1) * $album_limit;
		$this->display->album_limit = $album_limit;
		$this->display->display_albums(false, $this->config['load_moderators'], false, 'public_albumrow');
		$public_total = $this->display->album_root_total;
		$public_visible_total = $this->display->albums_total;
		$public_has_rows = $this->display->has_album_rows;
		$public_pagination_params = $this->display->category_page_params();
		if ($personal_page > 1)
		{
			$public_pagination_params['personal_page'] = $personal_page;
		}
		$this->pagination->generate_template_pagination([
			'routes' => ['phpbbgallery_core_index', 'phpbbgallery_core_index'],
			'params' => $public_pagination_params,
		], 'public_pagination', 'public_page', $public_total, $album_limit, $this->display->album_start);

		$personal_total = 0;
		if ($show_personal_albums)
		{
			$this->display->disable_category_pagination();
			$this->display->album_start = ($personal_page - 1) * $album_limit;
			$this->display->album_limit = $album_limit;
			$this->display->display_albums('personal', $this->config['load_moderators'], false, 'personal_albumrow');
			$personal_total = $this->display->albums_total;
			$personal_pagination_params = $public_pagination_params;
			unset($personal_pagination_params['personal_page']);
			if ($public_page > 1)
			{
				$personal_pagination_params['public_page'] = $public_page;
			}
			$this->pagination->generate_template_pagination([
				'routes' => ['phpbbgallery_core_index', 'phpbbgallery_core_index'],
				'params' => $personal_pagination_params,
			], 'personal_pagination', 'personal_page', $personal_total, $album_limit, $this->display->album_start);
		}

		$this->template->assign_vars([
			'PUBLIC_ALBUM_TOTAL' => $public_total > 0
				? $public_total . ' ' . $this->language->lang($public_total === 1 ? 'ALBUM' : 'ALBUMS')
				: '',
			'PERSONAL_ALBUM_TOTAL' => $this->language->lang('TOTAL_PEGAS_SHORT_SPRINTF', $personal_total),
			'S_HAS_PUBLIC_ALBUMS' => $public_has_rows || $public_visible_total > 0,
			'S_HAS_PERSONAL_ALBUMS' => $personal_total > 0,
		]);
		$config_value = (int) $this->gallery_config->get('rrc_gindex_mode');
		if ($config_value)
		{
			$recent_comments = ($config_value & self::RRC_MODE_RECENT_COMMENTS) !== 0;
			$random_images   = ($config_value & self::RRC_MODE_RANDOM_IMAGES) !== 0;
			$recent_images   = ($config_value & self::RRC_MODE_RECENT_IMAGES) !== 0;
			$most_viewed     = ($config_value & self::RRC_MODE_MOST_VIEWED) !== 0;
			$top_rated       = ($config_value & self::RRC_MODE_TOP_RATED) !== 0;

			// Now before build random and recent ... let's check if we have images that can build it
			if ($recent_images)
			{
				$this->template->assign_vars([
					'U_RECENT'	=> true,
				]);
				$this->gallery_search->recent($this->gallery_config->get('pegas_index_rct_count'), -1);
			}
			if ($random_images)
			{
				$this->template->assign_vars([
					'U_RANDOM'	=> true,
				]);
				$this->gallery_search->random($this->gallery_config->get('pegas_index_rnd_count'));
			}
			if ($most_viewed)
			{
				$this->gallery_search->featured(
					(int) $this->gallery_config->get('pegas_index_viewed_count'),
					'most_viewed',
					null,
					false
				);
			}
			if ($top_rated && $this->gallery_config->get('allow_rates'))
			{
				$this->gallery_search->featured(
					(int) $this->gallery_config->get('pegas_index_rated_count'),
					'top_rated',
					null,
					false
				);
			}
			if ($recent_comments)
			{
				$this->template->assign_vars([
					'U_RECENT_COMMENTS'	=> true,
					'S_RECENT_COMMENTS' => $this->helper->route('phpbbgallery_core_search_commented'),
					'COLLAPSE_COMMENTS'	=> (bool) $this->gallery_config->get('rrc_gindex_comments'),
				]);
				$this->gallery_search->recent_comments($this->gallery_config->get('items_per_page'), 0, false);
			}

		}

		/**
		 * Allow add-ons to render additional permission-filtered image blocks.
		 * This event also runs when every built-in Gallery-index block is disabled.
		 *
		 * @event phpbbgallery.core.index.image_blocks
		 * @var int config_value Selected Gallery-index mode bitmask
		 * @since 4.1.0
		 * @changed 4.2.0 Always dispatched
		 */
		$vars = ['config_value'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.index.image_blocks',
			compact($vars)
		));
		$this->display_legend();
		$this->display_birthdays();
		$this->assign_dropdown_links('phpbbgallery_core_index', $show_personal_albums);
		$this->assign_watch_all_link($show_personal_albums);

		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);

		return $this->helper->render('gallery/index_body.html', $this->gallery_config->get_title($this->language), 200, $this->gallery_config->get('disp_whoisonline'));
	}

	/**
	 * Personal Index Controller
	 *    Route: gallery/users
	 *
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function personal(int $page): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);

		// Display login box for guests and an error for users
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$get_albums = $this->gallery_auth->acl_album_ids('a_list');
		if (empty($get_albums) && !$this->user->data['is_registered'])
		{
			login_box();
		}
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$album_limit = max(1, (int) $this->gallery_config->get('items_per_page'));
		$this->template->assign_vars([
			'GALLERY_INDEX_ALBUM_LAYOUT' => $this->gallery_config->get_index_album_layout(),
			'S_AJAX_LIST_NAVIGATION' => (bool) $this->gallery_config->get('ajax_list_navigation'),
			'S_PERSONAL_GALLERY' => true,
		]);
		$this->display->album_start = ($page - 1) * $album_limit;
		$this->display->album_limit = $album_limit;
		$this->display->album_mode = 'personal';
		$this->display->display_albums('personal', $this->config['load_moderators']);
		$first_char = $this->request->variable('first_char', '');

		$this->pagination->generate_template_pagination([
			'routes' => [
				'phpbbgallery_core_personal',
				'phpbbgallery_core_personal_page',],
				'params' => $first_char !== '' ? ['first_char' => $first_char] : []], 'pagination', 'page', $this->display->albums_total, $this->display->album_limit, $this->display->album_start
		);

		$this->template->assign_vars([
			'TOTAL_ALBUMS'	=> $this->language->lang('TOTAL_PEGAS_SHORT_SPRINTF', $this->display->albums_total),
		]);

		$this->assign_dropdown_links('phpbbgallery_core_personal');

		$s_char_options = '<option value=""' . ((!$first_char) ? ' selected="selected"' : '') . '>' . $this->user->lang('ALL') . '</option>';
		// Loop the ASCII: a-z
		for ($i = 97; $i < 123; $i++)
		{
			$s_char_options .= '<option value="' . chr($i) . '"' . (($first_char == chr($i)) ? ' selected="selected"' : '') . '>' . chr($i - 32) . '</option>';
		}
		$s_char_options .= '<option value="other"' . (($first_char == 'other') ? ' selected="selected"' : '') . '>#</option>';

		$this->template->assign_vars([
			'S_CHAR_OPTIONS'				=> $s_char_options,
		]);

		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('PERSONAL_ALBUMS'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_personal'),
		]);

		return $this->helper->render('gallery/index_body.html', $this->language->lang('PERSONAL_ALBUMS'));
	}

	/**
	 * Subscribe to or unsubscribe from every currently visible album.
	 *
	 * @param string $mode subscribe or unsubscribe
	 * @return \Symfony\Component\HttpFoundation\Response|null
	 */
	public function watch_all(string $mode): \Symfony\Component\HttpFoundation\Response|null
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		if (!$this->can_watch_albums() || !in_array($mode, ['subscribe', 'unsubscribe'], true))
		{
			trigger_error($this->language->lang('NOT_AUTHORISED'));
		}

		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$album_ids = $this->get_watchable_album_ids((bool) $this->gallery_config->get('pegas_index_album'));
		if (!$album_ids)
		{
			trigger_error($this->language->lang('NOT_AUTHORISED'));
		}

		$confirm_key = $mode === 'subscribe' ? 'WATCH_ALL_ALBUMS_CONFIRM' : 'UNWATCH_ALL_ALBUMS_CONFIRM';
		if (confirm_box(true))
		{
			$this->update_album_subscriptions($mode, $album_ids);
			$back_link = $this->helper->route('phpbbgallery_core_index');
			meta_refresh(3, $back_link);
			$this->template->assign_var(
				'INFORMATION',
				$this->language->lang($mode === 'subscribe' ? 'WATCHING_ALL_ALBUMS' : 'UNWATCHED_ALL_ALBUMS')
			);

			return $this->helper->render(
				'gallery/message.html',
				$this->gallery_config->get_title($this->language)
			);
		}

		confirm_box(
			false,
			$this->language->lang($confirm_key),
			'',
			'confirm_body.html',
			$this->helper->route('phpbbgallery_core_index_watch_all', ['mode' => $mode])
		);
		return null;
	}

	/**
	 * Expose the appropriate bulk-subscription action on the Gallery index.
	 *
	 * @param bool $include_personal Include personal albums displayed on the index
	 * @return void
	 */
	protected function assign_watch_all_link(bool $include_personal): void
	{
		if (!$this->can_watch_albums())
		{
			return;
		}

		$album_ids = $this->get_watchable_album_ids($include_personal);
		if (!$album_ids)
		{
			return;
		}

		$watched_ids = $this->notifications_helper->get_watched_album_ids($album_ids);
		$all_watched = !array_diff($album_ids, $watched_ids);
		$mode = $all_watched ? 'unsubscribe' : 'subscribe';
		$this->template->assign_vars([
			'U_WATCH_ALL_ALBUMS' => $this->helper->route(
				'phpbbgallery_core_index_watch_all',
				['mode' => $mode]
			),
			'WATCH_ALL_ALBUMS_LABEL' => $this->language->lang(
				$all_watched ? 'UNWATCH_ALL_ALBUMS' : 'WATCH_ALL_ALBUMS'
			),
			'S_WATCHING_ALL_ALBUMS' => $all_watched,
		]);
	}

	/**
	 * Find real albums the current user may both list and view.
	 *
	 * @param bool $include_personal Include personal albums
	 * @return array<int>
	 */
	protected function get_watchable_album_ids(bool $include_personal): array
	{
		$listable = $this->gallery_auth->acl_album_ids('a_list', 'array', false, $include_personal);
		$viewable = $this->gallery_auth->acl_album_ids('i_view', 'array', false, $include_personal);
		$excluded = $this->gallery_auth->get_exclude_zebra();
		$album_ids = array_values(array_diff(array_intersect($listable, $viewable), $excluded));
		if (!$album_ids)
		{
			return [];
		}

		$watchable_ids = [];
		foreach (array_chunk($album_ids, 250) as $album_id_batch)
		{
			$sql = 'SELECT album_id
				FROM ' . $this->table_albums . '
				WHERE ' . $this->db->sql_in_set('album_id', $album_id_batch) . '
					AND album_type <> ' . (int) \phpbbgallery\core\block::TYPE_CAT;
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$watchable_ids[] = (int) $row['album_id'];
			}
			$this->db->sql_freeresult($result);
		}

		return array_values(array_unique($watchable_ids));
	}

	/**
	 * Keep bulk subscription queries bounded on large galleries.
	 *
	 * @param string     $mode      subscribe or unsubscribe
	 * @param array<int> $album_ids Album identifiers
	 * @return void
	 */
	protected function update_album_subscriptions(string $mode, array $album_ids): void
	{
		foreach (array_chunk($album_ids, 250) as $album_id_batch)
		{
			if ($mode === 'subscribe')
			{
				$this->notifications_helper->add_albums($album_id_batch);
			}
			else
			{
				$this->notifications_helper->remove_albums($album_id_batch);
			}
		}
	}

	/**
	 * Check whether the current identity may create Gallery subscriptions.
	 */
	protected function can_watch_albums(): bool
	{
		return !empty($this->user->data['is_registered']) && empty($this->user->data['is_bot']);
	}

	protected function assign_dropdown_links(string $base_route, bool $include_personal_statistics = true): void
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		// Now let's get display options
		$show_options = (int) $this->gallery_config->get('rrc_gindex_mode');

		$show_comments = (bool) ($show_options & self::RRC_MODE_RECENT_COMMENTS);
		$show_random   = (bool) ($show_options & self::RRC_MODE_RANDOM_IMAGES);
		$show_recent   = (bool) ($show_options & self::RRC_MODE_RECENT_IMAGES);
		$can_list_personal_albums = $include_personal_statistics
			&& $this->gallery_auth->acl_check('a_list', \phpbbgallery\core\auth\auth::PERSONAL_ALBUM);
		$statistics_albums = array_intersect(
			(array) $this->gallery_auth->acl_album_ids('i_view', 'array', false, $include_personal_statistics),
			(array) $this->gallery_auth->acl_album_ids('i_statistics', 'array', false, $include_personal_statistics)
		);
		$can_view_statistics = (bool) array_diff($statistics_albums, (array) $this->gallery_auth->get_exclude_zebra());
		$show_statistics = $can_view_statistics && (bool) $this->gallery_config->get('disp_statistic');
		$this->template->assign_vars([
			'TOTAL_IMAGES'		=> $show_statistics ? $this->language->lang('TOTAL_IMAGES_SPRINTF', $this->gallery_config->get('num_images')) : '',
			'TOTAL_IMAGE_COUNT'	=> $show_statistics ? (int) $this->gallery_config->get('num_images') : false,
			'TOTAL_VIEWS'		=> $show_statistics ? $this->gallery_config->get('num_views') : false,
			'TOTAL_COMMENTS'	=> ($this->gallery_config->get('allow_comments')) ? $this->language->lang('TOTAL_COMMENTS_SPRINTF', $this->gallery_config->get('num_comments')) : '',
			'TOTAL_PGALLERIES'	=> $can_list_personal_albums ? $this->language->lang('TOTAL_PEGAS_SPRINTF', $this->gallery_config->get('num_pegas')) : '',
			'NEWEST_PGALLERIES'	=> ($can_list_personal_albums && $this->gallery_config->get('num_pegas')) ? sprintf($this->language->lang('NEWEST_PGALLERY'), '<a href="' . $this->helper->route('phpbbgallery_core_album', ['album_id' => $this->gallery_config->get('newest_pega_album_id')]) . '" '. ($this->gallery_config->get('newest_pega_user_colour') ? 'class="username-coloured" style="color: #' . $this->gallery_config->get('newest_pega_user_colour') . ';"' : 'class="username"') . '>' . $this->gallery_config->get('newest_pega_username') . '</a>') : '',
		]);

		$dropdown_links = [
			'U_MCP'		=> ($this->gallery_auth->acl_check_global('m_')) ? $this->helper->route('phpbbgallery_core_moderate') : '',
			'U_MARK_ALBUMS'					=> ($this->user->data['is_registered']) ? $this->helper->route($base_route, ['hash' => generate_link_hash('global'), 'mark' => 'albums']) : '',
			'S_LOGIN_ACTION'			=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'mode=login&amp;redirect=' . urlencode($this->helper->route($base_route))),

			'U_GALLERY_SEARCH'				=> $this->helper->route('phpbbgallery_core_search'),
			'U_GALLERY_STATISTICS'			=> $can_view_statistics ? $this->helper->route('phpbbgallery_core_statistics') : '',
			'U_G_SEARCH_COMMENTED'			=> $this->config['phpbb_gallery_allow_comments'] && $show_comments ? $this->helper->route('phpbbgallery_core_search_commented') : false,
			'U_G_SEARCH_RECENT'				=> $show_recent ? $this->helper->route('phpbbgallery_core_search_recent') : false,
			'U_G_SEARCH_RANDOM'				=> $show_random ? $this->helper->route('phpbbgallery_core_search_random') : false,
			'U_G_SEARCH_SELF'				=> $this->helper->route('phpbbgallery_core_search_egosearch'),
			'U_G_SEARCH_TOPRATED'			=> $this->config['phpbb_gallery_allow_rates'] ? $this->helper->route('phpbbgallery_core_search_toprated') : '',
		];

		/**
		 * Allow optional providers to add links to the Gallery index menu.
		 *
		 * @event phpbbgallery.core.index.dropdown_links
		 * @var array  dropdown_links Template variables for index menu links
		 * @var string base_route     Current Gallery index route
		 * @since 4.1.0
		 */
		$vars = ['dropdown_links', 'base_route'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.index.dropdown_links',
			compact($vars)
		));
		$this->template->assign_vars($dropdown_links);
	}

	protected function display_legend(): void
	{
		$order_legend = ($this->config['legend_sort_groupname']) ? 'group_name' : 'group_legend';

		// Grab group details for legend display
		if ($this->auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
		{
			$sql = 'SELECT group_id, group_name, group_colour, group_type, group_legend
				FROM ' . GROUPS_TABLE . '
				WHERE group_legend > 0
				ORDER BY ' . $order_legend . ' ASC';
		}
		else
		{
			$sql = 'SELECT g.group_id, g.group_name, g.group_colour, g.group_type, g.group_legend
				FROM ' . GROUPS_TABLE . ' g
				LEFT JOIN ' . USER_GROUP_TABLE . ' ug
					ON (
						g.group_id = ug.group_id
						AND ug.user_id = ' . $this->user->data['user_id'] . '
						AND ug.user_pending = 0
					)
				WHERE g.group_legend > 0
					AND (g.group_type <> ' . GROUP_HIDDEN . ' OR ug.user_id = ' . (int) $this->user->data['user_id'] . ')
				ORDER BY g.' . $order_legend . ' ASC';
		}
		$result = $this->db->sql_query($sql);

		$legend = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$colour_text = ($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . '"' : '';
			$group_name = ($row['group_type'] == GROUP_SPECIAL) ? $this->language->lang('G_' . $row['group_name']) : $row['group_name'];

			if ($row['group_name'] == 'BOTS' || ($this->user->data['user_id'] != ANONYMOUS && !$this->auth->acl_get('u_viewprofile')))
			{
				$legend[] = '<span' . $colour_text . '>' . $group_name . '</span>';
			}
			else
			{
				$legend[] = '<a' . $colour_text . ' href="' . append_sid($this->root_path . 'memberlist.' . $this->php_ext, 'mode=group&amp;g=' . $row['group_id']) . '">' . $group_name . '</a>';
			}
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'LEGEND'	=> implode($this->language->lang('COMMA_SEPARATOR'), $legend),
		]);
	}

	protected function display_birthdays(): void
	{
		// Generate birthday list if required ...
		if ($this->config['load_birthdays'] && $this->config['allow_birthdays'] && $this->config['phpbb_gallery_disp_birthdays'] && $this->auth->acl_gets('u_viewprofile', 'a_user', 'a_useradd', 'a_userdel'))
		{
			$this->template->assign_vars([
				'S_DISPLAY_BIRTHDAY_LIST'	=> true,
			]);

			$time = $this->user->create_datetime();
			$now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

			// Display birthdays of 29th February on 28th February in non-leap-years
			$leap_year_birthdays = '';
			if ($now['mday'] == 28 && $now['mon'] == 2 && !$time->format('L'))
			{
				$leap_year_birthdays = " OR u.user_birthday LIKE '" . $this->db->sql_escape(sprintf('%2d-%2d-', 29, 2)) . "%'";
			}

			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_birthday
				FROM ' . USERS_TABLE . ' u
				LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
				WHERE (b.ban_id IS NULL
					OR b.ban_exclude = 1)
					AND (u.user_birthday LIKE '" . $this->db->sql_escape(sprintf('%2d-%2d-', $now['mday'], $now['mon'])) . "%' $leap_year_birthdays)
					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$birthday_username	= get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
				$birthday_year		= (int) substr($row['user_birthday'], -4);
				$birthday_age		= ($birthday_year) ? max(0, $now['year'] - $birthday_year) : '';

				$this->template->assign_block_vars('birthdays', [
					'USERNAME'	=> $birthday_username,
					'AGE'		=> $birthday_age,
				]);
			}
			$this->db->sql_freeresult($result);
		}
	}

	/**
	 * Keep pagination offsets within the valid range.
	 *
	 * @param int $page Requested page number
	 * @return int Page number starting at one
	 */
	protected function normalize_page(int $page): int
	{
		return max(1, $page);
	}

}
