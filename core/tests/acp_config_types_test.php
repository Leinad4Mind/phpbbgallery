<?php
/**
 * phpBB Gallery - ACP configuration module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\config_module;
use PHPUnit\Framework\TestCase;

final class acp_config_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(config_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === config_module::class)
			{
				$this->assertNotNull($property->getType(), config_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== config_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), config_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), config_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_display_configuration_is_flattened_for_phpbb(): void
	{
		global $phpbb_dispatcher;

		$had_dispatcher = isset($phpbb_dispatcher);
		$previous_dispatcher = $phpbb_dispatcher ?? null;
		$phpbb_dispatcher = new class
		{
			public function trigger_event(string $event_name, array $data): array
			{
				return $data;
			}
		};

		try
		{
			$display = (new config_module())->get_display_vars('main');
		}
		finally
		{
			if ($had_dispatcher)
			{
				$phpbb_dispatcher = $previous_dispatcher;
			}
			else
			{
				unset($phpbb_dispatcher);
			}
		}

		$this->assertSame('GALLERY_CONFIG', $display['title']);
		$this->assertSame('', $display['vars']['legend1']);
		$this->assertSame('GALLERY_CONFIG', $display['vars']['legend2']);
		$this->assertArrayHasKey('items_per_page', $display['vars']);
		$this->assertArrayHasKey('watermark_enabled', $display['vars']);
		$display_vars = $display['vars'];
		$this->assertSame('', end($display_vars));
	}

	public function test_bbcode_templates_keep_the_selected_link_target(): void
	{
		global $phpbb_gallery_url;

		$had_url = isset($phpbb_gallery_url);
		$previous_url = $phpbb_gallery_url ?? null;
		$phpbb_gallery_url = new class
		{
			public function path(string $name): string
			{
				return 'https://example.test/gallery/';
			}
		};

		try
		{
			$module = new config_module();
			$image_page = $module->bbcode_tpl('image_page');
			$image = $module->bbcode_tpl('image');
			$none = $module->bbcode_tpl('none');
		}
		finally
		{
			if ($had_url)
			{
				$phpbb_gallery_url = $previous_url;
			}
			else
			{
				unset($phpbb_gallery_url);
			}
		}

		$this->assertStringContainsString('image/{NUMBER}"><img', $image_page);
		$this->assertStringContainsString('image/{NUMBER}/source"><img', $image);
		$this->assertStringNotContainsString('<a href=', $none);
	}

	public function test_request_and_directory_access_are_php8_safe(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');

		$this->assertStringNotContainsString('$' . '_POST', $source);
		$this->assertStringNotContainsString('$' . '_REQUEST', $source);
		$this->assertStringNotContainsString('@readdir(', $source);
		$this->assertStringNotContainsString('@closedir(', $source);
		$this->assertSame(6, substr_count($source, '!== false && ('));
	}
}
