<?php
/**
 * phpBB Gallery - UCP settings module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\ucp\settings_module;
use PHPUnit\Framework\TestCase;

final class ucp_settings_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(settings_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === settings_module::class)
			{
				$this->assertNotNull($property->getType(), settings_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== settings_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), settings_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), settings_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_non_submit_view_dispatches_event_and_assigns_current_settings(): void
	{
		$module = new settings_module();
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->expects($this->once())
			->method('is_set_post')
			->with('submit')
			->willReturn(false);
		$dispatcher = new class
		{
			public array $events = [];

			public function dispatch(string $event_name): void
			{
				$this->events[] = $event_name;
			}
		};
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$settings = [
			'watch_own' => true,
			'watch_com' => false,
			'user_allow_comments' => true,
			'rrc_zebra' => false,
		];
		$gallery_user->expects($this->exactly(4))
			->method('get_data')
			->willReturnCallback(static fn (string $key): mixed => $settings[$key]);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')
			->willReturnCallback(static fn (string $key): string => $key);
		$template = $this->createMock(\phpbb\template\template::class);
		$assigned = [];
		$template->expects($this->once())
			->method('assign_vars')
			->willReturnCallback(static function (array $variables) use (&$assigned): void
			{
				$assigned = $variables;
			});

		$this->set_property($module, 'config', new \phpbb\config\config([
			'phpbb_gallery_allow_comments' => true,
			'phpbb_gallery_comment_user_control' => true,
		]));
		$this->set_property($module, 'request', $request);
		$this->set_property($module, 'dispatcher', $dispatcher);
		$this->set_property($module, 'gallery_user', $gallery_user);
		$this->set_property($module, 'language', $language);
		$this->set_property($module, 'template', $template);

		$method = new \ReflectionMethod(settings_module::class, 'set_personal_settings');
		$method->invoke($module);

		$this->assertSame(['phpbbgallery.core.ucp.set_settings_nosubmit'], $dispatcher->events);
		$this->assertTrue($assigned['S_PERSONAL_SETTINGS']);
		$this->assertTrue($assigned['S_WATCH_OWN']);
		$this->assertFalse($assigned['S_WATCH_COM']);
		$this->assertTrue($assigned['S_ALLOW_COMMENTS']);
		$this->assertFalse($assigned['S_RRC_ZEBRA']);
		$this->assertTrue($assigned['S_COMMENTS_ENABLED']);
		$this->assertSame('UCP_GALLERY_SETTINGS', $assigned['L_TITLE']);
		$this->assertSame('WATCH_NOTE', $assigned['L_TITLE_EXPLAIN']);
	}

	private function set_property(settings_module $module, string $name, object $value): void
	{
		(new \ReflectionProperty(settings_module::class, $name))->setValue($module, $value);
	}
}
