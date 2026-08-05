<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** A local object lease that removes only workspace-owned files. */
final class local_object
{
	private string $path;
	private bool $temporary;
	private bool $released = false;

	public function __construct(string $path, bool $temporary)
	{
		$this->path = $path;
		$this->temporary = $temporary;
	}

	public function get_path(): string
	{
		return $this->path;
	}

	public function is_temporary(): bool
	{
		return $this->temporary;
	}

	public function release(): void
	{
		if (!$this->released && $this->temporary && is_file($this->path) && !is_link($this->path))
		{
			@unlink($this->path);
		}
		$this->released = true;
	}

	public function __destruct()
	{
		$this->release();
	}
}
