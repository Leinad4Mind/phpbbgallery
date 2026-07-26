<?php
/**
 * phpBB Gallery - ACP Cleanup tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\acpcleanup\cleanup;

final class cleanup_test extends TestCase
{
	public function test_service_contract_uses_native_types(): void
	{
		$reflection = new \ReflectionClass(cleanup::class);
		$expected_properties = [
			'db' => 'phpbb\\db\\driver\\driver_interface',
			'tool' => 'phpbbgallery\\core\\file\\file',
			'user' => 'phpbb\\user',
			'language' => 'phpbb\\language\\language',
			'block' => 'phpbbgallery\\core\\block',
			'album' => 'phpbbgallery\\core\\album\\album',
			'comment' => 'phpbbgallery\\core\\comment',
			'gallery_config' => 'phpbbgallery\\core\\config',
			'log' => 'phpbbgallery\\core\\log',
			'moderate' => 'phpbbgallery\\core\\moderate',
			'albums_table' => 'string',
			'images_table' => 'string',
		];

		foreach ($expected_properties as $property_name => $expected_type)
		{
			$property = $reflection->getProperty($property_name);
			$this->assertSame($expected_type, (string) $property->getType());
		}

		$expected_returns = [
			'delete_files' => 'string',
			'delete_images' => 'string',
			'delete_author_images' => 'string',
			'delete_author_comments' => 'string',
			'delete_pegas' => 'array',
			'prune' => 'string',
			'lang_prune_pattern' => 'string',
		];

		foreach ($expected_returns as $method_name => $expected_type)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame($expected_type, (string) $method->getReturnType());
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertSame('array', (string) $parameter->getType());
			}
		}
	}

	public function test_delete_files_removes_sources_and_caches(): void
	{
		$dependencies = $this->create_service();
		$message = $dependencies['service']->delete_files(['férias.jpg', '日本.png']);

		$this->assertSame('CLEAN_ENTRIES_DONE', $message);
		$this->assertSame(['férias.jpg', '日本.png'], $dependencies['tool']->deleted);
		$this->assertSame(['férias.jpg', '日本.png'], $dependencies['tool']->deleted_cache);
		$this->assertSame(['admin', 'clean_deletefiles', 0, 0, ['LOG_CLEANUP_DELETE_FILES', 2]], $dependencies['log']->entries[0]);
	}

	public function test_newest_personal_gallery_config_uses_only_a_real_database_row(): void
	{
		$dependencies = $this->create_service();
		$update = new \ReflectionMethod(cleanup::class, 'update_newest_personal_gallery_config');
		$update->invoke($dependencies['service'], [
			'user_id' => 7,
			'username' => 'Alice',
			'user_colour' => 'abcdef',
			'album_id' => 12,
		]);

		$this->assertSame([
			'newest_pega_user_id' => 7,
			'newest_pega_username' => 'Alice',
			'newest_pega_user_colour' => 'abcdef',
			'newest_pega_album_id' => 12,
		], $dependencies['config']->values);

		$update->invoke($dependencies['service'], false);
		$this->assertSame(0, $dependencies['config']->values['newest_pega_user_id']);
		$this->assertSame('', $dependencies['config']->values['newest_pega_username']);
		$this->assertSame('', $dependencies['config']->values['newest_pega_user_colour']);
		$this->assertSame(0, $dependencies['config']->values['newest_pega_album_id']);
		$this->assertSame(0, $dependencies['config']->values['num_pegas']);
	}

	public function test_subalbums_without_a_personal_root_are_ignored(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString("if (isset(\$personal_bad_row[\$row['album_user_id']]))", $source);
	}

	public function test_database_cleanup_delegates_to_the_domain_services(): void
	{
		$dependencies = $this->create_service();

		$this->assertSame('CLEAN_SOURCES_DONE', $dependencies['service']->delete_images([10, 11]));
		$this->assertSame('CLEAN_AUTHORS_DONE', $dependencies['service']->delete_author_images([20]));
		$this->assertSame('CLEAN_COMMENTS_DONE', $dependencies['service']->delete_author_comments([30, 31]));

		$this->assertSame([
			[[10, 11], false],
			[[20], []],
		], $dependencies['moderate']->deleted);
		$this->assertSame([30, 31], $dependencies['comment']->deleted[0]);
	}

	public function test_prune_deletes_the_selected_rows_and_files(): void
	{
		$db = new fake_db([
			['image_id' => 5, 'image_filename' => 'five.jpg'],
			['image_id' => 8, 'image_filename' => 'eight.png'],
		]);
		$dependencies = $this->create_service($db);

		$this->assertSame('CLEAN_PRUNE_DONE', $dependencies['service']->prune(['image_time' => 123]));
		$this->assertStringContainsString('image_time < 123', $db->queries[0]);
		$this->assertSame([[[5, 8], [5 => 'five.jpg', 8 => 'eight.png']]], $dependencies['moderate']->deleted);
	}

	public function test_prune_ignores_unknown_columns_and_casts_thresholds(): void
	{
		$db = new fake_db();
		$dependencies = $this->create_service($db);

		$dependencies['service']->prune([
			'image_time' => '123 OR 1=1',
			'image_status = 0 OR 1' => '1',
		]);

		$this->assertStringContainsString('image_time < 123', $db->queries[0]);
		$this->assertStringNotContainsString('OR 1', $db->queries[0]);
		$this->assertStringNotContainsString('image_status', $db->queries[0]);
	}

	public function test_prune_normalizes_identifier_lists_before_using_dbal(): void
	{
		$db = new fake_db();
		$dependencies = $this->create_service($db);

		$dependencies['service']->prune([
			'image_album_id' => '4,7 OR 1=1,-2,0,4',
			'image_user_id' => ['9', 'invalid', 9],
		]);

		$this->assertStringContainsString('image_album_id IN (4,7)', $db->queries[0]);
		$this->assertStringContainsString('image_user_id IN (9)', $db->queries[0]);
	}

	public function test_prune_rejects_a_pattern_without_supported_filters(): void
	{
		$db = new fake_db();
		$dependencies = $this->create_service($db);

		try
		{
			$dependencies['service']->prune(['image_time < 1 OR 1=1' => 1]);
			$this->fail('An unsupported prune pattern was accepted.');
		}
		catch (\InvalidArgumentException)
		{
			$this->assertSame([], $db->queries);
		}
	}

	private function create_service(?fake_db $db = null): array
	{
		$db ??= new fake_db();
		$tool = new \phpbbgallery\core\file\file();
		$user = new \phpbb\user();
		$language = new \phpbb\language\language();
		$block = new \phpbbgallery\core\block();
		$album = new \phpbbgallery\core\album\album();
		$comment = new \phpbbgallery\core\comment();
		$config = new \phpbbgallery\core\config();
		$log = new \phpbbgallery\core\log();
		$moderate = new \phpbbgallery\core\moderate();

		return [
			'service' => new cleanup($db, $tool, $user, $language, $block, $album, $comment, $config, $log, $moderate, 'gallery_albums', 'gallery_images'),
			'tool' => $tool,
			'comment' => $comment,
			'config' => $config,
			'log' => $log,
			'moderate' => $moderate,
		];
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Database test double belongs to this isolated service test.
final class fake_db implements \phpbb\db\driver\driver_interface
{
	public array $queries = [];
	private array $rows;

	public function __construct(array $rows = [])
	{
		$this->rows = $rows;
	}

	public function sql_query(string $sql): object
	{
		$this->queries[] = $sql;
		return new \stdClass();
	}

	public function sql_fetchrow(object $result): array|false
	{
		return array_shift($this->rows) ?? false;
	}

	public function sql_freeresult(object $result): void
	{
	}

	public function sql_in_set(string $field, array $values, bool $negate = false, bool $allow_empty_set = false): string
	{
		return $field . ' IN (' . implode(',', $values) . ')';
	}
}
