<?php
/**
 * phpBB Gallery - Core image domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\image;
use PHPUnit\Framework\TestCase;

final class domain_image_types_test extends TestCase
{
	public function test_image_domain_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(image::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === image::class)
			{
				$this->assertNotNull($property->getType(), image::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== image::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), image::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), image::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_image_domain_return_contracts_are_explicit(): void
	{
		$this->assertSame('array|false', (string) (new \ReflectionMethod(image::class, 'get_new_author_info'))->getReturnType());
		$this->assertSame('bool', (string) (new \ReflectionMethod(image::class, 'delete_images'))->getReturnType());
		$this->assertSame('array', (string) (new \ReflectionMethod(image::class, 'get_filenames'))->getReturnType());
		$this->assertSame('string', (string) (new \ReflectionMethod(image::class, 'generate_link'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(image::class, 'handle_counter'))->getReturnType());
		$this->assertSame('array|false', (string) (new \ReflectionMethod(image::class, 'get_image_data'))->getReturnType());
		$this->assertSame('array', (string) (new \ReflectionMethod(image::class, 'get_image_data_or_fail'))->getReturnType());
		$this->assertSame('array|false', (string) (new \ReflectionMethod(image::class, 'get_last_image'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(image::class, 'assign_block'))->getReturnType());
	}

	public function test_empty_image_operations_have_stable_results_without_dependencies(): void
	{
		$image = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		$this->assertFalse($image->get_new_author_info(''));
		$this->assertFalse($image->delete_images([]));
		$this->assertSame([], $image->get_filenames([]));
		$this->assertFalse($image->get_image_data(0));
		$this->assertNull($image->handle_counter([], true));
	}

	public function test_status_guard_does_not_delete_a_draft_finalized_after_selection(): void
	{
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturn('image_id IN (71)');
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use (&$queries): string
		{
			$queries[] = $sql;

			return count($queries) === 1 ? 'selected-draft' : 'conditional-delete';
		});
		$db->expects($this->exactly(2))
			->method('sql_fetchrow')
			->with('selected-draft')
			->willReturnOnConsecutiveCalls([
				'image_id' => 71,
				'image_filename' => 'draft.png',
			], false);
		$db->expects($this->once())->method('sql_freeresult')->with('selected-draft');
		$db->expects($this->once())->method('sql_affectedrows')->willReturn(0);

		$reflection = new \ReflectionClass(image::class);
		$image = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($image, $db);
		$reflection->getProperty('contest')->setValue($image, $this->createMock(\phpbbgallery\core\contest::class));
		$reflection->getProperty('table_images')->setValue($image, 'gallery_images');

		$this->assertSame(0, $image->delete_images_matching_status([71], 3, [71 => 'draft.png'], false));
		$this->assertCount(2, $queries);
		$this->assertStringContainsString('AND image_status = 3', $queries[0]);
		$this->assertStringContainsString('WHERE image_id = 71', $queries[1]);
		$this->assertStringContainsString('AND image_status = 3', $queries[1]);
	}

	public function test_missing_image_database_row_returns_false(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$image = $reflection->newInstanceWithoutConstructor();
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with('SELECT * FROM gallery_images WHERE image_id = 99')
			->willReturn('result');
		$db->expects($this->once())
			->method('sql_fetchrow')
			->with('result')
			->willReturn(false);
		$db->expects($this->once())
			->method('sql_freeresult')
			->with('result');

		$reflection->getProperty('db')->setValue($image, $db);
		$reflection->getProperty('table_images')->setValue($image, 'gallery_images');

		$this->assertFalse($image->get_image_data(99));
	}

	public function test_required_image_data_returns_the_loaded_row(): void
	{
		$image = $this->getMockBuilder(image::class)
			->disableOriginalConstructor()
			->onlyMethods(['get_image_data'])
			->getMock();
		$image->method('get_image_data')->with(8)->willReturn(['image_id' => 8]);

		$this->assertSame(['image_id' => 8], $image->get_image_data_or_fail(8));
	}

	public function test_required_image_data_throws_a_404_for_a_missing_row(): void
	{
		$image = $this->getMockBuilder(image::class)
			->disableOriginalConstructor()
			->onlyMethods(['get_image_data'])
			->getMock();
		$image->method('get_image_data')->with(404)->willReturn(false);

		try
		{
			$image->get_image_data_or_fail(404);
			$this->fail('A missing image row was accepted.');
		}
		catch (\phpbb\exception\http_exception $exception)
		{
			$this->assertSame(404, $exception->getStatusCode());
			$this->assertSame('IMAGE_NOT_EXIST', $exception->getMessage());
		}
	}

	public function test_routed_image_consumers_require_an_existing_row(): void
	{
		$controller_root = dirname(__DIR__) . '/controller/';
		$expected_guards = [
			'image.php' => 3,
			'comment.php' => 4,
			'moderate.php' => 6,
		];

		foreach ($expected_guards as $controller_file => $expected_count)
		{
			$source = (string) file_get_contents($controller_root . $controller_file);
			$this->assertSame($expected_count, substr_count($source, '->get_image_data_or_fail('), $controller_file);
		}

		$this->assertSame(0, substr_count((string) file_get_contents($controller_root . 'image.php'), '->get_image_data('));
		$this->assertSame(0, substr_count((string) file_get_contents($controller_root . 'comment.php'), '->get_image_data('));
		$this->assertSame(1, substr_count((string) file_get_contents($controller_root . 'moderate.php'), '->get_image_data('));
	}

	public function test_report_notification_handles_an_image_deleted_during_dispatch(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/notification/helper.php');
		$lookup = strpos($source, 'get_image_data($target[\'reported_image_id\'])');
		$missing_guard = strpos($source, 'if ($image_data === false)', $lookup);
		$album_access = strpos($source, '$image_data[\'image_album_id\']', $lookup);

		$this->assertNotFalse($lookup);
		$this->assertNotFalse($missing_guard);
		$this->assertNotFalse($album_access);
		$this->assertLessThan($missing_guard, $lookup);
		$this->assertLessThan($album_access, $missing_guard);
	}

	public function test_image_display_bitmask_values_remain_stable(): void
	{
		$this->assertSame(128, image::IMAGE_SHOW_IP);
		$this->assertSame(64, image::IMAGE_SHOW_RATINGS);
		$this->assertSame(32, image::IMAGE_SHOW_USERNAME);
		$this->assertSame(16, image::IMAGE_SHOW_VIEWS);
		$this->assertSame(8, image::IMAGE_SHOW_TIME);
		$this->assertSame(4, image::IMAGE_SHOW_IMAGENAME);
		$this->assertSame(2, image::IMAGE_SHOW_COMMENTS);
		$this->assertSame(1, image::IMAGE_SHOW_ALBUM);
	}
}
