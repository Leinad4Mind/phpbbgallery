<?php
/**
 * phpBB Gallery - Notification domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\notification;
use phpbbgallery\core\notification\helper as notification_helper;
use PHPUnit\Framework\TestCase;

final class domain_notification_types_test extends TestCase
{
	public function test_notification_services_have_complete_native_contracts(): void
	{
		foreach ([notification::class, notification_helper::class] as $class_name)
		{
			$reflection = new \ReflectionClass($class_name);

			foreach ($reflection->getProperties() as $property)
			{
				if ($property->getDeclaringClass()->getName() === $class_name)
				{
					$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
				}
			}

			foreach ($reflection->getMethods() as $method)
			{
				if ($method->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}

				foreach ($method->getParameters() as $parameter)
				{
					$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName() . '($' . $parameter->getName() . ')');
				}

				if (!$method->isConstructor())
				{
					$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName() . '()');
				}
			}
		}
	}

	public function test_identifier_lists_are_normalized_and_deduplicated(): void
	{
		$this->assertSame([7], notification::cast_mixed_int2array(7));
		$this->assertSame([7, 8], notification::cast_mixed_int2array(['7', 8, '7']));
		$this->assertSame([7, 8], notification_helper::cast_mixed_int2array(['7', 8, '7']));
	}

	public function test_empty_identifier_lists_do_not_execute_watch_queries(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$user = new \phpbb\user();
		$user->data['user_id'] = 2;
		$watch = new notification($db, $user, 'gallery_watch');

		$watch->add([]);
		$watch->add_albums([]);
		$watch->remove([]);
		$watch->remove_albums([]);
		$watch->delete_images([]);
		$watch->delete_albums([]);
	}

	public function test_watcher_queries_return_integer_ids_and_free_results(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with('SELECT user_id FROM gallery_watch WHERE album_id = 11')
			->willReturn('result');
		$db->expects($this->exactly(3))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls(['user_id' => '4'], ['user_id' => 9], false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		$reflection = new \ReflectionClass(notification_helper::class);
		$helper = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($helper, $db);
		$reflection->getProperty('watch_table')->setValue($helper, 'gallery_watch');

		$this->assertSame([4, 9], $helper->get_album_watchers(11));
	}

	public function test_watched_album_ids_are_bounded_deduplicated_and_user_scoped(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('album_id', [3, 4])
			->willReturn('album_id IN (3, 4)');
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static function (string $sql): bool
			{
				return str_contains($sql, 'FROM gallery_watch')
					&& str_contains($sql, 'user_id = 5')
					&& str_contains($sql, 'album_id IN (3, 4)');
			}))
			->willReturn('result');
		$db->expects($this->exactly(4))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls(
				['album_id' => '3'],
				['album_id' => 3],
				['album_id' => 4],
				false
			);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$user = new \phpbb\user();
		$user->data['user_id'] = 5;

		$reflection = new \ReflectionClass(notification_helper::class);
		$helper = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($helper, $db);
		$reflection->getProperty('user')->setValue($helper, $user);
		$reflection->getProperty('watch_table')->setValue($helper, 'gallery_watch');

		$this->assertSame([3, 4], $helper->get_watched_album_ids(['3', 4, 3]));
	}

	public function test_empty_watched_album_candidate_set_avoids_database_queries(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$reflection = new \ReflectionClass(notification_helper::class);
		$helper = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($helper, $db);

		$this->assertSame([], $helper->get_watched_album_ids([]));
	}

	public function test_watched_album_reads_are_limited_to_batches_of_250(): void
	{
		$batches = [];
		$query_number = 0;
		$fetch_calls = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(3))
			->method('sql_in_set')
			->willReturnCallback(static function (string $field, array $ids) use (&$batches): string
			{
				TestCase::assertSame('album_id', $field);
				$batches[] = $ids;
				return 'album_id IN (' . implode(', ', $ids) . ')';
			});
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(static function () use (&$query_number): string
			{
				return 'result_' . ++$query_number;
			});
		$db->expects($this->exactly(6))
			->method('sql_fetchrow')
			->willReturnCallback(static function (string $result) use (&$fetch_calls): array|false
			{
				$fetch_calls[$result] = ($fetch_calls[$result] ?? 0) + 1;
				if ($fetch_calls[$result] > 1)
				{
					return false;
				}

				return ['album_id' => match ($result)
				{
					'result_1' => 1,
					'result_2' => 251,
					default => 501,
				}];
			});
		$db->expects($this->exactly(3))->method('sql_freeresult');
		$user = new \phpbb\user();
		$user->data['user_id'] = 5;
		$reflection = new \ReflectionClass(notification_helper::class);
		$helper = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($helper, $db);
		$reflection->getProperty('user')->setValue($helper, $user);
		$reflection->getProperty('watch_table')->setValue($helper, 'gallery_watch');

		$this->assertSame([1, 251, 501], $helper->get_watched_album_ids(range(1, 501)));
		$this->assertSame([250, 250, 1], array_map('count', $batches));
	}

	public function test_notification_watch_additions_use_multi_insert(): void
	{
		$this->assert_notification_watch_additions_are_batched('add', 'image_id');
		$this->assert_notification_watch_additions_are_batched('add_albums', 'album_id');
	}

	public function test_adding_album_watches_uses_valid_sql_and_unique_ids(): void
	{
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('album_id', [3, 4])
			->willReturn('album_id IN (3, 4)');
		$db->expects($this->once())
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return 'select_result';
			});
		$db->expects($this->once())->method('sql_fetchrow')->with('select_result')->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with('select_result');
		$db->expects($this->once())
			->method('sql_multi_insert')
			->with('gallery_watch', [
				['album_id' => 3, 'user_id' => 5],
				['album_id' => 4, 'user_id' => 5],
			]);

		$user = new \phpbb\user();
		$user->data['user_id'] = 5;
		$reflection = new \ReflectionClass(notification_helper::class);
		$helper = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($helper, $db);
		$reflection->getProperty('user')->setValue($helper, $user);
		$reflection->getProperty('watch_table')->setValue($helper, 'gallery_watch');

		$helper->add_albums([3, '4', 3]);

		$this->assertSame([
			'SELECT * FROM gallery_watch WHERE user_id = 5 and album_id IN (3, 4)',
		], $queries);
	}

	private function assert_notification_watch_additions_are_batched(string $method, string $id_column): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with($id_column, [3, 4])
			->willReturn($id_column . ' IN (3, 4)');
		$db->expects($this->once())->method('sql_query')->willReturn('select_result');
		$db->expects($this->once())->method('sql_fetchrow')->with('select_result')->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with('select_result');
		$db->expects($this->once())
			->method('sql_multi_insert')
			->with('gallery_watch', [
				[$id_column => 3, 'user_id' => 5],
				[$id_column => 4, 'user_id' => 5],
			]);

		$user = new \phpbb\user();
		$user->data['user_id'] = 5;
		$watch = new notification($db, $user, 'gallery_watch');
		$watch->{$method}([3, '4', 3]);
	}
}
