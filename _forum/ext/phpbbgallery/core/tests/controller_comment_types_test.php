<?php
/**
 * phpBB Gallery - Comment controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\comment;
use PHPUnit\Framework\TestCase;

final class controller_comment_types_test extends TestCase
{
	public function test_comment_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(comment::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === comment::class)
			{
				$this->assertNotNull($property->getType(), comment::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== comment::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), comment::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), comment::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_comment_routes_use_integer_identifiers_and_responses(): void
	{
		$reflection = new \ReflectionClass(comment::class);

		foreach (['add', 'edit', 'delete', 'rate'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertSame('int', (string) $parameter->getType());
			}
		}
	}

	public function test_comment_form_fields_use_the_phpbb_request_service(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/comment.php');

		$this->assertStringContainsString("\$this->request->is_set_post('cancel')", $source);
		$this->assertStringContainsString("\$this->request->is_set_post('attach_sig')", $source);
		$this->assertStringNotContainsString('\$_POST', $source);
	}
}
