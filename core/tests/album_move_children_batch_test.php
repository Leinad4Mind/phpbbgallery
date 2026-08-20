<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\album;
use phpbbgallery\core\album\manage;
use PHPUnit\Framework\TestCase;

final class album_move_children_batch_test extends TestCase
{
	public function test_contiguous_album_branches_are_moved_with_one_query_set(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(5))
			->method('sql_query')
			->willReturnCallback(function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return count($queries);
			});
		$db->method('sql_in_set')
			->willReturnCallback(function (string $field, array $values, bool $negate = false): string
			{
				return $field . ($negate ? ' NOT IN (' : ' IN (') . implode(', ', $values) . ')';
			});

		$gallery_album = $this->createMock(album::class);
		$gallery_album->expects($this->exactly(2))
			->method('get_info')
			->with(20)
			->willReturnOnConsecutiveCalls(
				['album_id' => 20, 'right_id' => 12],
				['album_id' => 20, 'right_id' => 6]
			);

		$manager = $this->manager($db, $gallery_album);
		$move = \Closure::bind(function (): array
		{
			return $this->move_album_nodes(
				[
					['album_id' => 2],
					['album_id' => 3],
					['album_id' => 4],
				],
				20,
				2,
				7
			);
		}, $manager, manage::class);

		$this->assertSame([], $move());
		$this->assertCount(5, $queries);
		$this->assertStringContainsString('right_id = right_id - 6', $queries[0]);
		$this->assertStringContainsString('left_id < 7', $queries[0]);
		$this->assertStringContainsString('left_id > 7', $queries[1]);
		$this->assertStringContainsString('6 BETWEEN left_id AND right_id', $queries[2]);
		$this->assertStringContainsString('album_id NOT IN (2, 3, 4)', $queries[2]);
		$this->assertStringContainsString('left_id = left_id + 4', $queries[4]);
		$this->assertStringContainsString('album_id IN (2, 3, 4)', $queries[4]);
	}

	public function test_album_deletion_moves_children_as_one_interval(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/album/manage.php');

		$this->assertStringContainsString('->move_album_children($album_id, $subalbums_to_id)', $source);
		$this->assertStringNotContainsString('->move_album($row[\'album_id\'], $subalbums_to_id)', $source);
	}

	public function test_album_tree_deletion_batches_content_cleanup(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/album/manage.php');
		$method = new \ReflectionMethod(manage::class, 'delete_album_content');

		$this->assertSame('array|int', (string) $method->getParameters()[0]->getType());
		$this->assertStringContainsString('$content_album_ids[] = (int) $row[\'album_id\'];', $source);
		$this->assertStringContainsString('$this->delete_album_content($content_album_ids)', $source);
		$this->assertStringContainsString('GROUP BY image_user_id', $source);
		$this->assertStringContainsString('$this->gallery_notification->delete_albums($album_ids);', $source);
		$this->assertStringNotContainsString('merge queries into loop', $source);
	}

	public function test_album_content_cleanup_uses_one_batched_query_set(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(6))
			->method('sql_query')
			->willReturnCallback(function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return count($queries);
			});
		$db->method('sql_in_set')
			->willReturnCallback(function (string $field, array $values): string
			{
				return $field . ' IN (' . implode(', ', $values) . ')';
			});
		$rows = [
			1 => [['image_user_id' => 9, 'image_count' => 2], false],
			2 => [
				['image_id' => 11, 'image_filename' => 'first.jpg', 'image_album_id' => 4],
				['image_id' => 12, 'image_filename' => 'second.jpg', 'image_album_id' => 5],
				false,
			],
			6 => [['num_images' => 7, 'num_comments' => 3]],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(function (int $result) use (&$rows)
			{
				return array_shift($rows[$result]);
			});

		$image = $this->createMock(\phpbbgallery\core\image\image::class);
		$image->expects($this->once())
			->method('delete_images')
			->with([11, 12], [11 => 'first.jpg', 12 => 'second.jpg'], false);
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->expects($this->once())->method('set_user_id')->with(9);
		$gallery_user->expects($this->once())->method('update_images')->with(-2);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config_values = [];
		$config->expects($this->exactly(2))
			->method('set')
			->willReturnCallback(function (string $key, $value) use (&$config_values): void
			{
				$config_values[$key] = $value;
			});
		$notification = $this->createMock(\phpbbgallery\core\notification::class);
		$notification->expects($this->once())->method('delete_albums')->with([4, 5]);
		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->once())->method('destroy')->with('sql', 'gallery_moderators');
		$cache->expects($this->once())->method('destroy_albums');
		$dispatcher = $this->createMock(\phpbb\event\dispatcher::class);
		$events = [];
		$dispatcher->expects($this->exactly(2))
			->method('trigger_event')
			->willReturnCallback(function (string $name, array $data) use (&$events): array
			{
				$events[] = [$name, $data['album_id']];

				return $data;
			});

		$manager = (new \ReflectionClass(manage::class))->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function ($database, $image_service, $user_service, $config_service, $notification_service, $cache_service, $event_dispatcher): void
		{
			$this->db = $database;
			$this->gallery_image = $image_service;
			$this->gallery_user = $user_service;
			$this->gallery_config = $config_service;
			$this->gallery_notification = $notification_service;
			$this->gallery_cache = $cache_service;
			$this->dispatcher = $event_dispatcher;
			$this->images_table = 'gallery_images';
			$this->permissions_table = 'gallery_permissions';
			$this->moderators_table = 'gallery_moderators';
			$this->tracking_table = 'gallery_tracking';
		}, $manager, manage::class);
		$initialize($db, $image, $gallery_user, $config, $notification, $cache, $dispatcher);

		$this->assertSame([], $manager->delete_album_content([4, 5, 4]));
		$this->assertSame(['num_images' => 7, 'num_comments' => 3], $config_values);
		$this->assertSame([
			['phpbbgallery.core.album.manage.delete_album_content', 4],
			['phpbbgallery.core.album.manage.delete_album_content', 5],
		], $events);
		$this->assertStringContainsString('image_album_id IN (4, 5)', $queries[0]);
		$this->assertStringContainsString('GROUP BY image_user_id', $queries[0]);
		$this->assertStringContainsString('perm_album_id IN (4, 5)', $queries[2]);
		$this->assertStringContainsString('album_id IN (4, 5)', $queries[4]);
	}

	public function test_category_conversion_deletes_images_but_preserves_album_state(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return count($queries);
			});
		$db->method('sql_in_set')
			->willReturnCallback(function (string $field, array $values): string
			{
				return $field . ' IN (' . implode(', ', $values) . ')';
			});
		$rows = [
			1 => [false],
			2 => [['image_id' => 11, 'image_filename' => 'first.jpg', 'image_album_id' => 4], false],
			3 => [['num_images' => 6, 'num_comments' => 2]],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(function (int $result) use (&$rows)
			{
				return array_shift($rows[$result]);
			});

		$image = $this->createMock(\phpbbgallery\core\image\image::class);
		$image->expects($this->once())
			->method('delete_images')
			->with([11], [11 => 'first.jpg'], false);
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->expects($this->never())->method('update_images');
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->exactly(2))->method('set');
		$notification = $this->createMock(\phpbbgallery\core\notification::class);
		$notification->expects($this->never())->method('delete_albums');
		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->never())->method('destroy');
		$cache->expects($this->once())->method('destroy_albums');
		$dispatcher = $this->createMock(\phpbb\event\dispatcher::class);
		$dispatcher->expects($this->once())
			->method('trigger_event')
			->with(
				'phpbbgallery.core.album.manage.delete_album_content',
				$this->callback(static function (array $data): bool
				{
					return $data['album_id'] === 4 && $data['preserve_album_state'] === true;
				})
			)
			->willReturnArgument(1);

		$manager = (new \ReflectionClass(manage::class))->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function ($database, $image_service, $user_service, $config_service, $notification_service, $cache_service, $event_dispatcher): void
		{
			$this->db = $database;
			$this->gallery_image = $image_service;
			$this->gallery_user = $user_service;
			$this->gallery_config = $config_service;
			$this->gallery_notification = $notification_service;
			$this->gallery_cache = $cache_service;
			$this->dispatcher = $event_dispatcher;
			$this->images_table = 'gallery_images';
			$this->permissions_table = 'gallery_permissions';
			$this->moderators_table = 'gallery_moderators';
			$this->tracking_table = 'gallery_tracking';
		}, $manager, manage::class);
		$initialize($db, $image, $gallery_user, $config, $notification, $cache, $dispatcher);

		$this->assertSame([], $manager->delete_album_content(4, true));
		$this->assertStringNotContainsString('gallery_permissions', implode(PHP_EOL, $queries));
		$this->assertStringNotContainsString('gallery_moderators', implode(PHP_EOL, $queries));
		$this->assertStringNotContainsString('gallery_tracking', implode(PHP_EOL, $queries));
	}

	public function test_category_conversion_moves_images_but_preserves_album_state(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->once())
			->method('sql_query')
			->willReturnCallback(function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return 1;
			});
		$db->method('sql_build_array')->willReturn('image_album_id = 8');

		$report = $this->createMock(\phpbbgallery\core\report::class);
		$report->expects($this->once())->method('move_album_content')->with(4, 8);
		$notification = $this->createMock(\phpbbgallery\core\notification::class);
		$notification->expects($this->never())->method('delete_albums');
		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->never())->method('destroy');
		$cache->expects($this->once())->method('destroy_albums');
		$album = $this->createMock(\phpbbgallery\core\album\album::class);
		$album->expects($this->exactly(2))->method('update_info');
		$dispatcher = $this->createMock(\phpbb\event\dispatcher::class);
		$dispatcher->expects($this->exactly(2))
			->method('trigger_event')
			->willReturnCallback(function (string $name, array $data): array
			{
				if ($name === 'phpbbgallery.core.album.manage.move_album_content')
				{
					$this->assertTrue($data['preserve_album_state']);
				}

				return $data;
			});

		$manager = (new \ReflectionClass(manage::class))->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function ($database, $report_service, $notification_service, $cache_service, $album_service, $event_dispatcher): void
		{
			$this->db = $database;
			$this->gallery_report = $report_service;
			$this->gallery_notification = $notification_service;
			$this->gallery_cache = $cache_service;
			$this->gallery_album = $album_service;
			$this->dispatcher = $event_dispatcher;
			$this->images_table = 'gallery_images';
			$this->permissions_table = 'gallery_permissions';
			$this->moderators_table = 'gallery_moderators';
		}, $manager, manage::class);
		$initialize($db, $report, $notification, $cache, $album, $dispatcher);

		$this->assertSame([], $manager->move_album_content(4, 8, true, true));
		$this->assertCount(1, $queries);
		$this->assertStringNotContainsString('gallery_permissions', $queries[0]);
		$this->assertStringNotContainsString('gallery_moderators', $queries[0]);
	}

	public function test_album_to_category_conversion_requests_state_preservation(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/album/manage.php');

		$this->assertStringContainsString(
			'$this->move_album_content($album_data_sql[\'album_id\'], $to_album_id, true, true)',
			$source
		);
		$this->assertStringContainsString(
			'$this->delete_album_content($album_data_sql[\'album_id\'], true)',
			$source
		);
	}

	public function test_descendant_destination_is_rejected_before_tree_changes(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$gallery_album = $this->createMock(album::class);
		$gallery_album->expects($this->once())
			->method('get_info')
			->with(3)
			->willReturn(['album_id' => 3, 'right_id' => 6]);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('lang')
			->with('ALBUM_PARENT_INVALID')
			->willReturn('invalid');

		$manager = $this->manager($db, $gallery_album, $language);
		$move = \Closure::bind(function (): array
		{
			return $this->move_album_nodes(
				[
					['album_id' => 2],
					['album_id' => 3],
					['album_id' => 4],
				],
				3,
				2,
				7
			);
		}, $manager, manage::class);

		$this->assertSame(['invalid'], $move());
	}

	private function manager(
		\phpbb\db\driver\driver_interface $db,
		album $gallery_album,
		?\phpbb\language\language $language = null
	): manage
	{
		$reflection = new \ReflectionClass(manage::class);
		$manager = $reflection->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function ($database, $album_service, $language_service): void
		{
			$this->db = $database;
			$this->gallery_album = $album_service;
			if ($language_service)
			{
				$this->language = $language_service;
			}
			$this->albums_table = 'gallery_albums';
			$this->user_id = 0;
		}, $manager, manage::class);
		$initialize($db, $gallery_album, $language);

		return $manager;
	}
}
