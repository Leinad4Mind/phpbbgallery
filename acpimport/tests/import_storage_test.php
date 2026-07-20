<?php
/**
 * phpBB Gallery - ACP Import Extension tests
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\acpimport\acp\import_storage;

class import_storage_test extends TestCase
{
	/** @var string */
	private $temporary_directory;

	/** @var string */
	private $import_directory;

	/** @var import_storage */
	private $storage;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery_acpimport_' . uniqid('', true) . '/';
		$this->import_directory = $this->temporary_directory . 'import/';
		$this->assertTrue(mkdir($this->import_directory, 0700, true));
		$this->storage = new import_storage($this->import_directory);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->temporary_directory);
	}

	public function test_generates_random_schema_identifiers(): void
	{
		$first = $this->storage->create_schema_id();
		$second = $this->storage->create_schema_id();

		$this->assertSame(1, preg_match('/^[a-f0-9]{32}$/', $first));
		$this->assertSame(1, preg_match('/^[a-f0-9]{32}$/', $second));
		$this->assertNotSame($first, $second);
	}

	public function test_writes_and_reads_non_executable_json_state(): void
	{
		$schema_id = $this->storage->create_schema_id();
		$payload = 'image' . chr(39) . '\\; phpinfo(); //';
		$state = $this->valid_state([$payload]);
		$state['image_name'] = $payload;
		$state['user_data']['username'] = $payload;

		$this->assertTrue($this->storage->write_state($schema_id, $state));
		$state_path = $this->storage->get_state_path($schema_id);
		$this->assertSame('.json', substr($state_path, -5));
		$this->assertStringNotContainsString('<?php', file_get_contents($state_path));
		$this->assertSame($state, $this->storage->read_state($schema_id));
	}

	public function test_rejects_invalid_schema_identifiers(): void
	{
		$state = $this->valid_state();
		foreach (['', '../state', str_repeat('a', 31), str_repeat('a', 33), str_repeat('A', 32), str_repeat('g', 32)] as $schema_id)
		{
			$this->assertFalse($this->storage->get_state_path($schema_id));
			$this->assertFalse($this->storage->write_state($schema_id, $state));
			$this->assertFalse($this->storage->read_state($schema_id));
			$this->assertFalse($this->storage->remove_state($schema_id));
		}
	}

	public function test_rejects_malformed_state(): void
	{
		$schema_id = $this->storage->create_schema_id();
		$state = $this->valid_state();

		$missing_key = $state;
		unset($missing_key['errors']);
		$this->assertFalse($this->storage->write_state($schema_id, $missing_key));

		$wrong_count = $state;
		$wrong_count['todo_images'] = 2;
		$this->assertFalse($this->storage->write_state($schema_id, $wrong_count));

		$unkeyed_images = $state;
		$unkeyed_images['images'] = [1 => 'image.png'];
		$this->assertFalse($this->storage->write_state($schema_id, $unkeyed_images));

		$invalid_utf8 = $state;
		$invalid_utf8['image_name'] = chr(255);
		$this->assertFalse($this->storage->write_state($schema_id, $invalid_utf8));

		$control_character = $state;
		$control_character['images'] = ['bad' . chr(10) . '.png'];
		$this->assertFalse($this->storage->write_state($schema_id, $control_character));

		$extra_key = $state;
		$extra_key['executable'] = 'phpinfo';
		$this->assertFalse($this->storage->write_state($schema_id, $extra_key));
	}

	public function test_rejects_corrupt_json_state(): void
	{
		$schema_id = $this->storage->create_schema_id();
		$state_path = $this->storage->get_state_path($schema_id);
		file_put_contents($state_path, '{invalid json');

		$this->assertFalse($this->storage->read_state($schema_id));
	}

	public function test_rejects_oversized_state_before_decoding(): void
	{
		$schema_id = $this->storage->create_schema_id();
		$state_path = $this->storage->get_state_path($schema_id);
		file_put_contents($state_path, str_repeat('x', 8388609));

		$this->assertFalse($this->storage->read_state($schema_id));
	}

	public function test_removes_json_state_without_touching_other_files(): void
	{
		$schema_id = $this->storage->create_schema_id();
		$state_path = $this->storage->get_state_path($schema_id);
		$marker = $this->import_directory . 'keep.txt';
		file_put_contents($marker, 'keep');
		$this->assertTrue($this->storage->write_state($schema_id, $this->valid_state()));

		$this->assertTrue($this->storage->remove_state($schema_id));
		$this->assertFalse(file_exists($state_path));
		$this->assertSame('keep', file_get_contents($marker));
		$this->assertTrue($this->storage->remove_state($schema_id));
	}

	public function test_removes_only_legacy_php_state_files(): void
	{
		$schema_id = str_repeat('a', 32);
		$state_file = $this->import_directory . $schema_id . '.php';
		$error_file = $this->import_directory . $schema_id . '_errors.php';
		$unrelated_php = $this->import_directory . 'unrelated.php';
		$near_match = $this->import_directory . $schema_id . '_other.php';
		$image = $this->import_directory . $schema_id . '.png';
		foreach ([$state_file, $error_file, $unrelated_php, $near_match, $image] as $file)
		{
			file_put_contents($file, 'content');
		}

		$this->assertSame(2, $this->storage->remove_legacy_php_state());
		$this->assertFalse(file_exists($state_file));
		$this->assertFalse(file_exists($error_file));
		$this->assertTrue(file_exists($unrelated_php));
		$this->assertTrue(file_exists($near_match));
		$this->assertTrue(file_exists($image));
	}

	public function test_lists_only_enabled_direct_child_images(): void
	{
		file_put_contents($this->import_directory . 'photo.png', $this->png_image());
		file_put_contents($this->import_directory . 'second.JPG', $this->png_image());
		file_put_contents($this->import_directory . 'ignored.gif', $this->gif_image());
		file_put_contents($this->import_directory . 'notes.txt', 'text');
		mkdir($this->import_directory . 'nested');
		file_put_contents($this->import_directory . 'nested/hidden.png', $this->png_image());
		$schema_id = $this->storage->create_schema_id();
		$this->assertTrue($this->storage->write_state($schema_id, $this->valid_state()));

		$images = $this->storage->get_images(['png', 'jpg', 'jpeg']);
		$this->assertSame(['photo.png', 'second.JPG'], array_keys($images));
		$this->assertSame(realpath($this->import_directory . 'photo.png'), $images['photo.png']['path']);
		$this->assertArrayNotHasKey('ignored.gif', $images);
		$this->assertArrayNotHasKey('hidden.png', $images);
	}

	public function test_resolves_only_an_enumerated_filename(): void
	{
		file_put_contents($this->import_directory . 'photo.png', $this->png_image());
		file_put_contents($this->temporary_directory . 'outside.png', $this->png_image());

		$image = $this->storage->resolve_image('photo.png', ['png']);
		$this->assertSame(realpath($this->import_directory . 'photo.png'), $image['path']);
		foreach (['../outside.png', '/outside.png', 'C:\\outside.png', 'missing.png'] as $unsafe_name)
		{
			$this->assertFalse($this->storage->resolve_image($unsafe_name, ['png']));
		}
	}

	public function test_ignores_symlinks_that_escape_the_import_directory(): void
	{
		$outside = $this->temporary_directory . 'outside.png';
		$link = $this->import_directory . 'linked.png';
		file_put_contents($outside, $this->png_image());
		if (!@symlink($outside, $link))
		{
			$this->addToAssertionCount(1);
			return;
		}

		$this->assertArrayNotHasKey('linked.png', $this->storage->get_images(['png']));
		$this->assertSame($this->png_image(), file_get_contents($outside));
	}

	public function test_inspects_content_and_extension_together(): void
	{
		file_put_contents($this->import_directory . 'valid.png', $this->png_image());
		file_put_contents($this->import_directory . 'disguised.jpg', $this->png_image());
		file_put_contents($this->import_directory . 'fake.png', 'not an image');

		$valid = $this->storage->resolve_image('valid.png', ['png', 'jpg']);
		$valid_inspection = $this->storage->inspect_image($valid);
		$this->assertSame('', $valid_inspection['error']);
		$this->assertSame('.png', $valid_inspection['target_extension']);

		$disguised = $this->storage->resolve_image('disguised.jpg', ['png', 'jpg']);
		$this->assertSame('mime_mismatch', $this->storage->inspect_image($disguised)['error']);

		$fake = $this->storage->resolve_image('fake.png', ['png', 'jpg']);
		$this->assertSame('invalid_type', $this->storage->inspect_image($fake)['error']);
	}

	public function test_copies_only_to_a_new_destination(): void
	{
		$source = $this->import_directory . 'source.png';
		$destination = $this->temporary_directory . 'destination.png';
		file_put_contents($source, $this->png_image());

		$this->assertTrue($this->storage->copy_image($source, $destination));
		$this->assertSame($this->png_image(), file_get_contents($destination));
		file_put_contents($source, 'changed');
		$this->assertFalse($this->storage->copy_image($source, $destination));
		$this->assertSame($this->png_image(), file_get_contents($destination));

		$outside = $this->temporary_directory . 'outside.png';
		file_put_contents($outside, $this->png_image());
		$this->assertFalse($this->storage->copy_image($outside, $this->temporary_directory . 'outside-copy.png'));
	}

	public function test_rejects_a_symlinked_state_file(): void
	{
		$schema_id = $this->storage->create_schema_id();
		$state_path = $this->storage->get_state_path($schema_id);
		$outside = $this->temporary_directory . 'outside.json';
		file_put_contents($outside, json_encode($this->valid_state()));
		if (!@symlink($outside, $state_path))
		{
			$this->addToAssertionCount(1);
			return;
		}

		$this->assertFalse($this->storage->read_state($schema_id));
		$this->assertFalse($this->storage->write_state($schema_id, $this->valid_state()));
		$this->assertSame(file_get_contents($outside), file_get_contents($state_path));
	}

	public function test_main_module_contains_no_executable_state_flow(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertSame(0, preg_match('/(?<!_)\binclude\s*\(/', $source));
		$this->assertStringNotContainsString('$_POST', $source);
		$this->assertStringNotContainsString('move_uploaded_file', $source);
		$this->assertStringNotContainsString('!$error_occurred ||', $source);
		$this->assertStringNotContainsString('_return_file', $source);
		$this->assertStringNotContainsString('$import_file', $source);
		$this->assertStringContainsString('read_state(', $source);
		$this->assertStringContainsString('write_state(', $source);
		$this->assertStringContainsString('get_images(', $source);
		$this->assertStringContainsString('copy_image(', $source);
		$this->assertStringContainsString('update_images($successful_images)', $source);
		$this->assertStringContainsString('$state[\'creator_id\']', $source);
	}

	private function valid_state(array $images = ['image.png']): array
	{
		return [
			'creator_id' => 2,
			'album_id' => 3,
			'start_time' => 1700000000,
			'num_offset' => 1,
			'done_images' => 0,
			'todo_images' => count($images),
			'image_name' => 'Image {NUM}',
			'filename' => false,
			'user_data' => [
				'user_id' => 4,
				'username' => 'Uploader',
				'user_colour' => 'ABCDEF',
			],
			'images' => $images,
			'errors' => [],
		];
	}

	private function png_image(): string
	{
		return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
	}

	private function gif_image(): string
	{
		return base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		foreach (array_diff(scandir($directory), ['.', '..']) as $name)
		{
			$path = $directory . $name;
			if (is_dir($path) && !is_link($path))
			{
				$this->remove_directory($path . '/');
			}
			else
			{
				unlink($path);
			}
		}

		rmdir($directory);
	}
}
