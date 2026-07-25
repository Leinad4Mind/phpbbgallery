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

	public function test_cached_permissions_replace_stale_acl_state(): void
	{
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->user_id = 7;
		$gallery_user->expects($this->once())
			->method('get_data')
			->with('user_permissions')
			->willReturn('0:0:0::-3');
		$service = $this->new_auth();
		$this->set_property($service, 'user', $gallery_user);
		$this->set_property($service, '_auth_data', [99 => new set()]);
		$this->set_property($service, '_auth_data_never', [99 => new set()]);
		$this->set_property($service, 'acl_cache', [99 => [0 => true]]);

		$service->load_user_permissions(7);

		$this->assertSame([-3], array_keys($this->get_property($service, '_auth_data')));
		$this->assertSame([], $this->get_property($service, '_auth_data_never'));
		$this->assertSame([], $this->get_property($service, 'acl_cache'));
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

	private function new_auth(): auth
	{
		return (new \ReflectionClass(auth::class))->newInstanceWithoutConstructor();
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
