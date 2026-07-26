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

class album
{
	/* @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/* @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/* @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/* @var \phpbb\pagination */
	protected \phpbb\pagination $pagination;

	/* @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/* @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/* @var \phpbbgallery\core\album\display */
	protected \phpbbgallery\core\album\display $display;

	/* @var \phpbbgallery\core\album\loader */
	protected \phpbbgallery\core\album\loader $loader;

	/* @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $auth;

	/* @var \phpbbgallery\core\auth\level */
	protected \phpbbgallery\core\auth\level $auth_level;

	/** @var \phpbbgallery\core\notification\helper */
	protected \phpbbgallery\core\notification\helper $notifications_helper;

	/** @var \phpbbgallery\core\url */
	protected \phpbbgallery\core\url $url;

	/** @var \phpbbgallery\core\image\image */
	protected \phpbbgallery\core\image\image $image;

	/** @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbb\request\request_interface */
	protected \phpbb\request\request_interface $request;

	/** @var \phpbbgallery\core\contest */
	protected \phpbbgallery\core\contest $contest;

	/* @var string */
	protected string $table_images;

	public const ALBUM_SHOW_IP = 128;
	public const ALBUM_SHOW_RATINGS = 64;
	public const ALBUM_SHOW_USERNAME = 32;
	public const ALBUM_SHOW_VIEWS = 16;
	public const ALBUM_SHOW_TIME = 8;
	public const ALBUM_SHOW_IMAGENAME = 4;
	public const ALBUM_SHOW_COMMENTS = 2;
	public const ALBUM_SHOW_ALBUM = 1;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config                                      $config       Config object
	 * @param \phpbb\controller\helper                                  $helper       Controller helper object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db           Database object
	 * @param \phpbb\pagination                                         $pagination   Pagination object
	 * @param \phpbb\template\template                                  $template     Template object
	 * @param \phpbb\user                                               $user         User object
	 * @param \phpbb\language\language                                  $language
	 * @param \phpbbgallery\core\album\display                          $display      Albums display object
	 * @param \phpbbgallery\core\album\loader                           $loader       Albums display object
	 * @param \phpbbgallery\core\auth\auth                              $auth         Gallery auth object
	 * @param \phpbbgallery\core\auth\level                             $auth_level   Gallery auth level object
	 * @param \phpbbgallery\core\config                                 $gallery_config
	 * @param \phpbbgallery\core\notification\helper                    $notifications_helper
	 * @param \phpbbgallery\core\url                                    $url
	 * @param \phpbbgallery\core\image\image                            $image
	 * @param \phpbb\request\request_interface                          $request
	 * @param string                                                    $images_table Gallery image table
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper,
		\phpbb\db\driver\driver_interface $db, \phpbb\pagination $pagination,
		\phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language,
		\phpbbgallery\core\album\display $display, \phpbbgallery\core\album\loader $loader,
		\phpbbgallery\core\auth\auth $auth, \phpbbgallery\core\auth\level $auth_level,
		\phpbbgallery\core\config $gallery_config, \phpbbgallery\core\notification\helper $notifications_helper,
		\phpbbgallery\core\url $url, \phpbbgallery\core\image\image $image, \phpbb\request\request_interface $request,
		\phpbbgallery\core\contest $contest,
		string $images_table)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->display = $display;
		$this->loader = $loader;
		$this->auth = $auth;
		$this->auth_level = $auth_level;
		$this->notifications_helper = $notifications_helper;
		$this->url = $url;
		$this->image = $image;
		$this->gallery_config = $gallery_config;
		$this->request = $request;
		$this->contest = $contest;
		$this->table_images = $images_table;
	}

	/**
	 * Album Controller
	 *    Route: gallery/album/{album_id}
	 *
	 * @param int $album_id Root Album ID
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function base(int $album_id, int $page = 1): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');

		try
		{
			$this->loader->load($album_id);
		}
		catch (\Exception $e)
		{
			throw new \phpbb\exception\http_exception(404, 'ALBUM_NOT_EXIST');
		}

		$album_data = $this->loader->get($album_id);

		if ($album_data['album_type'] == (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			if ($album_data['contest_id'] && $album_data['contest_marked'] && (($album_data['contest_start'] + $album_data['contest_end']) < time()))
			{
				$contest_end_time = $album_data['contest_start'] + $album_data['contest_end'];
				$this->contest->end($album_id, $album_data['contest_id'], $contest_end_time);

				$album_contest_data['contest_marked'] = (int) \phpbbgallery\core\block::NO_CONTEST;
			}
		}
		$this->check_permissions($album_id, $album_data['album_user_id'], $album_data['album_auth_access']);
		$this->auth_level->display($album_id, $album_data['album_status'], $album_data['album_user_id']);

		$this->display->generate_navigation($album_data);
		$album_display = $this->display->display_albums($album_data, $this->config['load_moderators']);

		$page_title = $album_data['album_name'];
		if ($page > 1)
		{
			$page_title .= ' - ' . $this->language->lang('PAGE_TITLE_NUMBER', $page);
		}

		if ($this->config['load_moderators'])
		{
			$moderators = $this->display->get_moderators($album_id);
			if (!empty($moderators[$album_id]))
			{
				$moderators = $moderators[$album_id];
				$l_moderator = (sizeof($moderators) == 1) ? $this->language->lang('MODERATOR') : $this->language->lang('MODERATORS');
				$this->template->assign_vars([
					'L_MODERATORS' => $l_moderator,
					'MODERATORS'   => implode($this->language->lang('COMMA_SEPARATOR'), $moderators),
				]);
			}
		}

		if ($this->auth->acl_check('m_', $album_id, $album_data['album_user_id']))
		{
			$this->template->assign_var('U_MCP', $this->helper->route(
				'phpbbgallery_core_moderate_album',
				['album_id' => (int) $album_id]
			));
		}

		if ((!$album_data['album_user_id'] || $album_data['album_user_id'] == $this->user->data['user_id'])
			&& ($this->user->data['user_id'] == ANONYMOUS || $this->auth->acl_check('i_upload', $album_id, $album_data['album_user_id'])))
		{
			if (!array_key_exists('contest_start', $album_data))
			{
				$this->template->assign_var('U_UPLOAD_IMAGE', $this->helper->route(
					'phpbbgallery_core_album_upload',
					['album_id' => (int) $album_id]
				));
			}
			else
			{
				if ($album_data['contest_start'] + $album_data['contest_rating'] > time())
				{
					$this->template->assign_var('U_UPLOAD_IMAGE', $this->helper->route(
						'phpbbgallery_core_album_upload',
						['album_id' => (int) $album_id]
					));
				}
			}
		}

		$this->template->assign_vars([
			'S_IS_POSTABLE' => $album_data['album_type'] != (int) \phpbbgallery\core\block::TYPE_CAT,
			'S_IS_LOCKED'   => $album_data['album_status'] == (int) \phpbbgallery\core\block::ALBUM_LOCKED,

			'U_RETURN_LINK'  => $this->helper->route('phpbbgallery_core_index'),
			'L_RETURN_LINK'  => $this->language->lang('RETURN_TO_GALLERY'),
			'S_ALBUM_ACTION' => $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $album_id]),
			'S_IS_WATCHED'   => $this->notifications_helper->get_watched_album($album_id) ? true : false,
			'U_WATCH_TOGGLE' => $this->helper->route('phpbbgallery_core_album_watch', ['album_id' => (int) $album_id]),
		]);

		if ($album_data['album_type'] != (int) \phpbbgallery\core\block::TYPE_CAT
			&& $album_data['album_images_real'] > 0)
		{
			$this->display_images($album_id, $album_data, ($page - 1) * (int) $this->config['phpbb_gallery_items_per_page'], (int) $this->config['phpbb_gallery_items_per_page'], $album_display[0]);
		}

//		phpbb_ext_gallery_core_misc::markread('album', $album_id);

		return $this->helper->render('gallery/album_body.html', $page_title);
	}

	/**
	 * @param int   $album_id
	 * @param array $album_data
	 * @param int   $start
	 * @param int   $limit
	 * @param array $descendant_album_ids
	 * @return void
	 */
	protected function display_images(int $album_id, array $album_data, int $start, int $limit, array $descendant_album_ids): void
	{
		$sort_days = $this->request->variable('st', 0);
		$sort_key = $this->request->variable('sk', ($album_data['album_sort_key']) ? $album_data['album_sort_key'] : $this->config['phpbb_gallery_default_sort_key']);
		$sort_dir = $this->request->variable('sd', ($album_data['album_sort_dir']) ? $album_data['album_sort_dir'] : $this->config['phpbb_gallery_default_sort_dir']);

		$image_status_check = ' AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED;

		$image_counter = $album_data['album_images'];

		$user_id = $this->user->data['user_id'];
		$album_owner_id = $album_data['album_user_id'];

		if ($this->auth->acl_check('m_status', $album_id, $album_owner_id))
		{
			$image_status_check = '';
			$image_counter = $album_data['album_images_real'];
		}
		else
		{
			$image_status_check = ' AND (image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . " OR image_user_id = $user_id)";

			$sql = 'SELECT COUNT(*) AS total_images
				FROM ' . $this->table_images . '
				WHERE image_album_id = ' . (int) $album_id . '
					AND (image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . " OR image_user_id = $user_id)
					AND image_status <> " . (int) \phpbbgallery\core\block::STATUS_ORPHAN;
			$result = $this->db->sql_query($sql);
			$image_counter = (int) $this->db->sql_fetchfield('total_images');
			$this->db->sql_freeresult($result);
		}

		// Keep pagination scoped to this album, but include images from individually
		// authorized descendants in the header total. display_albums() has already loaded
		// the branch and removed albums hidden by list/zebra rules, avoiding another tree query.
		$total_images_display = $image_counter;
		if ($album_data['right_id'] > $album_data['left_id'] + 1 && !empty($descendant_album_ids))
		{
			$total_images_display += $this->get_descendant_image_count($descendant_album_ids, $album_owner_id);
		}

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
		$sort_key = $this->normalize_sort_key($sort_key, $sort_by_sql);
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		$this->template->assign_block_vars('imageblock', [
			'BLOCK_NAME' => $album_data['album_name'],
		]);

		$images = [];
		$sql = 'SELECT *
			FROM ' . $this->table_images . '
			WHERE image_album_id = ' . (int) $album_id . "
				$image_status_check
				AND image_status <> " . (int) \phpbbgallery\core\block::STATUS_ORPHAN . "
			ORDER BY $sql_sort_order" . $sql_help_sort;
		$result = $this->db->sql_query_limit($sql, $limit, $start);

		// Now let's get display options
		$show_options = (int) $this->gallery_config->get('album_display');
		$show_ip = ($show_options & self::ALBUM_SHOW_IP) !== 0;
		$show_ratings = ($show_options & self::ALBUM_SHOW_RATINGS) !== 0;
		$show_username = ($show_options & self::ALBUM_SHOW_USERNAME) !== 0;
		$show_views = ($show_options & self::ALBUM_SHOW_VIEWS) !== 0;
		$show_time = ($show_options & self::ALBUM_SHOW_TIME) !== 0;
		$show_imagename = ($show_options & self::ALBUM_SHOW_IMAGENAME) !== 0;
		$show_comments = ($show_options & self::ALBUM_SHOW_COMMENTS) !== 0;
		$show_album = ($show_options & self::ALBUM_SHOW_ALBUM) !== 0;

		if (!empty($album_data['contest_marked']) && $album_data['contest_marked'])
		{
			$show_ratings = false;
		}

		while ($row = $this->db->sql_fetchrow($result))
		{
			// Assign the image to the template-block
			$image_data = array_merge($album_data, $row);
			$album_status = $image_data['album_status'];
			$album_user_id = $image_data['album_user_id'];

			//@todo: $rating = new phpbb_gallery_image_rating($image_data['image_id'], $image_data, $image_data);
			$image_data['rating'] = '0';//@todo: $rating->get_image_rating(false, false);
			//@todo: unset($rating);

			$s_user_allowed = (($image_data['image_user_id'] == $this->user->data['user_id']) && ($album_status != (int) \phpbbgallery\core\block::ALBUM_LOCKED));

			switch ($this->gallery_config->get('link_thumbnail'))
			{
				case 'image_page':
					$action = $this->helper->route('phpbbgallery_core_image', ['image_id' => $row['image_id']]);
				break;
				case 'image':
					$action = $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => $row['image_id']]);
				break;
				default:
					$action = false;
				break;
			}
			switch ($this->gallery_config->get('link_image_name'))
			{
				case 'image_page':
					$action_image = $this->helper->route('phpbbgallery_core_image', ['image_id' => $row['image_id']]);
				break;
				case 'image':
					$action_image = $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => $row['image_id']]);
				break;
				default:
					$action_image = false;
				break;
			}
			$s_allowed_delete = (($this->auth->acl_check('i_delete', $image_data['image_album_id'], $album_user_id) && $s_user_allowed) || $this->auth->acl_check('m_delete', $image_data['image_album_id'], $album_user_id));
			$s_allowed_edit = (($this->auth->acl_check('i_edit', $image_data['image_album_id'], $album_user_id) && $s_user_allowed) || $this->auth->acl_check('m_edit', $image_data['image_album_id'], $album_user_id));
			$s_quick_mod = ($s_allowed_delete || $s_allowed_edit || $this->auth->acl_check('m_status', $image_data['image_album_id'], $album_user_id) || $this->auth->acl_check('m_move', $image_data['image_album_id'], $album_user_id));

			$s_username_hidden = $image_data['image_contest'] && !$this->auth->acl_check('m_status', $image_data['image_album_id'], $album_user_id) && ($this->user->data['user_id'] != $image_data['image_user_id'] || $image_data['image_user_id'] == ANONYMOUS);
			$this->template->assign_block_vars('imageblock.image', [
				'IMAGE_ID'      => (int) $image_data['image_id'],
				'U_IMAGE'       => $action_image,
				'UC_IMAGE_NAME' => $show_imagename ? $image_data['image_name'] : false,
				'U_ALBUM'       => $show_album ? $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $album_data['album_id']]) : false,
				'ALBUM_NAME'    => $show_album ? $album_data['album_name'] : false,
				'IMAGE_VIEWS'   => $show_views ? (int) $image_data['image_view_count'] : -1,
				//'UC_THUMBNAIL'	=> 'self::generate_link('thumbnail', $phpbb_ext_gallery->config->get('link_thumbnail'), $image_data['image_id'], $image_data['image_name'], $image_data['image_album_id']),
				'UC_THUMBNAIL'        => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_data['image_id']]),
				'UC_THUMBNAIL_ACTION' => $action,
				'S_UNAPPROVED'        => ($this->auth->acl_check('m_status', $image_data['image_album_id'], $album_user_id) && ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED)) ? true : false,
				'S_LOCKED'            => ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_LOCKED) ? true : false,
				'S_REPORTED'          => ($this->auth->acl_check('m_report', $image_data['image_album_id'], $album_user_id) && $image_data['image_reported']) ? true : false,
				'POSTER'              => ($show_username) ? (($s_username_hidden) ? $this->language->lang('CONTEST_USERNAME') : get_username_string('full', $image_data['image_user_id'], $image_data['image_username'], $image_data['image_user_colour'])) : false,
				'TIME'                => $show_time ? $this->user->format_date($image_data['image_time']) : false,

				'S_RATINGS'  => ($this->config['phpbb_gallery_allow_rates'] == 1 && $show_ratings) ? ($image_data['image_rates'] > 0 ? $image_data['image_rate_avg'] / 100 : $this->language->lang('NOT_RATED')) : false,
				'U_RATINGS'  => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_data['image_id']]) . '#rating',
				'L_COMMENTS' => ($image_data['image_comments'] == 1) ? $this->language->lang('COMMENT') : $this->language->lang('COMMENTS'),
				'S_COMMENTS' => ($this->config['phpbb_gallery_allow_comments'] && $this->auth->acl_check('c_read', $image_data['image_album_id'], $album_user_id) && $show_comments) ? (($image_data['image_comments']) ? $image_data['image_comments'] : $this->language->lang('NO_COMMENTS')) : '',
				'U_COMMENTS' => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_data['image_id']]) . '#comments',

				'U_USER_IP'                  => $show_ip && $this->auth->acl_check('m_status', $image_data['image_album_id'], $album_user_id) ? $image_data['image_user_ip'] : false,
				'S_IMAGE_REPORTED'           => $image_data['image_reported'],
				'U_IMAGE_REPORTED'           => '',//($image_data['image_reported']) ? $phpbb_ext_gallery->url->append_sid('mcp', "mode=report_details&amp;album_id={$image_data['image_album_id']}&amp;option_id=" . $image_data['image_reported']) : '',
				'S_STATUS_APPROVED'          => ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_APPROVED) ? true : false,
				'S_STATUS_UNAPPROVED'        => ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED) ? true : false,
				'S_STATUS_UNAPPROVED_ACTION' => ($this->auth->acl_check('m_status', $image_data['image_album_id'], $album_user_id) && $image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED) ? $this->helper->route('phpbbgallery_core_moderate_image_approve', ['image_id' => $image_data['image_id']]) : '',
				'S_STATUS_LOCKED'            => ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_LOCKED) ? true : false,

				'U_REPORT' => ($this->auth->acl_check('m_report', $image_data['image_album_id'], $album_user_id) && $image_data['image_reported']) ? '123'/*$this->url->append_sid('mcp', "mode=report_details&amp;album_id={$image_data['image_album_id']}&amp;option_id=" . $image_data['image_reported'])*/ : '',
				'U_STATUS' => '',//($this->auth->acl_check('m_status', $image_data['image_album_id'], $album_user_id)) ? $phpbb_ext_gallery->url->append_sid('mcp', "mode=queue_details&amp;album_id={$image_data['image_album_id']}&amp;option_id=" . $image_data['image_id']) : '',
				'L_STATUS' => ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED) ? $this->language->lang('APPROVE_IMAGE') : (($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_APPROVED) ? $this->language->lang('CHANGE_IMAGE_STATUS') : $this->language->lang('UNLOCK_IMAGE')),

				'S_CONTEST_RANK' => $image_data['image_contest_rank'],
			]);
		}
		$this->db->sql_freeresult($result);

		$this->pagination->generate_template_pagination([
			'routes' => [
				'phpbbgallery_core_album',
				'phpbbgallery_core_album_page',
			],
			'params' => [
				'album_id' => (int) $album_id,
				'sk'       => $sort_key,
				'sd'       => $sort_dir,
				'st'       => $sort_days,
			],
		], 'pagination', 'page', $image_counter, $limit, $start);

		$this->template->assign_vars([
			'TOTAL_IMAGES'      => $this->language->lang('VIEW_ALBUM_IMAGES', $total_images_display),
			'S_SELECT_SORT_DIR' => $s_sort_dir,
			'S_SELECT_SORT_KEY' => $s_sort_key,
		]);
	}

	/**
	 * Count images in descendants that the current user may view.
	 * Moderation and view permissions are evaluated per album. Non-moderators only count
	 * approved/locked images plus their own unapproved images. Orphans are always excluded.
	 *
	 * @param array $album_ids Descendants already filtered by list and zebra visibility
	 * @param int   $album_owner_id
	 * @return int
	 */
	protected function get_descendant_image_count(array $album_ids, int $album_owner_id): int
	{
		$viewable_album_ids = [];
		$moderated_album_ids = [];
		foreach (array_unique(array_map('intval', $album_ids)) as $album_id)
		{
			if ($album_id <= 0 || !$this->auth->acl_check('i_view', $album_id, $album_owner_id))
			{
				continue;
			}

			$viewable_album_ids[] = $album_id;
			if ($this->auth->acl_check('m_status', $album_id, $album_owner_id))
			{
				$moderated_album_ids[] = $album_id;
			}
		}

		if (empty($viewable_album_ids))
		{
			return 0;
		}

		$standard_album_ids = array_values(array_diff($viewable_album_ids, $moderated_album_ids));
		$visibility_sql = [];
		if (!empty($standard_album_ids))
		{
			$visibility_sql[] = '(' . $this->db->sql_in_set('image_album_id', $standard_album_ids) . '
				AND (image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
					OR image_user_id = ' . (int) $this->user->data['user_id'] . '))';
		}
		if (!empty($moderated_album_ids))
		{
			$visibility_sql[] = $this->db->sql_in_set('image_album_id', $moderated_album_ids);
		}

		$sql = 'SELECT COUNT(image_id) AS total_images
			FROM ' . $this->table_images . '
			WHERE (' . implode(' OR ', $visibility_sql) . ')
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN;
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total_images');
		$this->db->sql_freeresult($result);

		return $total;
	}

	/**
	 * @param int $album_id
	 * @return \Symfony\Component\HttpFoundation\Response|null
	 */
	public function watch(int $album_id): \Symfony\Component\HttpFoundation\Response|null
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');

		$album_data = $this->loader->get($album_id);

		$this->check_permissions($album_id, $album_data['album_user_id'], $album_data['album_auth_access']);
		if (confirm_box(true))
		{
			$back_link = $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $album_id]);
			if ($this->notifications_helper->get_watched_album($album_id) == 1)
			{
				$this->notifications_helper->remove_albums($album_id);
				$this->template->assign_vars([
					'INFORMATION' => $this->language->lang('UNWATCH_ALBUM'),
				]);
				$this->url->meta_refresh(3, $back_link);
				return $this->helper->render('gallery/message.html', $this->language->lang('GALLERY'));
			}
			else
			{
				$this->notifications_helper->add_albums($album_id);
				$this->template->assign_vars([
					'INFORMATION' => $this->language->lang('WATCH_ALBUM'),
				]);
				$this->url->meta_refresh(3, $back_link);
				return $this->helper->render('gallery/message.html', $this->language->lang('GALLERY'));
			}
		}
		else
		{
			if ($this->notifications_helper->get_watched_album($album_id) == 1)
			{
				$lang = $this->language->lang('UNWATCH_ALBUM');
			}
			else
			{
				$lang = $this->language->lang('WATCH_ALBUM');
			}
			$s_hidden_fields = '';
			confirm_box(false, $lang, $s_hidden_fields);
		}
		//return $this->helper->render('gallery/moderate_approve.html', $this->language->lang('GALLERY'));
	}

	/**
	 * @param int $album_id
	 * @param int $owner_id
	 * @param int $album_auth_level
	 * @internal param array $album_data
	 * @return void
	 */
	protected function check_permissions(int $album_id, int $owner_id, int $album_auth_level): void
	{
		$this->auth->load_user_permissions($this->user->data['user_id']);
		$zebra_array = $this->auth->get_user_zebra($this->user->data['user_id']);
		if (!$this->auth->acl_check('i_view', $album_id, $owner_id) || $this->auth->get_zebra_state($zebra_array, (int) $owner_id, (int) $album_id) < (int) $album_auth_level)
		{
			if ($this->user->data['is_bot'])
			{
				// Redirect bots back to the index
				redirect($this->helper->route('phpbbgallery_core_index'));
			}

			// Display login box for guests and an error for users
			if (!$this->user->data['is_registered'])
			{
				login_box();
			}
			else
			{
				//return $this->error('NOT_AUTHORISED', 403);
				trigger_error($this->language->lang('NOT_AUTHORISED'));
			}
		}
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
