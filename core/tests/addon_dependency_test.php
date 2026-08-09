<?php
/**
 * phpBB Gallery - Add-on dependency tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class addon_dependency_test extends TestCase
{
	private const ADDONS = [
		\phpbbgallery\acpcleanup\ext::class => ['phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup'],
		\phpbbgallery\acpimport\ext::class => ['phpbbgallery/acpimport', 'info_acp_gallery_import'],
		\phpbbgallery\exif\ext::class => ['phpbbgallery/exif', 'info_exif'],
		\phpbbgallery\imagefields\ext::class => ['phpbbgallery/imagefields', 'info_imagefields'],
		\phpbbgallery\imagerevisions\ext::class => ['phpbbgallery/imagerevisions', 'info_imagerevisions'],
		\phpbbgallery\remotestorage\ext::class => ['phpbbgallery/remotestorage', 'info_acp_remotestorage'],
		\phpbbgallery\contest\ext::class => ['phpbbgallery/contest', 'info_contest'],
	];

	public function test_addons_allow_enable_when_core_is_active(): void
	{
		foreach (array_keys(self::ADDONS) as $extension_class)
		{
			[$extension, $manager] = $this->create_extension($extension_class, true, true);

			$this->assertTrue($extension->is_enableable(), $extension_class);
			$this->assertSame([], $manager->enable_calls, $extension_class);
		}
	}

	public function test_addons_enable_an_available_core_automatically(): void
	{
		foreach (array_keys(self::ADDONS) as $extension_class)
		{
			[$extension, $manager, $user] = $this->create_extension($extension_class, false, true);

			$this->assertTrue($extension->is_enableable(), $extension_class);
			$this->assertSame(['phpbbgallery/core'], $manager->enable_calls, $extension_class);
			$this->assertSame([], $user->languages, $extension_class);
		}
	}

	public function test_addons_reject_a_core_that_is_not_available(): void
	{
		foreach (self::ADDONS as $extension_class => [$extension_name, $language_file])
		{
			[$extension, $manager, $user] = $this->create_extension($extension_class, false, false);
			$warning = '';
			set_error_handler(static function (int $severity, string $message) use (&$warning): bool
			{
				$warning = $message;
				return true;
			});

			try
			{
				$this->assertFalse($extension->is_enableable(), $extension_class);
			}
			finally
			{
				restore_error_handler();
			}

			$this->assertSame('GALLERY_CORE_NOT_FOUND', $warning, $extension_class);
			$this->assertSame([[$extension_name, $language_file]], $user->languages, $extension_class);
			$this->assertSame([], $manager->enable_calls, $extension_class);
		}
	}

	/**
	 * @param class-string $extension_class
	 * @param bool         $core_enabled
	 * @param bool         $core_available
	 * @return array
	 */
	private function create_extension(string $extension_class, bool $core_enabled, bool $core_available): array
	{
		$manager = new class($core_enabled, $core_available) {
			public array $enable_calls = [];
			private bool $core_enabled;
			private bool $core_available;

			public function __construct(bool $core_enabled, bool $core_available)
			{
				$this->core_enabled = $core_enabled;
				$this->core_available = $core_available;
			}

			public function is_enabled(string $extension): bool
			{
				return $extension === 'phpbbgallery/core' && $this->core_enabled;
			}

			public function is_available(string $extension): bool
			{
				return $extension === 'phpbbgallery/core' && $this->core_available;
			}

			public function enable(string $extension): void
			{
				$this->enable_calls[] = $extension;
				$this->core_enabled = $this->core_available;
			}
		};
		$user = new class {
			public array $languages = [];

			public function add_lang_ext(string $extension, string $file): void
			{
				$this->languages[] = [$extension, $file];
			}

			public function lang(string $key): string
			{
				return $key;
			}
		};
		$container = new class($manager, $user) {
			private object $manager;
			private object $user;

			public function __construct(object $manager, object $user)
			{
				$this->manager = $manager;
				$this->user = $user;
			}

			public function get(string $service): object
			{
				return $service === 'ext.manager' ? $this->manager : $this->user;
			}
		};

		$extension = (new \ReflectionClass($extension_class))->newInstanceWithoutConstructor();
		$set_container = \Closure::bind(function (object $container): void
		{
			$this->container = $container;
		}, $extension, $extension_class);
		$set_container($container);

		return [$extension, $manager, $user];
	}
}
