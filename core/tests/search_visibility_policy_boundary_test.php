<?php
/**
 * phpBB Gallery search visibility-policy boundary tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class search_visibility_policy_boundary_test extends TestCase
{
	public function test_search_layers_depend_only_on_the_neutral_visibility_policy(): void
	{
		$search = (string) file_get_contents(dirname(__DIR__) . '/search.php');
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$controllers = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');

		$this->assertStringContainsString('policy\\image_visibility $image_visibility', $search);
		$this->assertStringContainsString('policy\\image_visibility $image_visibility', $controller);
		$this->assertStringContainsString('$this->image_visibility->private_data_sql(', $search);
		$this->assertStringContainsString('$this->image_visibility->results_sql(', $search);
		$this->assertStringContainsString('$this->image_visibility->private_data_sql(', $controller);
		$this->assertStringContainsString('$this->image_visibility->results_sql(', $controller);
		$this->assertStringNotContainsString('core\\contest::', $search);
		$this->assertStringNotContainsString('core\\contest::', $controller);
		$search_service = strstr($services, 'phpbbgallery.core.search:');
		$search_service = strstr($search_service, 'phpbbgallery.core.block:', true);
		$search_controller = strstr($controllers, 'phpbbgallery.core.controller.search:');
		$search_controller = strstr($search_controller, 'phpbbgallery.core.controller.comment:', true);
		$this->assertStringContainsString("- '@phpbbgallery.core.policy.image_visibility'", $search_service);
		$this->assertStringContainsString("- '@phpbbgallery.core.policy.image_visibility'", $search_controller);
	}
}
