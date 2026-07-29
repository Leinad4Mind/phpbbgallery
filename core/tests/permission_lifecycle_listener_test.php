<?php
/**
 * phpBB Gallery - Permission lifecycle listener tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\event\permission_lifecycle_listener;
use PHPUnit\Framework\TestCase;

final class permission_lifecycle_listener_test extends TestCase
{
	public function test_subscribes_to_every_group_membership_transition(): void
	{
		$this->assertSame([
			'core.acp_manage_group_request_data' => 'invalidate_group_auth_setting',
			'core.group_add_user_after' => 'invalidate_group_members',
			'core.group_delete_user_after' => 'invalidate_group_members',
			'core.user_set_group_attributes' => 'invalidate_group_members',
		], permission_lifecycle_listener::getSubscribedEvents());
	}

	public function test_listener_is_registered_with_the_gallery_auth_service(): void
	{
		$services = file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertIsString($services);
		$this->assertStringContainsString('phpbbgallery.core.permission_lifecycle_listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\event\\permission_lifecycle_listener', $services);
		$this->assertStringContainsString('- \'@phpbbgallery.core.auth\'', $services);
	}

	/**
	 * @dataProvider group_event_provider
	 */
	public function test_group_events_invalidate_only_affected_users(string $event_name): void
	{
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())
			->method('invalidate_user_permissions')
			->with([7, 9]);
		$listener = new permission_lifecycle_listener($gallery_auth);
		$event = new \phpbb\event\data([
			'user_id_ary' => [7, 9],
			'action' => $event_name,
		]);

		$listener->invalidate_group_members($event);
	}

	public static function group_event_provider(): array
	{
		return [
			'add' => ['add'],
			'delete' => ['delete'],
			'approve' => ['approve'],
			'default' => ['default'],
		];
	}

	public function test_empty_group_event_is_a_safe_no_op(): void
	{
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())
			->method('invalidate_user_permissions')
			->with([]);

		(new permission_lifecycle_listener($gallery_auth))->invalidate_group_members(new \phpbb\event\data([]));
	}

	public function test_group_skip_auth_change_invalidates_every_approved_member(): void
	{
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())
			->method('invalidate_group_permissions')
			->with(5);
		$listener = new permission_lifecycle_listener($gallery_auth);

		$listener->invalidate_group_auth_setting(new \phpbb\event\data([
			'action' => 'edit',
			'group_id' => 5,
			'group_row' => ['group_skip_auth' => 0],
			'submit_ary' => ['skip_auth' => 1],
		]));
	}

	/**
	 * @dataProvider unchanged_group_provider
	 */
	public function test_unrelated_group_submission_does_not_invalidate_permissions(array $event_data): void
	{
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->never())->method('invalidate_group_permissions');

		(new permission_lifecycle_listener($gallery_auth))->invalidate_group_auth_setting(new \phpbb\event\data($event_data));
	}

	public static function unchanged_group_provider(): array
	{
		return [
			'new group' => [[
				'action' => 'add',
				'group_id' => 5,
				'group_row' => [],
				'submit_ary' => ['skip_auth' => 1],
			]],
			'unchanged setting' => [[
				'action' => 'edit',
				'group_id' => 5,
				'group_row' => ['group_skip_auth' => 1],
				'submit_ary' => ['skip_auth' => 1],
			]],
			'missing setting' => [[
				'action' => 'edit',
				'group_id' => 5,
				'group_row' => ['group_skip_auth' => 0],
				'submit_ary' => [],
			]],
		];
	}

	public function test_listener_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(permission_lifecycle_listener::class);

		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), permission_lifecycle_listener::class . '::$' . $property->getName());
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== permission_lifecycle_listener::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), permission_lifecycle_listener::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), permission_lifecycle_listener::class . '::' . $method->getName() . '()');
			}
		}
	}
}
