<?php
/**
 * phpBB Gallery - Version-check metadata tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class version_check_metadata_test extends TestCase
{
	private const COMPONENTS = [
		'core' => 'gallery-core.json',
		'acpcleanup' => 'gallery-cleanup.json',
		'acpimport' => 'gallery-import.json',
		'bbpointsimages' => 'gallery-bbpointsimages.json',
		'bbtagsimages' => 'gallery-bbtagsimages.json',
		'contest' => 'gallery-contest.json',
		'exif' => 'gallery-exif.json',
		'export' => 'gallery-export.json',
		'favorite' => 'gallery-favorite.json',
		'feed' => 'gallery-feed.json',
		'imagefields' => 'gallery-imagefields.json',
		'imagerevisions' => 'gallery-imagerevisions.json',
		'remotestorage' => 'gallery-remotestorage.json',
		'tiff' => 'gallery-tiff.json',
	];

	/** @var array<string, string|null> */
	private const UNRELEASED = [
		'core' => '4.1.0',
		'remotestorage' => '1.0.0',
	];

	public function test_every_component_exposes_a_phpbb_version_check(): void
	{
		$extension_root = dirname(__DIR__, 2);

		foreach (self::COMPONENTS as $component => $filename)
		{
			$composer = $this->decode_json($extension_root . '/' . $component . '/composer.json');

			$this->assertArrayNotHasKey('version-check', $composer, $component . ' has a version-check block outside extra.');
			$this->assertSame(
				[
					'host' => 'raw.githubusercontent.com',
					'directory' => '/satanasov/phpbbgallery/master/',
					'filename' => $filename,
					'ssl' => true,
				],
				$composer['extra']['version-check'],
				$component . ' has unexpected version-check settings.'
			);
		}
	}

	public function test_version_files_match_their_component_manifests(): void
	{
		$extension_root = dirname(__DIR__, 2);

		foreach (self::COMPONENTS as $component => $filename)
		{
			$composer = $this->decode_json($extension_root . '/' . $component . '/composer.json');
			$metadata = $this->decode_json($extension_root . '/' . $filename);

			if (array_key_exists($component, self::UNRELEASED))
			{
				$stable_version = self::UNRELEASED[$component];
				$this->assertSame(
					$stable_version === null ? ['unstable'] : ['stable', 'unstable'],
					array_keys($metadata),
					$filename . ' has unexpected development channels.'
				);
				if ($stable_version !== null)
				{
					$this->assert_version_entry($metadata['stable'], $stable_version, $filename);
				}
				$this->assert_version_entry($metadata['unstable'], $composer['version'], $filename);
				continue;
			}

			$this->assertSame(['stable'], array_keys($metadata), $filename . ' has unexpected release channels.');
			$this->assert_version_entry($metadata['stable'], $composer['version'], $filename);
		}
	}

	/** @param array<string, mixed> $channel */
	private function assert_version_entry(array $channel, string $version, string $filename): void
	{
		$this->assertSame(['3.3'], array_keys($channel), $filename . ' has unexpected phpBB branches.');
		$this->assertSame([
			'current' => $version,
			'download' => 'https://github.com/satanasov/phpbbgallery',
			'announcement' => 'https://www.phpbb.com/customise/db/extension/phpbb_gallery',
			'eol' => null,
			'security' => false,
		], $channel['3.3'], $filename . ' has invalid release metadata.');
	}

	public function test_no_component_version_file_is_left_untracked(): void
	{
		$extension_root = dirname(__DIR__, 2);
		$actual = array_map('basename', glob($extension_root . '/gallery-*.json') ?: []);
		$expected = array_values(self::COMPONENTS);
		sort($actual);
		sort($expected);

		$this->assertSame($expected, $actual);
	}

	/**
	 * @return array<string, mixed>
	 */
	private function decode_json(string $filename): array
	{
		$this->assertFileExists($filename);

		return json_decode((string) file_get_contents($filename), true, 512, JSON_THROW_ON_ERROR);
	}
}
