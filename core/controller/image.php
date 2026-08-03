<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

class image
{
	/** @var \phpbb\request\request_interface */
	protected \phpbb\request\request_interface $request;

	/** @var \phpbb\auth\auth */
	protected \phpbb\auth\auth $auth;

	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\event\dispatcher_interface */
	protected \phpbb\event\dispatcher_interface $dispatcher;

	/** @var \phpbb\pagination */
	protected \phpbb\pagination $pagination;

	/** @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\profilefields\manager */
	protected \phpbb\profilefields\manager $cpf_manager;

	/** @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/** @var \phpbbgallery\core\album\display */
	protected \phpbbgallery\core\album\display $display;

	/** @var \phpbbgallery\core\album\loader */
	protected \phpbbgallery\core\album\loader $loader;

	/** @var \phpbbgallery\core\album\album */
	protected \phpbbgallery\core\album\album $album;

	/** @var \phpbbgallery\core\image\image */
	protected \phpbbgallery\core\image\image $image;

	/** @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\auth\image_authorization */
	protected \phpbbgallery\core\auth\image_authorization $image_authorization;

	/** @var \phpbbgallery\core\user */
	protected \phpbbgallery\core\user $gallery_user;

	/** @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\auth\level */
	protected \phpbbgallery\core\auth\level $auth_level;

	/** @var \phpbbgallery\core\url */
	protected \phpbbgallery\core\url $url;

	/** @var \phpbbgallery\core\misc */
	protected \phpbbgallery\core\misc $misc;

	/** @var \phpbbgallery\core\comment */
	protected \phpbbgallery\core\comment $comment;

	/** @var \phpbbgallery\core\report */
	protected \phpbbgallery\core\report $report;

	/** @var \phpbbgallery\core\notification\helper */
	protected \phpbbgallery\core\notification\helper $notification_helper;

	/** @var \phpbbgallery\core\log */
	protected \phpbbgallery\core\log $gallery_log;

	/** @var \phpbbgallery\core\moderate */
	protected \phpbbgallery\core\moderate $moderate;

	/** @var \phpbbgallery\core\rating */
	protected \phpbbgallery\core\rating $gallery_rating;

	/** @var \phpbbgallery\core\block */
	protected \phpbbgallery\core\block $block;

	/** @var \phpbbgallery\core\policy\image_visibility */
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;

	/** @var ContainerInterface */
	protected ContainerInterface $phpbb_container;

	/** @var string */
	protected string $table_comments;

	/** @var string */
	protected string $phpbb_root_path;

	/** @var string */
	protected string $php_ext;

	/** @var array */
	protected array $data = [];

	/** @var array */
	protected array $users_id_array = [];

	/** @var array */
	protected array $users_data_array = [];

	/** @var array */
	protected array $profile_fields_data = [];

	/** @var array */
	protected array $can_receive_pm_list = [];

	/** @var string */
	protected string $table_albums;

	/** @var string */
	protected string $table_images;

	/** @var string */
	protected string $table_users;

