<?php
/**
 * phpBB Gallery - TIFF Extension
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff;

use phpbbgallery\core\file\file;
use phpbbgallery\core\image\external_processor_interface;
use phpbbgallery\core\image\orientation;

/** Decode TIFF originals with bounded Imagick resources and create WebP derivatives. */
final class processor implements external_processor_interface
{
	private const MAX_SOURCE_FILESIZE = 134217728;
	private const MAX_RESIZE_ATTEMPTS = 6;
	private const MEMORY_LIMIT = 268435456;
	private const MAP_LIMIT = 536870912;
	private const DISK_LIMIT = 1073741824;

	private \phpbb\config\config $config;

	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public static function is_supported(): bool
	{
		if (!class_exists(\Imagick::class)
			|| !method_exists(\Imagick::class, 'queryFormats')
			|| !method_exists(\Imagick::class, 'setResourceLimit')
			|| !method_exists(\Imagick::class, 'getResourceLimit'))
		{
			return false;
		}

		try
		{
			return \Imagick::queryFormats('TIFF*') !== []
				&& \Imagick::queryFormats('WEBP') !== [];
		}
		catch (\Throwable)
		{
			return false;
		}
	}

	public function inspect(string $source): ?array
	{
		return $this->inspect_tiff($source, strtolower((string) pathinfo($source, PATHINFO_EXTENSION)));
	}

	public function prepare_source(string $source, array $options): ?array
	{
		$metadata = $this->inspect($source);
		if ($metadata === null)
		{
			return null;
		}

		$max_width = max(1, (int) ($options['max_width'] ?? 0));
		$max_height = max(1, (int) ($options['max_height'] ?? 0));
		$max_filesize = max(1, min(self::MAX_SOURCE_FILESIZE, (int) ($options['max_filesize'] ?? 0)));
		$allow_resize = !empty($options['allow_resize']);
		$requested_orientation = $options['orientation'] ?? null;
		if ($requested_orientation !== null && ((int) $requested_orientation < 1 || (int) $requested_orientation > 8))
		{
			return null;
		}
		$image_orientation = $requested_orientation !== null
			? orientation::normalize((int) $requested_orientation)
			: orientation::from_legacy_rotation((int) ($options['rotation'] ?? 0));

		$oversized = $metadata['width'] > $max_width || $metadata['height'] > $max_height;
		if (($oversized || $metadata['filesize'] > $max_filesize) && !$allow_resize)
		{
			return null;
		}
		if ($image_orientation === orientation::ORIGINAL && !$oversized && $metadata['filesize'] <= $max_filesize)
		{
			return $metadata;
		}
		if ($this->number_of_images($source) !== 1)
		{
			// Rewriting only frame zero would silently destroy a multipage TIFF.
			return null;
		}

		$image = $this->read_first_frame($source);
		if ($image === null)
		{
			return null;
		}

		$temporary = $this->temporary_path($source);
		if ($temporary === null)
		{
			$image->clear();
			return null;
		}

		try
		{
			if ($image_orientation !== orientation::ORIGINAL)
			{
				$rotation = orientation::clockwise_rotation($image_orientation);
				if ($rotation !== 0)
				{
					$image->rotateImage(new \ImagickPixel('none'), $rotation);
				}
				if (orientation::is_mirrored($image_orientation))
				{
					if (!method_exists($image, 'flopImage') || !$image->flopImage())
					{
						return null;
					}
				}
				$image->setImagePage(0, 0, 0, 0);
			}
			if ($image->getImageWidth() > $max_width || $image->getImageHeight() > $max_height)
			{
				$image->thumbnailImage($max_width, $max_height, true);
			}
			$image->setImageFormat('TIFF');
			$image->setImageCompression(\Imagick::COMPRESSION_ZIP);
			$image->stripImage();

			for ($attempt = 0; $attempt <= self::MAX_RESIZE_ATTEMPTS; $attempt++)
			{
				if (!$image->writeImage($temporary))
				{
					return null;
				}
				clearstatcache(true, $temporary);
				$filesize = @filesize($temporary);
				if ($filesize !== false && $filesize > 0 && $filesize <= $max_filesize)
				{
					$result = $this->inspect_tiff($temporary, (string) $metadata['extension']);
					if ($result === null || !$this->replace_file($temporary, $source))
					{
						return null;
					}

					return $this->inspect($source);
				}
				if (!$allow_resize || $attempt === self::MAX_RESIZE_ATTEMPTS
					|| ($image->getImageWidth() <= 1 && $image->getImageHeight() <= 1))
				{
					return null;
				}
				$image->thumbnailImage(
					max(1, (int) floor($image->getImageWidth() * 0.8)),
					max(1, (int) floor($image->getImageHeight() * 0.8)),
					true
				);
			}
		}
		catch (\Throwable)
		{
			return null;
		}
		finally
		{
			$image->clear();
			if (is_file($temporary) && !is_link($temporary))
			{
				@unlink($temporary);
			}
		}

		return null;
	}

