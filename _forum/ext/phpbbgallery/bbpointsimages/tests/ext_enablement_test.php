<?php
/**
 * BBPoints Images dependency tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbbgallery\bbpointsimages\ext;
use PHPUnit\Framework\TestCase;

final class ext_enablement_test extends TestCase
{
	public function test_available_dependencies_are_enabled_in_order(): void
	{
		[$extension, $manager] = $this->extension([], [
			'phpbbgallery/core',
			'sitesplat/bbpoints',
		]);

		$this->assertTrue($extension->is_enableable());
		$this->assertSame([
			'phpbbgallery/core',
			'sitesplat/bbpoints',
		], $manager->enable_calls);
	}

	public function test_missing_dependency_rejects_enable_without_partial_success(): void
	{
		[$extension, $manager, $user] = $this->extension(
			[],
			['phpbbgallery/core']
		);
		$warning = '';
		set_error_handler(static function (int $severity, string $message) use (&$warning): bool
		{
			$warning = $message;
			return true;
		});

		try
		{
			$this->assertFalse($extension->is_enableable());
		}
		finally
		{
			restore_error_handler();
		}

		$this->assertSame('BBPOINTSIMAGES_DEPENDENCIES_MISSING:sitesplat/bbpoints', $warning);
		$this->assertSame([], $manager->enable_calls);
		$this->assertSame([
			['phpbbgallery/bbpointsimages', 'info_acp_bbpointsimages'],
		], $user->languages);
	}

	/**
	 * @return array{0: ext, 1: object, 2: object}
	 */
	private function extension(array $enabled, array $available): array
	{
		$manager = new class($enabled, $available) {
			public array $enable_calls = [];
			private array $enabled;
			private array $available;

			public function __construct(array $enabled, array $available)
			{
				$this->enabled = array_fill_keys($enabled, true);
				$this->available = array_fill_keys($available, true);
			}

			public function is_enabled(string $extension): bool
			{
				return isset($this->enabled[$extension]);
			}

			public function is_available(string $extension): bool
			{
				return isset($this->available[$extension]);
			}

			public function enable(string $extension): void
			{
				$this->enable_calls[] = $extension;
				$this->enabled[$extension] = true;
			}
		};
		$user = new class {
			public array $languages = [];

			public function add_lang_ext(string $extension, string $file): void
			{
				$this->languages[] = [$extension, $file];
			}

			public function lang(string $key, string $value): string
			{
				return $key . ':' . $value;
			}
		};
		$container = new class($manager, $user) {
			public function __construct(private object $manager, private object $user)
			{
			}

			public function get(string $service): object
			{
				return $service === 'ext.manager' ? $this->manager : $this->user;
			}
		};
		$extension = new ext();
		$setter = \Closure::bind(function (object $container): void
		{
			$this->container = $container;
		}, $extension, ext::class);
		$setter($container);

		return [$extension, $manager, $user];
	}
}
