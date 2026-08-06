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

namespace phpbbgallery\core;

class moderate
{
	/**
	 * @var \phpbb\db\driver\driver_interface
	 */
	protected \phpbb\db\driver\driver_interface $db;

	/**
	 * @var \phpbb\template\template
	 */
	protected \phpbb\template\template $template;

	/**
	 * @var \phpbb\controller\helper
	 */
	protected \phpbb\controller\helper $helper;

	/**
	 * @var \phpbb\user
	 */
	protected \phpbb\user $user;

	/**
	 * @var \phpbb\language\language
	 */
	protected \phpbb\language\language $lang;

	/**
	 * @var \phpbb\user_loader
	 */
	protected \phpbb\user_loader $user_loader;

	/**
	 * @var \phpbbgallery\core\album\album
	 */
	protected \phpbbgallery\core\album\album $album;

	/**
	 * @var \phpbbgallery\core\auth\auth
	 */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/**
	 * @var \phpbb\pagination
	 */
	protected \phpbb\pagination $pagination;

	/**
	 * @var \phpbbgallery\core\comment
	 */
	protected \phpbbgallery\core\comment $comment;

	/**
	 * @var \phpbbgallery\core\report
	 */
	protected \phpbbgallery\core\report $report;

	/**
	 * @var \phpbbgallery\core\image\image
	 */
	protected \phpbbgallery\core\image\image $image;

	/**
	 * @var \phpbbgallery\core\config
	 */
	protected \phpbbgallery\core\config $gallery_config;

	/**
	 * @var \phpbbgallery\core\notification
	 */
	protected \phpbbgallery\core\notification $gallery_notification;

	/**
	 * @var \phpbbgallery\core\rating
	 */
	protected \phpbbgallery\core\rating $gallery_rating;

	/** @var \phpbbgallery\core\notification\helper|null Moderation notification service */
	protected ?\phpbbgallery\core\notification\helper $notification_helper = null;

	/**
	 * @var string
	 */
	protected string $images_table;

	/**
	 * @var string
	 */
	protected string $albums_table;

