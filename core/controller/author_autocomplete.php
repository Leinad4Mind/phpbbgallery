<?php
/**
 * phpBB Gallery - alternate-author autocomplete controller
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

use phpbb\auth\auth as phpbb_auth;
use phpbb\config\config as phpbb_config;
use phpbb\db\driver\driver_interface;
use phpbb\request\request_interface;
use phpbb\user;
use phpbbgallery\core\auth\auth as gallery_auth;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return bounded username suggestions to album moderators only.
 */
final class author_autocomplete
{
	public function __construct(
		private driver_interface $db,
		private request_interface $request,
		private user $user,
		private gallery_auth $gallery_auth,
		private phpbb_auth $phpbb_auth,
		private phpbb_config $config,
		private string $users_table,
		private string $albums_table
	)
	{
	}

	public function search(int $album_id): JsonResponse
	{
		if ($album_id < 1 || empty($this->user->data['is_registered']) || !empty($this->user->data['is_bot']))
		{
			return $this->response([], 403);
		}

		$sql_ary = [
			'SELECT' => 'a.album_user_id',
			'FROM'   => [$this->albums_table => 'a'],
			'WHERE'  => 'a.album_id = ' . (int) $album_id,
		];
		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
		$album_owner = $this->db->sql_fetchfield('album_user_id', false, $result);
		$this->db->sql_freeresult($result);
		if ($album_owner === false)
		{
			return $this->response([], 403);
		}

		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('m_edit', $album_id, (int) $album_owner))
		{
			return $this->response([], 403);
		}

		return $this->find_users();
	}

	/**
	 * Suggest authors from the standard Gallery search form.
	 */
	public function global_search(): JsonResponse
	{
		if (!$this->phpbb_auth->acl_get('u_search') || empty($this->config['load_search']))
		{
			return $this->response([], 403);
		}

		return $this->find_users();
	}

	private function find_users(): JsonResponse
	{
		$term = utf8_clean_string($this->request->variable('term', '', true));
		if (utf8_strlen($term) < 2)
		{
			return $this->response([]);
		}

		$like = $this->db->sql_like_expression(
			$this->db->sql_escape($term) . $this->db->get_any_char()
		);
		$sql_ary = [
			'SELECT'   => 'u.username',
			'FROM'     => [$this->users_table => 'u'],
			'WHERE'    => 'u.username_clean ' . $like . '
				AND ' . $this->db->sql_in_set('u.user_type', [USER_NORMAL, USER_FOUNDER]),
			'ORDER_BY' => 'u.username_clean ASC',
		];
		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_ary), 10);
		$users = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$username = (string) $row['username'];
			$users[] = ['label' => $username, 'value' => $username];
		}
		$this->db->sql_freeresult($result);

		return $this->response($users);
	}

	private function response(array $data, int $status = 200): JsonResponse
	{
		$response = new JsonResponse($data, $status);
		$response->headers->set('Cache-Control', 'private, no-store');
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		$response->headers->set('X-Robots-Tag', 'noindex');
		return $response;
	}
}
