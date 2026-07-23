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

	public function test_adding_album_watches_uses_valid_sql_and_unique_ids(): void
	{
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('album_id', [3, 4])
			->willReturn('album_id IN (3, 4)');
		$db->expects($this->exactly(3))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return count($queries) === 1 ? 'select_result' : 'insert_result';
			});
		$db->expects($this->once())->method('sql_fetchrow')->with('select_result')->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with('select_result');
		$db->expects($this->exactly(2))
			->method('sql_build_array')
			->willReturnCallback(static fn (string $operation, array $data): string => 'VALUES (' . $data['album_id'] . ', ' . $data['user_id'] . ')');

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
			'INSERT INTO gallery_watch VALUES (3, 5)',
			'INSERT INTO gallery_watch VALUES (4, 5)',
		], $queries);
	}
}
