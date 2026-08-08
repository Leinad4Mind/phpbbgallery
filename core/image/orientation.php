<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

/** Normalise the eight EXIF-compatible right-angle image orientations. */
final class orientation
{
	public const ORIGINAL = 1;
	public const MIRROR_HORIZONTAL = 2;
	public const ROTATE_180 = 3;
	public const MIRROR_VERTICAL = 4;
	public const MIRROR_HORIZONTAL_ROTATE_LEFT = 5;
	public const ROTATE_RIGHT = 6;
	public const MIRROR_HORIZONTAL_ROTATE_RIGHT = 7;
	public const ROTATE_LEFT = 8;

	public static function normalize(int $value): int
	{
		return ($value >= self::ORIGINAL && $value <= self::ROTATE_LEFT) ? $value : self::ORIGINAL;
	}

	public static function from_legacy_rotation(int $angle): int
	{
		$angle = (($angle % 360) + 360) % 360;
		return match ($angle)
		{
			90 => self::ROTATE_LEFT,
			180 => self::ROTATE_180,
			270 => self::ROTATE_RIGHT,
			default => self::ORIGINAL,
		};
	}

	public static function to_legacy_rotation(int $value): int
	{
		return match (self::normalize($value))
		{
			self::ROTATE_LEFT => 90,
			self::ROTATE_180 => 180,
			self::ROTATE_RIGHT => 270,
			default => 0,
		};
	}

	public static function swaps_dimensions(int $value): bool
	{
		return in_array(self::normalize($value), [
			self::MIRROR_HORIZONTAL_ROTATE_LEFT,
			self::ROTATE_RIGHT,
			self::MIRROR_HORIZONTAL_ROTATE_RIGHT,
			self::ROTATE_LEFT,
		], true);
	}

	public static function is_mirrored(int $value): bool
	{
		return in_array(self::normalize($value), [
			self::MIRROR_HORIZONTAL,
			self::MIRROR_VERTICAL,
			self::MIRROR_HORIZONTAL_ROTATE_LEFT,
			self::MIRROR_HORIZONTAL_ROTATE_RIGHT,
		], true);
	}

	public static function clockwise_rotation(int $value): int
	{
		return match (self::normalize($value))
		{
			self::ROTATE_180, self::MIRROR_VERTICAL => 180,
			self::MIRROR_HORIZONTAL_ROTATE_LEFT, self::ROTATE_RIGHT => 90,
			self::MIRROR_HORIZONTAL_ROTATE_RIGHT, self::ROTATE_LEFT => 270,
			default => 0,
		};
	}

	public static function from_exif(string $source): int
	{
		if (!function_exists('exif_read_data') || !is_file($source) || is_link($source))
		{
			return self::ORIGINAL;
		}

		$info = @getimagesize($source);
		if ($info === false || ($info['mime'] ?? '') !== 'image/jpeg')
		{
			return self::ORIGINAL;
		}

		try
		{
			$data = @exif_read_data($source, 'IFD0', true, false);
		}
		catch (\Throwable)
		{
			return self::ORIGINAL;
		}
		if (!is_array($data))
		{
			return self::ORIGINAL;
		}

		return self::normalize((int) ($data['IFD0']['Orientation'] ?? $data['Orientation'] ?? self::ORIGINAL));
	}

	/** Detect a second GIF image descriptor without decoding attacker-controlled pixels. */
	public static function is_animated_gif(string $source): bool
	{
		if (!is_file($source) || is_link($source) || !is_readable($source))
		{
			return false;
		}

		$handle = @fopen($source, 'rb');
		if (!is_resource($handle))
		{
			return false;
		}

		try
		{
			$header = fread($handle, 13);
			if (strlen($header) !== 13 || !in_array(substr($header, 0, 6), ['GIF87a', 'GIF89a'], true))
			{
				return false;
			}

			$packed = ord($header[10]);
			if (($packed & 0x80) !== 0)
			{
				$global_colour_table = 3 * (2 ** (($packed & 0x07) + 1));
				if (fseek($handle, $global_colour_table, SEEK_CUR) !== 0)
				{
					return false;
				}
			}

			$frames = 0;
			while (!feof($handle))
			{
				$byte = fread($handle, 1);
				if ($byte === '')
				{
					break;
				}

				$marker = ord($byte);
				if ($marker === 0x3B)
				{
					break;
				}
				if ($marker === 0x21)
				{
					if (fread($handle, 1) === '' || !self::skip_sub_blocks($handle))
					{
						return false;
					}
					continue;
				}
				if ($marker !== 0x2C)
				{
					return false;
				}

				$descriptor = fread($handle, 9);
				if (strlen($descriptor) !== 9)
				{
					return false;
				}
				$frames++;
				if ($frames > 1)
				{
					return true;
				}

				$local_packed = ord($descriptor[8]);
				if (($local_packed & 0x80) !== 0)
				{
					$local_colour_table = 3 * (2 ** (($local_packed & 0x07) + 1));
					if (fseek($handle, $local_colour_table, SEEK_CUR) !== 0)
					{
						return false;
					}
				}
				if (fread($handle, 1) === '' || !self::skip_sub_blocks($handle))
				{
					return false;
				}
			}
		}
		finally
		{
			fclose($handle);
		}

		return false;
	}

	/** @param resource $handle */
	private static function skip_sub_blocks($handle): bool
	{
		while (!feof($handle))
		{
			$size_byte = fread($handle, 1);
			if ($size_byte === '')
			{
				return false;
			}
			$size = ord($size_byte);
			if ($size === 0)
			{
				return true;
			}
			if (strlen(fread($handle, $size)) !== $size)
			{
				return false;
			}
		}

		return false;
	}
}
