<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- icon manager test doubles intentionally share this fixture.
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\icon\manager;

class icon_manager_test extends TestCase
{
	private string $icons_path;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->icons_path = sys_get_temp_dir() . '/phpbbgallery_icons_' . uniqid('', true) . '/';
		mkdir($this->icons_path, 0700, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->icons_path);
	}

	/**
	 * The manager's constructor parameter is strictly typed to the real
	 * \phpbb\files\upload, so - the same way this codebase's other file-upload
	 * tests do - the constructor is bypassed and the (loosely-typed) properties are
	 * set directly, letting a lightweight double stand in for it.
	 *
	 * The manager takes an absolute path (for scanning) and a root-relative one
	 * (for move_file()/storage); pointing both at the same temp directory lets the
	 * test double's move_file() write to a real path without a full phpBB container.
	 */
	private function new_manager(?icon_manager_test_file_upload $file_upload = null): manager
	{
		return $this->build_manager($file_upload ?? new icon_manager_test_file_upload(), $this->icons_path, rtrim($this->icons_path, '/\\'));
	}

	private function build_manager(icon_manager_test_file_upload $file_upload, string $icons_path, string $icons_path_relative): manager
	{
		$reflection = new \ReflectionClass(manager::class);
		$manager = $reflection->newInstanceWithoutConstructor();

		$this->set_property($manager, 'file_upload', $file_upload);
		$this->set_property($manager, 'language', new icon_manager_test_language());
		$this->set_property($manager, 'icons_path', rtrim($icons_path, '/\\') . DIRECTORY_SEPARATOR);
		$this->set_property($manager, 'icons_path_relative', rtrim($icons_path_relative, '/\\'));

		return $manager;
	}

	private function set_property(object $object, string $name, mixed $value): void
	{
		$property = new \ReflectionProperty($object, $name);
		if (PHP_VERSION_ID < 80100)
		{
			$property->setAccessible(true);
		}
		$property->setValue($object, $value);
	}

	public function test_list_icons_only_returns_direct_child_allowed_files(): void
	{
		file_put_contents($this->icons_path . 'bluray.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>');
		file_put_contents($this->icons_path . 'dvd.png', 'fake-png');
		file_put_contents($this->icons_path . 'notes.txt', 'not an icon');
		mkdir($this->icons_path . 'sub', 0700);
		file_put_contents($this->icons_path . 'sub/nested.png', 'nested');

		$this->assertSame(['bluray.svg', 'dvd.png'], $this->new_manager()->list_icons());
	}

	public function test_list_icons_is_naturally_sorted(): void
	{
		foreach (['icon10.png', 'icon2.png', 'icon1.png'] as $name)
		{
			file_put_contents($this->icons_path . $name, 'x');
		}

		$this->assertSame(['icon1.png', 'icon2.png', 'icon10.png'], $this->new_manager()->list_icons());
	}

	public function test_list_icons_refuses_symlinks(): void
	{
		if (!function_exists('symlink'))
		{
			$this->markTestSkipped('symlink() is not available.');
		}

		$outside = sys_get_temp_dir() . '/phpbbgallery_icons_outside_' . uniqid('', true) . '.png';
		file_put_contents($outside, 'outside');

		$link = $this->icons_path . 'linked.png';
		if (!@symlink($outside, $link))
		{
			$this->markTestSkipped('Could not create a symlink in this environment.');
		}

		try
		{
			$this->assertSame([], $this->new_manager()->list_icons());
		}
		finally
		{
			@unlink($link);
			@unlink($outside);
		}
	}

	public function test_is_valid_icon_matches_only_real_listed_files(): void
	{
		file_put_contents($this->icons_path . 'bluray.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>');

		$manager = $this->new_manager();

		$this->assertTrue($manager->is_valid_icon('bluray.svg'));
		$this->assertFalse($manager->is_valid_icon('missing.svg'));
		$this->assertFalse($manager->is_valid_icon('../etc/passwd'));
		$this->assertFalse($manager->is_valid_icon(''));
	}

	public function test_relative_path_joins_the_configured_folder_and_filename(): void
	{
		$manager = $this->build_manager(new icon_manager_test_file_upload(), $this->icons_path, 'images/galleryicons');

		$this->assertSame('images/galleryicons/bluray.svg', $manager->relative_path('bluray.svg'));
	}

	public function test_upload_accepts_an_allowed_raster_image(): void
	{
		$png = $this->png_bytes();
		$source = $this->write_source_file('source.png', $png);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'DVD Icon.png', 'size' => strlen($png)];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNull($result['error']);
		$this->assertSame('dvd_icon.png', $result['filename']);
		$this->assertFileExists($this->icons_path . 'dvd_icon.png');
		$this->assertSame($png, file_get_contents($this->icons_path . 'dvd_icon.png'));
	}

	public function test_upload_creates_a_missing_icon_directory_and_listing_guard(): void
	{
		$directory = $this->icons_path . 'created/';
		$png = $this->png_bytes();
		$source = $this->write_source_file('source.png', $png);
		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'dvd.png', 'size' => strlen($png)];

		$result = $this->build_manager($file_upload, $directory, rtrim($directory, '/\\'))->upload('icon_file');

		$this->assertNull($result['error']);
		$this->assertFileExists($directory . 'dvd.png');
		$this->assertFileExists($directory . 'index.htm');
	}

	public function test_upload_reports_storage_failure_instead_of_invalid_content(): void
	{
		$png = $this->png_bytes();
		$source = $this->write_source_file('source.png', $png);
		$file_upload = new icon_manager_test_file_upload();
		$file_upload->fail_move_silently = true;
		$file_upload->next_upload = ['source' => $source, 'realname' => 'dvd.png', 'size' => strlen($png)];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertSame('ICON_STORAGE_UNAVAILABLE:' . rtrim($this->icons_path, '/\\'), $result['error']);
		$this->assertNull($result['filename']);
	}

	public function test_upload_rejects_a_disallowed_extension(): void
	{
		$source = $this->write_source_file('source.exe', 'not an icon');

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'payload.exe', 'size' => 11];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNotNull($result['error']);
		$this->assertNull($result['filename']);
		$this->assertSame([], $this->new_manager($file_upload)->list_icons());
	}

	public function test_upload_rejects_an_oversized_file(): void
	{
		$oversized = str_repeat('x', 600000);
		$source = $this->write_source_file('source.png', $oversized);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'big.png', 'size' => strlen($oversized)];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNotNull($result['error']);
		$this->assertNull($result['filename']);
	}

	public function test_upload_rejects_content_that_does_not_match_its_claimed_extension(): void
	{
		// A renamed non-image file passes phpBB's own extension check (it only looks
		// at the filename), so the manager's own getimagesize()-based check has to
		// catch it before it can sit in a web-accessible folder as "an image".
		$source = $this->write_source_file('source.png', '<?php system($_GET["c"]); ?>');

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'shell.png', 'size' => 27];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNotNull($result['error']);
		$this->assertNull($result['filename']);
		$this->assertFileDoesNotExist($this->icons_path . 'shell.png');
	}

	public function test_upload_does_not_overwrite_an_existing_icon(): void
	{
		file_put_contents($this->icons_path . 'dvd.png', 'existing');

		$png = $this->png_bytes();
		$source = $this->write_source_file('source.png', $png);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'dvd.png', 'size' => strlen($png)];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNotNull($result['error']);
		$this->assertSame('existing', file_get_contents($this->icons_path . 'dvd.png'));
	}

	public function test_upload_accepts_and_sanitizes_a_clean_svg(): void
	{
		$svg = '<svg xmlns="http://www.w3.org/2000/svg"><circle cx="5" cy="5" r="4" /></svg>';
		$source = $this->write_source_file('source.svg', $svg);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'bluray.svg', 'size' => strlen($svg)];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNull($result['error']);
		$this->assertSame('bluray.svg', $result['filename']);
		$this->assertStringContainsString('<circle', file_get_contents($this->icons_path . 'bluray.svg'));
	}

	public function test_upload_strips_a_script_element_from_an_svg(): void
	{
		$svg = '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script><circle cx="1" cy="1" r="1" /></svg>';
		$source = $this->write_source_file('source.svg', $svg);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'evil.svg', 'size' => strlen($svg)];

		$this->new_manager($file_upload)->upload('icon_file');

		$saved = file_get_contents($this->icons_path . 'evil.svg');
		$this->assertStringNotContainsString('<script', $saved);
		$this->assertStringNotContainsString('alert', $saved);
		$this->assertStringContainsString('<circle', $saved);
	}

	public function test_upload_strips_event_handler_attributes_from_an_svg(): void
	{
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"><rect onclick="alert(2)" width="1" height="1" /></svg>';
		$source = $this->write_source_file('source.svg', $svg);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'evil.svg', 'size' => strlen($svg)];

		$this->new_manager($file_upload)->upload('icon_file');

		$saved = file_get_contents($this->icons_path . 'evil.svg');
		$this->assertStringNotContainsString('onload', $saved);
		$this->assertStringNotContainsString('onclick', $saved);
		$this->assertStringContainsString('<rect', $saved);
	}

	public function test_upload_strips_a_foreign_object_from_an_svg(): void
	{
		$svg = '<svg xmlns="http://www.w3.org/2000/svg"><foreignObject><div>html</div></foreignObject><circle cx="1" cy="1" r="1" /></svg>';
		$source = $this->write_source_file('source.svg', $svg);

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'evil.svg', 'size' => strlen($svg)];

		$this->new_manager($file_upload)->upload('icon_file');

		$saved = file_get_contents($this->icons_path . 'evil.svg');
		$this->assertStringNotContainsString('foreignObject', $saved);
		$this->assertStringContainsString('<circle', $saved);
	}

	public function test_upload_rejects_an_svg_masking_a_php_shell(): void
	{
		$source = $this->write_source_file('source.svg', '<?php system($_GET["c"]); ?>');

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'shell.svg', 'size' => 27];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNotNull($result['error']);
		$this->assertNull($result['filename']);
		$this->assertFileDoesNotExist($this->icons_path . 'shell.svg');
	}

	public function test_upload_rejects_an_svg_whose_root_element_is_not_svg(): void
	{
		$source = $this->write_source_file('source.svg', '<?xml version="1.0"?><root><script>alert(1)</script></root>');

		$file_upload = new icon_manager_test_file_upload();
		$file_upload->next_upload = ['source' => $source, 'realname' => 'not-svg.svg', 'size' => 10];

		$result = $this->new_manager($file_upload)->upload('icon_file');

		$this->assertNotNull($result['error']);
		$this->assertFileDoesNotExist($this->icons_path . 'not-svg.svg');
	}

	private function write_source_file(string $name, string $contents): string
	{
		$path = sys_get_temp_dir() . '/phpbbgallery_icon_src_' . uniqid('', true) . '_' . $name;
		file_put_contents($path, $contents);

		return $path;
	}

	private function png_bytes(): string
	{
		return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		foreach (array_diff((array) scandir($directory), ['.', '..']) as $name)
		{
			$path = $directory . $name;
			if (is_dir($path) && !is_link($path))
			{
				$this->remove_directory($path . '/');
			}
			else
			{
				@unlink($path);
			}
		}

		@rmdir($directory);
	}
}

