<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\integration;

/** Immutable reference returned after Gallery has finalized an imported image. */
final class image_import_result
{
	public function __construct(
		private int $image_id,
		private int $album_id,
		private int $actor_user_id,
		private array $image_data,
		private array $context
	)
	{
	}

	public function get_image_id(): int
	{
		return $this->image_id;
	}

	public function get_album_id(): int
	{
		return $this->album_id;
	}

	public function get_actor_user_id(): int
	{
		return $this->actor_user_id;
	}

	public function get_image_data(): array
	{
		return $this->image_data;
	}

	public function get_context(): array
	{
		return $this->context;
	}
}
