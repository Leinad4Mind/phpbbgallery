<?php
/**
 * phpBB Gallery - Moderation controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\moderate;
use PHPUnit\Framework\TestCase;

final class controller_moderate_types_test extends TestCase
{
	public function test_moderation_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(moderate::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === moderate::class)
			{
				$this->assertNotNull($property->getType(), moderate::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== moderate::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), moderate::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), moderate::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_moderation_routes_use_integer_identifiers_and_explicit_responses(): void
	{
		$reflection = new \ReflectionClass(moderate::class);
		$response_methods = ['base', 'action_log', 'image', 'approve', 'unapprove', 'move', 'lock'];
		$nullable_methods = ['queue_approve', 'reports', 'album_overview'];

		foreach ($response_methods as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
		}

		foreach ($nullable_methods as $method_name)
		{
			$this->assertSame('?Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod($method_name)->getReturnType());
		}

		foreach (['base', 'queue_approve', 'action_log', 'reports', 'album_overview', 'image', 'approve', 'unapprove', 'move', 'lock'] as $method_name)
		{
			foreach ($reflection->getMethod($method_name)->getParameters() as $parameter)
			{
				$this->assertSame('int', (string) $parameter->getType(), $method_name . '($' . $parameter->getName() . ')');
			}
		}
	}

	public function test_invalid_page_numbers_are_clamped_to_the_first_page(): void
	{
		$reflection = new \ReflectionClass(moderate::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_page');

		$this->assertSame(1, $normalizer->invoke($controller, -4));
		$this->assertSame(1, $normalizer->invoke($controller, 0));
		$this->assertSame(8, $normalizer->invoke($controller, 8));
	}

	public function test_redirect_actions_return_responses_without_sending_them_directly(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/moderate.php');

		$this->assertStringNotContainsString('->send()', $source);
		$this->assertGreaterThanOrEqual(5, substr_count($source, 'return new RedirectResponse('));
	}

	public function test_album_moderation_reuses_the_complete_album_navigation(): void
	{
		$album_data = [
			'album_id' => 12,
			'album_name' => 'Test album',
		];
		$display = new class extends \phpbbgallery\core\album\display
		{
			public array $navigation = [];

			public function __construct()
			{
			}

			public function generate_navigation(array $album_data): void
			{
				$this->navigation[] = $album_data;
			}
		};

		$reflection = new \ReflectionClass(moderate::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('display')->setValue($controller, $display);
		$reflection->getMethod('assign_navigation')->invoke($controller, $album_data);

		$this->assertSame([$album_data], $display->navigation);
	}

	public function test_all_rendered_moderation_pages_assign_gallery_navigation(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/moderate.php');

		$this->assertGreaterThanOrEqual(6, substr_count($source, '$this->assign_navigation('));
		$this->assertStringContainsString("'phpbbgallery_core_index'", $source);
		$this->assertStringContainsString("assign_block_vars('navlinks'", $source);
	}
}
