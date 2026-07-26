<?php
/**
 * phpBB Gallery - ACP environment diagnostics
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\acp;

/**
 * Collect the runtime and add-on state displayed on the Gallery overview.
 */
final class environment
{
	public const MINIMUM_PHP_VERSION = '8.1.0';
	public const MINIMUM_PHP_VERSION_ID = 80100;

	private const EXTENSIONS = [
		'gd' => [true, 'GALLERY_REQUIREMENT_REQUIRED'],
		'mbstring' => [true, 'GALLERY_REQUIREMENT_REQUIRED'],
		'zip' => [false, 'GALLERY_REQUIREMENT_OPTIONAL_ZIP'],
		'exif' => [false, 'GALLERY_REQUIREMENT_OPTIONAL_EXIF'],
	];

	private const ADDONS = [
		'phpbbgallery/acpcleanup' => ['ACP Cleanup', 'GALLERY_ADDON_CLEANUP_EXPLAIN'],
		'phpbbgallery/acpimport' => ['ACP Import', 'GALLERY_ADDON_IMPORT_EXPLAIN'],
		'phpbbgallery/exif' => ['EXIF', 'GALLERY_ADDON_EXIF_EXPLAIN'],
	];

	/**
	 * Detect the active PHP runtime and image-processing libraries.
	 *
	 * @return array Runtime checks
	 */
	public function runtime_checks(): array
	{
		$extensions = [];
		foreach (array_keys(self::EXTENSIONS) as $extension)
		{
			$extensions[$extension] = [
				'available' => extension_loaded($extension),
				'version' => (string) (phpversion($extension) ?: ''),
			];
		}

		if ($extensions['gd']['available'] && function_exists('gd_info'))
		{
			$gd_info = gd_info();
			$extensions['gd']['version'] = (string) ($gd_info['GD Version'] ?? $extensions['gd']['version']);
		}

		return $this->build_runtime_checks(PHP_VERSION_ID, PHP_VERSION, $extensions);
	}

	/**
	 * Build normalized checks from detected runtime values.
	 *
	 * @param int    $php_version_id PHP_VERSION_ID value
	 * @param string $php_version    PHP_VERSION value
	 * @param array  $extensions     Extension availability and version by name
	 * @return array Runtime checks
	 */
	public function build_runtime_checks(int $php_version_id, string $php_version, array $extensions): array
	{
		$checks = [[
			'name' => 'PHP',
			'version' => $php_version,
			'available' => $php_version_id >= self::MINIMUM_PHP_VERSION_ID,
			'required' => true,
			'requirement' => 'GALLERY_REQUIREMENT_PHP',
		]];

		foreach (self::EXTENSIONS as $extension => [$required, $requirement])
		{
			$checks[] = [
				'name' => $extension,
				'version' => (string) ($extensions[$extension]['version'] ?? ''),
				'available' => (bool) ($extensions[$extension]['available'] ?? false),
				'required' => $required,
				'requirement' => $requirement,
			];
		}

		return $checks;
	}

	/**
	 * Determine whether each packaged Gallery add-on is enabled or installable.
	 *
	 * @param object $extension_manager phpBB extension manager
	 * @return array Add-on checks
	 */
	public function addon_checks(object $extension_manager): array
	{
		$checks = [];
		foreach (self::ADDONS as $extension => [$name, $description])
		{
			if ($extension_manager->is_enabled($extension))
			{
				$status = 'enabled';
			}
			else if ($extension_manager->is_disabled($extension))
			{
				$status = 'disabled';
			}
			else if ($extension_manager->is_available($extension))
			{
				$status = 'not_installed';
			}
			else
			{
				$status = 'not_available';
			}

			$checks[] = [
				'extension' => $extension,
				'name' => $name,
				'description' => $description,
				'status' => $status,
			];
		}

		return $checks;
	}
}