	public function create_derivative(string $source, string $destination, int $max_width, int $max_height, int $quality): ?array
	{
		if (is_link($destination) || $this->inspect($source) === null)
		{
			return null;
		}
		$image = $this->read_first_frame($source);
		if ($image === null)
		{
			return null;
		}

		$valid = false;
		try
		{
			$quality = max(1, min(100, (int) ($this->config['phpbb_gallery_tiff_webp_quality'] ?? $quality)));
			if (method_exists($image, 'autoOrientImage'))
			{
				$image->autoOrientImage();
			}
			$image->setImagePage(0, 0, 0, 0);
			$image->thumbnailImage(max(1, $max_width), max(1, $max_height), true);
			$image->setImageFormat('WEBP');
			$image->setImageCompressionQuality(max(1, min(100, $quality)));
			$image->stripImage();
			if (!$image->writeImage($destination) || is_link($destination))
			{
				return null;
			}

			$metadata = $this->inspect_webp($destination);
			$valid = $metadata !== null;

			return $metadata;
		}
		catch (\Throwable)
		{
			return null;
		}
		finally
		{
			$image->clear();
			if (!$valid && is_file($destination) && !is_link($destination))
			{
				@unlink($destination);
			}
		}
	}

	private function inspect_tiff(string $source, string $extension): ?array
	{
		if (!self::is_supported()
			|| !in_array($extension, ['tif', 'tiff'], true)
			|| !is_file($source) || is_link($source) || !is_readable($source))
		{
			return null;
		}
		$filesize = @filesize($source);
		if ($filesize === false || $filesize < 1 || $filesize > self::MAX_SOURCE_FILESIZE)
		{
			return null;
		}

		$image = new \Imagick();
		try
		{
			$this->apply_resource_limits();
			$image->pingImage($source . '[0]');
			$format = strtoupper((string) $image->getImageFormat());
			$width = (int) $image->getImageWidth();
			$height = (int) $image->getImageHeight();
			if (!str_starts_with($format, 'TIFF') || !$this->valid_dimensions($width, $height))
			{
				return null;
			}

			return [
				'extension' => $extension,
				'mime' => 'image/tiff',
				'width' => $width,
				'height' => $height,
				'filesize' => (int) $filesize,
			];
		}
		catch (\Throwable)
		{
			return null;
		}
		finally
		{
			$image->clear();
		}
	}

	private function inspect_webp(string $source): ?array
	{
		clearstatcache(true, $source);
		$filesize = @filesize($source);
		$info = @getimagesize($source);
		if (!is_file($source) || is_link($source) || $filesize === false || $filesize < 1
			|| $info === false || ($info['mime'] ?? '') !== 'image/webp'
			|| !$this->valid_dimensions((int) $info[0], (int) $info[1]))
		{
			return null;
		}

		return [
			'extension' => 'webp',
			'mime' => 'image/webp',
			'width' => (int) $info[0],
			'height' => (int) $info[1],
			'filesize' => (int) $filesize,
		];
	}

	private function read_first_frame(string $source): ?\Imagick
	{
		if ($this->inspect($source) === null)
		{
			return null;
		}
		$image = new \Imagick();
		try
		{
			$this->apply_resource_limits();
			$image->readImage($source . '[0]');
			if (!str_starts_with(strtoupper((string) $image->getImageFormat()), 'TIFF')
				|| !$this->valid_dimensions((int) $image->getImageWidth(), (int) $image->getImageHeight()))
			{
				$image->clear();
				return null;
			}

			return $image;
		}
		catch (\Throwable)
		{
			$image->clear();
			return null;
		}
	}

	private function number_of_images(string $source): ?int
	{
		$image = new \Imagick();
		try
		{
			$this->apply_resource_limits();
			$image->pingImage($source);
			if (!method_exists($image, 'getNumberImages'))
			{
				return null;
			}

			return max(0, (int) $image->getNumberImages());
		}
		catch (\Throwable)
		{
			return null;
		}
		finally
		{
			$image->clear();
		}
	}

	private function apply_resource_limits(): void
	{
		foreach ([
			\Imagick::RESOURCETYPE_MEMORY => self::MEMORY_LIMIT,
			\Imagick::RESOURCETYPE_MAP => self::MAP_LIMIT,
			\Imagick::RESOURCETYPE_DISK => self::DISK_LIMIT,
			\Imagick::RESOURCETYPE_THREAD => 1,
		] as $type => $limit)
		{
			$current = \Imagick::getResourceLimit($type);
			\Imagick::setResourceLimit($type, $current > 0 ? min($current, $limit) : $limit);
		}
	}

	private function valid_dimensions(int $width, int $height): bool
	{
		return $width > 0 && $height > 0
			&& $width <= file::MAX_DECODE_PIXELS
			&& $height <= file::MAX_DECODE_PIXELS
			&& ($width * $height) <= file::MAX_DECODE_PIXELS;
	}

	private function temporary_path(string $source): ?string
	{
		try
		{
			return $source . '.tmp-' . bin2hex(random_bytes(8));
		}
		catch (\Throwable)
		{
			return null;
		}
	}

	private function replace_file(string $temporary, string $destination): bool
	{
		$backup = $this->temporary_path($destination);
		if ($backup === null || !@rename($destination, $backup))
		{
			return false;
		}
		if (@rename($temporary, $destination))
		{
			@chmod($destination, 0644);
			@unlink($backup);
			return true;
		}

		@rename($backup, $destination);

		return false;
	}
}
