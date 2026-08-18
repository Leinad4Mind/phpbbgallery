<?php
/**
 * phpBB Gallery - ACP permissions module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\permissions_module;
use phpbb\request\request_interface;
use PHPUnit\Framework\TestCase;

final class acp_permissions_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(permissions_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === permissions_module::class)
			{
				$this->assertNotNull($property->getType(), permissions_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== permissions_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), permissions_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), permissions_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_inheritance_helpers_have_explicit_validation_results(): void
	{
		foreach (['inherit_albums', 'inherit_victims', 'p_system_inherit_victims'] as $method_name)
		{
			$type = (string) (new \ReflectionMethod(permissions_module::class, $method_name))->getReturnType();
			$this->assertContains($type, ['string|bool', 'bool|string'], $method_name);
		}
	}

	public function test_permission_copy_reads_the_dedicated_inherit_field(): void
	{
		$expected = [31 => ['full' => 4, 2 => '4_7']];
		$request = $this->createMock(request_interface::class);
		$request->expects($this->once())
			->method('variable')
			->with('inherit', [0 => ['' => 0]])
			->willReturn($expected);

		$method = new \ReflectionMethod(permissions_module::class, 'requested_inheritance');
		$this->assertSame($expected, $method->invoke(new permissions_module(), $request));
	}

	public function test_system_victim_validation_initializes_the_converted_list(): void
	{
		global $phpbb_container;

		$had_container = isset($phpbb_container);
		$previous_container = $phpbb_container ?? null;
		$phpbb_container = new class
		{
			public function get(string $service): object
			{
				return new class
				{
					public const OWN_ALBUM = 1;
					public const PERSONAL_ALBUM = 2;
				};
			}
		};

		try
		{
			$module = new permissions_module();
			$language = $this->createMock(\phpbb\language\language::class);
			$language->method('lang')
				->willReturnCallback(static fn (string $key): string => $key);
			$module->language = $language;
			$method = new \ReflectionMethod(permissions_module::class, 'p_system_inherit_victims');

			$this->assertTrue($method->invoke($module, 1, [5], 0, 5));
		}
		finally
		{
			if ($had_container)
			{
				$phpbb_container = $previous_container;
			}
			else
			{
				unset($phpbb_container);
			}
		}
	}

	public function test_album_copy_sources_are_not_limited_by_display_order(): void
	{
		$this->with_permission_services(function (permissions_module $module): void
		{
			$albums = [
				['album_id' => 1, 'album_name' => 'First'],
				['album_id' => 2, 'album_name' => 'Current'],
				['album_id' => 3, 'album_name' => 'Later'],
			];
			$method = new \ReflectionMethod(permissions_module::class, 'inherit_albums');
			$options = $method->invoke($module, $albums, [1, 2, 3], 2);

			$this->assertStringContainsString('<option value="1">First</option>', $options);
			$this->assertStringContainsString('<option value="2" disabled="disabled" class="disabled-option">Current</option>', $options);
			$this->assertStringContainsString('<option value="3">Later</option>', $options);
			$this->assertTrue($method->invoke($module, $albums, [1, 2, 3], 2, 3));
			$this->assertFalse($method->invoke($module, $albums, [1, 2, 3], 2, 2));
		});
	}

	public function test_setting_copy_sources_disable_only_the_exact_target(): void
	{
		$this->with_permission_services(function (permissions_module $module): void
		{
			$albums = [
				['album_id' => 1, 'album_name' => 'First'],
				['album_id' => 2, 'album_name' => 'Current'],
				['album_id' => 3, 'album_name' => 'Later'],
			];
			$victims = [
				['victim_id' => 10, 'victim_name' => 'One'],
				['victim_id' => 20, 'victim_name' => 'Two'],
			];
			$method = new \ReflectionMethod(permissions_module::class, 'inherit_victims');
			$options = $method->invoke($module, $albums, [1, 2, 3], $victims, 2, 10);

			$this->assertStringContainsString('<option value="2_10" disabled="disabled" class="disabled-option">', $options);
			$this->assertStringContainsString('<option value="2_20">', $options);
			$this->assertStringContainsString('<option value="3_10">', $options);
			$this->assertTrue($method->invoke($module, $albums, [1, 2, 3], [10, 20], 2, 10, 3, 10));
			$this->assertFalse($method->invoke($module, $albums, [1, 2, 3], [10, 20], 2, 10, 2, 10));
		});
	}

	public function test_personal_permission_copy_sources_are_not_limited_by_order(): void
	{
		$this->with_permission_services(function (permissions_module $module): void
		{
			$victims = [
				['victim_id' => 5, 'victim_name' => 'First'],
				['victim_id' => 6, 'victim_name' => 'Current'],
				['victim_id' => 7, 'victim_name' => 'Later'],
			];
			$method = new \ReflectionMethod(permissions_module::class, 'p_system_inherit_victims');
			$options = $method->invoke($module, 1, $victims, 6);

			$this->assertStringContainsString('<option value="1_5">', $options);
			$this->assertStringContainsString('<option value="1_6" disabled="disabled" class="disabled-option">', $options);
			$this->assertStringContainsString('<option value="1_7">', $options);
			$this->assertTrue($method->invoke($module, 1, [5, 6, 7], 6, 7));
			$this->assertFalse($method->invoke($module, 1, [5, 6, 7], 6, 6));
		});
	}

	public function test_permission_mask_copy_uses_an_immutable_snapshot_for_cycles(): void
	{
		$module = new permissions_module();
		$method = new \ReflectionMethod(permissions_module::class, 'copy_permission_mask');
		$auth_settings = [1 => [10 => 0], 2 => [10 => 1]];
		$original_auth_settings = $auth_settings;
		$p_mask_storage = [
			0 => ['p_mask' => ['i_view' => 1], 'is_moderator' => false, 'usage' => [['c_mask' => 1, 'v_mask' => 10]]],
			1 => ['p_mask' => ['i_view' => 0], 'is_moderator' => false, 'usage' => [['c_mask' => 2, 'v_mask' => 10]]],
		];

		$first = [&$auth_settings, &$p_mask_storage, $original_auth_settings, 1, 10, 2, 10];
		$second = [&$auth_settings, &$p_mask_storage, $original_auth_settings, 2, 10, 1, 10];
		$this->assertTrue($method->invokeArgs($module, $first));
		$this->assertTrue($method->invokeArgs($module, $second));

		$this->assertSame([1 => [10 => 1], 2 => [10 => 0]], $auth_settings);
		$this->assertSame([['c_mask' => 2, 'v_mask' => 10]], $p_mask_storage[0]['usage']);
		$this->assertSame([['c_mask' => 1, 'v_mask' => 10]], $p_mask_storage[1]['usage']);
	}

	public function test_submit_detection_uses_the_phpbb_request_abstraction(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/permissions_module.php');

		$this->assertStringNotContainsString('$' . '_POST', $source);
		$this->assertStringContainsString('$converted_victims = [];', $source);
		$this->assertSame(8, substr_count($source, 'is_set_post('));
	}

	public function test_system_groups_use_the_native_acp_separator_style_and_order(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/permissions_module.php');

		$this->assertSame(2, substr_count($source, "? ' class=\"sep\"' : ''"));
		$this->assertStringContainsString("'ORDER_BY'\t\t=> 'g.group_type DESC, g.group_name ASC'", $source);
		$this->assertStringContainsString('ORDER BY group_type DESC, group_name ASC', $source);
	}

	public function test_user_permission_masks_expose_native_trace_links_only_for_boolean_permissions(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/permissions_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_permissions.html');

		$this->assertStringContainsString("case 'trace':", $source);
		$this->assertSame(3, substr_count($source, "'U_TRACE'"));
		$this->assertStringContainsString('$' . "victim_mode === 'user'", $source);
		$this->assertStringContainsString('!str_ends_with($' . "permission, '_count')", $source);
		$this->assertStringContainsString("mask.U_TRACE|default('')", $template);
		$this->assertStringContainsString("popup(this.href, 750, 515, '_trace')", $template);
	}

	public function test_permission_copy_controls_explain_their_distinct_scopes(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/permissions_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_permissions.html');

		$this->assertStringContainsString("'S_GALLERY_ACP_OPERATION_HELP' => true", $source);
		$this->assertStringContainsString('data-gallery-operation-help-open="gallery_permissions_album_copy_help"', $template);
		$this->assertStringContainsString('data-gallery-operation-help-open="gallery_permissions_setting_copy_help"', $template);
		$this->assertStringContainsString("lang('COPY_PERMISSIONS_ALBUM_HELP')", $template);
		$this->assertStringContainsString("lang('COPY_PERMISSIONS_SETTING_HELP')", $template);
	}

	public function test_standalone_permission_masks_are_read_only_and_reuse_trace_links(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/permissions_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_permission_masks.html');

		$this->assertStringContainsString('case \'masks\':', $source);
		$this->assertStringContainsString('permission_trace', $source);
		$this->assertStringContainsString("variable('album_id', [0])", $source);
		$this->assertStringContainsString('->masks(', $source);
		$this->assertStringContainsString('S_PERMISSION_MASK_RESULT', $template);
		$this->assertStringContainsString('name="album_id[]"', $template);
		$this->assertStringContainsString('multiple', $template);
		$this->assertStringContainsString('permission_mask', $template);
		$this->assertStringContainsString('permission.U_TRACE', $template);
		$this->assertStringContainsString('permission.S_DENIED', $template);
		$this->assertStringContainsString("lang('PERMISSION_YES')", $template);
		$this->assertStringContainsString("lang('PERMISSION_NEVER')", $template);
		$this->assertStringNotContainsString("lang('PERMISSION_NO')", $template);
		$this->assertStringNotContainsString('name="setting[', $template);
		$this->assertStringNotContainsString("name='setting[", $template);
	}

	private function with_permission_services(callable $callback): void
	{
		global $phpbb_container;

		$had_container = isset($phpbb_container);
		$previous_container = $phpbb_container ?? null;
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn (string $key): string => $key);
		$auth = new class
		{
			public const OWN_ALBUM = 1;
			public const PERSONAL_ALBUM = 2;
		};
		$phpbb_container = new class($language, $auth)
		{
			public function __construct(private object $language, private object $auth)
			{
			}

			public function get(string $service): object
			{
				return $service === 'language' ? $this->language : $this->auth;
			}
		};

		try
		{
			$module = new permissions_module();
			$module->language = $language;
			$callback($module);
		}
		finally
		{
			if ($had_container)
			{
				$phpbb_container = $previous_container;
			}
			else
			{
				unset($phpbb_container);
			}
		}
	}
}
