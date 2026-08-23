<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package phpbbgallery/core
 * @license GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

class pagination_test extends TestCase
{
	public function test_route_pagination_exposes_page_number_jump_after_six_pages(): void
	{
		[$pagination, $template] = $this->pagination();
		$pagination->generate_template_pagination([
			'routes' => ['gallery_first', 'gallery_page'],
			'params' => ['album_id' => 42],
		], 'public_pagination', 'public_page', 70, 10, 1);

		$this->assertSame('page', $template->vars['PUBLIC_PAGINATION_GALLERY_JUMP_MODE']);
		$this->assertSame(10, $template->vars['PUBLIC_PAGINATION_GALLERY_JUMP_PER_PAGE']);
		$this->assertStringContainsString('/gallery_page?', $template->vars['PUBLIC_PAGINATION_GALLERY_JUMP_URL']);
		$this->assertStringContainsString('public_page=PHPBBGALLERYPAGE', $template->vars['PUBLIC_PAGINATION_GALLERY_JUMP_URL']);
		$this->assertStringContainsString('album_id=42', $template->vars['PUBLIC_PAGINATION_GALLERY_JUMP_URL']);
	}

	public function test_offset_pagination_exposes_offset_jump(): void
	{
		[$pagination, $template] = $this->pagination();
		$pagination->generate_template_pagination('/gallery/search?q=test', 'pagination', 'start', 70, 10, 0);

		$this->assertSame('offset', $template->vars['GALLERY_JUMP_MODE']);
		$this->assertStringContainsString('start=PHPBBGALLERYPAGE', $template->vars['GALLERY_JUMP_URL']);
	}

	public function test_jump_is_not_offered_for_six_pages(): void
	{
		[$pagination, $template] = $this->pagination();
		$pagination->generate_template_pagination('/gallery/search', 'pagination', 'start', 60, 10, 0);

		$this->assertSame('', $template->vars['GALLERY_JUMP_URL']);
	}

	public function test_frontend_services_use_the_gallery_pagination_adapter(): void
	{
		$core_services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$controller_services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$contest_services = (string) file_get_contents(dirname(__DIR__, 2) . '/contest/config/services.yml');
		$favorite_module = (string) file_get_contents(dirname(__DIR__, 2) . '/favorite/ucp/main_module.php');

		$this->assertStringContainsString('phpbbgallery.core.pagination:', $core_services);
		$this->assertStringContainsString("'@phpbbgallery.core.pagination'", $core_services);
		$this->assertStringContainsString("'@phpbbgallery.core.pagination'", $controller_services);
		$this->assertStringContainsString("'@phpbbgallery.core.pagination'", $contest_services);
		$this->assertStringContainsString("get('phpbbgallery.core.pagination')", $favorite_module);
		$this->assertStringNotContainsString("'@pagination'", $core_services);
		$this->assertStringNotContainsString("'@pagination'", $controller_services);
	}

	private function pagination(): array
	{
		$template = new class {
			public array $vars = [];
			public array $blocks = [];

			public function assign_block_vars($name, array $values): void
			{
				$this->blocks[$name][] = $values;
			}

			public function alter_block_array($name, array $values, $key = false, $mode = 'insert'): void
			{
				$this->vars = array_merge($this->vars, $values);
			}

			public function assign_vars(array $values): void
			{
				$this->vars = array_merge($this->vars, $values);
			}
		};
		$user = new class {
			public function lang($key, ...$arguments): string
			{
				return $key . ' ' . implode(' ', $arguments);
			}
		};
		$helper = new class {
			public function route($route, array $params = [], $is_amp = true, $session_id = false): string
			{
				return '/' . $route . '?' . http_build_query($params);
			}
		};
		$dispatcher = new class {
			public function trigger_event($event_name, $data = [])
			{
				return $data;
			}
		};

		$reflection = new \ReflectionClass(\phpbbgallery\core\pagination::class);
		$pagination = $reflection->newInstanceWithoutConstructor();
		$parent = new \ReflectionClass(\phpbb\pagination::class);
		foreach (compact('template', 'user', 'helper') + ['phpbb_dispatcher' => $dispatcher] as $name => $value)
		{
			$property = $parent->getProperty($name);
			$property->setValue($pagination, $value);
		}

		return [$pagination, $template];
	}
}
