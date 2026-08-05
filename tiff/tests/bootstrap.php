<?php
// phpcs:ignoreFile -- Imagick-compatible test doubles must retain the extension's public API.
/**
 * phpBB Gallery - TIFF tests bootstrap
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

require_once dirname(__DIR__, 2) . '/core/tests/bootstrap.php';

if (!class_exists('Imagick'))
{
	class Imagick
	{
		public const COMPRESSION_ZIP = 10;
		public const RESOURCETYPE_MEMORY = 1;
		public const RESOURCETYPE_MAP = 2;
		public const RESOURCETYPE_DISK = 3;
		public const RESOURCETYPE_THREAD = 4;

		private string $format = 'TIFF';
		private int $width = 1;
		private int $height = 1;

		public static function queryFormats(string $pattern = '*'): array
		{
			return str_starts_with($pattern, 'TIFF') ? ['TIFF'] : ($pattern === 'WEBP' ? ['WEBP'] : []);
		}

		public static function getResourceLimit(int $type): int
		{
			return 0;
		}

		public static function setResourceLimit(int $type, int $limit): bool
		{
			return true;
		}

		public function pingImage(string $source): bool
		{
			return $this->load($source);
		}

		public function readImage(string $source): bool
		{
			return $this->load($source);
		}

		public function getImageFormat(): string
		{
			return $this->format;
		}

		public function getImageWidth(): int
		{
			return $this->width;
		}

		public function getImageHeight(): int
		{
			return $this->height;
		}

		public function rotateImage(ImagickPixel $background, int $degrees): bool
		{
			if ($degrees === 90 || $degrees === 270)
			{
				[$this->width, $this->height] = [$this->height, $this->width];
			}

			return true;
		}

		public function thumbnailImage(int $max_width, int $max_height, bool $best_fit = false): bool
		{
			$scale = min(1, $max_width / $this->width, $max_height / $this->height);
			$this->width = max(1, (int) floor($this->width * $scale));
			$this->height = max(1, (int) floor($this->height * $scale));

			return true;
		}

		public function setImageFormat(string $format): bool
		{
			$this->format = strtoupper($format);

			return true;
		}

		public function setImagePage(int $width, int $height, int $x, int $y): bool { return true; }
		public function setImageCompression(int $compression): bool { return true; }
		public function setImageCompressionQuality(int $quality): bool { return true; }
		public function stripImage(): bool { return true; }
		public function autoOrientImage(): bool { return true; }
		public function clear(): bool { return true; }

		public function writeImage(string $destination): bool
		{
			if ($this->format === 'WEBP')
			{
				$image = imagecreatetruecolor($this->width, $this->height);
				$result = imagewebp($image, $destination, 82);
				return $result;
			}

			return file_put_contents($destination, "FAKE:TIFF:{$this->width}:{$this->height}\n") !== false;
		}

		private function load(string $source): bool
		{
			$source = preg_replace('/\[0\]$/D', '', $source);
			$content = is_string($source) ? @file_get_contents($source) : false;
			if (!is_string($content) || preg_match('/^FAKE:([A-Z]+):(\d+):(\d+)/D', $content, $matches) !== 1)
			{
				throw new RuntimeException('Invalid fake image.');
			}
			$this->format = $matches[1];
			$this->width = (int) $matches[2];
			$this->height = (int) $matches[3];

			return true;
		}
	}

	class ImagickPixel
	{
		public function __construct(string $colour = '')
		{
		}
	}
}

require_once dirname(__DIR__) . '/processor.php';
require_once dirname(__DIR__) . '/event/listener.php';
require_once dirname(__DIR__, 2) . '/acpimport/acp/import_storage.php';
require_once dirname(__DIR__, 2) . '/acpimport/acp/import_storage.php';
if (!class_exists('phpbb\\db\\migration\\migration'))
{
	require_once __DIR__ . '/migration_stub.php';
}
require_once dirname(__DIR__) . '/migrations/m1_init.php';
