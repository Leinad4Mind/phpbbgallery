<?php
/**
 * phpBB Gallery - Search controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\search;
use PHPUnit\Framework\TestCase;

final class controller_search_types_test extends TestCase
{
	public function test_search_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(search::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === search::class)
			{
				$this->assertNotNull($property->getType(), search::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== search::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), search::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), search::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_search_routes_return_responses_and_paged_routes_use_integers(): void
	{
		$reflection = new \ReflectionClass(search::class);
		foreach (['base', 'random', 'recent', 'recent_comments', 'ego_search', 'toprated'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
			if ($method_name !== 'random')
			{
				$this->assertSame('int', (string) $method->getParameters()[0]->getType());
			}
		}
	}

	public function test_page_numbers_are_clamped_to_the_first_page(): void
	{
		$reflection = new \ReflectionClass(search::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_page');

		$this->assertSame(1, $normalizer->invoke($controller, -10));
		$this->assertSame(1, $normalizer->invoke($controller, 0));
		$this->assertSame(4, $normalizer->invoke($controller, 4));
	}

	public function test_optional_identifier_filters_drop_zero_invalid_and_duplicate_values(): void
	{
		$reflection = new \ReflectionClass(search::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_id_filter');

		$this->assertSame([], $normalizer->invoke($controller, [0]));
		$this->assertSame([7, 12], $normalizer->invoke($controller, ['7', -3, 0, 12, 7, 'invalid']));
	}

	public function test_search_pagination_and_toprated_breadcrumb_use_the_correct_targets(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');

		$this->assertStringContainsString("'page', \$search_count, \$this->gallery_config->get('items_per_page'), \$start", $source);
		$this->assertStringContainsString("'SEARCH_TOPRATED'),\n\t\t\t'U_VIEW_FORUM'\t=> \$this->helper->route('phpbbgallery_core_search_toprated')", $source);
		$this->assertStringNotContainsString('\$current_page - 1', $source);
	}
}
