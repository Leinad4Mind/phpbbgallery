<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

class package_hygiene_test extends TestCase
{
	/** @var string */
	private $core_root;

	/** @var string */
	private $extension_root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->core_root = dirname(__DIR__);
		$this->extension_root = dirname($this->core_root);
	}

	public function test_generated_and_backup_artifacts_are_not_shipped(): void
	{
		$artifacts = [];
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->extension_root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			$name = $file->getFilename();
			$extension = strtolower($file->getExtension());
			if ($name === 'differences.md' || in_array($extension, ['bak', 'map'], true))
			{
				$artifacts[] = $file->getPathname();
			}
		}

		$this->assertSame([], $artifacts);
	}

	public function test_runtime_javascript_has_one_canonical_copy(): void
	{
		$asset_directory = $this->core_root . '/styles/all/template/js';
		$expected = [
			'gallery_polaroid.js',
			'jquery.fileupload-image.js',
			'jquery.fileupload-process.js',
			'jquery.fileupload-ui.js',
			'jquery.fileupload-validate.js',
			'jquery.fileupload.js',
			'jquery.iframe-transport.js',
			'jquery.ui.widget.js',
			'load-image.all.min.js',
		];
		$actual = array_values(array_filter(scandir($asset_directory), function (string $name) use ($asset_directory): bool
		{
			return is_file($asset_directory . '/' . $name);
		}));
		sort($actual);

		$this->assertSame($expected, $actual);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$this->assertSame([], glob($this->core_root . '/styles/' . $style . '/js/*.js') ?: []);
		}
	}

	public function test_every_namespaced_javascript_reference_resolves(): void
	{
		$references = [];
		$styles_root = $this->core_root . '/styles';
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($styles_root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			if ($file->getExtension() !== 'html')
			{
				continue;
			}

			preg_match_all(
				'#@phpbbgallery_core/js/([A-Za-z0-9._-]+)#',
				file_get_contents($file->getPathname()),
				$matches
			);
			$references = array_merge($references, $matches[1]);
		}

		$references = array_values(array_unique($references));
		sort($references);
		$this->assertNotEmpty($references);

		foreach ($references as $reference)
		{
			$this->assertFileExists($this->core_root . '/styles/all/template/js/' . $reference);
		}
	}

	public function test_polaroid_layout_uses_the_shared_asset_in_every_style(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = file_get_contents(
				$this->core_root . '/styles/' . $style . '/template/gallery/albumlist_polaroid.html'
			);
			$this->assertStringContainsString(
				'INCLUDEJS @phpbbgallery_core/js/gallery_polaroid.js',
				$template
			);
			$this->assertFileDoesNotExist(
				$this->core_root . '/styles/' . $style . '/template/gallery/gallery.js'
			);
		}
	}

	public function test_third_party_assets_match_the_documented_checksums(): void
	{
		$checksums = [
			'jquery.ui.widget.js' => 'd50b39d3a03aed723335188a428bca4a783b211368e8b13ae024fea22cad34f3',
			'load-image.all.min.js' => '1f9a171543305bc03d542822165a94ffad55580cc137634da12877736b04bbe9',
			'jquery.iframe-transport.js' => '5de5c447928d2b0ef87ba9f51a6e238cf841d12c90f2ca0e2fa5e2c835dec54f',
			'jquery.fileupload.js' => 'd81a55f26e15da852b28364fe8446fe4d6caea7aa1d68fa9ee25171407749f1f',
			'jquery.fileupload-process.js' => '9bc8036cf1e2028623f3ccf5e4b265b7a52a925428f00184e351ff9e1f6404e3',
			'jquery.fileupload-image.js' => '361eaa379b6e61f8ff280c5f203b3a3a62340d96595ab34691e47e7ef09291e8',
			'jquery.fileupload-validate.js' => 'da84967f1eecd4cc3474fc2027ad3a9cfe94a1c26fdc6ad1c49075888119a1e6',
			'jquery.fileupload-ui.js' => '3c3b4e896fe9763c331a2ce9dfa40779c0bf11a8d839a6e5ddca917ce6ff743c',
		];
		$asset_directory = $this->core_root . '/styles/all/template/js';
		$notices = file_get_contents($this->core_root . '/THIRD_PARTY.md');

		foreach ($checksums as $file => $checksum)
		{
			$this->assertSame($checksum, hash_file('sha256', $asset_directory . '/' . $file));
			$this->assertStringContainsString($file . ' | ' . $checksum, $notices);
		}

		$widget = file_get_contents($asset_directory . '/jquery.ui.widget.js');
		$loader = file_get_contents($asset_directory . '/load-image.all.min.js');
		$this->assertStringContainsString('jQuery UI Widget 1.14.2', $widget);
		$this->assertStringNotContainsString('sourceMappingURL=', $loader);
	}
}