	/**
	 * moderate constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\template\template          $template
	 * @param \phpbb\controller\helper          $helper
	 * @param \phpbb\user                       $user
	 * @param \phpbb\language\language          $lang
	 * @param \phpbb\user_loader                $user_loader
	 * @param \phpbbgallery\core\album\album   $album
	 * @param \phpbbgallery\core\auth\auth     $gallery_auth
	 * @param \phpbb\pagination                 $pagination
	 * @param \phpbbgallery\core\comment       $comment
	 * @param \phpbbgallery\core\report        $report
	 * @param \phpbbgallery\core\image\image   $image
	 * @param \phpbbgallery\core\config        $gallery_config
	 * @param \phpbbgallery\core\notification  $gallery_notification
	 * @param \phpbbgallery\core\rating        $gallery_rating
	 * @param string                            $images_table
	 * @param string                            $albums_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\user $user,
		\phpbb\language\language $lang,
		\phpbb\user_loader $user_loader, \phpbbgallery\core\album\album $album, \phpbbgallery\core\auth\auth $gallery_auth, \phpbb\pagination $pagination,
		\phpbbgallery\core\comment $comment, \phpbbgallery\core\report $report, \phpbbgallery\core\image\image $image,
		\phpbbgallery\core\config $gallery_config, \phpbbgallery\core\notification $gallery_notification, \phpbbgallery\core\rating $gallery_rating,
		string $images_table, string $albums_table)
	{
		$this->db = $db;
		$this->template = $template;
		$this->helper = $helper;
		$this->user = $user;
		$this->lang = $lang;
		$this->user_loader = $user_loader;
		$this->album = $album;
		$this->gallery_auth = $gallery_auth;
		$this->pagination = $pagination;
		$this->comment = $comment;
		$this->report = $report;
		$this->image = $image;
		$this->gallery_config = $gallery_config;
		$this->gallery_notification = $gallery_notification;
		$this->gallery_rating = $gallery_rating;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
	}

	public function set_notification_helper(\phpbbgallery\core\notification\helper $notification_helper): void
	{
		$this->notification_helper = $notification_helper;
	}

	/**
	 * Helper function building queues
	 *
	 * @param int $album    album we build queue for
	 * @param int $page     This queue builder should return objects for MCP queues, so page?
	 * @param int $per_page We need how many elements per page
	 * @return void
	 */
	public function build_list(int $album, int $page = 1, int $per_page = 0): void
	{
		// So if we are not forcing par page get it from config
		if ($per_page == 0)
		{
			$per_page = $this->gallery_config->get('items_per_page');
		}
		// Let's get albums that user can moderate
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		// Get albums we can approve in
		$mod_array = [];
		if ($album === 0)
		{
			$mod_array = $this->gallery_auth->acl_album_ids('m_status');
			if (empty($mod_array))
			{
				$mod_array[] = 0;
			}
		}
		else
		{
			$approve_album = $this->album->get_info($album);
			$mod_array = $approve_album
				&& $this->gallery_auth->acl_check('m_status', $album, (int) $approve_album['album_user_id'])
				? [$album]
				: [0];
		}
		// Let's get count of unapproved
		$sql = 'SELECT COUNT(DISTINCT image_id) as count 
			FROM ' . $this->images_table . ' 
			WHERE image_status = ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ' AND ' . $this->db->sql_in_set('image_album_id', $mod_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$count = $row['count'];
		// If user has no albums to have e return him
		$sql = 'SELECT i.*, a.album_name
			FROM ' . $this->images_table . ' i
			INNER JOIN ' . $this->albums_table . ' a
				ON a.album_id = i.image_album_id
			WHERE i.image_status = ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . ' AND ' . $this->db->sql_in_set('i.image_album_id', $mod_array) . '
			ORDER BY i.image_id DESC';
		$page = $page - 1;
		$result = $this->db->sql_query_limit($sql, $per_page, $page * $per_page);

		$waiting_images = $users_array = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$waiting_images[] = [
				'image_id'       => $row['image_id'],
				'image_name'     => $row['image_name'],
				'image_author'   => (int) $row['image_user_id'],
				'image_time'     => $row['image_time'],
				'image_album_id' => $row['image_album_id'],
				'album_name'     => $row['album_name'],
			];
			$users_array[$row['image_user_id']] = [''];
		}
		$this->db->sql_freeresult($result);

		// Deletion requests deliberately use m_delete rather than m_status: an
		// album may delegate permanent deletion without delegating approvals.
		if ($album === 0)
		{
			$delete_mod_array = $this->gallery_auth->acl_album_ids('m_delete');
		}
		else
		{
			$delete_album = $this->album->get_info($album);
			$delete_mod_array = $delete_album
				&& $this->gallery_auth->acl_check('m_delete', $album, (int) $delete_album['album_user_id'])
				? [$album]
				: [];
		}
		if (!$delete_mod_array)
		{
			$delete_mod_array = [0];
		}

		$sql = 'SELECT COUNT(DISTINCT image_id) AS count
			FROM ' . $this->images_table . '
			WHERE image_status = ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_album_id', $delete_mod_array);
		$result = $this->db->sql_query($sql);
		$delete_count = (int) $this->db->sql_fetchfield('count');
		$this->db->sql_freeresult($result);

		$sql = 'SELECT i.*, a.album_name
			FROM ' . $this->images_table . ' i
			INNER JOIN ' . $this->albums_table . ' a
				ON a.album_id = i.image_album_id
			WHERE i.image_status = ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('i.image_album_id', $delete_mod_array) . '
			ORDER BY i.image_delete_request_time DESC, i.image_id DESC';
		$result = $this->db->sql_query_limit($sql, $per_page, $page * $per_page);
		$delete_requests = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$delete_requests[] = $row;
			$users_array[(int) $row['image_user_id']] = [''];
		}
		$this->db->sql_freeresult($result);

		if ($users_array)
		{
			$this->user_loader->load_users(array_keys($users_array));
		}