class icon_manager_test_language
{
	public function lang(string $key, ...$args): string
	{
		return $key . (empty($args) ? '' : ':' . implode(',', $args));
	}
}

/**
 * Stands in for \phpbb\files\upload. handle_upload() returns a filespec-shaped
 * double whose move_file() actually writes bytes, so the manager's own post-move
 * validation (raster type check, SVG sanitizer) runs against a real file exactly
 * as it would in production.
 */
class icon_manager_test_file_upload
{
	/** @var array|null ['source' => path, 'realname' => name, 'size' => int] */
	public ?array $next_upload = null;
	public bool $fail_move_silently = false;

	private array $allowed_extensions = [];
	private int $max_filesize = 0;

	public function reset_vars(): void
	{
		$this->allowed_extensions = [];
		$this->max_filesize = 0;
	}

	public function set_allowed_extensions(array $extensions): void
	{
		$this->allowed_extensions = $extensions;
	}

	public function set_max_filesize(int $max_filesize): void
	{
		$this->max_filesize = $max_filesize;
	}

	public function set_disallowed_content(array $content): void
	{
	}

	public function handle_upload(string $type, string $form_field)
	{
		$upload = $this->next_upload;
		$file = new icon_manager_test_filespec($upload['source'], $upload['realname'], $this->fail_move_silently);

		$extension = strtolower(pathinfo($upload['realname'], PATHINFO_EXTENSION));
		if (!in_array($extension, $this->allowed_extensions, true))
		{
			$file->error[] = 'DISALLOWED_EXTENSION';
		}
		else if ($this->max_filesize && $upload['size'] > $this->max_filesize)
		{
			$file->error[] = 'WRONG_FILESIZE';
		}

		return $file;
	}
}

