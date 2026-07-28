<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class search_extension_events_test extends TestCase
{
	public function test_search_events_receive_the_registered_dispatcher(): void
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\controller\search::class);
		$parameter = $reflection->getConstructor()->getParameters()[3];

		$this->assertSame('dispatcher', $parameter->getName());
		$this->assertSame('phpbb\\event\\dispatcher_interface', (string) $parameter->getType());

		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$this->assertStringContainsString('$this->dispatcher = $dispatcher;', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$search_service = strstr($services, 'phpbbgallery.core.controller.search:');
		$search_service = strstr($search_service, 'phpbbgallery.core.controller.comment:', true);
		$this->assertStringContainsString("- '@dispatcher'", $search_service);
	}

	public function test_addon_search_conditions_keep_core_permission_and_visibility_filters(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$event = strpos($controller, "trigger_event('phpbbgallery.core.search.configure'");
		$album_boundary = strpos($controller, "sql_in_set('i.image_album_id', \$search_album)", $event ?: 0);
		$visibility_boundary = strpos($controller, 'get_image_visibility_sql()', $album_boundary ?: 0);
		$addon_merge = strpos($controller, 'array_filter($additional_search_where', $visibility_boundary ?: 0);

		$this->assertNotFalse($event);
		$this->assertNotFalse($album_boundary);
		$this->assertNotFalse($visibility_boundary);
		$this->assertNotFalse($addon_merge);
		$this->assertLessThan($album_boundary, $event);
		$this->assertLessThan($visibility_boundary, $album_boundary);
		$this->assertLessThan($addon_merge, $visibility_boundary);
		$this->assertStringContainsString('&& !$additional_search_active', $controller);
	}

	public function test_addon_search_parameters_are_retained_by_pagination(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$merge = strpos($controller, '], $additional_search_params);');
		$pagination = strpos($controller, "'params' => \$pagination_params", $merge ?: 0);

		$this->assertNotFalse($merge);
		$this->assertNotFalse($pagination);
		$this->assertLessThan($pagination, $merge);
	}

	public function test_final_permission_boundaries_are_exposed_to_result_facets(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$where = strpos($controller, "\$search_where = (string) \$sql_array['WHERE']");
		$event = strpos($controller, "trigger_event('phpbbgallery.core.search.results'", $where ?: 0);
		$pagination = strpos($controller, 'generate_template_pagination([', $event ?: 0);

		$this->assertNotFalse($where);
		$this->assertNotFalse($event);
		$this->assertNotFalse($pagination);
		$this->assertLessThan($event, $where);
		$this->assertLessThan($pagination, $event);
		$this->assertStringContainsString("['search_where', 'search_count', 'search_params']", $controller);
	}

	public function test_every_style_exposes_the_tag_neutral_search_field_event(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/search_body.html');
			$this->assertSame(1, substr_count($template, '{% EVENT phpbbgallery_core_search_fields %}'), $style);
			$results = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/search_results.html');
			$this->assertSame(1, substr_count($results, '{% EVENT phpbbgallery_core_search_results_facets %}'), $style);
		}
	}
}
