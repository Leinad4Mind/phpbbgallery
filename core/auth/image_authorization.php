<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\auth;

class image_authorization
{
	public function can_manage_image(int $user_id, array $image_data, bool $has_image_permission, bool $has_moderator_permission, bool $is_orphan): bool
	{
		if ($has_moderator_permission)
		{
			return true;
		}

		return $has_image_permission && !$is_orphan && isset($image_data['image_user_id']) && (int) $image_data['image_user_id'] === $user_id;
	}

	/**
	 * Whether making the user the author of an image would let them delete it through
	 * the "delete own images" permission while they lack the moderator delete permission.
	 */
	public function author_change_grants_deletion(int $user_id, array $image_data, int $new_author_id, bool $has_own_delete, bool $has_moderator_delete): bool
	{
		$is_already_author = isset($image_data['image_user_id']) && (int) $image_data['image_user_id'] === $user_id;

		return $new_author_id === $user_id && !$is_already_author && $has_own_delete && !$has_moderator_delete;
	}

	/**
	 * @return array|false
	 */
	public function normalize_image_ids(array $image_ids): array|false
	{
		$normalized_ids = [];
		foreach ($image_ids as $image_id)
		{
			if (!is_int($image_id) || $image_id < 1)
			{
				return false;
			}

			$normalized_ids[$image_id] = $image_id;
		}

		return $normalized_ids ? array_values($normalized_ids) : false;
	}

	public function can_moderate_image(array $image_data, array $album_data, int $route_album_id, bool $has_permission): bool
	{
		if (!$has_permission || !isset($image_data['image_album_id'], $album_data['album_id']))
		{
			return false;
		}

		$image_album_id = (int) $image_data['image_album_id'];
		$loaded_album_id = (int) $album_data['album_id'];

		return $image_album_id > 0 && $image_album_id === $loaded_album_id && ($route_album_id === 0 || $route_album_id === $image_album_id);
	}

	public function can_moderate_album(array $album_data, int $album_id, bool $has_permission): bool
	{
		return $has_permission && $album_id > 0 && isset($album_data['album_id']) && (int) $album_data['album_id'] === $album_id;
	}
}
