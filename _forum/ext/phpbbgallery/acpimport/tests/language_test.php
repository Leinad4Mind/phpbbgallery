<?php
/**
 * phpBB Gallery - ACP Import Extension tests
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\tests;

use PHPUnit\Framework\TestCase;

class language_test extends TestCase
{
	private const EXPECTED_KEYS = [
		'ACP_IMPORT_ALBUMS',
		'ACP_IMPORT_ALBUMS_EXPLAIN',
		'EXTENSION_ENABLE_SUCCESS',
		'GALLERY_CORE_NOT_FOUND',
		'IMPORT_ALBUM',
		'IMPORT_DEBUG_MES',
		'IMPORT_DIR_EMPTY',
		'IMPORT_FINISHED',
		'IMPORT_FINISHED_ERRORS',
		'IMPORT_INVALID_IMAGE',
		'IMPORT_MISSING_ALBUM',
		'IMPORT_SCHEMA_CREATED',
		'IMPORT_SCHEMA_WRITE_FAILED',
		'IMPORT_SELECT',
		'IMPORT_USER',
		'IMPORT_USERS_PEGA',
		'IMPORT_USER_EXP',
		'MISSING_IMPORT_SCHEMA',
		'NO_FILE_SELECTED',
	];

	public function test_every_language_has_the_complete_import_component(): void
	{
		$language_directories = glob(dirname(__DIR__) . '/language/*', GLOB_ONLYDIR);
		$this->assertNotEmpty($language_directories);

		$tested_languages = [];
		foreach ($language_directories as $directory)
		{
			$language = basename($directory);
			$file = $directory . '/info_acp_gallery_import.php';
			$this->assertFileExists($file, 'Missing ACP Import language file for ' . $language);

			$lang = [];
			include $file;
			$keys = array_keys($lang);
			sort($keys);
			$this->assertSame(self::EXPECTED_KEYS, $keys, 'Unexpected ACP Import language keys for ' . $language);

			foreach ($lang as $key => $message)
			{
				$this->assertNotSame('', $message, 'Empty translation for ' . $language . ':' . $key);
				$this->assertSame(1, preg_match('//u', $message), 'Invalid UTF-8 for ' . $language . ':' . $key);
				$this->assertSame($this->expected_placeholders($key), $this->placeholders($message), 'Placeholder mismatch for ' . $language . ':' . $key);
			}

			$tested_languages[] = $language;
		}

		sort($tested_languages);
		$this->assertSame(['bg', 'de', 'en', 'fr', 'it', 'pt', 'pt_br', 'pt_preao', 'ru'], $tested_languages);
	}

	private function expected_placeholders(string $key): array
	{
		$placeholders = [
			'IMPORT_DEBUG_MES' => ['%1$s', '%2$s'],
			'IMPORT_DIR_EMPTY' => ['%s'],
			'IMPORT_FINISHED' => ['%1$s'],
			'IMPORT_FINISHED_ERRORS' => ['%1$s'],
			'IMPORT_INVALID_IMAGE' => ['%s'],
			'MISSING_IMPORT_SCHEMA' => ['%s'],
		];

		return isset($placeholders[$key]) ? $placeholders[$key] : [];
	}

	private function placeholders(string $message): array
	{
		preg_match_all('/%(?:\d+\$)?[ds]/', $message, $matches);

		return $matches[0];
	}
}
