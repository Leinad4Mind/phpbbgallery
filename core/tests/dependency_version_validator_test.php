<?php
/**
 * phpBB Gallery - Dependency version validator tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\dependency\version_validator;
use PHPUnit\Framework\TestCase;

final class dependency_version_validator_test extends TestCase
{
	public function test_version_range_uses_an_inclusive_minimum_and_exclusive_maximum(): void
	{
		$this->assertFalse(version_validator::satisfies('', '4.1.0', '5.0.0'));
		$this->assertFalse(version_validator::satisfies('4.0.9', '4.1.0', '5.0.0'));
		$this->assertTrue(version_validator::satisfies('4.1.0', '4.1.0', '5.0.0'));
		$this->assertTrue(version_validator::satisfies('4.9.9', '4.1.0', '5.0.0'));
		$this->assertFalse(version_validator::satisfies('5.0.0', '4.1.0', '5.0.0'));
	}

	public function test_incompatible_dependencies_include_expected_and_detected_versions(): void
	{
		$manager = $this->manager([
			'phpbbgallery/core' => '4.0.0',
			'sitesplat/bbpoints' => '1.3.0',
		]);

		$this->assertSame([
			'phpbbgallery/core >=4.1.0,<5.0.0 (4.0.0)',
		], version_validator::incompatible($manager, [
			'phpbbgallery/core' => ['4.1.0', '5.0.0'],
			'sitesplat/bbpoints' => ['1.3.0', '2.0.0'],
		]));
	}

	public function test_unreadable_metadata_fails_closed(): void
	{
		$this->assertSame([
			'phpbbgallery/core >=4.1.0,<5.0.0 (?)',
		], version_validator::incompatible($this->manager([]), [
			'phpbbgallery/core' => ['4.1.0', '5.0.0'],
		]));
	}

	public function test_every_addon_declares_and_enforces_its_core_version_range(): void
	{
		$gallery_root = dirname(__DIR__, 2);
		foreach (glob($gallery_root . '/*/composer.json') ?: [] as $manifest)
		{
			$component = basename(dirname($manifest));
			if ($component === 'core')
			{
				continue;
			}

			$composer = json_decode((string) file_get_contents($manifest), true, 512, JSON_THROW_ON_ERROR);
			$minimum = $component === 'featured' ? '4.2.0' : '4.1.0';
			$this->assertSame(
				'>=' . $minimum . ',<5.0.0@dev',
				$composer['extra']['soft-require']['phpbbgallery/core'] ?? null,
				$component
			);

			$extension = (string) file_get_contents(dirname($manifest) . '/ext.php');
			$this->assertStringContainsString('version_validator::validate(', $extension, $component);
			$this->assertStringContainsString("'phpbbgallery/core' => ['" . $minimum . "', '5.0.0']", $extension, $component);
		}
	}

	public function test_sitesplat_integrations_validate_their_host_extensions(): void
	{
		foreach (['bbpointsimages' => 'bbpoints', 'bbtagsimages' => 'bbtags'] as $component => $dependency)
		{
			$root = dirname(__DIR__, 2) . '/' . $component;
			$composer = json_decode((string) file_get_contents($root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
			$this->assertSame('>=1.3.0,<2.0.0@dev', $composer['extra']['soft-require']['sitesplat/' . $dependency] ?? null);
			$this->assertStringContainsString("'sitesplat/" . $dependency . "' => ['1.3.0', '2.0.0']", (string) file_get_contents($root . '/ext.php'));
		}
	}

	private function manager(array $versions): object
	{
		return new class($versions) {
			public function __construct(private array $versions)
			{
			}

			public function create_extension_metadata_manager(string $extension): object
			{
				if (!isset($this->versions[$extension]))
				{
					throw new \RuntimeException('Metadata unavailable.');
				}

				return new class($this->versions[$extension]) {
					public function __construct(private string $version)
					{
					}

					public function get_metadata(string $field): string
					{
						if ($field !== 'version')
						{
							throw new \InvalidArgumentException('Unexpected metadata field.');
						}

						return $this->version;
					}
				};
			}
		};
	}
}