		foreach ($waiting_images as $image_data)
		{
			$this->template->assign_block_vars('image_unapproved', [
				'U_IMAGE_ID'           => $image_data['image_id'],
				'U_IMAGE'              => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_data['image_id']]),
				'U_IMAGE_URL'          => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_data['image_id']]),
				'U_IMAGE_MODERATE_URL' => $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $image_data['image_id']]),
				'U_IMAGE_NAME'         => $image_data['image_name'],
				'IMAGE_AUTHOR'         => $this->user_loader->get_username($image_data['image_author'], 'full'),
				'IMAGE_TIME'           => $this->user->format_date($image_data['image_time']),
				'IMAGE_ALBUM'          => $image_data['album_name'],
				'IMAGE_ALBUM_URL'      => $this->helper->route('phpbbgallery_core_album', ['album_id' => $image_data['image_album_id']]),
				'IMAGE_ALBUM_ID'       => $image_data['image_album_id'],
			]);
		}
		foreach ($delete_requests as $image_data)
		{
			$this->template->assign_block_vars('image_delete_requested', [
				'U_IMAGE_ID'           => (int) $image_data['image_id'],
				'U_IMAGE'              => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => (int) $image_data['image_id']]),
				'U_IMAGE_MODERATE_URL' => $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => (int) $image_data['image_id']]),
				'U_IMAGE_NAME'         => $image_data['image_name'],
				'IMAGE_AUTHOR'         => $this->user_loader->get_username((int) $image_data['image_user_id'], 'full'),
				'IMAGE_TIME'           => $this->user->format_date((int) $image_data['image_delete_request_time']),
				'IMAGE_ALBUM'          => $image_data['album_name'],
				'IMAGE_ALBUM_URL'      => $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $image_data['image_album_id']]),
				'IMAGE_ALBUM_ID'       => (int) $image_data['image_album_id'],
			]);
		}
		$this->template->assign_vars([
			'TOTAL_IMAGES_WAITING'     => $this->lang->lang('WAITING_UNAPPROVED_IMAGE', (int) $count),
			'TOTAL_DELETE_REQUESTS'    => $this->lang->lang('WAITING_DELETE_REQUESTS', $delete_count),
			'S_GALLERY_APPROVE_ACTION' => $album > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'),
		]);
		$count = max((int) $count, $delete_count);
		if ($album === 0)
		{
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_moderate_queue_approve',
					'phpbbgallery_core_moderate_queue_approve_page',
				],
				'params' => [],
			], 'pagination', 'page', $count, $per_page, $page * $per_page);
			$this->template->assign_vars([
				'TOTAL_PAGES' => $this->lang->lang('PAGE_TITLE_NUMBER', $page + 1),
			]);
		}
		else
		{
			$this->pagination->generate_template_pagination([
				'routes' => [
					'phpbbgallery_core_moderate_queue_approve_album',
					'phpbbgallery_core_moderate_queue_approve_album_page',
				],
				'params' => [
					'album_id' => $album,
				],
			], 'pagination', 'page', $count, $per_page, $page * $per_page);
			$this->template->assign_vars([
				'TOTAL_PAGES' => $this->lang->lang('PAGE_TITLE_NUMBER', $page + 1),
			]);
		}
	}

	/**
	 * Build album overview
	 *
	 * @param int $album_id
	 * @param int $page     This queue builder should return objects for MCP queues, so page?
	 * @param int $per_page We need how many elements per page
	 * @return void
	 */
	public function album_overview(int $album_id, int $page = 1, int $per_page = 0): void
	{
		// So if we are not forcing par page get it from config
		if ($per_page == 0)
		{
			$per_page = $this->gallery_config->get('items_per_page');
		}
		// Let's get albums that user can moderate
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		// we have security in the controller, so no need to be paranoid ...
		// and we will build queue with only items user can review
		if (!isset($album_id))
		{
			return;
		}
		// Let's see what the user can do?
		$status[] = 1;
		$actions = [];
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$album = $this->album->get_info($album_id);
		if ($this->gallery_auth->acl_check('m_status', $album['album_id'], $album['album_user_id']))
		{
			$status[] = 0;
			$status[] = 2;
			$actions['approve'] = 'QUEUES_A_APPROVE';
			$actions['unapprove'] = 'QUEUES_A_UNAPPROVE';
			$actions['lock'] = 'QUEUES_A_LOCK';
		}
		if ($this->gallery_auth->acl_check('m_delete', $album['album_id'], $album['album_user_id']))
		{
			$actions['delete'] = 'QUEUES_A_DELETE';
		}
		if ($this->gallery_auth->acl_check('m_move', $album['album_id'], $album['album_user_id']))
		{
			$actions['move'] = 'QUEUES_A_MOVE';
		}
		if ($this->gallery_auth->acl_check('m_edit', $album['album_id'], $album['album_user_id']))
		{
			$actions['change_author'] = 'CHANGE_AUTHOR';
			$actions['rename'] = 'RENAME_IMAGES';
		}
		if ($this->gallery_auth->acl_check('m_report', $album['album_id'], $album['album_user_id']))
		{
			$actions['report'] = 'REPORT_A_CLOSE';
		}
		$sql = 'SELECT COUNT(DISTINCT image_id) AS count FROM ' . $this->images_table . ' WHERE ' . $this->db->sql_in_set('image_status', $status) . ' AND image_album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$count = $row['count'];
		$sql = 'SELECT * FROM ' . $this->images_table . ' WHERE ' . $this->db->sql_in_set('image_status', $status) . ' AND image_album_id = ' . (int) $album_id . ' ORDER BY image_id DESC';

		$result = $this->db->sql_query_limit($sql, $per_page, ($page - 1) * $per_page);
		$users_array = [];
		$images = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$images[] = [
				'image_id'             => $row['image_id'],
				'image_filename'       => $row['image_filename'],
				'image_name'           => $row['image_name'],
				'image_name_clean'     => $row['image_name_clean'],
				'image_desc'           => $row['image_desc'],
				'image_desc_uid'       => $row['image_desc_uid'],
				'image_desc_bitfield'  => $row['image_desc_bitfield'],
				'image_user_id'        => $row['image_user_id'],
				'image_username'       => $row['image_username'],
				'image_username_clean' => $row['image_username_clean'],
				'image_user_colour'    => $row['image_user_colour'],
				'image_user_ip'        => $row['image_user_ip'],
				'image_time'           => $row['image_time'],
				'image_album_id'       => $row['image_album_id'],
				'image_view_count'     => $row['image_view_count'],
				'image_status'         => $row['image_status'],
				'image_filemissing'    => $row['image_filemissing'],
				'image_rates'          => $row['image_rates'],
				'image_rate_points'    => $row['image_rate_points'],
				'image_rate_avg'       => $row['image_rate_avg'],
				'image_comments'       => $row['image_comments'],
				'image_last_comment'   => $row['image_last_comment'],
				'image_allow_comments' => $row['image_allow_comments'],
				'image_favorited'      => $row['image_favorited'],
				'image_reported'       => $row['image_reported'],
				'filesize_upload'      => $row['filesize_upload'],
				'filesize_medium'      => $row['filesize_medium'],
				'filesize_cache'       => $row['filesize_cache'],
			];
			$users_array[$row['image_user_id']] = [''];
		}
		$this->db->sql_freeresult($result);

		if (empty($users_array))
		{
			return;
		}

		// Load users
		$this->user_loader->load_users(array_keys($users_array));
		foreach ($images as $var)
		{
			$this->template->assign_block_vars('overview', [
				'U_IMAGE_ID'           => $var['image_id'],
				'U_IMAGE'              => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $var['image_id']]),
				'U_IMAGE_URL'          => $this->helper->route('phpbbgallery_core_image', ['image_id' => $var['image_id']]),
				'U_IMAGE_MODERATE_URL' => $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $var['image_id']]),
				'U_IMAGE_NAME'         => $var['image_name'],
				'IMAGE_AUTHOR'         => $this->user_loader->get_username($var['image_user_id'], 'full'),
				'IMAGE_TIME'           => $this->user->format_date($var['image_time']),
				'IMAGE_ALBUM'          => $album['album_name'],
				'IMAGE_ALBUM_URL'      => $this->helper->route('phpbbgallery_core_album', ['album_id' => $var['image_album_id']]),
				'IMAGE_ALBUM_ID'       => $var['image_album_id'],
				'U_IS_REPORTED'        => $this->gallery_auth->acl_check('m_report', $album['album_id'], $album['album_user_id']) && $var['image_reported'] > 0 ? true : false,
				'U_IS_UNAPPROVED'      => $var['image_status'] == 0 ? true : false,
				'U_IS_LOCKED'          => $var['image_status'] == 2 ? true : false,
			]);
		}

		$this->pagination->generate_template_pagination([
			'routes' => [
				'phpbbgallery_core_moderate_view',
				'phpbbgallery_core_moderate_view_page',
			],
			'params' => [
				'album_id' => $album_id,
			],
		], 'pagination', 'page', $count, $per_page, ($page - 1) * $per_page);

		$select = '<select name="select_action" id="select_action">';
		foreach ($actions as $id => $var)
		{
			$select .= '<option value="' . $id . '">' . $this->lang->lang($var) . '</option>';
		}
		$select .= '</select>';
		$this->template->assign_vars([
			'TOTAL_PAGES'                        => $this->lang->lang('PAGE_TITLE_NUMBER', $page),
			'S_GALLERY_MODERATE_OVERVIEW_ACTION' => $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]),
			'U_ACTION_SELECT'                    => $select,
		]);
	}

	/**
	 * Delete images and all related domain data.
	 *
	 * @param array       $images Image identifiers
	 * @param array|false $files  Known filenames, or false to resolve them later
	 * @return void
	 */
	public function delete_images(array $images, array|false $files = []): void
	{
		$notification_rows = $this->load_notification_rows($images);
		if ($files === false)
		{
			$files = [];
		}

		// handle_counter excludes unapproved, orphan and pending-deletion rows,
		// therefore only images still represented in public counters are removed.
		$this->image->handle_counter($images, false);

		// We are going to do some cleanup
		$this->gallery_rating->loader(0);
		$this->gallery_rating->delete_ratings($images);
		$this->comment->delete_images($images);
		$this->gallery_notification->delete_images($images);
		$this->report->delete_images($images);
		if ($this->image->delete_images($images, $files) && $this->notification_helper !== null)
		{
			$rejected_rows = array_values(array_filter($notification_rows, static fn(array $row): bool =>
				(int) $row['image_status'] === (int) \phpbbgallery\core\block::STATUS_UNAPPROVED
			));
			$moderated_rows = array_values(array_filter($notification_rows, static fn(array $row): bool =>
				(int) $row['image_status'] !== (int) \phpbbgallery\core\block::STATUS_UNAPPROVED
			));
			if ($rejected_rows)
			{
				$this->notification_helper->notify_moderation('rejected', $rejected_rows, 'm_status');
			}
			if ($moderated_rows)
			{
				$this->notification_helper->notify_removed_authors($moderated_rows);
				$this->notification_helper->notify_moderation('deleted', $moderated_rows, 'm_delete');
			}
		}
	}

	/**
	 * Permanently delete only images still awaiting deletion review.
	 */
	public function delete_requested_images(array $images): int
	{
		$notification_rows = $this->load_notification_rows($images);
		$this->gallery_rating->loader(0);
		$deleted = $this->image->delete_images_matching_status_ids(
			$images,
			\phpbbgallery\core\block::STATUS_DELETE_REQUESTED
		);
		if (!$deleted)
		{
			return 0;
		}

		$this->gallery_rating->delete_ratings($deleted);
		$this->comment->delete_images($deleted);
		$this->gallery_notification->delete_images($deleted);
		$this->report->delete_images($deleted);
		if ($this->notification_helper !== null)
		{
			$deleted_lookup = array_fill_keys(array_map('intval', $deleted), true);
			$deleted_rows = array_values(array_filter($notification_rows, static fn(array $row): bool =>
				isset($deleted_lookup[(int) $row['image_id']])
			));
			$this->notification_helper->notify_removed_authors($deleted_rows);
			$this->notification_helper->notify_moderation('deleted', $deleted_rows, 'm_delete');
		}

		return count($deleted);
	}

	/**
	 * Load immutable notification data before image rows are removed.
	 *
	 * @param array $images Image identifiers
	 * @return array
	 */
	private function load_notification_rows(array $images): array
	{
		if ($this->notification_helper === null)
		{
			return [];
		}

		$images = array_values(array_unique(array_filter(array_map('intval', $images))));
		if (!$images)
		{
			return [];
		}

		$sql = 'SELECT image_id, image_user_id, image_album_id, image_status
			FROM ' . $this->images_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $images);
		$result = $this->db->sql_query($sql);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}
}
