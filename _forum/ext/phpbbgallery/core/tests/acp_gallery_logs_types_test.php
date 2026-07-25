<?php
/**
 * phpBB Gallery - ACP gallery-log module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\gallery_logs_module;
use PHPUnit\Framework\TestCase;

final class acp_gallery_logs_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(gallery_logs_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === gallery_logs_module::class)
			{
				$this->assertNotNull($property->getType(), gallery_logs_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== gallery_logs_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), gallery_logs_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), gallery_logs_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_log_mutations_retain_request_and_csrf_guards(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/gallery_logs_module.php');
		$post_check = strpos($source, '$request->is_set_post(\'delmarked\')');
		$form_check = strpos($source, 'check_form_key(\'acp_logs\')');
		$delete = strpos($source, '$log->delete_logs($marked)');

		$this->assertNotFalse($post_check);
		$this->assertNotFalse($form_check);
		$this->assertNotFalse($delete);
		$this->assertLessThan($form_check, $post_check);
		$this->assertLessThan($delete, $form_check);
	}
}
