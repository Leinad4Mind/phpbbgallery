<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\integration;

/** Immutable input for a trusted server-side Gallery image import. */
final class image_import_request
{
	public function __construct(
		private string $integration_name,
		private string $source_path,
		private string $original_filename,
		private int $album_id,
		private string $image_name,
		private string $description = '',
		private string $subtitle = '',
		private bool $allow_comments = false,
		private int $actor_user_id = 0,
		private array $context = []
	)
	{
		$this->integration_name = trim($this->integration_name);
		$this->source_path = trim($this->source_path);
		$this->original_filename = basename(str_replace('\\', '/', trim($this->original_filename)));
		$this->image_name = trim($this->image_name);
		$this->description = trim($this->description);
		$this->subtitle = trim($this->subtitle);

		if (!preg_match('#^[a-z0-9]+/[a-z0-9]+$#D', $this->integration_name))
		{
			throw new \InvalidArgumentException('The Gallery integration name must be a lowercase vendor/extension identifier.');
		}
		if ($this->source_path === '' || $this->original_filename === '')
		{
			throw new \InvalidArgumentException('A source path and original filename are required.');
		}
		if ($this->album_id <= 0)
		{
			throw new \InvalidArgumentException('A positive Gallery album ID is required.');
		}
		if ($this->image_name === '')
		{
			throw new \InvalidArgumentException('An image name is required.');
		}
		if ($this->actor_user_id < 0)
		{
			throw new \InvalidArgumentException('The actor user ID cannot be negative.');
		}
	}

	public function get_integration_name(): string
	{
		return $this->integration_name;
	}

	public function get_source_path(): string
	{
		return $this->source_path;
	}

	public function get_original_filename(): string
	{
		return $this->original_filename;
	}

	public function get_album_id(): int
	{
		return $this->album_id;
	}

	public function get_image_name(): string
	{
		return $this->image_name;
	}

	public function get_description(): string
	{
		return $this->description;
	}

	public function get_subtitle(): string
	{
		return $this->subtitle;
	}

	public function allows_comments(): bool
	{
		return $this->allow_comments;
	}

	public function get_actor_user_id(): int
	{
		return $this->actor_user_id;
	}

	public function get_context(): array
	{
		return $this->context;
	}
}
