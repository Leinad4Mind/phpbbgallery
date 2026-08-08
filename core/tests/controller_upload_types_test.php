<?php
/**
 * phpBB Gallery - Upload controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\upload;
use PHPUnit\Framework\TestCase;

final class controller_upload_types_test extends TestCase
{
	public function test_upload_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(upload::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === upload::class)
			{
				$this->assertNotNull($property->getType(), upload::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== upload::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), upload::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), upload::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_upload_events_receive_the_registered_dispatcher(): void
	{
		$reflection = new \ReflectionClass(upload::class);
		$parameter = $reflection->getConstructor()->getParameters()[2];

		$this->assertSame('dispatcher', $parameter->getName());
		$this->assertSame('phpbb\\event\\dispatcher_interface', (string) $parameter->getType());

		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
		$this->assertStringContainsString('$this->dispatcher = $dispatcher;', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$upload_service = strstr($services, 'phpbbgallery.core.controller.upload:');
		$upload_service = strstr($upload_service, 'phpbbgallery.core.controller.album:', true);
		$this->assertStringContainsString("- '@dispatcher'", $upload_service);
	}

	public function test_upload_route_uses_an_integer_album_and_returns_a_response(): void
	{
		$method = (new \ReflectionClass(upload::class))->getMethod('main');

		$this->assertSame('int', (string) $method->getParameters()[0]->getType());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
	}

	public function test_filesystem_check_requires_all_upload_directories(): void
	{
		$base = sys_get_temp_dir() . '/phpbbgallery-controller-upload-' . str_replace('.', '-', uniqid('', true));
		$core = $base . '/files/phpbbgallery/core';
		$medium = $core . '/medium';
		$mini = $core . '/mini';
		$source = $core . '/source';
		$this->assertTrue(mkdir($medium, 0777, true));
		$this->assertTrue(mkdir($mini));
		$this->assertTrue(mkdir($source));

		try
		{
			$reflection = new \ReflectionClass(upload::class);
			$controller = $reflection->newInstanceWithoutConstructor();
			$reflection->getProperty('phpbb_root_path')->setValue($controller, $base . '/');
			$check = $reflection->getMethod('check_fs');

			$this->assertTrue($check->invoke($controller));
			$this->assertTrue(rmdir($source));
			$this->assertFalse($check->invoke($controller));
		}
		finally
		{
			if (is_dir($source))
			{
				rmdir($source);
			}
			rmdir($mini);
			rmdir($medium);
			rmdir($core);
			rmdir(dirname($core));
			rmdir(dirname($core, 2));
			rmdir($base);
		}
	}

	public function test_guest_username_validation_uses_the_upload_error_collector(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');

		$this->assertStringContainsString('$process->new_error($this->language->lang($result . \'_USERNAME\'))', $source);
		$this->assertStringNotContainsString('$error_array', $source);
	}

	public function test_album_operation_is_checked_at_entry_and_before_finalization(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');

		$this->assertSame(2, substr_count($source, '$this->album_operation->allows(\'upload\', $album_data)'));
		$this->assertStringNotContainsString('core\\contest', $source);
	}
}
