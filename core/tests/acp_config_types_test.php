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
		$this->assertArrayHasKey('title', $display['vars']);
		$this->assertArrayHasKey('items_per_page', $display['vars']);
		$this->assertArrayHasKey('watermark_enabled', $display['vars']);
		$this->assertSame('int:0:100', $display['vars']['jpg_quality']['validate']);
		$this->assertSame('number:0:100', $display['vars']['jpg_quality']['type']);
		$this->assertArrayHasKey('viewtopic_icon', $display['vars']);
		$this->assertArrayHasKey('viewtopic_images', $display['vars']);
		$this->assertArrayHasKey('viewtopic_link', $display['vars']);
		$this->assertArrayHasKey('forum_index_mode', $display['vars']);
		$this->assertArrayHasKey('forum_index_recent_count', $display['vars']);
		$this->assertArrayHasKey('forum_index_random_count', $display['vars']);
		$this->assertArrayHasKey('forum_index_display', $display['vars']);
		$this->assertArrayHasKey('forum_index_personal', $display['vars']);
		$this->assertArrayHasKey('allow_contests', $display['vars']);
		$config_keys = array_keys($display['vars']);
		$this->assertGreaterThan(
			array_search('disp_nextprev_thumbnail', $config_keys, true),
			array_search('ajax_navigation', $config_keys, true)
		);
		$this->assertLessThan(
			array_search('disp_image_url', $config_keys, true),
			array_search('ajax_navigation', $config_keys, true)
		);
		$display_vars = $display['vars'];
		$this->assertSame('', end($display_vars));
	}

	public function test_bbcode_templates_keep_the_selected_link_target_without_a_session_id(): void
	{
		global $phpbb_container;

		$had_container = isset($phpbb_container);
		$previous_container = $phpbb_container ?? null;
		$helper = new class
		{
			public function route(string $name, array $parameters): string
			{
				$base = '/gallery/image/' . $parameters['image_id'];
				if ($name === 'phpbbgallery_core_image_file_source')
				{
					return $base . '/source?sid=private-session';
				}
				if ($name === 'phpbbgallery_core_image_file_mini')
				{
					return $base . '/mini?sid=private-session';
				}

				return $base . '?sid=private-session';
			}
		};
		$gallery_url = $this->getMockBuilder(\phpbbgallery\core\url::class)
			->disableOriginalConstructor()
			->onlyMethods(['get_uri'])
			->getMock();
		$strip_session_id = (new \ReflectionClass(\phpbbgallery\core\url::class))->getMethod('strip_session_id');
		$gallery_url->method('get_uri')->willReturnCallback(
			static fn(string $route): string => 'https://example.test' . $strip_session_id->invoke($gallery_url, $route)
		);
		$phpbb_container = new class($helper, $gallery_url)
		{
			public function __construct(private object $helper, private object $gallery_url)
			{
			}

			public function get(string $service): object
			{
				return $service === 'controller.helper' ? $this->helper : $this->gallery_url;
			}
		};

		try
		{
			$module = new config_module();
			$image_page = $module->bbcode_tpl('image_page');
			$image = $module->bbcode_tpl('image');
			$none = $module->bbcode_tpl('none');
			$image_page_repeat = $module->bbcode_tpl('image_page');
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

		$this->assertStringContainsString('image/{NUMBER}"><img', $image_page);
		$this->assertStringContainsString('image/{NUMBER}/source"><img', $image);
		$this->assertStringNotContainsString('<a href=', $none);
		$this->assertSame($image_page, $image_page_repeat);
		$this->assertStringNotContainsString('sid=', $image_page . $image . $none);

		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');
		$this->assertSame(1, substr_count($source, '$phpbb_container->get(\'text_formatter.cache\')->invalidate();'));
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
