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
		'imagerevisions' => 'gallery-imagerevisions.json',
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

			$this->assertSame(['stable'], array_keys($metadata), $filename . ' has unexpected release channels.');
			$this->assertSame(['3.3'], array_keys($metadata['stable']), $filename . ' has unexpected phpBB branches.');
			$this->assertSame(
				[
					'current' => $composer['version'],
					'download' => 'https://github.com/satanasov/phpbbgallery',
					'announcement' => 'https://www.phpbb.com/customise/db/extension/phpbb_gallery',
					'eol' => null,
					'security' => false,
				],
				$metadata['stable']['3.3'],
				$filename . ' does not match its component manifest.'
			);
		}
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
