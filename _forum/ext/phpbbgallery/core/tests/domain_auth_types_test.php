<?php
/**
 * phpBB Gallery - Authorization domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\auth\auth;
use phpbbgallery\core\auth\set;
use PHPUnit\Framework\TestCase;

final class domain_auth_types_test extends TestCase
{
	public function test_auth_contract_is_fully_typed_and_constants_are_public(): void
	{
		$reflection = new \ReflectionClass(auth::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === auth::class)
			{
				$this->assertNotNull($property->getType(), auth::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== auth::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), auth::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), auth::class . '::' . $method->getName() . '()');
			}
		}

		foreach ($reflection->getReflectionConstants() as $constant)
		{
			$this->assertTrue($constant->isPublic(), auth::class . '::' . $constant->getName());
		}
	}

	public function test_favorite_permission_only_exists_while_its_addon_is_enabled(): void
	{
		$this->assertFalse($this->constructed_auth(false)->has_permission('i_favorite'));
		$this->assertTrue($this->constructed_auth(true)->has_permission('i_favorite'));
	}

	public function test_cached_permissions_replace_stale_acl_state(): void
	{
		$phpbb_user = new \phpbb\user();
		$phpbb_user->data = [
			'user_id' => 7,
			'user_perm_from' => 0,
		];
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->user_id = 7;
		$gallery_user->expects($this->once())
			->method('get_data')
			->with('user_permissions')
			->willReturn('0:0:0::-3');
		$service = $this->new_auth();
		$this->set_property($service, 'phpbb_user', $phpbb_user);
		$this->set_property($service, 'user', $gallery_user);
		$this->set_property($service, '_auth_data', [99 => new set()]);
		$this->set_property($service, '_auth_data_never', [99 => new set()]);
		$this->set_property($service, 'acl_cache', [99 => [0 => true]]);

		$service->load_user_permissions(7);

		$this->assertSame([-3], array_keys($this->get_property($service, '_auth_data')));
		$this->assertSame([], $this->get_property($service, '_auth_data_never'));
		$this->assertSame([], $this->get_property($service, 'acl_cache'));
	}

	public function test_phpbb_permission_switch_loads_the_impersonated_gallery_user(): void
	{
		$phpbb_user = new \phpbb\user();
		$phpbb_user->data = [
			'user_id' => 2,
			'user_perm_from' => 42,
		];
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->user_id = 2;
		$gallery_user->expects($this->once())
			->method('set_user_id')
			->with(42);
		$gallery_user->expects($this->once())
			->method('get_data')
			->with('user_permissions')
			->willReturn('0:0:0::-3');
		$service = $this->new_auth();
		$this->set_property($service, 'phpbb_user', $phpbb_user);
		$this->set_property($service, 'user', $gallery_user);

		$service->load_user_permissions(2);

		$this->assertSame([-3], array_keys($this->get_property($service, '_auth_data')));
	}

	public function test_permission_switch_does_not_override_explicit_user_lookups(): void
	{
		$phpbb_user = new \phpbb\user();
		$phpbb_user->data = [
			'user_id' => 2,
			'user_perm_from' => 42,
		];
		$service = $this->new_auth();
		$this->set_property($service, 'phpbb_user', $phpbb_user);

		$this->assertSame(77, $this->invoke_method($service, 'get_effective_user_id', [77]));
	}

	public function test_cached_acl_round_trip_ignores_malformed_rows(): void
	{
		$permission_set = new set();
		$permission_set->set_bit(2, true);
		$permission_set->set_count('i_count', 4);
		$permission_set->set_count('a_count', 6);
		$service = $this->new_auth();
		$serialized = $this->invoke_method($service, 'serialize_auth_data', [[-3 => $permission_set, 7 => $permission_set]]);

		$restored = $this->new_auth();
		$this->invoke_method($restored, 'unserialize_auth_data', [$serialized . PHP_EOL . 'broken' . PHP_EOL . '1:2::invalid']);
		$auth_data = $this->get_property($restored, '_auth_data');

		$this->assertSame([-3, 7], array_keys($auth_data));
		$this->assertTrue($auth_data[-3]->get_bit(2));
		$this->assertSame(4, $auth_data[7]->get_count('i_count'));
		$this->assertSame(6, $auth_data[7]->get_count('a_count'));
	}

	public function test_zebra_moderator_check_uses_album_then_author(): void
	{
		$user = new \phpbb\user();
		$user->data = ['user_id' => 99];
		$service = $this->getMockBuilder(auth::class)
			->disableOriginalConstructor()
			->onlyMethods(['acl_check'])
			->getMock();
		$service->expects($this->once())
			->method('acl_check')
			->with('m_', 77, 42)
			->willReturn(true);
		$this->set_property($service, 'phpbb_user', $user);

		$this->assertSame(5, $service->get_zebra_state(['foe' => [], 'friend' => [], 'bff' => []], 42, 77));
	}

	public function test_anonymous_personal_album_restriction_uses_cached_albums(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$cache = $this->createMock(\phpbbgallery\core\cache::class);
		$cache->expects($this->once())
			->method('get_albums')
			->willReturn([
				77 => [
					'album_id' => 77,
					'album_user_id' => 42,
					'album_auth_access' => auth::ACCESS_REGISTERED,
				],
			]);
		$service = $this->new_auth();
		$this->set_property($service, 'cache', $cache);
		$this->set_property($service, '_auth_data', [auth::PERSONAL_ALBUM => new set()]);

		$this->invoke_method($service, 'restrict_pegas', [ANONYMOUS]);

		$auth_data = $this->get_property($service, '_auth_data');
		$this->assertArrayHasKey(77, $auth_data);
		$this->assertSame(0, $auth_data[77]->get_bits());
	}

	public function test_unknown_acl_and_missing_album_fail_closed(): void
	{
		$service = $this->new_auth();
		$this->assertFalse($service->acl_check('not_a_permission', 77));

		$permissions = new \ReflectionProperty(auth::class, '_permissions');
		$original_permissions = $permissions->getValue();
		$permissions->setValue(null, ['m_status']);
		try
		{
			$database = $this->createMock(\phpbb\db\driver\driver_interface::class);
			$database->expects($this->once())
				->method('sql_query')
				->with('SELECT * FROM gallery_albums WHERE album_id = 77')
				->willReturn(false);
			$database->expects($this->once())
				->method('sql_fetchrow')
				->with(false)
				->willReturn(false);
			$database->expects($this->once())
				->method('sql_freeresult')
				->with(false);
			$this->set_property($service, 'db', $database);
			$this->set_property($service, 'table_albums', 'gallery_albums');

			$this->assertSame([], $service->acl_users_ids('m_status', 77));
		}
		finally
		{
			$permissions->setValue(null, $original_permissions);
		}
	}

	public function test_acl_users_resolves_all_role_groups_in_one_query(): void
	{
		if (!defined('USER_GROUP_TABLE'))
		{
			define('USER_GROUP_TABLE', 'phpbb_user_group');
		}

		$queries = [];
		$rows = [
			'album_result' => [['album_user_id' => 0]],
			'permission_result' => [
				['perm_role_id' => 1, 'perm_user_id' => 11, 'perm_group_id' => 2],
				['perm_role_id' => 2, 'perm_user_id' => 0, 'perm_group_id' => 3],
			],
			'role_result' => [['role_id' => 1], ['role_id' => 2]],
			'group_result' => [
				['user_id' => 21, 'user_pending' => 0],
				['user_id' => 31, 'user_pending' => 0],
				['user_id' => 32, 'user_pending' => 1],
			],
		];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static fn (string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->exactly(4))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return ['album_result', 'permission_result', 'role_result', 'group_result'][count($queries) - 1];
			});
		$db->expects($this->exactly(11))
			->method('sql_fetchrow')
			->willReturnCallback(static function (string $result) use (&$rows): array|false
			{
				return array_shift($rows[$result]) ?: false;
			});
		$db->expects($this->exactly(4))->method('sql_freeresult');

		$permissions = new \ReflectionProperty(auth::class, '_permissions');
		$original_permissions = $permissions->getValue();
		$permissions->setValue(null, ['m_status']);
		try
		{
			$service = $this->new_auth();
			$this->set_property($service, 'db', $db);
			$this->set_property($service, 'table_albums', 'gallery_albums');
			$this->set_property($service, 'table_permissions', 'gallery_permissions');
			$this->set_property($service, 'table_roles', 'gallery_roles');

			$this->assertSame([11, 21, 31], $service->acl_users_ids('m_status', 77));
			$this->assertCount(1, array_filter($queries, static fn (string $sql): bool => str_contains($sql, USER_GROUP_TABLE)));
		}
		finally
		{
			$permissions->setValue(null, $original_permissions);
		}
	}

	private function new_auth(): auth
	{
		return (new \ReflectionClass(auth::class))->newInstanceWithoutConstructor();
	}

	private function constructed_auth(bool $favorite_enabled): auth
	{
		$extension_manager = $this->createMock(\phpbb\extension\manager::class);
		$extension_manager->expects($this->once())
			->method('is_enabled')
			->with('phpbbgallery/favorite')
			->willReturn($favorite_enabled);

		return new auth(
			$this->createStub(\phpbbgallery\core\cache::class),
			$this->createStub(\phpbb\db\driver\driver_interface::class),
			$this->createStub(\phpbbgallery\core\user::class),
			new \phpbb\user(),
			$this->createStub(\phpbb\auth\auth::class),
			'gallery_permissions',
			'gallery_roles',
			'gallery_users',
			'gallery_albums',
			$extension_manager
		);
	}

	private function set_property(auth $service, string $name, mixed $value): void
	{
		(new \ReflectionProperty(auth::class, $name))->setValue($service, $value);
	}

	private function get_property(auth $service, string $name): mixed
	{
		return (new \ReflectionProperty(auth::class, $name))->getValue($service);
	}

	private function invoke_method(auth $service, string $name, array $arguments): mixed
	{
		return (new \ReflectionMethod(auth::class, $name))->invokeArgs($service, $arguments);
	}
}
