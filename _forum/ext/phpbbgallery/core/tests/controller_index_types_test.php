<?php
/**
 * phpBB Gallery - Index controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\index;
use PHPUnit\Framework\TestCase;

final class controller_index_types_test extends TestCase
{
	public function test_index_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(index::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === index::class)
			{
				$this->assertNotNull($property->getType(), index::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== index::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), index::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), index::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_route_actions_return_responses_and_use_integer_pages(): void
	{
		$reflection = new \ReflectionClass(index::class);

		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('base')->getReturnType());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('personal')->getReturnType());
		$this->assertSame('int', (string) $reflection->getMethod('personal')->getParameters()[0]->getType());
	}

	public function test_empty_latest_image_results_have_a_stable_identifier(): void
	{
		$reflection = new \ReflectionClass(index::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_last_image');

		$this->assertSame(['image_id' => 0], $normalizer->invoke($controller, false));
		$this->assertSame(['image_id' => 0], $normalizer->invoke($controller, []));
		$this->assertSame(['image_id' => 17, 'image_name' => 'Example'], $normalizer->invoke($controller, ['image_id' => 17, 'image_name' => 'Example']));
	}

	public function test_personal_gallery_pages_are_clamped_to_the_first_page(): void
	{
		$reflection = new \ReflectionClass(index::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_page');

		$this->assertSame(1, $normalizer->invoke($controller, -3));
		$this->assertSame(1, $normalizer->invoke($controller, 0));
		$this->assertSame(4, $normalizer->invoke($controller, 4));
	}

	public function test_rrc_mode_flags_remain_stable(): void
	{
		$this->assertSame(4, index::RRC_MODE_RECENT_COMMENTS);
		$this->assertSame(2, index::RRC_MODE_RANDOM_IMAGES);
		$this->assertSame(1, index::RRC_MODE_RECENT_IMAGES);
	}

	public function test_latest_image_summary_uses_the_neutral_identity_policy(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertStringContainsString('$hide_last_image_uploader', $source);
		$this->assertStringContainsString('$this->image_visibility->hides_private_data(', $source);
		$this->assertStringNotContainsString('core\\contest::', $source);
		$this->assertStringContainsString('CONTEST_USERNAME', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$index_service = strstr($services, 'phpbbgallery.core.controller.index:');
		$index_service = strstr($index_service, 'phpbbgallery.core.controller.search:', true);
		$this->assertStringContainsString(
			"- '@phpbbgallery.core.policy.image_visibility'",
			$index_service
		);
	}

	public function test_optional_index_links_are_added_through_neutral_event(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertStringContainsString('phpbbgallery.core.index.dropdown_links', $source);
		$this->assertStringContainsString('$this->template->assign_vars($dropdown_links)', $source);
		$this->assertStringNotContainsString('has_visible_contest_winners()', $source);
		$this->assertStringNotContainsString("'U_G_SEARCH_CONTESTS'", $source);
	}
}
