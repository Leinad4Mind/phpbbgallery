<?php
/**
 * phpBB Gallery - Identity synchronization tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\identity_sync;
use PHPUnit\Framework\TestCase;

final class identity_sync_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}
		if (!defined('USERS_TABLE'))
		{
			define('USERS_TABLE', 'phpbb_users');
		}
	}

	public function test_rename_uses_resolved_user_id_and_clears_identity_caches(): void
	{
		$queries = [];
		$destroyed = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_escape')->willReturnCallback(static fn (string $value): string => str_replace("'", "''", $value));
		$db->expects($this->once())
			->method('sql_query_limit')
			->with($this->stringContains("username_clean = 'new o''brien'"), 1)
			->willReturn('user-result');
		$db->expects($this->once())->method('sql_fetchrow')->with('user-result')->willReturn(['user_id' => 42]);
		$db->expects($this->once())->method('sql_freeresult')->with('user-result');
		$db->expects($this->exactly(5))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): void
			{
				$queries[] = $sql;
			});

		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->once())->method('get')->with('newest_pega_user_id')->willReturn(42);
		$config->expects($this->once())->method('set')->with('newest_pega_username', "New O'Brien");
		$cache = $this->identity_cache($destroyed);

		$this->new_service($db, $config, $cache)->rename_user('Guest collision', "New O'Brien");

		$this->assertStringContainsString('UPDATE gallery_images', $queries[0]);
		$this->assertStringContainsString("image_username = 'New O''Brien'", $queries[0]);
		$this->assertStringContainsString('WHERE image_user_id = 42', $queries[0]);
		$this->assertStringContainsString('WHERE comment_user_id = 42', $queries[1]);
		$this->assertStringContainsString('WHERE album_last_user_id = 42', $queries[2]);
		$this->assertStringContainsString('CASE WHEN parent_id = 0', $queries[3]);
		$this->assertStringContainsString("album_parents = ''", $queries[3]);
		$this->assertStringContainsString('WHERE album_user_id = 42', $queries[3]);
		$this->assertStringContainsString('WHERE user_id = 42', $queries[4]);
		$this->assertSame(['gallery_albums', 'gallery_comments', 'gallery_images', 'gallery_modscache'], $destroyed);
		$this->assertStringNotContainsString('Guest collision', implode("\n", $queries));
	}

	public function test_unresolved_or_unchanged_username_is_a_safe_no_op(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_escape')->willReturnArgument(0);
		$db->expects($this->once())->method('sql_query_limit')->willReturn('user-result');
		$db->expects($this->once())->method('sql_fetchrow')->with('user-result')->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with('user-result');
		$db->expects($this->never())->method('sql_query');
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->never())->method('get');
		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->never())->method('destroy_images');

		$service = $this->new_service($db, $config, $cache);
		$service->rename_user('Same', 'Same');
		$service->rename_user('Old', 'Missing');
	}

	public function test_default_group_colour_updates_every_identity_snapshot(): void
	{
		$queries = [];
		$destroyed = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_escape')->with('AABBCC')->willReturn('AABBCC');
		$db->expects($this->exactly(3))
			->method('sql_in_set')
			->willReturnCallback(static fn (string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): void
			{
				$queries[] = $sql;
			});
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->once())->method('get')->with('newest_pega_user_id')->willReturn(9);
		$config->expects($this->once())->method('set')->with('newest_pega_user_colour', 'AABBCC');
		$cache = $this->identity_cache($destroyed);

		$this->new_service($db, $config, $cache)->recolour_users([9, 7, 9, 1, 0], 'AABBCC');

		$this->assertStringContainsString('album_last_user_id IN (7, 9)', $queries[0]);
		$this->assertStringContainsString('comment_user_id IN (7, 9)', $queries[1]);
		$this->assertStringContainsString('image_user_id IN (7, 9)', $queries[2]);
		$this->assertSame(['gallery_albums', 'gallery_comments', 'gallery_images', 'gallery_modscache'], $destroyed);
	}

	public function test_deleted_users_and_groups_remove_derived_acl_rows(): void
	{
		$queries = [];
		$destroyed = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static fn (string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->exactly(4))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): void
			{
				$queries[] = $sql;
			});
		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->exactly(4))
			->method('destroy')
			->willReturnCallback(static function (string $target, string|false $table) use (&$destroyed): void
			{
				$destroyed[] = [$target, $table];
			});
		$service = $this->new_service($db, $this->createStub(\phpbbgallery\core\config::class), $cache);

		$service->delete_users([9, 7, 9, 1, 0]);
		$service->delete_group(5);
		$service->delete_group(0);

		$this->assertStringContainsString('user_id IN (7, 9)', $queries[0]);
		$this->assertStringContainsString('perm_user_id IN (7, 9)', $queries[1]);
		$this->assertStringContainsString('group_id = 5', $queries[2]);
		$this->assertStringContainsString('perm_group_id = 5', $queries[3]);
		$this->assertSame([
			['sql', 'gallery_modscache'],
			['sql', 'gallery_permissions'],
			['sql', 'gallery_modscache'],
			['sql', 'gallery_permissions'],
		], $destroyed);
	}

	public function test_moderator_listing_uses_live_names_and_album_cleanup_invalidates_it(): void
	{
		$display = file_get_contents(dirname(__DIR__) . '/album/display.php');
		$manage = file_get_contents(dirname(__DIR__) . '/album/manage.php');

		$this->assertIsString($display);
		$this->assertStringContainsString('u.username AS current_username', $display);
		$this->assertStringContainsString('g.group_name AS current_group_name', $display);
		$this->assertStringContainsString('$album_id !== false', $display);
		$this->assertStringContainsString('$row[\'current_username\']', $display);
		$this->assertStringContainsString('$row[\'current_group_name\']', $display);
		$this->assertIsString($manage);
		$this->assertGreaterThanOrEqual(2, substr_count($manage, 'destroy(\'sql\', $this->moderators_table)'));
	}

	public function test_identity_service_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(identity_sync::class);

		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), identity_sync::class . '::$' . $property->getName());
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== identity_sync::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), identity_sync::class . '::' . $method->getName());
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), identity_sync::class . '::' . $method->getName());
			}
		}
	}

	private function new_service(\phpbb\db\driver\driver_interface $db, \phpbbgallery\core\config $config,
								\phpbbgallery\core\cache $cache): identity_sync
	{
		return new identity_sync(
			$db,
			$config,
			$cache,
			'gallery_albums',
			'gallery_images',
			'gallery_comments',
			'gallery_modscache',
			'gallery_permissions'
		);
	}

	private function identity_cache(array &$destroyed): \phpbbgallery\core\cache
	{
		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->once())->method('destroy_images');
		$cache->expects($this->once())->method('destroy_albums');
		$cache->expects($this->exactly(4))
			->method('destroy')
			->willReturnCallback(static function (string $target, string|false $table) use (&$destroyed): void
			{
				TestCase::assertSame('sql', $target);
				$destroyed[] = $table;
			});

		return $cache;
	}
}