class icon_manager_test_filespec
{
	public array $error = [];

	private string $source;
	private string $realname;
	private ?string $destination_file = null;
	private bool $fail_move_silently;

	public function __construct(string $source, string $realname, bool $fail_move_silently = false)
	{
		$this->source = $source;
		$this->realname = $realname;
		$this->fail_move_silently = $fail_move_silently;
	}

	public function clean_filename(string $mode): void
	{
		if ($mode !== 'real')
		{
			return;
		}

		$extension = strtolower(pathinfo($this->realname, PATHINFO_EXTENSION));
		$stem = pathinfo($this->realname, PATHINFO_FILENAME);
		$bad_chars = ["'", '\\', ' ', '/', ':', '*', '?', '"', '<', '>', '|'];

		$this->realname = str_replace($bad_chars, '_', strtolower($stem)) . '.' . $extension;
	}

	public function get(string $property)
	{
		return $property === 'destination_file' ? $this->destination_file : null;
	}

	public function move_file(string $destination, bool $overwrite = false, bool $skip_image_check = false): bool
	{
		if (!empty($this->error))
		{
			return false;
		}
		if ($this->fail_move_silently)
		{
			return false;
		}

		// The test double treats $destination as the already-absolute target
		// directory - manager::__construct() was given the same path for both its
		// absolute and root-relative arguments precisely to make that true here.
		$target = rtrim($destination, '/\\') . '/' . $this->realname;

		if (file_exists($target) && !$overwrite)
		{
			$this->error[] = 'GENERAL_UPLOAD_ERROR';

			return false;
		}

		if (!@copy($this->source, $target))
		{
			$this->error[] = 'GENERAL_UPLOAD_ERROR';

			return false;
		}

		$this->destination_file = $target;

		return true;
	}
}
