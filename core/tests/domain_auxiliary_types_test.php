<?php
/**
 * phpBB Gallery - Auxiliary domain service tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\log;
use phpbbgallery\core\misc;
use PHPUnit\Framework\TestCase;

final class domain_auxiliary_types_test extends TestCase
{
	public function test_log_and_misc_contracts_are_fully_typed(): void
	{
		foreach ([log::class, misc::class] as $class_name)
		{
			$reflection = new \ReflectionClass($class_name);

			foreach ($reflection->getProperties() as $property)
			{
				if ($property->getDeclaringClass()->getName() === $class_name)
				{
					$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
				}
			}

			foreach ($reflection->getMethods() as $method)
			{
				if ($method->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}

				foreach ($method->getParameters() as $parameter)
				{
					$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName() . '($' . $parameter->getName() . ')');
				}

				if (!$method->isConstructor())
				{
					$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName() . '()');
				}
			}
		}
	}

	public function test_add_log_builds_an_insert_for_the_current_user(): void
	{
		$database = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$database->expects($this->never())->method('sql_escape');
		$database->expects($this->once())
			->method('sql_build_array')
			->with('INSERT', $this->callback(static function (array $row): bool
			{
				return $row['log_type'] === 'admin' &&
					$row['log_action'] === 'resync' &&
					$row['log_user'] === 42 &&
					$row['log_ip'] === '127.0.0.1' &&
					$row['album'] === 7 &&
					$row['image'] === 9 &&
					json_decode($row['description'], true, 512, JSON_THROW_ON_ERROR) === ['DONE', 'C:\\photos\\summer'];
			}))
			->willReturn('VALUES (...)');
		$database->expects($this->once())
			->method('sql_query')
			->with('INSERT INTO gallery_log VALUES (...)');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 42];
		$user->ip = '127.0.0.1';
		$service = (new \ReflectionClass(log::class))->newInstanceWithoutConstructor();
		$this->set_property($service, 'db', $database);
		$this->set_property($service, 'user', $user);
		$this->set_property($service, 'log_table', 'gallery_log');

		$service->add_log('admin', 'resync', 7, 9, ['DONE', 'C:\\photos\\summer']);
	}

	public function test_log_description_decoder_preserves_slashes_and_supports_legacy_rows(): void
	{
		$service = (new \ReflectionClass(log::class))->newInstanceWithoutConstructor();
		$decode = new \ReflectionMethod(log::class, 'decode_log_description');
		$description = ['LOG_IMAGE_EDITED', 'C:\\photos\\summer', "O'Brien", "null\0byte"];
		$current_json = json_encode($description, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

		$this->assertSame($description, $decode->invoke($service, $current_json));
		$this->assertSame($description, $decode->invoke($service, addslashes($current_json)));
		$this->assertNull($decode->invoke($service, '{invalid json'));
		$this->assertSame(0, preg_match('/(?<![a-zA-Z0-9_])stripslashes\s*\(/', (string) file_get_contents(dirname(__DIR__) . '/log.php')));
	}

	public function test_captcha_result_is_boolean_and_cached_per_mode(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$user = new \phpbb\user();
		$user->data = ['user_id' => ANONYMOUS];
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->once())
			->method('get')
			->with('captcha_unit_upload')
			->willReturn(1);
		$service = (new \ReflectionClass(misc::class))->newInstanceWithoutConstructor();
		$this->set_property($service, 'user', $user);
		$this->set_property($service, 'gallery_config', $config);

		$this->assertTrue($service->display_captcha('unit_upload'));
		$this->assertTrue($service->display_captcha('unit_upload'));
	}

	public function test_markread_accepts_a_single_album_without_counting_a_scalar(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$user = new \phpbb\user();
		$user->data = ['user_id' => 42];
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->expects($this->once())
			->method('set_user_id')
			->with(42);
		$service = (new \ReflectionClass(misc::class))->newInstanceWithoutConstructor();
		$this->set_property($service, 'user', $user);
		$this->set_property($service, 'gallery_user', $gallery_user);

		$service->markread('all', 7);
		$this->assertTrue(true);
	}

	public function test_log_sort_direction_uses_the_requested_value(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/log.php');
		$ascending = '(($additional[\'sort_dir\'] ?? \'d\') === \'a\') ? \'ASC\' : \'DESC\'';
		$legacy = 'isset($additional[\'sort_dir\']) ? \'ASC\' : \'DESC\'';

		$this->assertStringContainsString($ascending, $source);
		$this->assertStringNotContainsString($legacy, $source);
	}

	private function set_property(object $service, string $name, mixed $value): void
	{
		(new \ReflectionProperty($service::class, $name))->setValue($service, $value);
	}
}
