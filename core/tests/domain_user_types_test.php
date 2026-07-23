<?php
/**
 * phpBB Gallery - Core user domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\user;
use PHPUnit\Framework\TestCase;

final class domain_user_types_test extends TestCase
{
	public function test_user_domain_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(user::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === user::class)
			{
				$this->assertNotNull($property->getType(), user::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== user::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), user::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), user::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_switching_users_clears_request_local_state_without_loading(): void
	{
		$reflection = new \ReflectionClass(user::class);
		$gallery_user = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('data')->setValue($gallery_user, ['personal_album_id' => 33]);
		$gallery_user->user_id = 4;
		$gallery_user->entry_exists = true;

		$gallery_user->set_user_id(9, false);

		$this->assertSame(9, $gallery_user->user_id);
		$this->assertNull($gallery_user->entry_exists);
		$this->assertSame([], $reflection->getProperty('data')->getValue($gallery_user));
		$this->assertFalse($gallery_user->get_data('personal_album_id', false));
	}

	public function test_missing_user_row_cannot_reuse_previous_users_data(): void
	{
		$reflection = new \ReflectionClass(user::class);
		$gallery_user = $reflection->newInstanceWithoutConstructor();
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static fn (string $sql): bool => str_contains($sql, 'FROM gallery_users') && str_contains($sql, 'WHERE user_id = 12')), 30)
			->willReturn('result');
		$db->expects($this->once())->method('sql_fetchrow')->with('result')->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		$reflection->getProperty('db')->setValue($gallery_user, $db);
		$reflection->getProperty('gallery_users_table')->setValue($gallery_user, 'gallery_users');
		$gallery_user->set_user_id(12, false);
		$reflection->getProperty('data')->setValue($gallery_user, ['watch_own' => true]);

		$gallery_user->load_data();

		$this->assertFalse($gallery_user->entry_exists);
		$this->assertSame([], $reflection->getProperty('data')->getValue($gallery_user));
		$this->assertFalse($gallery_user->get_data('watch_own', false));
	}

	public function test_empty_and_global_user_filters_are_explicitly_safe(): void
	{
		$gallery_user = (new \ReflectionClass(user::class))->newInstanceWithoutConstructor();

		$this->assertSame('WHERE 1 = 0', $gallery_user->sql_build_where([]));
		$this->assertSame('', $gallery_user->sql_build_where('all'));
		$this->assertSame('WHERE user_id = 17', $gallery_user->sql_build_where(17));
		$this->assertSame('WHERE user_id = 0', $gallery_user->sql_build_where('invalid'));
	}

	public function test_known_user_data_is_normalized_without_event_dispatch(): void
	{
		$gallery_user = (new \ReflectionClass(user::class))->newInstanceWithoutConstructor();

		$this->assertSame([
			'user_id' => 0,
			'user_images' => 7,
			'watch_own' => false,
			'user_permissions' => 'serialized',
		], $gallery_user->validate_data([
			'user_id' => -8,
			'user_images' => '7',
			'watch_own' => 0,
			'user_permissions' => 'serialized',
		]));
		$this->assertSame(['user_images' => -3], $gallery_user->validate_data(['user_images' => -3], true));
	}

	public function test_personal_album_lookup_frees_the_database_result(): void
	{
		$reflection = new \ReflectionClass(user::class);
		$gallery_user = $reflection->newInstanceWithoutConstructor();
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with('SELECT personal_album_id FROM gallery_users WHERE user_id = 5')
			->willReturn('result');
		$db->expects($this->once())
			->method('sql_fetchrow')
			->with('result')
			->willReturn(['personal_album_id' => '41']);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		$reflection->getProperty('db')->setValue($gallery_user, $db);
		$reflection->getProperty('gallery_users_table')->setValue($gallery_user, 'gallery_users');
		$gallery_user->user_id = 5;

		$this->assertSame(41, $gallery_user->get_own_root_album());
	}

	public function test_destroy_restores_safe_empty_state(): void
	{
		$reflection = new \ReflectionClass(user::class);
		$gallery_user = $reflection->newInstanceWithoutConstructor();
		$gallery_user->user_id = 5;
		$gallery_user->entry_exists = true;
		$reflection->getProperty('data')->setValue($gallery_user, ['watch_own' => true]);

		$gallery_user->destroy();

		$this->assertNull($gallery_user->user_id);
		$this->assertNull($gallery_user->entry_exists);
		$this->assertSame([], $reflection->getProperty('data')->getValue($gallery_user));
	}
}
