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
			if ($name === 'differences.md' || in_array($extension, ['bak', 'bkp', 'map'], true))
			{
				$artifacts[] = $file->getPathname();
			}
		}

		$this->assertSame([], $artifacts);
	}

	public function test_packaged_text_files_use_unix_line_endings(): void
	{
		$text_extensions = ['php', 'css', 'dist', 'htm', 'html', 'js', 'json', 'md', 'txt', 'yml'];
		$invalid_files = [];
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->extension_root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			if (!in_array(strtolower($file->getExtension()), $text_extensions, true))
			{
				continue;
			}

			$content = (string) file_get_contents($file->getPathname());
			if (str_contains($content, chr(13)) || ($content !== '' && !str_ends_with($content, chr(10))))
			{
				$invalid_files[] = $file->getPathname();
			}
		}

		$this->assertSame([], $invalid_files);
	}

	public function test_runtime_javascript_has_one_canonical_copy(): void
	{
		$asset_directory = $this->core_root . '/styles/all/template/js';
		$expected = [
			'editor_selector.js',
			'gallery_polaroid.js',
			'image_navigation.js',
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

	public function test_shared_stylesheet_and_image_references_resolve(): void
	{
		$header_event = file_get_contents(
			$this->core_root . '/styles/all/template/event/overall_header_head_append.html'
		);
		$this->assertStringContainsString('@phpbbgallery_core/gallery.css', $header_event);
		$this->assertStringContainsString('@phpbbgallery_core/default.css', $header_event);
		$this->assertLessThan(
			strpos($header_event, '@phpbbgallery_core/default.css'),
			strpos($header_event, '@phpbbgallery_core/gallery.css')
		);

		$theme_directory = $this->core_root . '/styles/all/theme';
		$stylesheet = file_get_contents($theme_directory . '/gallery.css');
		$this->assertStringNotContainsString('clip-path: url(#left_arrow)', $stylesheet);
		$this->assertStringNotContainsString('clip-path: url(#right_arrow)', $stylesheet);
		preg_match_all(
			'#url\([^./]*\./images/([A-Za-z0-9._-]+)#',
			$stylesheet,
			$matches
		);
		$this->assertCount(6, $matches[1]);
		foreach ($matches[1] as $image)
		{
			$this->assertFileExists($theme_directory . '/images/' . $image);
		}

		$this->assertFileDoesNotExist($this->core_root . '/styles/prosilver/theme/gallery.css');
		$this->assertFileDoesNotExist($this->core_root . '/styles/prosilver/theme/gallery-color.css');
		$this->assertFileDoesNotExist(
			$this->core_root . '/styles/prosilver/template/event/overall_header_head_append.html'
		);
	}

	public function test_polaroid_layout_uses_the_shared_asset_in_every_style(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = file_get_contents(
				$this->core_root . '/styles/' . $style . '/template/gallery/albumlist_polaroid.html'
			);
			$this->assertStringContainsString(
				'@phpbbgallery_core/js/gallery_polaroid.js',
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
			'jquery.iframe-transport.js' => 'be43036704c70db0148f4970326f6dd36bad7b34eed8e5f76719269ef70cb8cd',
			'jquery.fileupload.js' => '071e66375d2207b30024197a4b566c5fd70c6f72ab394f1375f2521d36cc3dac',
			'jquery.fileupload-process.js' => 'a7f04469af255c4c547e8961ead78e4894718337f7a79df44df892d0067cf2b8',
			'jquery.fileupload-image.js' => 'bed7dd16807fe0e8d477a396d1103d0d609c4e4c9933fa2cc0f459d53a4b30a1',
			'jquery.fileupload-validate.js' => '8e899b2766035a6d318c7c50cbd258b78eb29c8108a171afeef6bbee2ffe2446',
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

	public function test_php_sources_do_not_keep_executable_code_in_comments(): void
	{
		$offenders = [];
		$patterns = [
			'#^//\s*(?:\$this->|\$[A-Za-z_][A-Za-z0-9_]*->|\$[A-Za-z_][A-Za-z0-9_]*\s*=|return\s+\$|var_dump\()#',
			'#^//\s*(?:if|foreach|while)\s*\(#',
			'#^//\s*[A-Za-z_][A-Za-z0-9_]*::[A-Za-z_][A-Za-z0-9_]*\(#',
			'#^/\*\s*(?:if\s*\(|else\s*\{|\$[A-Za-z_])#s',
			'#/\*\s*&&#',
		];
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->core_root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			if ($file->getExtension() !== 'php')
			{
				continue;
			}

			foreach (token_get_all((string) file_get_contents($file->getPathname())) as $token)
			{
				if (!is_array($token) || $token[0] !== T_COMMENT)
				{
					continue;
				}

				$comment = trim($token[1]);
				foreach ($patterns as $pattern)
				{
					if (preg_match($pattern, $comment))
					{
						$offenders[] = $file->getPathname() . ':' . $token[2];
						break;
					}
				}
			}
		}

		$this->assertSame([], $offenders);
	}

	public function test_production_phpdoc_uses_supported_annotations(): void
	{
		$offenders = [];
		$patterns = [
			'#/\* @var\b#',
			'#@param\s+\$#',
			'#@param\s+\([^)]#',
			'#@internal param\b#',
			'#@author\s*:#',
			'#@function:#',
			'#^\s*\*\s+return\b#m',
		];
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->core_root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			$path = str_replace('\\', '/', $file->getPathname());
			if ($file->getExtension() !== 'php' || str_contains($path, '/tests/'))
			{
				continue;
			}

			$source = (string) file_get_contents($file->getPathname());
			foreach ($patterns as $pattern)
			{
				if (preg_match($pattern, $source))
				{
					$offenders[] = $path . ':' . $pattern;
				}
			}
		}

		$this->assertSame([], $offenders);
	}

	public function test_album_image_actions_use_current_moderation_routes(): void
	{
		foreach (['/controller/album.php', '/image/image.php'] as $relative_path)
		{
			$source = (string) file_get_contents($this->core_root . $relative_path);

			$this->assertStringNotContainsString('123', $source, $relative_path);
			$this->assertStringContainsString('phpbbgallery_core_moderate_image', $source, $relative_path);
		}
	}

	public function test_development_files_are_excluded_from_release_archives(): void
	{
		$attributes = (string) file_get_contents($this->extension_root . '/.gitattributes');

		foreach ([
			'core',
			'acpcleanup',
			'acpimport',
			'exif',
			'export',
			'favorite',
			'feed',
			'bbtagsimages',
			'bbpointsimages',
			'imagerevisions',
		] as $extension)
		{
			$this->assertStringContainsString('/' . $extension . '/phpunit.xml.dist export-ignore', $attributes);
			$this->assertStringContainsString('/' . $extension . '/tests export-ignore', $attributes);
			$this->assertStringContainsString('/' . $extension . '/tests/** export-ignore', $attributes);
		}
	}

	public function test_every_packaged_component_contains_the_declared_license(): void
	{
		foreach ([
			'core',
			'acpcleanup',
			'acpimport',
			'exif',
			'export',
			'favorite',
			'feed',
			'bbtagsimages',
			'bbpointsimages',
			'imagerevisions',
		] as $extension)
		{
			$this->assertFileExists($this->extension_root . '/' . $extension . '/license.txt', $extension);
		}
	}
}
