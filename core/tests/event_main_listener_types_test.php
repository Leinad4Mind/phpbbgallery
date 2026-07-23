<?php
/**
 * phpBB Gallery - Main event listener tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\event\main_listener;
use PHPUnit\Framework\TestCase;

final class event_main_listener_types_test extends TestCase
{
	public function test_main_listener_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(main_listener::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === main_listener::class)
			{
				$this->assertNotNull($property->getType(), main_listener::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== main_listener::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), main_listener::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), main_listener::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_subscribed_event_map_remains_stable(): void
	{
		$this->assertSame([
			'core.user_setup' => 'load_language_on_setup',
			'core.page_header' => 'add_page_header_link',
			'core.memberlist_view_profile' => 'user_profile_galleries',
			'core.grab_profile_fields_data' => 'get_user_ids',
		], main_listener::getSubscribedEvents());
	}

	public function test_profile_event_state_is_reset_for_multi_user_events(): void
	{
		$reflection = new \ReflectionClass(main_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('user_ids')->setValue($listener, [7]);
		$reflection->getProperty('albums')->setValue($listener, [7 => 17]);
		$event = new \phpbb\event\data(['user_ids' => [7, 8]]);

		$listener->get_user_ids($event);

		$this->assertSame([], $reflection->getProperty('user_ids')->getValue($listener));
		$this->assertSame([], $reflection->getProperty('albums')->getValue($listener));
	}
}
