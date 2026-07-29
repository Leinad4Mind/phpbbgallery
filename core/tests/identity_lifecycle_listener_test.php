<?php
/**
 * phpBB Gallery - Identity lifecycle listener tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\event\identity_lifecycle_listener;
use PHPUnit\Framework\TestCase;

final class identity_lifecycle_listener_test extends TestCase
{
	public function test_subscribes_to_phpbb_identity_lifecycle_events(): void
	{
		$this->assertSame([
			'core.update_username' => 'rename_user',
			'core.user_set_default_group' => 'recolour_users',
			'core.delete_user_after' => 'delete_users',
			'core.delete_group_after' => 'delete_group',
		], identity_lifecycle_listener::getSubscribedEvents());
	}

	public function test_services_are_registered_with_every_required_table(): void
	{
		$services = file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertIsString($services);
		$this->assertStringContainsString('phpbbgallery.core.identity_sync:', $services);
		$this->assertStringContainsString('class: phpbbgallery\core\identity_sync', $services);
		$this->assertStringContainsString("- '@phpbbgallery.core.identity_sync'", $services);
		foreach (['gallery_albums', 'gallery_images', 'gallery_comments', 'gallery_moderators', 'gallery_permissions'] as $table)
		{
			$this->assertStringContainsString('%phpbbgallery.tables.' . $table . '%', $services);
		}
	}

	public function test_username_event_is_forwarded(): void
	{
		$sync = $this->createMock(\phpbbgallery\core\identity_sync::class);
		$sync->expects($this->once())->method('rename_user')->with('Old name', 'New name');
		$listener = new identity_lifecycle_listener($sync);

		$listener->rename_user(new \phpbb\event\data([
			'old_name' => 'Old name',
			'new_name' => 'New name',
		]));
	}

	public function test_default_group_colour_is_forwarded_only_when_present(): void
	{
		$sync = $this->createMock(\phpbbgallery\core\identity_sync::class);
		$sync->expects($this->once())->method('recolour_users')->with([7, 9], 'AABBCC');
		$listener = new identity_lifecycle_listener($sync);

		$listener->recolour_users(new \phpbb\event\data(['user_id_ary' => [7, 9], 'sql_ary' => []]));
		$listener->recolour_users(new \phpbb\event\data([
			'user_id_ary' => [7, 9],
			'sql_ary' => ['user_colour' => 'AABBCC'],
		]));
	}

	public function test_deletion_events_are_forwarded(): void
	{
		$sync = $this->createMock(\phpbbgallery\core\identity_sync::class);
		$sync->expects($this->once())->method('delete_users')->with([7, 9]);
		$sync->expects($this->once())->method('delete_group')->with(5);
		$listener = new identity_lifecycle_listener($sync);

		$listener->delete_users(new \phpbb\event\data(['user_ids' => [7, 9]]));
		$listener->delete_group(new \phpbb\event\data(['group_id' => 5]));
	}

	public function test_listener_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(identity_lifecycle_listener::class);

		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), identity_lifecycle_listener::class . '::$' . $property->getName());
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== identity_lifecycle_listener::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), identity_lifecycle_listener::class . '::' . $method->getName());
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), identity_lifecycle_listener::class . '::' . $method->getName());
			}
		}
	}
}
