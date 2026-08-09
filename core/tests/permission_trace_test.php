<?php
/**
 * phpBB Gallery - Permission trace tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\auth\auth;
use phpbbgallery\core\auth\permission_trace;
use PHPUnit\Framework\TestCase;

final class permission_trace_test extends TestCase
{
	public function test_trace_matches_gallery_yes_no_never_precedence(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('has_permission')->with('i_view')->willReturn(true);
		$gallery_auth->expects($this->once())->method('get_usergroups')->with(42)->willReturn([2, 3, 4]);

		$queries = [];
		$db->method('sql_in_set')->willReturnCallback(static function (string $field, array $values): string
		{
			return $field . ' IN (' . implode(',', $values) . ')';
		});
		$db->expects($this->once())->method('sql_query_limit')->with($this->stringContains('user_id = 42'), 1)->willReturn('user_result');
		$db->expects($this->exactly(2))->method('sql_query')->willReturnCallback(static function (string $sql) use (&$queries): string
		{
			$queries[] = $sql;
			return str_contains($sql, 'FROM phpbb_groups') ? 'group_result' : 'assignment_result';
		});

		$rows = [
			'user_result' => [['user_id' => 42, 'username' => 'Alice']],
			'group_result' => [
				['group_id' => 2, 'group_name' => 'REGISTERED', 'group_type' => 3],
				['group_id' => 3, 'group_name' => 'Judges', 'group_type' => 0],
				['group_id' => 4, 'group_name' => 'Readers', 'group_type' => 0],
			],
			'assignment_result' => [
				['perm_user_id' => 0, 'perm_group_id' => 2, 'i_view' => auth::ACL_YES],
				['perm_user_id' => 0, 'perm_group_id' => 3, 'i_view' => auth::ACL_NEVER],
				['perm_user_id' => 0, 'perm_group_id' => 4, 'i_view' => auth::ACL_NO],
				['perm_user_id' => 42, 'perm_group_id' => 0, 'i_view' => auth::ACL_YES],
			],
		];
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use (&$rows): array|false
		{
			return $rows[$result] ? array_shift($rows[$result]) : false;
		});

		$trace = new permission_trace($db, $gallery_auth, 'gallery_permissions', 'gallery_roles');
		$result = $trace->trace(42, 'i_view', 7, auth::PUBLIC_ALBUM);

		$this->assertSame('Alice', $result['username']);
		$this->assertSame([auth::ACL_YES, auth::ACL_NEVER, auth::ACL_NEVER, auth::ACL_NEVER], array_column($result['rows'], 'total'));
		$this->assertSame([auth::ACL_YES, auth::ACL_NEVER, auth::ACL_NO, auth::ACL_YES], array_column($result['rows'], 'setting'));
		$this->assertSame([permission_trace::SOURCE_GROUP, permission_trace::SOURCE_GROUP, permission_trace::SOURCE_GROUP, permission_trace::SOURCE_USER], array_column($result['rows'], 'source'));
		$this->assertSame(auth::ACL_NEVER, $result['total']);
		$this->assertStringContainsString('pr.*', $queries[1]);
		$this->assertStringNotContainsString('pr.i_view', $queries[1]);
		$this->assertStringContainsString('p.perm_system = 0 AND p.perm_album_id = 7', $queries[1]);
	}

	public function test_direct_no_keeps_group_yes_in_a_personal_scope(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->method('has_permission')->willReturn(true);
		$gallery_auth->method('get_usergroups')->willReturn([8]);
		$db->method('sql_in_set')->willReturnCallback(static fn (string $field, array $values): string => $field . ' IN (' . implode(',', $values) . ')');
		$db->method('sql_query_limit')->willReturn('user_result');
		$queries = [];
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use (&$queries): string
		{
			$queries[] = $sql;
			return str_contains($sql, 'FROM phpbb_groups') ? 'group_result' : 'assignment_result';
		});
		$rows = [
			'user_result' => [['user_id' => 9, 'username' => 'Bob']],
			'group_result' => [['group_id' => 8, 'group_name' => 'Members', 'group_type' => 0]],
			'assignment_result' => [['perm_user_id' => 0, 'perm_group_id' => 8, 'c_read' => auth::ACL_YES]],
		];
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use (&$rows): array|false
		{
			return $rows[$result] ? array_shift($rows[$result]) : false;
		});

		$result = (new permission_trace($db, $gallery_auth, 'gallery_permissions', 'gallery_roles'))
			->trace(9, 'c_read', 0, auth::PERSONAL_ALBUM);

		$this->assertSame([auth::ACL_YES, auth::ACL_NO], array_column($result['rows'], 'setting'));
		$this->assertSame([auth::ACL_YES, auth::ACL_YES], array_column($result['rows'], 'total'));
		$this->assertSame(auth::ACL_YES, $result['total']);
		$this->assertStringContainsString('p.perm_system = -3', $queries[1]);
	}

	/** @dataProvider invalid_request_provider */
	public function test_trace_rejects_invalid_permissions_and_scopes(int $user_id, string $permission, int $album_id, int $permission_system): void
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->method('has_permission')->willReturn(true);
		$trace = new permission_trace(
			$this->createMock(\phpbb\db\driver\driver_interface::class),
			$gallery_auth,
			'gallery_permissions',
			'gallery_roles'
		);

		$this->expectException(\InvalidArgumentException::class);
		$trace->trace($user_id, $permission, $album_id, $permission_system);
	}

	public static function invalid_request_provider(): array
	{
		return [
			'unknown user' => [0, 'i_view', 7, auth::PUBLIC_ALBUM],
			'unsafe permission name' => [42, 'i_view FROM users', 7, auth::PUBLIC_ALBUM],
			'numeric limit' => [42, 'i_count', 7, auth::PUBLIC_ALBUM],
			'public scope without album' => [42, 'i_view', 0, auth::PUBLIC_ALBUM],
			'personal scope with album' => [42, 'i_view', 7, auth::PERSONAL_ALBUM],
		];
	}

	public function test_service_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(permission_trace::class);
		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), $property->getName());
		}
		foreach ($reflection->getMethods() as $method)
		{
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), $method->getName() . '($' . $parameter->getName() . ')');
			}
			if (!$method->isConstructor() && !$method->isDestructor())
			{
				$this->assertNotNull($method->getReturnType(), $method->getName());
			}
		}
	}

	public function test_service_is_registered_with_gallery_permission_tables(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.auth.permission_trace:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\auth\\permission_trace', $services);
		$this->assertStringContainsString("- '@phpbbgallery.core.auth'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_permissions%'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_roles%'", $services);
	}
}
