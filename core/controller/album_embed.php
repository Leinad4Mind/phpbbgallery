<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Permission-filtered album pages consumed by Gallery album BBCodes.
 */
class album_embed
{
	public const ITEMS_PER_PAGE = 8;

	private \phpbb\db\driver\driver_interface $db;
	private \phpbb\request\request_interface $request;
	private \phpbb\user $user;
	private \phpbb\language\language $language;
	private \phpbb\controller\helper $helper;
	private \phpbbgallery\core\album\loader $loader;
	private \phpbbgallery\core\auth\auth $auth;
	private \phpbbgallery\core\config $gallery_config;
	private \phpbbgallery\core\unread_counter $unread_counter;
	private string $images_table;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request_interface $request,
		\phpbb\user $user, \phpbb\language\language $language, \phpbb\controller\helper $helper,
		\phpbbgallery\core\album\loader $loader, \phpbbgallery\core\auth\auth $auth,
		\phpbbgallery\core\config $gallery_config, \phpbbgallery\core\unread_counter $unread_counter,
		string $images_table)
	{
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->loader = $loader;
		$this->auth = $auth;
		$this->gallery_config = $gallery_config;
		$this->unread_counter = $unread_counter;
		$this->images_table = $images_table;
	}

	public function page(int $album_id): JsonResponse
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		try
		{
			$this->loader->load($album_id);
			$album = $this->loader->get($album_id);
		}
		catch (\Exception)
		{
			return $this->response(['error' => $this->language->lang('ALBUM_NOT_EXIST')], 404);
		}

		$user_id = (int) $this->user->data['user_id'];
		$owner_id = (int) $album['album_user_id'];
		$this->auth->load_user_permissions($user_id);
		$zebra = $this->auth->get_user_zebra($user_id);
		if (!$this->auth->acl_check('i_view', $album_id, $owner_id)
			|| $this->auth->get_zebra_state($zebra, $owner_id, $album_id) < (int) $album['album_auth_access'])
		{
			return $this->response(['error' => $this->language->lang('NOT_AUTHORISED')], 403);
		}

		$can_moderate = $this->auth->acl_check('m_status', $album_id, $owner_id);
		$where = 'image_album_id = ' . (int) $album_id . '
			AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
			AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;
		if (!$can_moderate)
		{
			$where .= ' AND (image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED
				. ' OR image_user_id = ' . $user_id . ')';
		}

		$sql = 'SELECT COUNT(*) AS total_images
			FROM ' . $this->images_table . '
			WHERE ' . $where;
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total_images');
		$this->db->sql_freeresult($result);

		$pages = max(1, (int) ceil($total / self::ITEMS_PER_PAGE));
		$page = min($pages, max(1, $this->request->variable('page', 1)));
		$start = ($page - 1) * self::ITEMS_PER_PAGE;
		[$sort_column, $sort_direction] = $this->sort_order($album);

		$sql = 'SELECT image_id, image_name
			FROM ' . $this->images_table . '
			WHERE ' . $where . '
			ORDER BY ' . $sort_column . ' ' . $sort_direction . ', image_id ' . $sort_direction;
		$result = $this->db->sql_query_limit($sql, self::ITEMS_PER_PAGE, $start);
		$images = [];
		$image_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_id = (int) $row['image_id'];
			$image_ids[] = $image_id;
			$images[] = [
				'image_id' => $image_id,
				'image_name' => (string) $row['image_name'],
				'thumbnail_url' => $this->helper->route(
					'phpbbgallery_core_image_file_mini',
					['image_id' => $image_id],
					false
				),
				'view_url' => $this->helper->route(
					'phpbbgallery_core_image',
					['image_id' => $image_id],
					false
				),
			];
		}
		$this->db->sql_freeresult($result);
		$this->unread_counter->mark_viewed_many($image_ids);

		return $this->response([
			'album' => [
				'album_id' => (int) $album_id,
				'album_name' => (string) $album['album_name'],
				'view_url' => $this->helper->route(
					'phpbbgallery_core_album',
					['album_id' => (int) $album_id],
					false
				),
			],
			'images' => $images,
			'pagination' => [
				'page' => $page,
				'pages' => $pages,
				'per_page' => self::ITEMS_PER_PAGE,
				'total' => $total,
			],
			'labels' => [
				'empty' => $this->language->lang('NO_IMAGES_LONG'),
				'previous' => $this->language->lang('PREVIOUS'),
				'next' => $this->language->lang('NEXT'),
				'page' => $page . ' / ' . $pages,
			],
		]);
	}

	/**
	 * Resolve the album's persisted sort without accepting arbitrary SQL.
	 *
	 * @return array{0: string, 1: string}
	 */
	private function sort_order(array $album): array
	{
		$columns = [
			't' => 'image_time',
			'n' => 'image_name_clean',
			'vc' => 'image_view_count',
			'u' => 'image_username_clean',
			'ra' => 'image_rate_points',
			'r' => 'image_rates',
			'c' => 'image_comments',
			'lc' => 'image_last_comment',
		];
		$key = (string) ($album['album_sort_key'] ?: $this->gallery_config->get('default_sort_key'));
		$direction = (string) ($album['album_sort_dir'] ?: $this->gallery_config->get('default_sort_dir'));

		return [
			$columns[$key] ?? $columns['t'],
			$direction === 'a' ? 'ASC' : 'DESC',
		];
	}

	private function response(array $data, int $status = 200): JsonResponse
	{
		$response = new JsonResponse($data, $status);
		$response->headers->set('Cache-Control', 'private, no-store');
		$response->headers->set('X-Content-Type-Options', 'nosniff');

		return $response;
	}
}
