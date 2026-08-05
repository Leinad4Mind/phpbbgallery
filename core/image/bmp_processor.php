<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

use phpbbgallery\core\file\file;

/** Decode verified BMP originals and create browser-safe WebP derivatives. */
final class bmp_processor implements external_processor_interface
{
	private const MAX_SOURCE_FILESIZE = 134217728;
	private const MAX_RESIZE_ATTEMPTS = 6;

	public static function is_supported(): bool
	{
		return defined('IMG_BMP')
			&& defined('IMG_WEBP')
			&& defined('IMAGETYPE_BMP')
			&& defined('IMAGETYPE_WEBP')
			&& function_exists('imagetypes')
			&& function_exists('imagecreatefrombmp')
			&& function_exists('imagebmp')
			&& function_exists('imagewebp')
			&& function_exists('imagecreatetruecolor')
			&& function_exists('imagecopyresampled')
			&& function_exists('imagerotate')
			&& (imagetypes() & IMG_BMP) === IMG_BMP
			&& (imagetypes() & IMG_WEBP) === IMG_WEBP;
	}

	public function inspect(string $source): ?array
	{
		$metadata = $this->inspect_header($source, IMAGETYPE_BMP, 'bmp', 'image/bmp');
		if ($metadata === null)
		{
			return null;
		}

		try
		{
			$image = @imagecreatefrombmp($source);
		}
		catch (\Throwable)
		{
			return null;
		}
		if (!$image instanceof \GdImage)
		{
			return null;
		}
		$valid = imagesx($image) === $metadata['width'] && imagesy($image) === $metadata['height'];
		$image = null;

		return $valid ? $metadata : null;
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
		$rotation = (int) ($options['rotation'] ?? 0);
		if (!in_array($rotation, [0, 90, 180, 270], true))
		{
			return null;
		}

		$oversized = $metadata['width'] > $max_width || $metadata['height'] > $max_height;
		if (($oversized || $metadata['filesize'] > $max_filesize) && !$allow_resize)
		{
			return null;
		}
		if (!$rotation && !$oversized && $metadata['filesize'] <= $max_filesize)
		{
			return $metadata;
		}

		$image = $this->decode($source);
		if ($image === null)
		{
			return null;
		}
		$temporary = $this->temporary_path($source);
		if ($temporary === null)
		{
			return null;
		}

		try
		{
			if ($rotation)
			{
				$rotated = @imagerotate($image, $rotation, 0);
				if (!$rotated instanceof \GdImage)
				{
					return null;
				}
				$image = $rotated;
			}

			$resized = $this->fit($image, $max_width, $max_height);
			if ($resized === null)
			{
				return null;
			}
			$image = $resized;

			for ($attempt = 0; $attempt <= self::MAX_RESIZE_ATTEMPTS; $attempt++)
			{
				if (!@imagebmp($image, $temporary, true))
				{
					return null;
				}
				$written = $this->inspect($temporary);
				if ($written !== null && $written['filesize'] <= $max_filesize)
				{
					if (!$this->replace_file($temporary, $source))
					{
						return null;
					}

					return $this->inspect($source);
				}
				if (!$allow_resize || $attempt === self::MAX_RESIZE_ATTEMPTS
					|| (imagesx($image) <= 1 && imagesy($image) <= 1))
				{
					return null;
				}
				$smaller = $this->resample(
					$image,
					max(1, (int) floor(imagesx($image) * 0.8)),
					max(1, (int) floor(imagesy($image) * 0.8))
				);
				if ($smaller === null)
				{
					return null;
				}
				$image = $smaller;
			}
		}
		catch (\Throwable)
		{
			return null;
		}
		finally
		{
			$image = null;
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
		$image = $this->decode($source);
		if ($image === null)
		{
			return null;
		}

		$valid = false;
		try
		{
			$resized = $this->fit($image, max(1, $max_width), max(1, $max_height));
			if ($resized === null || !@imagewebp($resized, $destination, max(1, min(100, $quality))))
			{
				return null;
			}
			$metadata = $this->inspect_header($destination, IMAGETYPE_WEBP, 'webp', 'image/webp');
			$valid = $metadata !== null;

			return $metadata;
		}
		catch (\Throwable)
		{
			return null;
		}
		finally
		{
			$image = null;
			if (!$valid && is_file($destination) && !is_link($destination))
			{
				@unlink($destination);
			}
		}
	}

	private function inspect_header(string $source, int $expected_type, string $extension, string $mime): ?array
	{
		if (!self::is_supported() || !is_file($source) || is_link($source) || !is_readable($source))
		{
			return null;
		}
		clearstatcache(true, $source);
		$filesize = @filesize($source);
		$info = @getimagesize($source);
		if ($filesize === false || $filesize < 1 || $filesize > self::MAX_SOURCE_FILESIZE
			|| $info === false || (int) ($info[2] ?? 0) !== $expected_type
			|| !$this->valid_dimensions((int) $info[0], (int) $info[1]))
		{
			return null;
		}

		return [
			'extension' => $extension,
			'mime' => $mime,
			'width' => (int) $info[0],
			'height' => (int) $info[1],
			'filesize' => (int) $filesize,
		];
	}

	private function decode(string $source): ?\GdImage
	{
		if ($this->inspect_header($source, IMAGETYPE_BMP, 'bmp', 'image/bmp') === null)
		{
			return null;
		}
		try
		{
			$image = @imagecreatefrombmp($source);
		}
		catch (\Throwable)
		{
			return null;
		}

		return $image instanceof \GdImage ? $image : null;
	}

	private function fit(\GdImage $image, int $max_width, int $max_height): ?\GdImage
	{
		$width = imagesx($image);
		$height = imagesy($image);
		$ratio = min(1, $max_width / $width, $max_height / $height);
		if ($ratio >= 1)
		{
			return $image;
		}

		return $this->resample($image, max(1, (int) floor($width * $ratio)), max(1, (int) floor($height * $ratio)));
	}

	private function resample(\GdImage $source, int $width, int $height): ?\GdImage
	{
		$destination = imagecreatetruecolor($width, $height);
		if (!$destination instanceof \GdImage
			|| !imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, imagesx($source), imagesy($source)))
		{
			return null;
		}

		return $destination;
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