	/**
	 * Constructor
	 *
	 * @param \phpbb\request\request_interface                          $request
	 * @param \phpbb\auth\auth                                          $auth         Gallery auth object
	 * @param \phpbb\config\config                                      $config       Config object
	 * @param \phpbb\controller\helper                                  $helper       Controller helper object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db           Database object
	 * @param \phpbb\event\dispatcher_interface                         $dispatcher   Event dispatcher object
	 * @param \phpbb\pagination                                         $pagination   Pagination object
	 * @param \phpbb\template\template                                  $template     Template object
	 * @param \phpbb\user                                               $user         User object
	 * @param \phpbb\profilefields\manager                              $cpf_manager
	 * @param \phpbb\language\language                                  $language
	 * @param \phpbbgallery\core\album\display                          $display      Albums display object
	 * @param \phpbbgallery\core\album\loader                           $loader       Albums display object
	 * @param \phpbbgallery\core\album\album                            $album
	 * @param \phpbbgallery\core\image\image                            $image
	 * @param \phpbbgallery\core\auth\auth                              $gallery_auth
	 * @param \phpbbgallery\core\auth\image_authorization               $image_authorization
	 * @param \phpbbgallery\core\user                                   $gallery_user
	 * @param \phpbbgallery\core\config                                 $gallery_config
	 * @param \phpbbgallery\core\auth\level                             $auth_level   Gallery auth level object
	 * @param \phpbbgallery\core\url                                    $url
	 * @param \phpbbgallery\core\misc                                   $misc
	 * @param \phpbbgallery\core\comment                                $comment
	 * @param \phpbbgallery\core\report                                 $report
	 * @param \phpbbgallery\core\notification\helper                    $notification_helper
	 * @param \phpbbgallery\core\log                                    $gallery_log
	 * @param \phpbbgallery\core\moderate                               $moderate
	 * @param \phpbbgallery\core\rating                                 $gallery_rating
	 * @param \phpbbgallery\core\block                                  $block
	 * @param \phpbbgallery\core\policy\image_visibility                $image_visibility
	 * @param ContainerInterface                                        $phpbb_container
	 * @param string                                                    $albums_table Gallery albums table
	 * @param string                                                    $images_table Gallery images table
	 * @param string                                                    $users_table  Gallery users table
	 * @param string                                                    $table_comments
	 * @param string                                                    $phpbb_root_path
	 * @param string                                                    $php_ext
	 */
	public function __construct(\phpbb\request\request_interface $request, \phpbb\auth\auth $auth, \phpbb\config\config $config,
		\phpbb\controller\helper $helper, \phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher, \phpbb\pagination $pagination,
		\phpbb\template\template $template, \phpbb\user $user, \phpbb\profilefields\manager $cpf_manager,
		\phpbb\language\language $language, \phpbbgallery\core\album\display $display,
		\phpbbgallery\core\album\loader $loader, \phpbbgallery\core\album\album $album,
		\phpbbgallery\core\image\image $image, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\auth\image_authorization $image_authorization,
		\phpbbgallery\core\user $gallery_user, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\level $auth_level, \phpbbgallery\core\url $url, \phpbbgallery\core\misc $misc,
		\phpbbgallery\core\comment $comment, \phpbbgallery\core\report $report,
		\phpbbgallery\core\notification\helper $notification_helper, \phpbbgallery\core\log $gallery_log,
		\phpbbgallery\core\moderate $moderate, \phpbbgallery\core\rating $gallery_rating,
		\phpbbgallery\core\block $block, \phpbbgallery\core\policy\image_visibility $image_visibility,
		ContainerInterface $phpbb_container,
		string $albums_table, string $images_table, string $users_table, string $table_comments, string $phpbb_root_path, string $php_ext)
	{
		$this->request = $request;
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->db = $db;
		$this->dispatcher = $dispatcher;
		$this->pagination = $pagination;
		$this->template = $template;
		$this->user = $user;
		$this->cpf_manager = $cpf_manager;
		$this->language = $language;
		$this->display = $display;
		$this->loader = $loader;
		$this->album = $album;
		$this->image = $image;
		$this->gallery_auth = $gallery_auth;
		$this->image_authorization = $image_authorization;
		$this->gallery_user = $gallery_user;
		$this->gallery_config = $gallery_config;
		$this->auth_level = $auth_level;
		$this->url = $url;
		$this->misc = $misc;
		$this->comment = $comment;
		$this->report = $report;
		$this->notification_helper = $notification_helper;
		$this->gallery_log = $gallery_log;
		$this->moderate = $moderate;
		$this->gallery_rating = $gallery_rating;
		$this->block = $block;
		$this->image_visibility = $image_visibility;
		$this->phpbb_container = $phpbb_container;
		$this->table_albums = $albums_table;
		$this->table_images = $images_table;
		$this->table_users = $users_table;
		$this->table_comments = $table_comments;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Image Controller
	 *    Route: gallery/image_id/{image_id}
	 *
	 * @param int $image_id Image ID
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function base(int $image_id, int $page = 1): \Symfony\Component\HttpFoundation\Response
	{
		$this->reset_request_state();
		$page = max(1, $page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');

		try
		{
			$sql = 'SELECT *
			FROM ' . $this->table_images . '
			WHERE image_id = ' . (int) $image_id;
			$result = $this->db->sql_query($sql);
			$image_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!is_array($image_data))
			{
				// Image does not exist
				throw new \OutOfBoundsException('INVALID_IMAGE');
			}
			$this->data = $image_data;

			$this->loader->load($this->data['image_album_id']);
		}
		catch (\Exception $e)
		{
			throw new \phpbb\exception\http_exception(404, 'INVALID_IMAGE');
		}

		$album_id = (int) $this->data['image_album_id'];
		$album_data = $this->loader->get($album_id);
		$this->check_permissions($album_id, $album_data['album_user_id'], $this->data['image_status'], $album_data['album_auth_access'], $this->data);
		$can_moderate = $this->gallery_auth->acl_check('m_status', $album_id, $album_data['album_user_id']);
		$hide_private_data = $this->image_visibility->hides_private_data(
			$this->data,
			(int) $this->user->data['user_id'],
			$can_moderate
		);
		$hide_results = $this->image_visibility->hides_results($this->data, $can_moderate);

		$this->display->generate_navigation($album_data);

		$image_visibility_conditions = $this->get_image_visibility_conditions($album_id, (int) $album_data['album_user_id']);

		if (!$this->user->data['is_bot'] && isset($this->user->data['session_page']) && (strpos($this->user->data['session_page'], '&image_id=' . $image_id) === false || isset($this->user->data['session_created'])))
		{
			$sql = 'UPDATE ' . $this->table_images . '
				SET image_view_count = image_view_count + 1
				WHERE image_id = ' . (int) $image_id;
			$this->db->sql_query($sql);
			$this->gallery_config->inc('num_views', 1, false);
		}

		// Do stuff here
		$page_title = $this->data['image_name'];
		if ($page > 1)
		{
			$page_title .= ' - ' . $this->language->lang('PAGE_TITLE_NUMBER', $page);
		}

		$s_allowed_delete = $s_allowed_edit = $s_allowed_move = $s_allowed_status = false;
		if (($this->gallery_auth->acl_check('m_', $album_id, $album_data['album_user_id']) || ($this->data['image_user_id'] == $this->user->data['user_id'])) && ($this->user->data['user_id'] != ANONYMOUS))
		{
			$s_user_allowed = (($this->data['image_user_id'] == $this->user->data['user_id']) && ($album_data['album_status'] != 1));

			$s_allowed_delete = (($this->gallery_auth->acl_check('i_delete', $album_id, $album_data['album_user_id']) && $s_user_allowed) || $this->gallery_auth->acl_check('m_delete', $album_id, $album_data['album_user_id']));
			$s_allowed_edit = (($this->gallery_auth->acl_check('i_edit', $album_id, $album_data['album_user_id']) && $s_user_allowed) || $this->gallery_auth->acl_check('m_edit', $album_id, $album_data['album_user_id']));
			$s_allowed_move = (($this->gallery_auth->acl_check('i_move', $album_id, $album_data['album_user_id']) && $s_user_allowed) || $this->gallery_auth->acl_check('m_move', $album_id, $album_data['album_user_id']));
			$s_quick_mod = ($s_allowed_delete || $s_allowed_edit || $s_allowed_move || $this->gallery_auth->acl_check('m_status', $album_id, $album_data['album_user_id']));

			$this->language->add_lang(['gallery_mcp'], 'phpbbgallery/core');
			$this->template->assign_vars([
				'S_MOD_ACTION' => $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => (int) $image_id]),
				'S_QUICK_MOD'  => $s_quick_mod,
				'S_QM_MOVE'    => $s_allowed_move,
				'S_QM_EDIT'    => $s_allowed_edit,
				'S_QM_DELETE'  => $s_allowed_delete,
				'S_QM_REPORT'  => $this->gallery_auth->acl_check('m_report', $album_id, $album_data['album_user_id']),
				'S_QM_STATUS'  => $this->gallery_auth->acl_check('m_status', $album_id, $album_data['album_user_id']),

				'S_IMAGE_REPORTED'    => $this->data['image_reported'] ? true : false,
				'U_IMAGE_REPORTED'    => ($this->data['image_reported']) ? $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => (int) $image_id]) : '',
				'S_STATUS_APPROVED'   => ($this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_APPROVED),
				'S_STATUS_UNAPPROVED' => ($this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED),
				'S_STATUS_LOCKED'     => ($this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_LOCKED),
			]);
		}
		$image_desc = generate_text_for_display($this->data['image_desc'], $this->data['image_desc_uid'], $this->data['image_desc_bitfield'], 7);
		$image_subtitle = (string) ($this->data['image_subtitle'] ?? '');
		$image_subtitle_search_url = $this->build_subtitle_search_url($image_subtitle);
		$image_award = $this->image_visibility->award($this->data);

		// Let's see if we can get next end prev
		$sort_key = $this->request->variable('sk', ($album_data['album_sort_key']) ? $album_data['album_sort_key'] : $this->config['phpbb_gallery_default_sort_key']);
		$sort_dir = $this->request->variable('sd', ($album_data['album_sort_dir']) ? $album_data['album_sort_dir'] : $this->config['phpbb_gallery_default_sort_dir']);
		$sort_days = $this->request->variable('st', 0);

		if (in_array($sort_key, ['r', 'ra']))
		{
			$sql_help_sort = ', image_id ' . (($sort_dir == 'd') ? 'ASC' : 'DESC');
		}
		else
		{
			$sql_help_sort = ', image_id ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		}

		$limit_days = [];
		$sort_by_text = [
			't'  => $this->language->lang('TIME'),
			'n'  => $this->language->lang('IMAGE_NAME'),
			'vc' => $this->language->lang('GALLERY_VIEWS'),
			'u'  => $this->language->lang('SORT_USERNAME'),
		];
		$sort_by_sql = [
			't'  => 'image_time',
			'n'  => 'image_name_clean',
			'vc' => 'image_view_count',
			'u'  => 'image_username_clean',
		];

		if ($this->config['phpbb_gallery_allow_rates'])
		{
			$sort_by_text['ra'] = $this->language->lang('RATING');
			$sort_by_sql['ra'] = 'image_rate_points';
			$sort_by_text['r'] = $this->language->lang('RATES_COUNT');
			$sort_by_sql['r'] = 'image_rates';
		}
		if ($this->config['phpbb_gallery_allow_comments'])
		{
			$sort_by_text['c'] = $this->language->lang('COMMENTS');
			$sort_by_sql['c'] = 'image_comments';
			$sort_by_text['lc'] = $this->language->lang('NEW_COMMENT');
			$sort_by_sql['lc'] = 'image_last_comment';
		}
		if ($hide_results)
		{
			foreach (['u', 'ra', 'r', 'c', 'lc'] as $private_sort_key)
			{
				unset($sort_by_text[$private_sort_key], $sort_by_sql[$private_sort_key]);
			}
		}
		$sort_key = $this->normalize_sort_key($sort_key, $sort_by_sql);
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		$sql_sort_order .= $sql_help_sort;

		// Let's see if there is previous image
		$sql = 'SELECT *
			FROM ' . $this->table_images . '
			WHERE ' . implode(' AND ', $image_visibility_conditions) . '
			ORDER BY ' . $sql_sort_order;

		$result = $this->db->sql_query($sql);
		$images_array = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$images_array[] = $row;
		}
		$cur = 0;
		foreach ($images_array as $id => $var)
		{
			if ($var['image_id'] == $image_id)
			{
				$cur = $id;
			}
		}
		$next = $prev = false;
		if (count($images_array) > $cur + 1)
		{
			$next = [
				'image_id'   => $images_array[$cur + 1]['image_id'],
				'image_name' => $images_array[$cur + 1]['image_name'],
			];
		}
		if ($cur > 0)
		{
			$prev = [
				'image_id'   => $images_array[$cur - 1]['image_id'],
				'image_name' => $images_array[$cur - 1]['image_name'],
			];
		}
		$this->db->sql_freeresult($result);
		$display_navigation_thumbnails = (bool) $this->gallery_config->get('disp_nextprev_thumbnail');
		$next_url = $next ? $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $next['image_id']]) : '';
		$previous_url = $prev ? $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $prev['image_id']]) : '';
		$image_action = $this->get_image_action((int) $image_id, $next);

		$this->template->assign_vars([
			// Deprecated compatibility variables for third-party styles. Core styles
			// render the structured values below and therefore escape image names.
			'UC_NEXT_IMAGE' => $this->build_legacy_navigation_link($next, false, $display_navigation_thumbnails),
			'UC_PREV_IMAGE' => $this->build_legacy_navigation_link($prev, true, $display_navigation_thumbnails),
			'U_NEXT_IMAGE' => $next_url,
			'U_PREV_IMAGE' => $previous_url,
			'U_NEXT_IMAGE_THUMB' => ($next && $display_navigation_thumbnails) ? $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => (int) $next['image_id']]) : '',
			'U_PREV_IMAGE_THUMB' => ($prev && $display_navigation_thumbnails) ? $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => (int) $prev['image_id']]) : '',
			'NEXT_IMAGE_NAME' => $next ? (string) $next['image_name'] : '',
			'PREV_IMAGE_NAME' => $prev ? (string) $prev['image_name'] : '',
			'U_VIEW_ALBUM'  => $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]),
			'UC_IMAGE'      => $this->helper->route('phpbbgallery_core_image_file_medium', ['image_id' => (int) $image_id]),
			'UC_IMAGE_ACTION' => $image_action,
			'S_AJAX_IMAGE_NAVIGATION' => (bool) $this->gallery_config->get('ajax_navigation'),
			'S_IMAGE_ACTION_NEXT' => $image_action !== '' && $image_action === $next_url,

			'U_DELETE' => ($s_allowed_delete) ? $this->helper->route('phpbbgallery_core_image_delete', ['image_id' => $image_id]) : '',
			'U_EDIT'   => ($s_allowed_edit) ? $this->helper->route('phpbbgallery_core_image_edit', ['image_id' => $image_id]) : '',
			'U_REPORT' => ($this->gallery_auth->acl_check('i_report', $album_id, $album_data['album_user_id']) && ($this->data['image_user_id'] != $this->user->data['user_id'])) ? $this->helper->route('phpbbgallery_core_image_report', ['image_id' => $image_id]) : '',
			'U_STATUS' => ($s_allowed_status) ? $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $image_id]) : '',

			'IMAGE_AWARD'         => $image_award['label'],
			'IMAGE_AWARD_TITLE'   => $image_award['title'],
			'S_IMAGE_AWARD_RANK'  => $image_award['rank'],
			'IMAGE_NAME'          => $this->data['image_name'],
			'IMAGE_SUBTITLE'      => $image_subtitle,
			'U_IMAGE_SUBTITLE_SEARCH' => $image_subtitle_search_url,
			'IMAGE_DESC'          => $image_desc,
			'IMAGE_BBCODE'        => ($this->config['allow_bbcode']) ? '[' . $this->gallery_config->get_bbcode_tag() . ']' . (int) $image_id . '[/' . $this->gallery_config->get_bbcode_tag() . ']' : '',
			'IMAGE_IMGURL_BBCODE' => ($this->config['phpbb_gallery_disp_image_url']) ? '[url=' . $this->url->get_uri($this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id])) . '][img]' . $this->url->get_uri($this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id])) . '[/img][/url]' : '',
			'IMAGE_URL'           => ($this->config['phpbb_gallery_disp_image_url']) ? $this->url->get_uri($this->helper->route('phpbbgallery_core_image_file_medium', ['image_id' => $image_id])) : '',
			'IMAGE_TIME'          => $this->user->format_date($this->data['image_time']),
			'IMAGE_VIEW'          => $this->data['image_view_count'],
			'IMAGE_RESOLUTION'    => $this->get_image_resolution((string) $this->data['image_filename']),
			'POSTER_IP'           => (!$hide_private_data && $this->auth->acl_get('a_')) ? $this->data['image_user_ip'] : '',

			'S_ALBUM_ACTION' => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]),

			'U_RETURN_LINK' => $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]),
			'S_RETURN_LINK' => $this->language->lang('RETURN_TO', $album_data['album_name']),
		]);

		$image_data = $this->data;

		/**
		 * Event view image
		 *
		 * @event phpbbgallery.core.viewimage
		 * @var    int        image_id        id of the image we are viewing
		 * @var    array    image_data        All the data related to the image
		 * @var    array    album_data        All the data related to the album image is part of
		 * @var    string    page_title        Page title
		 * @var    bool      hide_private_data Whether author-related data must remain hidden
		 * @since 1.2.0
		 */
		$vars = ['image_id', 'image_data', 'album_data', 'page_title', 'hide_private_data'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.viewimage', compact($vars)));

		$this->data = $image_data;

		$hide_private_data = $hide_private_data || $this->image_visibility->hides_private_data(
			$this->data,
			(int) $this->user->data['user_id'],
			$can_moderate
		);
		if ($hide_private_data)
		{
			$this->template->assign_var('IMAGE_DESC', $this->image_visibility->private_data_description(
				$this->data,
				$album_data,
				(int) $this->user->data['user_id'],
				$can_moderate,
				$this->language->lang('GALLERY_PRIVATE_IMAGE_DESC')
			));
			$this->assign_hidden_poster($this->image_visibility->private_data_label(
				$this->data,
				(int) $this->user->data['user_id'],
				$can_moderate,
				$this->language->lang('GALLERY_PRIVATE_USER')
			));
		}
		else
		{
			$this->users_id_array[$this->data['image_user_id']] = $this->data['image_user_id'];

			$this->load_users_data();

			$user_id = $this->data['image_user_id'];
			$this->users_data_array[$user_id]['username'] = ($this->data['image_username']) ? $this->data['image_username'] : $this->language->lang('GUEST');
			$user_data = $this->users_data_array[$user_id] ?? [];
			$this->assign_image_poster_profile_fields((int) $user_id);
			$this->template->assign_vars([
				'POSTER_FULL'     => get_username_string('full', $user_id, $user_data['username'] ?? '', $user_data['user_colour'] ?? ''),
				'POSTER_COLOUR'   => get_username_string('colour', $user_id, $user_data['username'] ?? '', $user_data['user_colour'] ?? ''),
				'POSTER_USERNAME' => get_username_string('username', $user_id, $user_data['username'] ?? '', $user_data['user_colour'] ?? ''),
				'U_POSTER'        => get_username_string('profile', $user_id, $user_data['username'] ?? '', $user_data['user_colour'] ?? ''),

				'POSTER_SIGNATURE'    => $user_data['sig'] ?? '',
				'POSTER_RANK_TITLE'   => $user_data['rank_title'] ?? '',
				'POSTER_RANK_IMG'     => $user_data['rank_image'] ?? '',
				'POSTER_RANK_IMG_SRC' => $user_data['rank_image_src'] ?? '',
				'POSTER_JOINED'       => $user_data['joined'] ?? '',
				'POSTER_POSTS'        => $user_data['posts'] ?? 0,
				'POSTER_AVATAR'       => $user_data['avatar'] ?? '',
				'POSTER_WARNINGS'     => $user_data['warnings'] ?? 0,
				'POSTER_AGE'          => $user_data['age'] ?? '',

				'POSTER_ONLINE_IMG' => ($user_id == ANONYMOUS || !$this->config['load_onlinetrack']) ? '' : (($user_data['online'] ?? false) ? $this->user->img('icon_user_online', 'ONLINE') : $this->user->img('icon_user_offline', 'OFFLINE')),
				'S_POSTER_ONLINE'   => ($user_id == ANONYMOUS || !$this->config['load_onlinetrack']) ? false : (($user_data['online'] ?? false) ? true : false),

				//'U_POSTER_PROFILE'		=> $user_data['profile'] ?? '',
				'U_POSTER_SEARCH' => $user_data['search'] ?? '',
				'U_POSTER_PM'     => ($user_id != ANONYMOUS && $this->config['allow_privmsg'] && $this->auth->acl_get('u_sendpm') && (($user_data['allow_pm'] ?? false) || $this->auth->acl_gets('a_', 'm_'))) ? $this->url->append_sid('phpbb', 'ucp', 'i=pm&amp;mode=compose&amp;u=' . $user_id) : '',
				'U_POSTER_EMAIL'  => ($this->auth->acl_gets('a_') || !$this->config['board_hide_emails']) ? ($user_data['email'] ?? false) : false,
				'U_POSTER_JABBER' => $user_data['jabber'] ?? '',
			]);
		}

		// Add ratings
		if ($this->gallery_config->get('allow_rates'))
		{
			$rating = $this->gallery_rating;
			$rating->loader($image_id, $image_data, $album_data);

			$user_rating = $rating->get_user_rating($this->user->data['user_id']);

			// Check: User didn't rate yet, has permissions, it's not the users own image and the user is logged in
			if (!$user_rating && $rating->is_able())
			{
				$rating->display_box();
			}
			$this->template->assign_vars([
				'IMAGE_RATING'      => $rating->get_image_rating($user_rating),
				'S_ALLOWED_TO_RATE' => (!$user_rating && $rating->is_able()),
				'S_VIEW_RATE'       => ($this->gallery_auth->acl_check('i_rate', $album_id, $album_data['album_user_id'])) ? true : false,
				'S_RATE_ACTION'     => $this->helper->route('phpbbgallery_core_image_rate', ['image_id' => $image_id]),
			]);
			unset($rating);
		}
		/**
		 * Posting comment
		 */
		$comments_disabled = (!$this->gallery_config->get('allow_comments') || ($this->gallery_config->get('comment_user_control') && !$image_data['image_allow_comments']));
		if (!$comments_disabled && $this->gallery_auth->acl_check('c_post', $album_id, $album_data['album_user_id']) && $this->comment->is_allowed($album_data, $image_data))
		{
			add_form_key('gallery');
			$this->language->add_lang('posting');
			$this->url->_include('functions_posting', 'phpbb');

			$bbcode_status = ($this->config['allow_bbcode']) ? true : false;
			$smilies_status = ($this->config['allow_smilies']) ? true : false;
			$img_status = ($bbcode_status) ? true : false;
			$url_status = ($this->config['allow_post_links']) ? true : false;
			$flash_status = false;
			$quote_status = true;

			if (!function_exists('generate_smilies'))
			{
				include_once($this->phpbb_root_path . 'includes/functions_posting.' . $this->php_ext);
			}
			if (!function_exists('display_custom_bbcodes'))
			{
				include_once($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
			}
			// Build custom bbcodes array
			display_custom_bbcodes();

			// Build smilies array
			generate_smilies('inline', 0);

			$s_hide_comment_input = !$this->comment->is_able($album_data, $this->data);

			$this->template->assign_vars([
				'S_ALLOWED_TO_COMMENT' => true,
				'S_HIDE_COMMENT_INPUT' => $s_hide_comment_input,
				'COMMENT_UNAVAILABLE_MESSAGE' => $s_hide_comment_input ? $this->album_operation_message(
					'comment',
					$album_data,
					$this->data,
					$this->language->lang('GALLERY_COMMENT_UNAVAILABLE')
				) : '',

				'BBCODE_STATUS'       => ($bbcode_status) ? sprintf($this->language->lang('BBCODE_IS_ON'), '<a href="' . $this->url->append_sid('phpbb', 'faq', 'mode=bbcode') . '">', '</a>') : sprintf($this->language->lang('BBCODE_IS_OFF'), '<a href="' . $this->url->append_sid('phpbb', 'faq', 'mode=bbcode') . '">', '</a>'),
				'IMG_STATUS'          => ($img_status) ? $this->language->lang('IMAGES_ARE_ON') : $this->language->lang('IMAGES_ARE_OFF'),
				'FLASH_STATUS'        => ($flash_status) ? $this->language->lang('FLASH_IS_ON') : $this->language->lang('FLASH_IS_OFF'),
				'SMILIES_STATUS'      => ($smilies_status) ? $this->language->lang('SMILIES_ARE_ON') : $this->language->lang('SMILIES_ARE_OFF'),
				'URL_STATUS'          => ($bbcode_status && $url_status) ? $this->language->lang('URL_IS_ON') : $this->language->lang('URL_IS_OFF'),
				'S_SIGNATURE_CHECKED' => ($this->user->optionget('attachsig')) ? ' checked="checked"' : '',

				'S_BBCODE_ALLOWED'  => $bbcode_status,
				'S_SMILIES_ALLOWED' => $smilies_status,
				'S_LINKS_ALLOWED'   => $url_status,
				'S_BBCODE_IMG'      => $img_status,
				'S_BBCODE_URL'      => $url_status,
				'S_BBCODE_FLASH'    => $flash_status,
				'S_BBCODE_QUOTE'    => $quote_status,
				'L_COMMENT_LENGTH'  => sprintf($this->language->lang('COMMENT_LENGTH'), $this->gallery_config->get('comment_length')),
			]);

			if ($this->misc->display_captcha('comment'))
			{
				$captcha = $this->phpbb_container->get('captcha.factory')->get_instance($this->config['captcha_plugin'])
				;
				$captcha->init(CONFIRM_POST);
				$s_captcha_hidden_fields = '';
				$this->template->assign_vars([
					'S_CONFIRM_CODE'   => true,
					'CAPTCHA_TEMPLATE' => $captcha->get_template(),
				]);

			}

			// Different link, when we rate and don't comment
			if (!$s_hide_comment_input)
			{
				$this->template->assign_var('S_COMMENT_ACTION', $this->helper->route('phpbbgallery_core_comment_add', ['image_id' => $image_id, 'comment_id' => 0]));
			}
		}
		else if ($this->gallery_config->get('comment_user_control') && !$image_data['image_allow_comments'])
		{
			$this->template->assign_var('S_COMMENTS_DISABLED', true);
		}

		/**
		 * Listing comment
		 */
		if (!$hide_results && $this->gallery_config->get('allow_comments') && $this->gallery_auth->acl_check('c_read', $album_id, $album_data['album_user_id']))
		{
			$this->display_comments($image_id, $this->data, $album_id, $album_data, ($page - 1) * $this->gallery_config->get('items_per_page'), $this->gallery_config->get('items_per_page'));
		}
		else if ($hide_results)
		{
			$this->template->assign_vars([
				'S_ALLOWED_READ_COMMENTS' => false,
				'IMAGE_COMMENTS'          => 0,
			]);
		}
		return $this->helper->render('gallery/viewimage_body.html', $page_title);
	}

	/**
	 * Resolve the explanation for an operation blocked by an optional album type.
	 */
	private function album_operation_message(
		string $operation,
		array $album_data,
		array $image_data,
		string $fallback
	): string
	{
		$message = $fallback;
		$vars = ['operation', 'album_data', 'image_data', 'message'];
		extract($this->dispatcher->trigger_event(
			'phpbbgallery.core.album_operation.message',
			compact($vars)
		));

		$message = trim((string) $message);

		return $message !== '' ? $message : $fallback;
	}

	/**
	 * Build the deprecated pre-rendered navigation link for third-party styles.
	 *
	 * @param array|false $image     Adjacent image data
	 * @param bool        $previous  Whether this is the previous-image link
	 * @param bool        $thumbnail Whether to render the mini image
	 * @return string Legacy HTML link, or an empty string at the album edge
	 */
	protected function build_legacy_navigation_link(array|false $image, bool $previous, bool $thumbnail): string
	{
		if (!$image)
		{
			return '';
		}

		$image_id = (int) $image['image_id'];
		$image_name = utf8_htmlspecialchars((string) $image['image_name']);
		$image_url = utf8_htmlspecialchars($this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]));
		if ($thumbnail)
		{
			$thumbnail_url = utf8_htmlspecialchars($this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id]));
			return '<a href="' . $image_url . '"><img src="' . $thumbnail_url . '" alt="' . $image_name . '"></a>';
		}

		return '<a href="' . $image_url . '">' . ($previous ? '&laquo;&laquo;&nbsp;' : '') . $image_name . ($previous ? '' : '&nbsp;&raquo;&raquo;') . '</a>';
	}

	/**
	 * Describe the stored image's pixel dimensions.
	 *
	 * The dimensions are read from the file rather than the database so they stay
	 * true after the gallery resizes or rotates an image, and so they are available
	 * for every format - unlike EXIF, which only JPEGs carry.
	 *
	 * @param string $filename Stored image filename
	 * @return string Formatted resolution, or an empty string when it is unavailable
	 */
	protected function get_image_resolution(string $filename): string
	{
		if (!$this->gallery_config->get('disp_resolution') || $filename === '')
		{
			return '';
		}

		// getimagesize() only parses the header, so this stays cheap enough to run
		// on an image page view.
		$image_size = @getimagesize($this->url->path('upload') . $filename);
		if ($image_size === false || empty($image_size[0]) || empty($image_size[1]))
		{
			// A missing or unreadable file must not break the page; the template
			// simply omits the row.
			return '';
		}

		return $this->language->lang('IMAGE_RESOLUTION_VALUE', (int) $image_size[0], (int) $image_size[1]);
	}

	/**
	 * Resolve the configured action when the displayed image is clicked.
	 *
	 * Unknown modes fall back to the original image so links remain usable if a
	 * third-party integration is removed before its saved configuration.
	 *
	 * @param int         $image_id Current image identifier
	 * @param array|false $next     Next visible image, when one exists
	 * @return string Click destination, or an empty string when no link is wanted
	 */
	protected function get_image_action(int $image_id, array|false $next): string
	{
		switch ($this->gallery_config->get('link_imagepage'))
		{
			case 'none':
				return '';

			case 'next':
				return $next
					? $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $next['image_id']])
					: '';

			case 'image':
			default:
				return $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => $image_id]);
		}
	}

	protected function normalize_subtitle_search_terms(string $subtitle): string
	{
		$terms = preg_replace('#\s+#u', ' ', str_replace(['(', ')'], ' ', $subtitle));
		return trim($terms ?? '');
	}

	protected function build_subtitle_search_url(string $subtitle): string
	{
		$terms = $this->normalize_subtitle_search_terms($subtitle);
		if ($terms === '' || !$this->auth->acl_get('u_search') || empty($this->config['load_search']))
		{
			return '';
		}

		return $this->helper->route('phpbbgallery_core_search', [
			'keywords' => $terms,
			'terms' => 'all',
			'submit' => 1,
		]);
	}

	/**
	 * Assign the image poster's custom profile fields to root template blocks.
	 */
	private function assign_image_poster_profile_fields(int $poster_id): void
	{
		if (!$this->config['load_cpf_viewtopic'] || empty($this->profile_fields_data[$poster_id]))
		{
			return;
		}

		$profile_fields = $this->cpf_manager->generate_profile_fields_template_data($this->profile_fields_data[$poster_id]);
		if (!empty($profile_fields['row']))
		{
			$this->template->assign_vars($profile_fields['row']);
		}

		foreach ($profile_fields['blockrow'] ?? [] as $field_data)
		{
			if ($field_data['S_PROFILE_CONTACT'])
			{
				$this->template->assign_block_vars('contact', [
					'ID'        => $field_data['PROFILE_FIELD_IDENT'],
					'NAME'      => $field_data['PROFILE_FIELD_NAME'],
					'U_CONTACT' => $field_data['PROFILE_FIELD_CONTACT'],
				]);
			}
			else
			{
				$this->template->assign_block_vars('custom_fields', $field_data);
			}
		}
	}

	/**
	 * Assign an anonymous poster shell for data protected by an add-on policy.
	 *
	 * Every profile and contact variable used by the bundled styles is cleared so
	 * a template or event cannot accidentally expose the real entrant.
	 *
	 * @return void
	 */
	private function assign_hidden_poster(string $label): void
	{
		$this->template->destroy_block_vars('contact');
		$this->template->destroy_block_vars('custom_fields');
		$this->template->assign_vars([
			'POSTER_FULL'               => $label,
			'POSTER_COLOUR'             => '',
			'POSTER_USERNAME'           => $label,
			'POSTER_SIGNATURE'          => '',
			'POSTER_RANK_TITLE'         => '',
			'POSTER_RANK_IMG'           => '',
			'POSTER_RANK_IMG_SRC'       => '',
			'POSTER_JOINED'             => '',
			'POSTER_POSTS'              => '',
			'POSTER_FROM'               => '',
			'POSTER_AVATAR'             => '',
			'POSTER_WARNINGS'           => 0,
			'POSTER_AGE'                => '',
			'POSTER_ONLINE_IMG'         => '',
			'POSTER_GALLERY_IMAGES'     => '',
			'POSTER_IP'                 => '',
			'U_POSTER'                  => '',
			'U_POSTER_PROFILE'          => '',
			'U_POSTER_SEARCH'           => '',
			'U_POSTER_PM'               => '',
			'U_POSTER_EMAIL'            => '',
			'U_POSTER_WWW'              => '',
			'U_POSTER_MSN'              => '',
			'U_POSTER_ICQ'              => '',
			'U_POSTER_YIM'              => '',
			'U_POSTER_AIM'              => '',
			'U_POSTER_JABBER'           => '',
			'U_POSTER_GALLERY'          => '',
			'U_POSTER_GALLERY_SEARCH'   => '',
			'U_POSTER_WHOIS'            => '',
			'S_POSTER_ONLINE'           => false,
			'S_CUSTOM_FIELDS'           => false,
			'S_PRIVATE_IDENTITY_HIDDEN' => true,
		]);
	}

	/**
	 * Build the visibility boundary used by previous/next image navigation.
	 *
	 * @return string[] SQL conditions containing only cast values and fixed identifiers
	 */
	private function get_image_visibility_conditions(int $album_id, int $album_user_id): array
	{
		$conditions = [
			'image_album_id = ' . (int) $album_id,
			'image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN,
		];

		if (!$this->gallery_auth->acl_check('m_status', $album_id, $album_user_id))
		{
			$conditions[] = '(image_status = ' . (int) \phpbbgallery\core\block::STATUS_APPROVED .
				' OR image_user_id = ' . (int) $this->user->data['user_id'] . ')';
		}

		return $conditions;
	}

	protected function display_comments(int $image_id, array $image_data, int $album_id, array $album_data, int $start, int $limit): void
	{
		$sort_order = ($this->request->variable('sort_order', 'ASC') == 'ASC') ? 'ASC' : 'DESC';
		$this->template->assign_vars([
			'S_ALLOWED_READ_COMMENTS' => true,
			'IMAGE_COMMENTS'          => $image_data['image_comments'],
			'SORT_ASC'                => ($sort_order == 'ASC') ? true : false,
		]);

		if ($image_data['image_comments'] > 0)
		{
			if (!class_exists('bbcode'))
			{
				$this->url->_include('bbcode', 'phpbb');
			}

			$bbcode = new \bbcode();

			$comments = [];
			$sql = 'SELECT *
				FROM ' . $this->table_comments . '
				WHERE comment_image_id = ' . (int) $image_id . '
				ORDER BY comment_id ' . $sort_order;
			$result = $this->db->sql_query_limit($sql, $limit, $start);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$comments[] = $row;
				$this->users_id_array[$row['comment_user_id']] = $row['comment_user_id'];
				if ($row['comment_edit_count'] > 0)
				{
					$this->users_id_array[$row['comment_edit_user_id']] = $row['comment_edit_user_id'];
				}
			}
			$this->db->sql_freeresult($result);

			$this->load_users_data();

			foreach ($comments as $row)
			{
				$edit_info = '';

				// Let's deploy new profile
				$poster_id = $row['comment_user_id'];
				$user_data = $this->users_data_array[$poster_id] ?? [];
				if ($row['comment_edit_count'] > 0)
				{
					$editor_data = $this->users_data_array[$row['comment_edit_user_id']] ?? [];
					$editor_id = $editor_data ? (int) $row['comment_edit_user_id'] : (int) ANONYMOUS;
					$edit_info = ($row['comment_edit_count'] == 1) ? $this->language->lang('IMAGE_EDITED_TIME_TOTAL') : $this->language->lang('IMAGE_EDITED_TIMES_TOTAL');
					$edit_info = sprintf($edit_info, get_username_string('full', $editor_id, $editor_data['username'] ?? $this->language->lang('GUEST'), $editor_data['user_colour'] ?? ''), $this->user->format_date($row['comment_edit_time'], false, true), $row['comment_edit_count']);
				}
				$poster_data = $this->prepare_comment_poster($row, $user_data);
				$user_deleted = $poster_data['user_deleted'];
				$display_poster_id = $poster_data['poster_id'];
				$poster_username = $poster_data['username'];
				$poster_colour = $poster_data['user_colour'];
				// End signature parsing, only if needed
				if (($user_data['sig'] ?? '') !== '' && empty($user_data['sig_parsed']))
				{
					$parse_flags = (!empty($user_data['sig_bbcode_bitfield']) ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
					$user_data['sig'] = generate_text_for_display($user_data['sig'], $user_data['sig_bbcode_uid'] ?? '', $user_data['sig_bbcode_bitfield'] ?? '', $parse_flags, true);
					$user_data['sig_parsed'] = true;
					$this->users_data_array[$poster_id] = $user_data;
				}

				$cp_row = [];
				//CPF
				if ($this->config['load_cpf_viewtopic'])
				{
					$cp_row = (isset($this->profile_fields_data[$poster_id])) ? $this->cpf_manager->generate_profile_fields_template_data($this->profile_fields_data[$poster_id]) : [];
				}
				$can_receive_pm = !$user_deleted &&
					// They must be a "normal" user
					$user_data['user_type'] != USER_IGNORE &&
					// They must not be deactivated by the administrator
					($user_data['user_type'] != USER_INACTIVE || $user_data['user_inactive_reason'] != INACTIVE_MANUAL) &&
					// They must be able to read PMs
					in_array($poster_id, $this->can_receive_pm_list) &&
					// They must allow users to contact via PM
					(($this->auth->acl_gets('a_', 'm_') || $this->auth->acl_getf_global('m_')) || $user_data['allow_pm']);
				$u_pm = '';
				if ($this->config['allow_privmsg'] && $this->auth->acl_get('u_sendpm') && $can_receive_pm)
				{
					$u_pm = append_sid("{$this->phpbb_root_path}ucp.$this->php_ext", 'i=pm&amp;mode=compose');
				}

				$comment_row = [
					'U_COMMENT'  => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]) . '#comment_' . $row['comment_id'],
					'COMMENT_ID' => $row['comment_id'],
					'TIME'       => $this->user->format_date($row['comment_time']),
					'TEXT'       => generate_text_for_display($row['comment'], $row['comment_uid'], $row['comment_bitfield'], 7),
					'EDIT_INFO'  => $edit_info,
					'U_DELETE'   => ($this->gallery_auth->acl_check('m_comments', $album_id, $album_data['album_user_id']) || ($this->gallery_auth->acl_check('c_delete', $album_id, $album_data['album_user_id']) && ($row['comment_user_id'] == $this->user->data['user_id']) && $this->user->data['is_registered'])) ? $this->helper->route('phpbbgallery_core_comment_delete', ['image_id' => $image_id, 'comment_id' => $row['comment_id']]) : '',
					'U_QUOTE'    => ($this->gallery_auth->acl_check('c_post', $album_id, $album_data['album_user_id'])) ? $this->helper->route('phpbbgallery_core_comment_add', ['image_id' => $image_id, 'comment_id' => $row['comment_id']]) : '',
					'U_EDIT'     => ($this->gallery_auth->acl_check('m_comments', $album_id, $album_data['album_user_id']) || ($this->gallery_auth->acl_check('c_edit', $album_id, $album_data['album_user_id']) && ($row['comment_user_id'] == $this->user->data['user_id']) && $this->user->data['is_registered'])) ? $this->helper->route('phpbbgallery_core_comment_edit', ['image_id' => $image_id, 'comment_id' => $row['comment_id']]) : '',
					// TODO Whois link
					// 'U_WHOIS'     => ($this->auth->acl_get('a_')) ? $this->url->append_sid('mcp', 'mode=whois&amp;ip=' . $row['comment_user_ip']) : '',

					'POSTER_FULL'     => get_username_string('full', $display_poster_id, $poster_username, $poster_colour),
					'POSTER_COLOUR'   => get_username_string('colour', $display_poster_id, $poster_username, $poster_colour),
					'POSTER_USERNAME' => get_username_string('username', $display_poster_id, $poster_username, $poster_colour),
					'U_POSTER'        => get_username_string('profile', $display_poster_id, $poster_username, $poster_colour),
					'POSTER_IP'       => ($this->auth->acl_get('a_')) ? $row['comment_user_ip'] : '',

					'SIGNATURE'              => ($row['comment_signature'] && !$user_deleted) ? ($user_data['sig'] ?? '') : '',
					'POSTER_RANK_TITLE'      => $user_deleted ? '' : $user_data['rank_title'],
					'POSTER_RANK_IMG'        => $user_deleted ? '' : $user_data['rank_image'],
					'POSTER_RANK_IMG_SRC'    => $user_deleted ? '' : $user_data['rank_image_src'],
					'POSTER_JOINED'   => $user_deleted ? '' : $user_data['joined'],
					'POSTER_POSTS'    => $user_deleted ? '' : $user_data['posts'],
					'POSTER_FROM'     => isset($user_data['from']) ? $user_data['from'] : '',
					'POSTER_AVATAR'   => $user_deleted ? '' : $user_data['avatar'],
					'POSTER_WARNINGS' => $user_deleted ? '' : $user_data['warnings'],
					'POSTER_AGE'      => $user_deleted ? '' : $user_data['age'],

					// 'MINI_POST_IMG'  => $this->user->img('icon_post_target', 'POST'),
					// 'ICQ_STATUS_IMG' => isset($user_data['icq_status_img']) ? $user_data['icq_status_img'] : '',
					'POSTER_ONLINE_IMG' => ($poster_id == ANONYMOUS || !$this->config['load_onlinetrack']) ? '' : ($user_deleted ? '' : ($user_data['online'] ? $this->user->img('icon_user_online', 'ONLINE') : $this->user->img('icon_user_offline', 'OFFLINE'))),
					'S_POSTER_ONLINE'   => ($poster_id == ANONYMOUS || !$this->config['load_onlinetrack']) ? false : ($user_deleted ? '' : $user_data['online']),

					'S_CUSTOM_FIELDS' => (isset($cp_row['row']) && count($cp_row['row'])) ? true : false,
				];
				if (isset($cp_row['row']) && count($cp_row['row']))
				{
					$comment_row = array_merge($comment_row, $cp_row['row']);
				}
				$this->template->assign_block_vars('commentrow', $comment_row);

				$contact_fields = [
					[
						'ID'        => 'pm',
						'NAME'      => $this->language->lang('SEND_PRIVATE_MESSAGE'),
						'U_CONTACT' => $u_pm,
					],
					[
						'ID'        => 'email',
						'NAME'      => $this->language->lang('SEND_EMAIL'),
						'U_CONTACT' => $user_data['email'] ?? '',
					],
					[
						'ID'        => 'jabber',
						'NAME'      => $this->language->lang('JABBER'),
						'U_CONTACT' => $user_data['jabber'] ?? '',
					],
				];

				foreach ($contact_fields as $field)
				{
					if ($field['U_CONTACT'])
					{
						$this->template->assign_block_vars('commentrow.contact', $field);
					}
				}

				if (!empty($cp_row['blockrow']))
				{
					foreach ($cp_row['blockrow'] as $field_data)
					{
						if ($field_data['S_PROFILE_CONTACT'])
						{
							$this->template->assign_block_vars('commentrow.contact', [
								'ID'        => $field_data['PROFILE_FIELD_IDENT'],
								'NAME'      => $field_data['PROFILE_FIELD_NAME'],
								'U_CONTACT' => $field_data['PROFILE_FIELD_CONTACT'],
							]);
						}
						else
						{
							$this->template->assign_block_vars('commentrow.custom_fields', $field_data);
						}
					}
				}

			}
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_image',
					'phpbbgallery_core_image_page',
				],
				'params' => [
					'image_id' => (int) $image_id,
				],
			], 'pagination', 'page', $image_data['image_comments'], $limit, $start);

			$this->template->assign_vars([
				'TOTAL_COMMENTS' => $this->language->lang('VIEW_IMAGE_COMMENTS', $image_data['image_comments']),
				//'S_SELECT_SORT_DIR'			=> $s_sort_dir,
				//'S_SELECT_SORT_KEY'			=> $s_sort_key,
			]);
		}
	}

	// Edit image
	public function edit(int $image_id): \Symfony\Component\HttpFoundation\Response|null
	{
		//we cheat a little but we will make good later
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_id = $image_data['image_album_id'];
		$album_data = $this->album->get_info($album_id);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->display->generate_navigation($album_data);
		add_form_key('gallery');
		$submit = $this->request->variable('submit', false);
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $image_data['image_album_id']]);
		$disp_image_data = $image_data;
		$owner_id = $image_data['image_user_id'];
		$album_loginlink = $this->url->append_sid('phpbb', 'ucp', 'mode=login');
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$has_image_permission = $this->gallery_auth->acl_check('i_edit', $album_id, $album_data['album_user_id']);
		$has_moderator_permission = $this->gallery_auth->acl_check('m_edit', $album_id, $album_data['album_user_id']);
		$is_orphan = $image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_ORPHAN;
		if (!$this->image_authorization->can_manage_image((int) $this->user->data['user_id'], $image_data, $has_image_permission, $has_moderator_permission, $is_orphan))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			return null;
		}
		if ($submit)
		{
			if (!check_form_key('gallery'))
			{
				trigger_error('FORM_INVALID');
			}

			$image_desc = $this->request->variable('message', [''], true);
			$image_desc = $image_desc[0];
			$image_name = $this->request->variable('image_name', [''], true);
			$image_name = $image_name[0];
			$image_subtitle = $this->request->variable('image_subtitle', [''], true);
			$image_subtitle = trim(utf8_normalize_nfc((string) $image_subtitle[0]));
			if (strlen($image_desc) > $this->gallery_config->get('description_length'))
			{
				trigger_error($this->language->lang('DESC_TOO_LONG'));
			}
			if (utf8_strlen($image_subtitle) > \phpbbgallery\core\upload::IMAGE_SUBTITLE_MAX_LENGTH)
			{
				trigger_error($this->language->lang('IMAGE_SUBTITLE_TOO_LONG', \phpbbgallery\core\upload::IMAGE_SUBTITLE_MAX_LENGTH));
			}
			// Create message parser instance
			if (!class_exists('parse_message'))
			{
				include_once($this->phpbb_root_path . 'includes/message_parser.' . $this->php_ext);
			}
			$message_parser = new \parse_message();
			$message_parser->message = utf8_normalize_nfc($image_desc);
			if ($message_parser->message)
			{
				$message_parser->parse(true, true, true, true, false, true, true, true);
			}

			$sql_ary = [
				'image_name'           => $image_name,
				'image_name_clean'     => utf8_clean_string($image_name),
				'image_subtitle'       => $image_subtitle,
				'image_desc'           => $message_parser->message,
				'image_desc_uid'       => $message_parser->bbcode_uid,
				'image_desc_bitfield'  => $message_parser->bbcode_bitfield,
				'image_allow_comments' => $this->request->variable('allow_comments', 0),
			];

			/**
			 * Event edit image
			 *
			 * @event phpbbgallery.core.image_edit
			 * @var    array    sql_ary        sql array that should be populated.
			 * @since 3.2.2
			 */
			$vars = ['sql_ary'];
			extract($this->dispatcher->trigger_event('phpbbgallery.core.image_edit', compact($vars)));

			$errors = [];
			if (empty($sql_ary['image_name_clean']))
			{
				$errors[] = $this->language->lang('MISSING_IMAGE_NAME');
			}

			if (!$this->gallery_config->get('allow_comments') || !$this->gallery_config->get('comment_user_control'))
			{
				unset($sql_ary['image_allow_comments']);
			}

			$change_image_count = false;
			if ($this->gallery_auth->acl_check('m_edit', $album_id, $album_data['album_user_id']))
			{
				$user_data = $this->image->get_new_author_info($this->request->variable('change_author', '', true));
				if ($user_data)
				{
					$sql_ary = array_merge($sql_ary, [
						'image_user_id'        => $user_data['user_id'],
						'image_username'       => $user_data['username'],
						'image_username_clean' => utf8_clean_string($user_data['username']),
						'image_user_colour'    => $user_data['user_colour'],
					]);

					if ($image_data['image_status'] != $this->block->get_image_status_unapproved())
					{
						$change_image_count = true;
					}
				}
				else if ($this->request->variable('change_author', '', true))
				{
					$errors[] = $this->language->lang('INVALID_USERNAME');
				}
			}

			$move_to_personal = $this->request->variable('move_to_personal', 0);
			if ($move_to_personal)
			{
				$personal_album_id = 0;
				if ($this->user->data['user_id'] != $image_data['image_user_id'])
				{
					$image_user = $this->gallery_user;
					$image_user->set_user_id($image_data['image_user_id']);
					$personal_album_id = $image_user->get_data('personal_album_id');

					// The User has no personal album, moderators can created that without the need of permissions
					if (!$personal_album_id)
					{
						$personal_album_id = $this->album->generate_personal_album($image_data['image_username'], $image_data['image_user_id'], $image_data['image_user_colour'], $image_user);
					}
				}
				else
				{
					$personal_album_id = $this->gallery_user->get_data('personal_album_id');
					if (!$personal_album_id && $this->gallery_auth->acl_check('i_upload', $this->gallery_auth->get_own_album()))
					{
						$personal_album_id = $this->album->generate_personal_album($image_data['image_username'], $image_data['image_user_id'], $image_data['image_user_colour'], $this->gallery_user);
					}
				}

				if ($personal_album_id)
				{
					$sql_ary['image_album_id'] = $personal_album_id;
				}
			}

			$rotate = $this->request->variable('rotate', [0]);
			$rotate = (isset($rotate[0])) ? $rotate[0] : 0;
			$file_changed = false;

			/**
			 * Allow add-ons to replace or otherwise transform the physical image file.
			 * This event runs after the edit form CSRF and image-ownership checks.
			 *
			 * @event phpbbgallery.core.image_edit_file
			 * @var int   image_id    Image identifier
			 * @var array image_data  Current image database row
			 * @var array album_data  Current album database row
			 * @var array errors      Validation errors; listeners may append messages
			 * @var int   rotate      Requested rotation in degrees
			 * @var bool  file_changed Set true when a listener replaced the source file
			 * @since 3.4.0
			 */
			$vars = ['image_id', 'image_data', 'album_data', 'errors', 'rotate', 'file_changed'];
			extract($this->dispatcher->trigger_event('phpbbgallery.core.image_edit_file', compact($vars)));

			if (!$errors && !$file_changed && $this->gallery_config->get('allow_rotate') && ($rotate > 0) && (($rotate % 90) == 0))
			{
				$image_tools = new \phpbbgallery\core\file\file($this->request, $this->url, $this->gallery_config, 2);
				$image_tools->set_image_options($this->gallery_config->get('max_filesize'), $this->gallery_config->get('max_height'), $this->gallery_config->get('max_width'));
				$image_tools->set_image_data($this->url->path('upload') . $image_data['image_filename']);

				// Rotate the image
				$image_tools->rotate_image($rotate, $this->gallery_config->get('allow_rotate'));
				if ($image_tools->rotated)
				{
					$image_tools->write_image($image_tools->image_source, $this->gallery_config->get('jpg_quality'), true);
				}
				@unlink($this->url->path('thumbnail') . $image_data['image_filename']);
				@unlink($this->url->path('medium') . $image_data['image_filename']);
			}

			$error = implode('<br />', $errors);

			if (!$error)
			{
				$sql = 'UPDATE ' . $this->table_images . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE image_id = ' . (int) $image_id;
				$this->db->sql_query($sql);

				$updated_image_data = array_merge($image_data, $sql_ary);
				/**
				 * Notify add-ons after an authorized image edit has been persisted.
				 *
				 * @event phpbbgallery.core.image_edit_after
				 * @var int   image_id           Edited image identifier
				 * @var array image_data         Image row before the edit
				 * @var array updated_image_data Image row after applying the edit
				 * @var array sql_ary            Values persisted by this edit
				 * @since 3.4.0
				 */
				$vars = ['image_id', 'image_data', 'updated_image_data', 'sql_ary'];
				extract($this->dispatcher->trigger_event('phpbbgallery.core.image_edit_after', compact($vars)));

				$this->album->update_info($album_data['album_id']);
				if ($move_to_personal && $personal_album_id)
				{
					$this->album->update_info($personal_album_id);
				}

				if ($change_image_count)
				{
					$new_user = new \phpbbgallery\core\user($this->db, $this->dispatcher, $this->user, $this->cpf_manager, $this->config, $this->auth, $this->table_users, $this->phpbb_root_path, $this->php_ext);
					$new_user->set_user_id($user_data['user_id']);
					$new_user->update_images(1);
					$old_user = new \phpbbgallery\core\user($this->db, $this->dispatcher, $this->user, $this->cpf_manager, $this->config, $this->auth, $this->table_users, $this->phpbb_root_path, $this->php_ext);
					$old_user->set_user_id($image_data['image_user_id']);
					$old_user->update_images(-1);
				}

				if ($this->user->data['user_id'] != $image_data['image_user_id'])
				{
					$this->gallery_log->add_log('moderator', 'edit', $image_data['image_album_id'], $image_id, ['LOG_GALLERY_EDITED', $image_name]);
				}

				$message = $this->language->lang('IMAGES_UPDATED_SUCCESSFULLY');
				$message .= '<br /><br />' . sprintf($this->language->lang('CLICK_RETURN_IMAGE'), '<a href="' . $image_backlink . '">', '</a>');
				$message .= '<br /><br />' . sprintf($this->language->lang('CLICK_RETURN_ALBUM'), '<a href="' . $album_backlink . '">', '</a>');
				$this->url->meta_refresh(3, $image_backlink);
				trigger_error($message);
			}
			$disp_image_data = array_merge($disp_image_data, $sql_ary);
		}

		if (!class_exists('bbcode'))
		{
			include($this->phpbb_root_path . 'includes/bbcode.' . $this->php_ext);
		}
		if (!class_exists('parse_message'))
		{
			include_once($this->phpbb_root_path . 'includes/message_parser.' . $this->php_ext);
		}
		$message_parser = new \parse_message();
		$message_parser->message = $disp_image_data['image_desc'];
		$message_parser->decode_message($disp_image_data['image_desc_uid']);

		$page_title = $disp_image_data['image_name'];

		$template_vars = [
			'U_IMAGE'    => $this->image->generate_link('thumbnail', 'plugin', $image_id, $image_data['image_name'], $album_id),
			'IMAGE_NAME' => $disp_image_data['image_name'],
			'IMAGE_SUBTITLE' => $disp_image_data['image_subtitle'] ?? '',
			'IMAGE_DESC' => $message_parser->message,
		];

		/**
		 * Event edit image display
		 *
		 * @event phpbbgallery.core.image_edit_display
		 * @var array template_vars   Template array
		 * @var array disp_image_data Display image array
		 * @var int   image_id        Image identifier
		 * @var array image_data      Current image database row
		 * @var array album_data      Current album database row
		 * @since 3.2.2
		 */
		$vars = ['template_vars', 'disp_image_data', 'image_id', 'image_data', 'album_data'];
		extract($this->dispatcher->trigger_event('phpbbgallery.core.image_edit_display', compact($vars)));
		$this->template->assign_block_vars('image', $template_vars);

		$this->template->assign_vars([
			'L_DESCRIPTION_LENGTH' => $this->language->lang('DESCRIPTION_LENGTH', $this->gallery_config->get('description_length')),
			'S_EDIT'               => true,
			'S_ALBUM_ACTION'       => $this->helper->route('phpbbgallery_core_image_edit', ['image_id' => $image_id]),
			'ERROR'                => (isset($error)) ? $error : '',

			'U_VIEW_IMAGE' => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]),
			'IMAGE_NAME'   => $image_data['image_name'],

			'S_CHANGE_AUTHOR'    => $this->gallery_auth->acl_check('m_edit', $album_id, $album_data['album_user_id']),
			'CHANGE_AUTHOR'      => $this->request->variable('change_author', '', true),
			'U_FIND_USERNAME'    => $this->url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=postform&amp;field=change_author&amp;select_single=true'),
			'S_COMMENTS_ENABLED' => $this->gallery_config->get('allow_comments') && $this->gallery_config->get('comment_user_control'),
			'S_ALLOW_COMMENTS'   => $image_data['image_allow_comments'],

			'NUM_IMAGES'       => 1,
			'S_ALLOW_ROTATE'   => ($this->gallery_config->get('allow_rotate') && function_exists('imagerotate')),
			//'S_MOVE_PERSONAL'	=> (($this->galley_auth->acl_check('i_upload', $this->galley_auth::OWN_ALBUM) || phpbb_gallery::$user->get_data('personal_album_id')) || ($user->data['user_id'] != $image_data['image_user_id'])) ? true : false,
			'S_MOVE_MODERATOR' => ($this->user->data['user_id'] != $image_data['image_user_id']) ? true : false,
		]);

		return $this->helper->render('gallery/posting_body.html', $page_title);
	}

	// Delete image
	public function delete(int $image_id): \Symfony\Component\HttpFoundation\Response|null
	{
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_id = $image_data['image_album_id'];
		$album_data = $this->album->get_info($album_id);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$album_loginlink = $this->url->append_sid('phpbb', 'ucp', 'mode=login');
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $image_data['image_album_id']]);
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$has_image_permission = $this->gallery_auth->acl_check('i_delete', $album_id, $album_data['album_user_id']);
		$has_moderator_permission = $this->gallery_auth->acl_check('m_delete', $album_id, $album_data['album_user_id']);
		$is_orphan = $image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_ORPHAN;
		if (!$this->image_authorization->can_manage_image((int) $this->user->data['user_id'], $image_data, $has_image_permission, $has_moderator_permission, $is_orphan))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			return null;
		}
		$s_hidden_fields = build_hidden_fields([
			'album_id' => $album_id,
			'image_id' => $image_id,
			'mode'     => 'delete',
		]);

		if (confirm_box(true))
		{
			$this->image->handle_counter($image_id, false);
			$this->moderate->delete_images([$image_id], [$image_id => $image_data['image_filename']]);
			$this->album->update_info($album_id);

			$message = $this->language->lang('DELETED_IMAGE') . '<br />';
			$message .= '<br />' . sprintf($this->language->lang('CLICK_RETURN_ALBUM'), '<a href="' . $album_backlink . '">', '</a>');

			if ($this->user->data['user_id'] != $image_data['image_user_id'])
			{
				$this->gallery_log->add_log('moderator', 'delete', $image_data['image_album_id'], $image_id, ['LOG_GALLERY_DELETED', $image_data['image_name']]);
			}
			// So we need to see if there are still unapproved images in the album
			$this->notification_helper->read('approval', $album_id);
			$this->url->meta_refresh(3, $album_backlink);
			trigger_error($message);
		}
		else
		{
			if ($this->request->is_set_post('cancel'))
			{
				$message = $this->language->lang('DELETED_IMAGE_NOT') . '<br />';
				$message .= '<br />' . sprintf($this->language->lang('CLICK_RETURN_IMAGE'), '<a href="' . $image_backlink . '">', '</a>');
				$this->url->meta_refresh(3, $image_backlink);
				trigger_error($message);
			}
			else
			{
				confirm_box(false, 'DELETE_IMAGE2', $s_hidden_fields);
			}
		}

		return null;
	}
	// Report image
	public function report(int $image_id): \Symfony\Component\HttpFoundation\Response
	{
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_id = $image_data['image_album_id'];
		$album_data = $this->album->get_info($album_id);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$album_loginlink = $this->url->append_sid('phpbb', 'ucp', 'mode=login');
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $image_data['image_album_id']]);
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('i_report', $album_id, $album_data['album_user_id']) || ($image_data['image_user_id'] == $this->user->data['user_id']))
		{
			$this->misc->not_authorised($image_backlink, '');
		}
		add_form_key('gallery');
		$submit = $this->request->variable('submit', false);
		$error = '';
		if ($submit)
		{
			if (!check_form_key('gallery'))
			{
				trigger_error('FORM_INVALID');
			}

			$report_message = $this->request->variable('message', '', true);
			$error = '';
			if ($report_message == '')
			{
				$error = $this->language->lang('MISSING_REPORT_REASON');
				$submit = false;
			}

			if (!$error && $image_data['image_reported'])
			{
				$error = $this->language->lang('IMAGE_ALREADY_REPORTED');
			}

			if (!$error)
			{
				$data = [
					'report_album_id' => (int) $album_id,
					'report_image_id' => (int) $image_id,
					'report_note'     => $report_message,
				];

				$this->report->add($data);

				$message = $this->language->lang('IMAGES_REPORTED_SUCCESSFULLY');
				$message .= '<br /><br />' . sprintf($this->language->lang('CLICK_RETURN_IMAGE'), '<a href="' . $image_backlink . '">', '</a>');
				$message .= '<br /><br />' . sprintf($this->language->lang('CLICK_RETURN_ALBUM'), '<a href="' . $album_backlink . '">', '</a>');

				$this->url->meta_refresh(3, $image_backlink);
				trigger_error($message);
			}

		}

		$this->template->assign_vars([
			'ERROR'            => $error,
			'U_IMAGE'          => ($image_id) ? $this->helper->route('phpbbgallery_core_image_file_medium', ['image_id' => $image_id]) : '',
			'IMAGE_NAME'       => $image_data['image_name'],
			'U_VIEW_IMAGE'     => ($image_id) ? $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]) : '',
			'IMAGE_RSZ_WIDTH'  => $this->gallery_config->get('medium_width'),
			'IMAGE_RSZ_HEIGHT' => $this->gallery_config->get('medium_height'),

			'S_REPORT'       => true,
			'S_ALBUM_ACTION' => $this->helper->route('phpbbgallery_core_image_report', ['image_id' => $image_id]),
		]);

		$page_title = $this->language->lang('REPORT_IMAGE');

		return $this->helper->render('gallery/posting_body.html', $page_title);
	}

	/**
	 * Build safe identity data for an image comment author.
	 *
	 * Deleted users retain the username stored with the comment, but are rendered
	 * as guests so no invalid profile link is generated.
	 *
	 * @param array $comment Comment database row
	 * @param array $user_data Current phpBB user row, or an empty array
	 * @return array Display identity
	 */
	protected function prepare_comment_poster(array $comment, array $user_data): array
	{
		$user_deleted = !$user_data;
		$stored_username = $comment['comment_username'] ?? '';

		return [
			'user_deleted' => $user_deleted,
			'poster_id' => $user_deleted ? (int) ANONYMOUS : (int) $comment['comment_user_id'],
			'username' => $user_data['username'] ?? ($stored_username !== '' ? $stored_username : $this->language->lang('GUEST')),
			'user_colour' => $user_data['user_colour'] ?? ($comment['comment_user_colour'] ?? ''),
		];
	}

	/**
	 * @param int $album_id
	 * @param int $owner_id
	 * @param int $image_status
	 * @param int $album_auth_level
	 * @param array $user_data
	 * @return void
	 */
	protected function check_permissions(int $album_id, int $owner_id, int $image_status, int $album_auth_level, array $user_data): void
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$zebra_array = $this->gallery_auth->get_user_zebra($this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('i_view', $album_id, $owner_id) || ($image_status == (int) \phpbbgallery\core\block::STATUS_ORPHAN) || $this->gallery_auth->get_zebra_state($zebra_array, (int) $owner_id, (int) $album_id) < (int) $album_auth_level)
		{
			if ($this->user->data['is_bot'])
			{
				// Redirect bots back to the index
				redirect($this->helper->route('phpbbgallery_core_index'));
			}

			// Display login box for guests and an error for users
			if (!$this->user->data['is_registered'])
			{
				// @todo Add "redirect after login" url
				login_box();
			}
			else
			{
				redirect('gallery/album/' . $album_id);
			}
		}
		if (!$this->gallery_auth->acl_check('m_status', $album_id, $owner_id) && $user_data['image_user_id'] != $this->user->data['user_id'] && ($image_status == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED))
		{
			redirect('gallery/album/' . $album_id);
		}
	}

	protected function load_users_data(): void
	{

		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT' => 'u.*, gu.personal_album_id, gu.user_images',
			'FROM'   => [USERS_TABLE => 'u'],

			'LEFT_JOIN' => [
				[
					'FROM' => [$this->table_users => 'gu'],
					'ON'   => 'gu.user_id = u.user_id',
				],
			],

			'WHERE' => $this->db->sql_in_set('u.user_id', $this->users_id_array),
		]);
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->gallery_user->add_user_to_cache($this->users_data_array, $row);
		}
		$this->db->sql_freeresult($result);

		// Load CPF's
		$profile_fields_tmp = $this->cpf_manager->grab_profile_fields_data($this->users_id_array);
		foreach ($profile_fields_tmp as $profile_user_id => $profile_fields)
		{
			$this->profile_fields_data[$profile_user_id] = [];
			foreach ($profile_fields as $used_ident => $profile_field)
			{
				if ($profile_field['data']['field_show_on_vt'])
				{
					$this->profile_fields_data[$profile_user_id][$used_ident] = $profile_field;
				}
			}
		}
		unset($profile_fields_tmp);

		// Get the list of users who can receive private messages
		$this->can_receive_pm_list = [];
		if (is_array($this->users_data_array))
		{
			$this->can_receive_pm_list = $this->auth->acl_get_list(array_keys($this->users_data_array), 'u_readpm');
		}
		$this->can_receive_pm_list = (empty($this->can_receive_pm_list) || !isset($this->can_receive_pm_list[0]['u_readpm'])) ? [] : $this->can_receive_pm_list[0]['u_readpm'];

		// Load online-information
		if ($this->config['load_onlinetrack'] && sizeof($this->users_id_array))
		{
			$sql = 'SELECT session_user_id, MAX(session_time) as online_time, MIN(session_viewonline) AS viewonline
				FROM ' . SESSIONS_TABLE . '
				WHERE ' . $this->db->sql_in_set('session_user_id', $this->users_id_array) . '
				GROUP BY session_user_id';
			$result = $this->db->sql_query($sql);

			$update_time = $this->config['load_online_time'] * 60;
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->users_data_array[$row['session_user_id']]['online'] = (time() - $update_time < $row['online_time'] && (($row['viewonline']) || $this->auth->acl_get('u_viewonline'))) ? true : false;
			}
			$this->db->sql_freeresult($result);
		}
	}

	/**
	 * Reset request-local image and user caches before rendering an image.
	 *
	 * @return void
	 */
	protected function reset_request_state(): void
	{
		$this->data = [];
		$this->users_id_array = [];
		$this->users_data_array = [];
		$this->profile_fields_data = [];
		$this->can_receive_pm_list = [];
	}

	/**
	 * Fall back to chronological sorting for unsupported request values.
	 *
	 * @param string $sort_key    Requested sort key
	 * @param array  $sort_by_sql Supported sort columns
	 * @return string Valid sort key
	 */
	protected function normalize_sort_key(string $sort_key, array $sort_by_sql): string
	{
		return isset($sort_by_sql[$sort_key]) ? $sort_key : 't';
	}
}
