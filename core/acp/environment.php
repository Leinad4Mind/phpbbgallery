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
		'phpbbgallery/acpcleanup' => ['ACP Cleanup', '1.4.0', 'free', 'GALLERY_ADDON_CLEANUP_EXPLAIN'],
		'phpbbgallery/acpimport' => ['ACP Import', '1.4.0', 'free', 'GALLERY_ADDON_IMPORT_EXPLAIN'],
		'phpbbgallery/contest' => ['Contests', '1.0.0', 'free', 'GALLERY_ADDON_CONTEST_EXPLAIN'],
		'phpbbgallery/exif' => ['Exif', '1.4.0', 'free', 'GALLERY_ADDON_EXIF_EXPLAIN'],
		'phpbbgallery/favorite' => ['Favorite', '1.0.0', 'free', 'GALLERY_ADDON_FAVORITE_EXPLAIN'],
		'phpbbgallery/feed' => ['Feed', '1.0.0', 'free', 'GALLERY_ADDON_FEED_EXPLAIN'],
		'phpbbgallery/tiff' => ['TIFF', '1.0.0', 'free', 'GALLERY_ADDON_TIFF_EXPLAIN'],
		'phpbbgallery/bbpointsimages' => ['BBPoints Images', '1.0.0', 'premium', 'GALLERY_ADDON_BBPOINTS_IMAGES_EXPLAIN'],
		'phpbbgallery/bbtagsimages' => ['BBTags Images', '1.0.0', 'premium', 'GALLERY_ADDON_BBTAGS_IMAGES_EXPLAIN'],
		'phpbbgallery/export' => ['Export', '1.0.0', 'premium', 'GALLERY_ADDON_EXPORT_EXPLAIN'],
		'phpbbgallery/imagefields' => ['Image Fields', '1.0.0', 'premium', 'GALLERY_ADDON_IMAGE_FIELDS_EXPLAIN'],
		'phpbbgallery/imagerevisions' => ['Image Revisions', '1.0.0', 'premium', 'GALLERY_ADDON_IMAGE_REVISIONS_EXPLAIN'],
		'phpbbgallery/remotestorage' => ['Remote Storage', '1.0.0', 'premium', 'GALLERY_ADDON_REMOTE_STORAGE_EXPLAIN'],
	];

	/**
	 * Detect the active PHP runtime and image-processing libraries.
	 *
	 * @param string|null $tiff_status TIFF add-on status, or null when its package is absent
	 * @return array Runtime checks
	 */
	public function runtime_checks(?string $tiff_status = null): array
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
		if ($tiff_status !== null)
		{
			$extensions['imagick'] = $this->imagick_runtime_check();
		}

		return $this->build_runtime_checks(PHP_VERSION_ID, PHP_VERSION, $extensions, $tiff_status);
	}

	/**
	 * Build normalized checks from detected runtime values.
	 *
	 * @param int    $php_version_id PHP_VERSION_ID value
	 * @param string $php_version    PHP_VERSION value
	 * @param array  $extensions     Extension availability and version by name
	 * @param string|null $tiff_status TIFF add-on status, or null when its package is absent
	 * @return array Runtime checks
	 */
	public function build_runtime_checks(int $php_version_id, string $php_version, array $extensions, ?string $tiff_status = null): array
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
		if ($tiff_status !== null)
		{
			$checks[] = [
				'name' => 'Imagick (TIFF)',
				'version' => (string) ($extensions['imagick']['version'] ?? ''),
				'available' => (bool) ($extensions['imagick']['available'] ?? false),
				'required' => $tiff_status === 'enabled',
				'requirement' => 'GALLERY_REQUIREMENT_TIFF_IMAGICK',
			];
		}

		return $checks;
	}

	/**
	 * Detect the complete Imagick capability required by the TIFF add-on.
	 *
	 * @return array{available: bool, version: string}
	 */
	private function imagick_runtime_check(): array
	{
		$version = extension_loaded('imagick') ? (string) (phpversion('imagick') ?: '') : '';
		$available = extension_loaded('imagick')
			&& class_exists(\Imagick::class)
			&& method_exists(\Imagick::class, 'queryFormats')
			&& method_exists(\Imagick::class, 'setResourceLimit')
			&& method_exists(\Imagick::class, 'getResourceLimit');

		if ($available)
		{
			try
			{
				$available = \Imagick::queryFormats('TIFF*') !== []
					&& \Imagick::queryFormats('WEBP') !== [];
			}
			catch (\Throwable)
			{
				$available = false;
			}
		}

		return [
			'available' => $available,
			'version' => $version,
		];
	}

	/**
	 * Return required runtime components that are not available.
	 *
	 * @param array $checks Runtime checks
	 * @return array Component names
	 */
	public function missing_required_components(array $checks): array
	{
		$missing = [];
		foreach ($checks as $check)
		{
			if ($check['required'] && !$check['available'])
			{
				$missing[] = $check['name'];
			}
		}

		return $missing;
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
		foreach (self::ADDONS as $extension => [$name, $version, $tier, $description])
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
				'name' => 'phpBB Gallery Add-on: ' . $name,
				'version' => $version,
				'tier' => $tier,
				'description' => $description,
				'status' => $status,
			];
		}
		$tier_order = ['free' => 0, 'premium' => 1];
		usort($checks, static function(array $left, array $right) use ($tier_order): int
		{
			$tier_comparison = $tier_order[$left['tier']] <=> $tier_order[$right['tier']];

			return $tier_comparison !== 0
				? $tier_comparison
				: strcasecmp($left['name'], $right['name']);
		});

		return $checks;
	}
}
