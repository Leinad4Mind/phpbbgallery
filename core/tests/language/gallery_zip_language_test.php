<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\language;

use PHPUnit\Framework\TestCase;

class gallery_zip_language_test extends TestCase
{
	private const EXPECTED_KEYS = [
		'ZIP_COMPRESSION_RATIO_EXCEEDED',
		'ZIP_DUPLICATE_PATH',
		'ZIP_EXTENSION_NOT_AVAILABLE',
		'ZIP_EXTRACTION_FAILED',
		'ZIP_INVALID_ARCHIVE',
		'ZIP_INVALID_IMAGE_TYPE',
		'ZIP_NO_IMAGES',
		'ZIP_SIZE_LIMIT_EXCEEDED',
		'ZIP_TOO_MANY_ENTRIES',
		'ZIP_TOO_MANY_IMAGES',
		'ZIP_UNSAFE_PATH',
	];

	public function test_every_language_has_the_complete_zip_component(): void
	{
		$language_directories = glob(dirname(__DIR__, 2) . '/language/*', GLOB_ONLYDIR);
		$this->assertNotEmpty($language_directories);

		$tested_languages = [];
		foreach ($language_directories as $directory)
		{
			$language = basename($directory);
			$file = $directory . '/gallery_zip.php';
			$this->assertFileExists($file, 'Missing ZIP language component for ' . $language);

			$lang = [];
			include $file;
			$keys = array_keys($lang);
			sort($keys);
			$this->assertSame(self::EXPECTED_KEYS, $keys, 'Unexpected ZIP language keys for ' . $language);

			foreach ($lang as $key => $message)
			{
				$this->assertNotSame('', $message, 'Empty translation for ' . $language . ':' . $key);
				$this->assertSame(1, preg_match('//u', $message), 'Invalid UTF-8 for ' . $language . ':' . $key);
				$this->assertSame($this->expected_placeholders($key), $this->placeholders($message), 'Placeholder mismatch for ' . $language . ':' . $key);
			}

			$tested_languages[] = $language;
		}

		sort($tested_languages);
		$this->assertSame(['bg', 'de', 'en', 'es', 'fr', 'it', 'nl', 'pt', 'pt_br', 'pt_preao', 'ru'], $tested_languages);
	}

	private function expected_placeholders(string $key): array
	{
		if ($key === 'ZIP_INVALID_IMAGE_TYPE')
		{
			return ['%s'];
		}
		if ($key === 'ZIP_TOO_MANY_ENTRIES' || $key === 'ZIP_TOO_MANY_IMAGES')
		{
			return ['%d'];
		}

		return [];
	}

	private function placeholders(string $message): array
	{
		preg_match_all('/%(?:\d+\$)?[ds]/', $message, $matches);

		return $matches[0];
	}
}
