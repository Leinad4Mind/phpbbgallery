<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

/** Read trusted image dimensions without decoding the complete image. */
class dimensions
{
	private format_registry $format_registry;
	private \phpbbgallery\core\storage\workspace $storage_workspace;

	public function __construct(format_registry $format_registry, \phpbbgallery\core\storage\workspace $storage_workspace)
	{
		$this->format_registry = $format_registry;
		$this->storage_workspace = $storage_workspace;
	}

	/**
	 * Inspect an already available file.
	 *
	 * @return array{width: int, height: int}|null
	 */
	public function inspect_file(string $filename, string $path): ?array
	{
		if ($filename === '' || $path === '' || !is_file($path))
		{
			return null;
		}

		$processor = $this->format_registry->processor_for_filename($filename);
		if ($processor !== null)
		{
			$metadata = $processor->inspect($path);
			if ($metadata === null || !$this->format_registry->accepts_metadata($filename, $metadata))
			{
				return null;
			}
			$width = (int) $metadata['width'];
			$height = (int) $metadata['height'];
		}
		else
		{
			$image_size = @getimagesize($path);
			if ($image_size === false)
			{
				return null;
			}
			$width = (int) ($image_size[0] ?? 0);
			$height = (int) ($image_size[1] ?? 0);
		}

		return ($width > 0 && $height > 0) ? ['width' => $width, 'height' => $height] : null;
	}

	/**
	 * Materialize and inspect a source from the active storage provider.
	 *
	 * @return array{width: int, height: int}|null
	 */
	public function inspect_source(string $filename): ?array
	{
		$source = null;
		try
		{
			$source = $this->storage_workspace->materialize(
				\phpbbgallery\core\storage\provider_interface::SOURCE,
				$filename
			);
			return $this->inspect_file($filename, $source->get_path());
		}
		catch (\RuntimeException)
		{
			return null;
		}
		finally
		{
			if ($source !== null)
			{
				$source->release();
			}
		}
	}
}
