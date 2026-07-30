<?php
/**
 * phpBB Gallery - Viewonline location resolver
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

class online_location
{
	/** @var array<int, array|false> */
	private array $albums = [];

	/** @var array<int, array|false> */
	private array $images = [];

	/** @var array<string, array<int, int>> */
	private array $zebra = [];

	private bool $permissions_loaded = false;

	public function __construct(
		private \phpbb\db\driver\driver_interface $db,
		private \phpbbgallery\core\auth\auth $gallery_auth,
		private \phpbb\user $user,
		private \phpbb\language\language $language,
		private \phpbb\controller\helper $helper,
		private \phpbbgallery\core\config $gallery_config,
		private string $albums_table,
		private string $images_table
	)
	{
	}

	/**
	 * Resolve a stored phpBB session page to a permission-safe Gallery location.
	 *
	 * @param string $session_page Stored phpBB session page
	 * @return array{location: string, location_url: string}|null
	 */
	public function resolve(string $session_page): ?array
	{
		$segments = $this->gallery_segments($session_page);
		if ($segments === null)
		{
			return null;
		}

		if ($segments === [])
		{
			return $this->gallery_location('VIEWING_GALLERY');
		}

		switch ($segments[0])
		{
			case 'album':
				return $this->album_location($segments);

			case 'image':
				return $this->image_location((int) ($segments[1] ?? 0));

			case 'comment':
				return $this->image_location((int) ($segments[1] ?? 0));

			case 'search':
				return $this->gallery_location('SEARCHING_GALLERY', 'phpbbgallery_core_search');
		}

		return $this->gallery_location('VIEWING_GALLERY');
	}

	/**
	 * @param string[] $segments
	 * @return array{location: string, location_url: string}
	 */
	private function album_location(array $segments): array
	{
		$album = $this->get_album((int) ($segments[1] ?? 0));
		if (!$album || !$this->can_view_album($album))
		{
			return $this->gallery_location('VIEWING_GALLERY');
		}

		$language_key = ($segments[2] ?? '') === 'upload' ? 'UPLOADING_TO_ALBUM' : 'VIEWING_ALBUM';

		return [
			'location' => $this->language->lang($language_key, utf8_htmlspecialchars((string) $album['album_name'])),
			'location_url' => $this->route('phpbbgallery_core_album', ['album_id' => (int) $album['album_id']]),
		];
	}

	/**
	 * @return array{location: string, location_url: string}
	 */
	private function image_location(int $image_id): array
	{
		$image = $this->get_image($image_id);
		if (!$image || !$this->can_view_image($image))
		{
			return $this->gallery_location('VIEWING_GALLERY');
		}

		return [
			'location' => $this->language->lang('VIEWING_IMAGE', utf8_htmlspecialchars((string) $image['album_name'])),
			'location_url' => $this->route('phpbbgallery_core_image', ['image_id' => (int) $image['image_id']]),
		];
	}

	/**
	 * @return array{location: string, location_url: string}
	 */
	private function gallery_location(string $language_key, string $route = 'phpbbgallery_core_index'): array
	{
		return [
			'location' => $this->language->lang($language_key, $this->gallery_config->get_title($this->language)),
			'location_url' => $this->route($route),
		];
	}

	/**
	 * @return string[]|null
	 */
	private function gallery_segments(string $session_page): ?array
	{
		$path = rawurldecode(explode('?', str_replace('\\', '/', $session_page), 2)[0]);
		if (!preg_match('~(?:^|/)(?:app\.php/)?gallery(?:/([^?#]*))?/?$~i', $path, $matches))
		{
			return null;
		}

		$path = trim((string) ($matches[1] ?? ''), '/');
		if ($path === '')
		{
			return [];
		}

		return array_values(array_filter(explode('/', strtolower($path)), static fn(string $segment): bool => $segment !== ''));
	}

	/**
	 * @return array|false
	 */
	private function get_album(int $album_id): array|false
	{
		if ($album_id <= 0)
		{
			return false;
		}
		if (array_key_exists($album_id, $this->albums))
		{
			return $this->albums[$album_id];
		}

		$sql = 'SELECT album_id, album_name, album_user_id, album_auth_access
			FROM ' . $this->albums_table . '
			WHERE album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->albums[$album_id] = $row;

		return $row;
	}

	/**
	 * @return array|false
	 */
	private function get_image(int $image_id): array|false
	{
		if ($image_id <= 0)
		{
			return false;
		}
		if (array_key_exists($image_id, $this->images))
		{
			return $this->images[$image_id];
		}

		$sql = 'SELECT i.image_id, i.image_album_id, i.image_status, i.image_user_id,
				a.album_id, a.album_name, a.album_user_id, a.album_auth_access
			FROM ' . $this->images_table . ' i
			JOIN ' . $this->albums_table . ' a
				ON a.album_id = i.image_album_id
			WHERE i.image_id = ' . (int) $image_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->images[$image_id] = $row;

		return $row;
	}

	private function can_view_album(array $album): bool
	{
		$this->load_permissions();

		return (bool) $this->gallery_auth->acl_check(
			'i_view',
			(int) $album['album_id'],
			(int) $album['album_user_id']
		) && $this->gallery_auth->get_zebra_state(
			$this->zebra,
			(int) $album['album_user_id'],
			(int) $album['album_id']
		) >= (int) $album['album_auth_access'];
	}

	private function can_view_image(array $image): bool
	{
		if (!$this->can_view_album($image))
		{
			return false;
		}

		$status = (int) $image['image_status'];
		if (in_array($status, [block::STATUS_APPROVED, block::STATUS_LOCKED], true))
		{
			return true;
		}
		if ($status !== block::STATUS_UNAPPROVED)
		{
			return false;
		}

		return (int) $image['image_user_id'] === (int) ($this->user->data['user_id'] ?? 0)
			|| (bool) $this->gallery_auth->acl_check(
				'm_status',
				(int) $image['album_id'],
				(int) $image['album_user_id']
			);
	}

	private function load_permissions(): void
	{
		if ($this->permissions_loaded)
		{
			return;
		}

		$user_id = (int) ($this->user->data['user_id'] ?? 0);
		$this->gallery_auth->load_user_permissions($user_id);
		$this->zebra = $this->gallery_auth->get_user_zebra($user_id);
		$this->permissions_loaded = true;
	}

	private function route(string $route, array $parameters = []): string
	{
		return $this->helper->route($route, $parameters, true, '');
	}
}
