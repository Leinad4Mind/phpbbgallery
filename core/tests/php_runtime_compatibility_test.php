<?php
/**
 * phpBB Gallery - PHP runtime compatibility tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class php_runtime_compatibility_test extends TestCase
{
	private const COMPONENTS = [
		'core',
		'acpcleanup',
		'acpimport',
		'bbpointsimages',
		'bbtagsimages',
		'contest',
		'exif',
		'export',
		'favorite',
		'feed',
		'imagerevisions',
		'remotestorage',
		'tiff',
	];

	public function test_all_components_declare_the_supported_runtime(): void
	{
		$extension_root = dirname(__DIR__, 2);

		foreach (self::COMPONENTS as $component)
		{
			$composer_file = $extension_root . '/' . $component . '/composer.json';
			$composer = json_decode((string) file_get_contents($composer_file), true, 512, JSON_THROW_ON_ERROR);

			$this->assertSame('>=8.1', $composer['require']['php'], $component . ' has an unexpected PHP requirement.');
			$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb'], $component . ' has an unexpected phpBB requirement.');
			if ($component === 'core')
			{
				$this->assertSame('4.0.0', $composer['version']);
				$this->assertSame('*', $composer['require']['ext-gd']);
				$this->assertSame('*', $composer['require']['ext-mbstring']);
			}

			if (isset($composer['require-dev']['phpunit/phpunit']))
			{
				$this->assertSame('^10.5', $composer['require-dev']['phpunit/phpunit'], $component . ' still allows a legacy PHPUnit runtime.');
			}
		}
	}

	public function test_production_code_does_not_use_legacy_var_properties(): void
	{
		$extension_root = dirname(__DIR__, 2);
		$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extension_root, \FilesystemIterator::SKIP_DOTS));

		foreach ($files as $file)
		{
			$path = str_replace('\\', '/', $file->getPathname());
			if ($file->getExtension() !== 'php' || str_contains($path, '/tests/'))
			{
				continue;
			}

			$this->assertDoesNotMatchRegularExpression('/^\s*var\s+\$/m', (string) file_get_contents($path), $path . ' contains a legacy var property.');
		}
	}

	public function test_production_code_uses_short_array_syntax(): void
	{
		$extension_root = dirname(__DIR__, 2);
		$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extension_root, \FilesystemIterator::SKIP_DOTS));

		foreach ($files as $file)
		{
			$path = str_replace('\\', '/', $file->getPathname());
			if ($file->getExtension() !== 'php' || str_contains($path, '/tests/'))
			{
				continue;
			}

			$tokens = token_get_all((string) file_get_contents($path));
			$uses_legacy_array = false;
			foreach ($tokens as $index => $token)
			{
				if (!is_array($token) || $token[0] !== T_ARRAY)
				{
					continue;
				}

				for ($next = $index + 1, $token_count = count($tokens); $next < $token_count; $next++)
				{
					if (is_array($tokens[$next]) && in_array($tokens[$next][0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true))
					{
						continue;
					}

					$uses_legacy_array = $tokens[$next] === '(';
					break;
				}

				if ($uses_legacy_array)
				{
					break;
				}
			}
			$this->assertFalse($uses_legacy_array, $path . ' contains legacy array() syntax.');
		}
	}

	public function test_module_runtime_state_uses_declared_typed_properties(): void
	{
		$extension_root = dirname(__DIR__, 2);
		$module_files = [
			'acpcleanup/acp/main_module.php',
			'acpimport/acp/import_storage.php',
			'acpimport/acp/main_module.php',
			'core/acp/albums_module.php',
			'core/acp/config_module.php',
			'core/acp/gallery_logs_module.php',
			'core/acp/permissions_module.php',
			'core/ucp/settings_module.php',
		];

		foreach ($module_files as $module_file)
		{
			require_once $extension_root . '/' . $module_file;
		}

		$expected = [
			\phpbbgallery\acpcleanup\acp\main_module::class => [
				'u_action' => 'string',
				'tpl_name' => 'string',
				'page_title' => 'string',
			],
			\phpbbgallery\acpimport\acp\main_module::class => [
				'u_action' => 'string',
				'tpl_name' => 'string',
				'page_title' => 'string',
				'import_storage' => 'phpbbgallery\\acpimport\\acp\\import_storage',
				'import_errors' => 'array',
			],
			\phpbbgallery\core\acp\albums_module::class => [
				'u_action' => 'string',
				'parent_id' => 'int',
				'language' => 'phpbb\\language\\language',
				'tpl_name' => 'string',
				'page_title' => 'string',
			],
			\phpbbgallery\core\acp\config_module::class => [
				'u_action' => 'string',
				'tpl_name' => 'string',
				'page_title' => 'string',
				'language' => 'phpbb\\language\\language',
				'new_config' => 'array',
				'display_vars' => 'array',
			],
			\phpbbgallery\core\acp\gallery_logs_module::class => [
				'u_action' => 'string',
				'tpl_name' => 'string',
				'page_title' => 'string',
				'language' => 'phpbb\\language\\language',
			],
			\phpbbgallery\core\acp\main_module::class => [
				'u_action' => 'string',
				'tpl_name' => 'string',
				'page_title' => 'string',
				'language' => 'phpbb\\language\\language',
			],
			\phpbbgallery\core\acp\permissions_module::class => [
				'u_action' => 'string',
				'language' => 'phpbb\\language\\language',
				'tpl_name' => 'string',
				'page_title' => 'string',
			],
			\phpbbgallery\core\ucp\main_module::class => [
				'u_action' => 'string',
				'language' => 'phpbb\\language\\language',
				'tpl_name' => 'string',
				'page_title' => 'string',
			],
			\phpbbgallery\core\ucp\settings_module::class => [
				'u_action' => 'string',
				'page_title' => 'string',
				'tpl_name' => 'string',
			],
			\phpbbgallery\core\upload::class => [
				'min_width' => 'int',
				'min_height' => 'int',
				'max_width' => 'int',
				'max_height' => 'int',
			],
		];

		foreach ($expected as $class => $properties)
		{
			$reflection = new \ReflectionClass($class);
			foreach ($properties as $property_name => $expected_type)
			{
				$property = $reflection->getProperty($property_name);
				$this->assertTrue($property->hasType(), $class . '::$' . $property_name . ' must be typed.');
				$this->assertSame($expected_type, (string) $property->getType(), $class . '::$' . $property_name . ' has an unexpected type.');
			}
		}
	}
}
