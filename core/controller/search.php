<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

class search
{
	/** @var \phpbb\auth\auth */
	protected \phpbb\auth\auth $auth;

	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/**
	 * Gallery Event Dispatcher
	 *
	 * @var \phpbb\event\dispatcher_interface
	 */
	protected \phpbb\event\dispatcher_interface $dispatcher;

	/** @var \phpbb\pagination  */
	protected \phpbb\pagination $pagination;

	/** @var \phpbb\request\request_interface */
	protected \phpbb\request\request_interface $request;

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

	/** @var \phpbbgallery\core\album\album  */
	protected \phpbbgallery\core\album\album $album;

	/** @var \phpbbgallery\core\image\image  */
	protected \phpbbgallery\core\image\image $image;

	/** @var \phpbbgallery\core\url  */
	protected \phpbbgallery\core\url $url;

	/** @var \phpbbgallery\core\search  */
	protected \phpbbgallery\core\search $gallery_search;

	/** @var \phpbbgallery\core\policy\image_visibility */
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;

	/** @var string */
	protected string $images_table;

	/** @var string */
	protected string $albums_table;

	/** @var string */
	protected string $comments_table;

	/** @var string */
	protected string $root_path;

	/** @var string */
	protected string $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                                          $auth      Auth object
	 * @param \phpbb\config\config                                      $config    Config object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db        Database object
	 * @param \phpbb\event\dispatcher_interface                        $dispatcher
	 * @param \phpbb\pagination                                         $pagination
	 * @param \phpbb\request\request_interface                          $request   Request object
	 * @param \phpbb\template\template                                  $template  Template object
	 * @param \phpbb\user                                               $user      User object
	 * @param \phpbb\language\language                                  $language
	 * @param \phpbb\controller\helper                                  $helper    Controller helper object
	 * @param \phpbbgallery\core\album\display                          $display   Albums display object
	 * @param \phpbbgallery\core\config                                 $gallery_config
	 * @param \phpbbgallery\core\auth\auth                              $gallery_auth
	 * @param \phpbbgallery\core\album\album                            $album
	 * @param \phpbbgallery\core\image\image                            $image
	 * @param \phpbbgallery\core\url                                    $url
	 * @param \phpbbgallery\core\search                                 $gallery_search
	 * @param \phpbbgallery\core\policy\image_visibility               $image_visibility
	 * @param string                                                    $images_table
	 * @param string                                                    $albums_table
	 * @param string                                                    $comments_table
	 * @param string                                                    $root_path Root path
	 * @param string                                                    $php_ext   php file extension
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\pagination $pagination, \phpbb\request\request_interface $request,
		\phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language, \phpbb\controller\helper $helper,
		\phpbbgallery\core\album\display $display, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\album\album $album, \phpbbgallery\core\image\image $image,
		\phpbbgallery\core\url $url, \phpbbgallery\core\search $gallery_search,
		\phpbbgallery\core\policy\image_visibility $image_visibility,
		string $images_table, string $albums_table, string $comments_table, string $root_path, string $php_ext)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->dispatcher = $dispatcher;
		$this->pagination = $pagination;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->display = $display;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
		$this->album = $album;
		$this->image = $image;
		$this->url = $url;
		$this->gallery_search = $gallery_search;
		$this->image_visibility = $image_visibility;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
		$this->comments_table = $comments_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->template->assign_var('GALLERY_INDEX_ALBUM_LAYOUT', $this->gallery_config->get_index_album_layout());
	}

	/**
	 * Index Controller
	 *    Route: gallery/search/{page}
	 *
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */

	public function base(int $page = 1): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$search_id		= $this->request->variable('search_id', '');

		$submit			= $this->request->variable('submit', false);
		$keywords		= utf8_normalize_nfc($this->request->variable('keywords', '', true));
		$add_keywords	= utf8_normalize_nfc($this->request->variable('add_keywords', '', true));
		$username		= $this->request->variable('username', '', true);
		$user_id			= $this->normalize_id_filter($this->request->variable('user_id', [0]));
		$search_terms	= $this->request->variable('terms', 'all');
		$search_album	= $this->normalize_id_filter($this->request->variable('aid', [0]));
		$search_child	= $this->request->variable('sc', true);
		$search_fields	= $this->request->variable('sf', 'all');
		$sort_days		= $this->request->variable('st', 0);
		$sort_key		= $this->request->variable('sk', 't');
		$sort_dir		= $this->request->variable('sd', 'd');
		$filtered		= $this->request->variable('filtered', false);

		$start 			= ($page - 1) * $this->gallery_config->get('items_per_page');
		if ($filtered)
		{
			$submit = true;
		}
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'   => $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'   => $this->language->lang('SEARCH'),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_vars([
			'S_SEARCH_ACTION'                 => $this->helper->route('phpbbgallery_core_search'),
			'U_SEARCH_AUTHOR_AUTOCOMPLETE'   => $this->helper->route('phpbbgallery_core_search_author_autocomplete'),
		]);
		// Is user able to search? Has search been disabled?
		if (!$this->auth->acl_get('u_search') || !$this->config['load_search'])
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}
		/**
		* Build the sort options
		*/
		$limit_days = [0 => $this->language->lang('ALL_IMAGES'), 1 => $this->language->lang('1_DAY'), 7 => $this->language->lang('7_DAYS'), 14 => $this->language->lang('2_WEEKS'), 30 => $this->language->lang('1_MONTH'), 90 => $this->language->lang('3_MONTHS'), 180 => $this->language->lang('6_MONTHS'), 365 => $this->language->lang('1_YEAR')];
		$sort_by_text = ['t' => $this->language->lang('TIME'), 'n' => $this->language->lang('IMAGE_NAME'), 'u' => $this->language->lang('SORT_USERNAME'), 'vc' => $this->language->lang('GALLERY_VIEWS')];
		$sort_by_sql = ['t' => 'image_time', 'n' => 'image_name_clean', 'u' => 'image_username_clean', 'vc' => 'image_view_count'];

		if ($this->gallery_config->get('allow_rates'))
		{
			$sort_by_text['ra'] = $this->language->lang('RATING');
			$sort_by_sql['ra'] = 'image_rate_points';
			$sort_by_text['r'] = $this->language->lang('RATES_COUNT');
			$sort_by_sql['r'] = 'image_rates';
		}
		if ($this->gallery_config->get('allow_comments'))
		{
			$sort_by_text['c'] = $this->language->lang('COMMENTS');
			$sort_by_sql['c'] = 'image_comments';
			$sort_by_text['lc'] = $this->language->lang('NEW_COMMENT');
			$sort_by_sql['lc'] = 'image_last_comment';
		}
		$search_sort_joins = [];
		/**
		 * Allow add-ons to provide indexed sort methods for Gallery searches.
		 *
		 * @event phpbbgallery.core.search.sort_options
		 * @var string sort_key          Requested sort key before validation
		 * @var array  sort_by_text      Sort-key labels
		 * @var array  sort_by_sql       Sort-key SQL expressions
		 * @var array  search_sort_joins Portable DBAL LEFT JOIN definitions
		 * @since 4.1.0
		 */
		$vars = ['sort_key', 'sort_by_text', 'sort_by_sql', 'search_sort_joins'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.search.sort_options',
			compact($vars)
		));
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$moderated_album_ids = $this->gallery_auth->acl_album_ids('m_status');

		$additional_search_active = false;
		$additional_search_where = [];
		$additional_search_params = [];
		/**
		 * Allow add-ons to contribute an independently validated image-search
		 * condition and retain its request values across pagination.
		 *
		 * @event phpbbgallery.core.search.configure
		 * @var bool  additional_search_active Whether the add-on supplied a search criterion
		 * @var array additional_search_where  Portable SQL conditions applied to image alias i
		 * @var array additional_search_params Request parameters retained by pagination
		 * @since 3.4.0
		 */
		$vars = ['additional_search_active', 'additional_search_where', 'additional_search_params'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.search.configure', compact($vars)));

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		if (!isset($sort_by_sql[$sort_key]))
		{
			$sort_key = 't';
		}
		$sql_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		// We will build SQL array and then build query (easily change count with rq)
		$sql_array = $sql_where = [];
		$sql_array['FROM'] = [
			$this->images_table => 'i',
		];
		if ($search_sort_joins)
		{
			$sql_array['LEFT_JOIN'] = $search_sort_joins;
		}
		if ($keywords || $username || $user_id || $search_id || $submit || $additional_search_active)
		{
			$user_id_ary = [];
			$private_data_sql = $this->image_visibility->get_visibility_sql_for_private_data(
				'i',
				(int) $this->user->data['user_id'],
				$moderated_album_ids
			);
			$results_sql = $this->image_visibility->get_visibility_sql_for_results('i', $moderated_album_ids);
			// Let's resolve username to user id ... or array of them.
			if ($username)
			{
				if ((strpos($username, '*') !== false) && (utf8_strlen(str_replace(['*', '%'], '', $username)) < $this->config['min_search_author_chars']))
				{
					trigger_error(sprintf($this->language->lang('TOO_FEW_AUTHOR_CHARS'), $this->config['min_search_author_chars']));
				}
				$username_parsed = (strpos($username, '*') !== false) ? ' username_clean ' . $this->db->sql_like_expression(str_replace('*', $this->db->get_any_char(), utf8_clean_string($username))) : ' username_clean = \'' . $this->db->sql_escape(utf8_clean_string($username)) .'\'';
				$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE ' . $username_parsed . '
					AND user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')';
				$result = $this->db->sql_query_limit($sql, 100);

				$user_id_ary = [];
				while ($row = $this->db->sql_fetchrow($result))
				{
					$user_id_ary[] = (int) $row['user_id'];
				}
				$this->db->sql_freeresult($result);

				$user_id_ary[] = (int) ANONYMOUS;
				$user_id = $user_id_ary;
			}

			if (!empty($user_id))
			{
				$sql_where[] =  $this->db->sql_in_set('i.image_user_id', $user_id);
				$sql_where[] = $private_data_sql;
			}
			if ($sort_key === 'u' && empty($user_id))
			{
				$sql_where[] = $private_data_sql;
			}
			else if (in_array($sort_key, ['ra', 'r', 'c', 'lc'], true))
			{
				$sql_where[] = $results_sql;
			}
			// if we search in an existing search result just add the additional keywords. But we need to use "all search terms"-mode
			// so we can keep the old keywords in their old mode, but add the new ones as required words
			if ($add_keywords)
			{
				if ($search_terms == 'all')
				{
					$keywords .= ' ' . $add_keywords;
				}
				else
				{
					$search_terms = 'all';
					$keywords = preg_replace('#\s+#u', ' |', $keywords) . ' ' .$add_keywords;
				}
			}
			$keywords_ary = ($keywords) ? explode(' ', $keywords) : [];

			// pre-made searches
			$sql = $field = $l_search_title = $search_results = '';

			$total_match_count = 0;
			$sql_limit = 0;

			$search_query = '';

			if (is_array($keywords_ary) && !sizeof($keywords_ary) && empty($user_id) && !$additional_search_active)
			{
				trigger_error('NO_SEARCH_RESULTS');
			}

			foreach ($keywords_ary as $word)
			{
				$like_expression = $this->db->sql_like_expression(str_replace('*', $this->db->get_any_char(), $this->db->get_any_char() . mb_strtolower($word) . $this->db->get_any_char()));
				$match_search_query = 'LOWER(i.image_name) ' . $like_expression .
					' OR LOWER(i.image_subtitle) ' . $like_expression .
					' OR (' . $private_data_sql . ' AND LOWER(i.image_desc) ' . $like_expression . ')';
				$search_query .= ((!$search_query) ? '' : (($search_terms == 'all') ? ' AND ' : ' OR ')) . '(' . $match_search_query . ')';
			}
			$sql_where[] = $search_query;

			$search_album = $this->get_search_album_ids($search_album);
			$sql_where[] = $this->db->sql_in_set('i.image_album_id', $search_album);
			$sql_where[] = $this->get_image_visibility_sql();
			$sql_where = array_merge($sql_where, array_filter($additional_search_where, 'is_string'));
			$sql_array['WHERE'] = implode(' and ', array_filter($sql_where));
			$sql_array['SELECT'] = 'COUNT(i.image_id) as count';

			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$search_count = (int) ($row['count'] ?? 0);
			$this->db->sql_freeresult($result);
			if ($search_count == 0)
			{
				trigger_error('NO_SEARCH_RESULTS');
			}
			$sql_array['SELECT'] = '*, a.album_name, a.album_status, a.album_user_id, a.album_id';
			$sql_array['LEFT_JOIN'][] = [
					'FROM'		=> [$this->albums_table => 'a'],
					'ON'		=> 'a.album_id = i.image_album_id',
			];
			$sql_array['ORDER_BY'] = $sql_order;
			$sql_array['GROUP_BY'] = $sort_by_sql[$sort_key] . ', i.image_id, a.album_id';

			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query_limit($sql, $this->gallery_config->get('items_per_page'), $start);
			$rowset = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$rowset[] = $row;
			}
			$this->db->sql_freeresult($result);
			$this->template->assign_block_vars('imageblock', [
				'BLOCK_NAME'	=> '',
				'U_BLOCK'	=> $this->helper->route('phpbbgallery_core_search'),
			]);

			$show_options = $this->gallery_config->get('search_display');
			$thumbnail_link = $this->gallery_config->get('link_thumbnail');
			$imagename_link = $this->gallery_config->get('link_image_name');
			$image_template_vars = [];
			/**
			 * Allow add-ons to enrich a bounded page of visible search results.
			 *
			 * @event phpbbgallery.core.search.image_template_vars
			 * @var array images              Visible image rows on the current page
			 * @var array image_template_vars Additional variables keyed by image ID
			 * @since 4.1.0
			 */
			$vars = ['images', 'image_template_vars'];
			$images = $rowset;
			extract($this->dispatcher->trigger_event(
				'phpbbgallery.core.search.image_template_vars',
				compact($vars)
			));
			foreach ($rowset as $row)
			{
				$image_id = (int) $row['image_id'];
				$additional_vars = isset($image_template_vars[$image_id]) && is_array($image_template_vars[$image_id])
					? $image_template_vars[$image_id]
					: [];
				$this->image->assign_block('imageblock.image', $row, $show_options, $thumbnail_link, $imagename_link, $additional_vars);
			}
			$pagination_params = array_merge([
				'keywords' => $keywords,
				'username' => $username,
				'user_id' => $username !== '' ? [0] : $user_id,
				'terms' => $search_terms,
				'aid' => $search_album,
				'sc' => $search_child,
				'sf' => $search_fields,
				'st' => $sort_days,
				'sk' => $sort_key,
				'sd' => $sort_dir,
				'filtered' => true,
			], $additional_search_params);
			$search_where = (string) $sql_array['WHERE'];
			$search_params = $pagination_params;
			/**
			 * Allow add-ons to derive permission-preserving facets from the
			 * final image result set before the results template is rendered.
			 *
			 * @event phpbbgallery.core.search.results
			 * @var string search_where  Final DBAL SQL condition for image alias i
			 * @var int    search_count  Number of matching visible images
			 * @var array  search_params Validated parameters retained by pagination
			 * @since 3.4.0
			 */
			$vars = ['search_where', 'search_count', 'search_params'];
			$this->dispatcher->trigger_event('phpbbgallery.core.search.results', compact($vars));
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_search',
					'phpbbgallery_core_search_page',
				],
				'params' => $pagination_params,
			], 'pagination', 'page', $search_count, $this->gallery_config->get('items_per_page'), $start);

			$this->template->assign_vars([
				'SEARCH_MATCHES'              => $this->language->lang('FOUND_SEARCH_MATCHES', $search_count),
				'SEARCH_KEYWORDS_VALUE'       => $keywords,
				'SEARCH_AUTHOR_VALUE'         => $username,
				'SEARCH_IN_RESULTS'            => true,
				'S_SELECT_SORT_DIR'            => $s_sort_dir,
				'S_SELECT_SORT_KEY'            => $s_sort_key,
				'S_SELECT_SORT_DAYS'           => $s_limit_days,
				'S_SEARCH_RESULT_HIDDEN_FIELDS' => build_hidden_fields(array_merge($pagination_params, $this->search_context_params())),
				'S_SEARCH_SORT_HIDDEN_FIELDS' => build_hidden_fields(array_merge(
					array_diff_key($pagination_params, ['sk' => true, 'sd' => true]),
					$this->search_context_params()
				)),
			]);
			return $this->helper->render('gallery/search_results.html', $this->gallery_config->get_title($this->language));
		}
		$s_albums = $this->album->get_albumbox(false, false, false, 'i_view');
		$s_hidden_fields = $this->search_context_params();
		$this->template->assign_vars([
			'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
			'S_ALBUM_OPTIONS'		=> $s_albums,
			'S_SELECT_SORT_DIR'		=> $s_sort_dir,
			'S_SELECT_SORT_KEY'		=> $s_sort_key,
			'S_SELECT_SORT_DAYS'	=> $s_limit_days,
			'S_IN_SEARCH'			=> true,
		]);
		return $this->helper->render('gallery/search_body.html', $this->gallery_config->get_title($this->language));
	}

	/**
	* Index Controller
	*	Route: gallery/search/random
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function random(): \Symfony\Component\HttpFoundation\Response
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');

		// Is user able to search? Has search been disabled?
		if (!$this->auth->acl_get('u_search') || !$this->config['load_search'])
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH_RANDOM'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search_random'),
		]);

		$this->gallery_search->random($this->gallery_config->get('items_per_page'));

		return $this->helper->render('gallery/search_random.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/search/recent/{page}
	 *
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function recent(int $page): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');

		// Is user able to search? Has search been disabled?
		if (!$this->auth->acl_get('u_search') || !$this->config['load_search'])
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH_RECENT'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search_recent'),
		]);

		$limit = $this->gallery_config->get('items_per_page');
		$start = ($page - 1) * $limit;
		$this->gallery_search->recent($limit, $start);

		return $this->helper->render('gallery/search_recent.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/search/commented/{page}
	 *
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function recent_comments(int $page): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');

		// Is user able to search? Has search been disabled?
		if (!$this->auth->acl_get('u_search') || !$this->config['load_search'])
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH_RECENT_COMMENTS'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search_commented'),
		]);

		$limit = $this->gallery_config->get('items_per_page');
		$start = ($page - 1) * $limit;

		$this->gallery_search->recent_comments($limit, $start);

		return $this->helper->render('gallery/search_results.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/search/self/{page}
	 *
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function ego_search(int $page): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');

		// Is user able to search? Has search been disabled?
		if (!$this->auth->acl_get('u_search') || !$this->config['load_search'])
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH_USER_IMAGES_OF', $this->user->data['username']),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search_egosearch'),
		]);

		$limit = $this->gallery_config->get('items_per_page');
		$start = ($page - 1) * $limit;

		$this->gallery_search->recent($limit, $start, $this->user->data['user_id']);

		return $this->helper->render('gallery/search_results.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/search/toprated/{page}
	 *
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function toprated(int $page): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');

		// Is user able to search? Has search been disabled?
		if (!$this->auth->acl_get('u_search') || !$this->config['load_search'])
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME'	=> $this->language->lang('SEARCH_TOPRATED'),
			'U_VIEW_FORUM'	=> $this->helper->route('phpbbgallery_core_search_toprated'),
		]);

		$limit = $this->gallery_config->get('items_per_page');
		$start = ($page - 1) * $limit;

		$this->gallery_search->rating($limit, $start);

		return $this->helper->render('gallery/search_results.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Keep routed page numbers inside the valid pagination range.
	 *
	 * @param int $page Requested page number
	 * @return int Normalized page number
	 */
	protected function normalize_page(int $page): int
	{
		return max(1, $page);
	}

	/**
	 * Preserve an explicitly selected style and a URL-based authenticated session
	 * when a GET search form replaces the current query string.
	 *
	 * @return array Safe request context parameters
	 */
	protected function search_context_params(): array
	{
		$params = [];
		$style = $this->request->variable('style', 0);
		if ($style > 0)
		{
			$params['style'] = $style;
		}

		$sid = $this->request->variable('sid', '');
		$session_id = (string) ($this->user->session_id ?? '');
		if ($sid !== '' && $session_id !== '' && hash_equals($session_id, $sid))
		{
			$params['sid'] = $sid;
		}

		return $params;
	}

	/**
	 * Normalize an optional request filter to unique positive identifiers.
	 *
	 * @param array $ids Submitted identifiers
	 * @return array Positive integer identifiers
	 */
	protected function normalize_id_filter(array $ids): array
	{
		$ids = array_map('intval', $ids);
		$ids = array_filter($ids, static fn (int $id): bool => $id > 0);

		return array_values(array_unique($ids));
	}

	/**
	 * Restrict a submitted album filter to albums the current user can view.
	 *
	 * @param array $requested_album_ids Submitted album identifiers
	 * @return array Allowed album identifiers
	 */
	protected function get_search_album_ids(array $requested_album_ids): array
	{
		$viewable_album_ids = $this->normalize_id_filter((array) $this->gallery_auth->acl_album_ids('i_view'));

		if (!$requested_album_ids)
		{
			return $viewable_album_ids;
		}

		return array_values(array_intersect($requested_album_ids, $viewable_album_ids));
	}

	/**
	 * Build the image-status boundary for an interactive search.
	 *
	 * Orphan uploads are never searchable. Unapproved images remain visible only
	 * to their registered uploader or to moderators of the containing album.
	 *
	 * @return string Portable DBAL SQL condition
	 */
	protected function get_image_visibility_sql(): string
	{
		$visibility = [
			'i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED,
		];

		if (!empty($this->user->data['is_registered']))
		{
			$visibility[] = 'i.image_user_id = ' . (int) $this->user->data['user_id'];
		}

		$moderated_album_ids = $this->normalize_id_filter((array) $this->gallery_auth->acl_album_ids('m_status'));
		if ($moderated_album_ids)
		{
			$visibility[] = $this->db->sql_in_set('i.image_album_id', $moderated_album_ids);
		}

		return 'i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN .
			' AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED .
			' AND (' . implode(' OR ', $visibility) . ')';
	}
}
