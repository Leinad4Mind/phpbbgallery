<?php
/**
 * phpBB Gallery accessible-album resolver.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

/**
 * Resolves albums visible to the current effective phpBB identity.
 */
class album_access
{
	private \phpbbgallery\core\auth\auth $gallery_auth;
	private \phpbb\user $user;
	private ?array $resolved = null;

	public function __construct(\phpbbgallery\core\auth\auth $gallery_auth, \phpbb\user $user)
	{
		$this->gallery_auth = $gallery_auth;
		$this->user = $user;
	}

	/**
	 * Return the viewable, moderated and combined accessible album IDs.
	 *
	 * @return array{viewable: array<int>, moderated: array<int>, visible: array<int>}
	 */
	public function resolve(): array
	{
		if ($this->resolved !== null)
		{
			return $this->resolved;
		}

		$this->gallery_auth->load_user_permissions((int) ($this->user->data['user_id'] ?? 0));
		$excluded = $this->gallery_auth->get_exclude_zebra();
		$viewable = $this->normalize(array_diff($this->gallery_auth->acl_album_ids('i_view'), $excluded));
		$moderated = $this->normalize(array_diff($this->gallery_auth->acl_album_ids('m_status'), $excluded));

		return $this->resolved = [
			'viewable' => $viewable,
			'moderated' => $moderated,
			'visible' => $this->normalize(array_merge($viewable, $moderated)),
		];
	}

	/**
	 * Whether the effective identity can enter at least one album.
	 */
	public function has_any(): bool
	{
		return $this->resolve()['visible'] !== [];
	}

	/**
	 * Normalize album identifiers without changing their discovery order.
	 *
	 * @param array $album_ids Album identifiers
	 * @return array<int>
	 */
	private function normalize(array $album_ids): array
	{
		$normalized = [];
		foreach ($album_ids as $album_id)
		{
			$album_id = (int) $album_id;
			if ($album_id > 0)
			{
				$normalized[$album_id] = $album_id;
			}
		}

		return array_values($normalized);
	}
}
