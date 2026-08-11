<?php
/**
 * phpBB Gallery - ACP albums module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\albums_module;
use phpbbgallery\core\icon\manager;
use phpbb\request\request_interface;
use PHPUnit\Framework\TestCase;

final class acp_albums_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(albums_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === albums_module::class)
			{
				$this->assertNotNull($property->getType(), albums_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== albums_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), albums_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), albums_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_update_detection_uses_the_phpbb_request_abstraction(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('$request->is_set_post(\'update\')', $source);
		$this->assertStringNotContainsString('$' . '_POST', $source);
	}

	public function test_subalbum_controls_follow_the_album_role(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_albums.html');
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertStringContainsString('{% if S_HAS_SUBALBUMS %}', $template);
		$this->assertStringContainsString('{% if S_HAS_PARENT_ALBUM %}', $template);
		$this->assertStringContainsString("lang('SUBALBUM_DISPLAY_MODE')", $template);
		$this->assertStringContainsString('SUBALBUM_DISPLAY_HIDDEN', $template);
		$this->assertStringContainsString('SUBALBUM_DISPLAY_TEXT', $template);
		$this->assertStringContainsString('SUBALBUM_DISPLAY_ICONS', $template);
		$this->assertStringContainsString("'S_HAS_PARENT_ALBUM'", $source);
		$this->assertStringContainsString("'S_HAS_SUBALBUMS'\t=> \$has_subalbums", $source);
		$this->assertStringContainsString('normalise_subalbum_display_mode', $source);
		$this->assertStringContainsString("\$db->sql_in_set('parent_id', \$subalbum_parent_ids)", $source);
		$this->assertStringContainsString('AND display_on_index = 1', $source);
		$this->assertStringContainsString("assign_block_vars('albums.subalbum'", $source);
	}

	public function test_image_capability_comes_from_the_album_type_registry(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');

		$this->assertSame(2, substr_count($source, '$album_type_registry->accepts_images('));
		$this->assertStringNotContainsString('block::TYPE_CONTEST', $source);
	}

	public function test_multiple_icon_uploads_are_validated_individually(): void
	{
		$icon_manager = $this->getMockBuilder(manager::class)
			->disableOriginalConstructor()
			->onlyMethods(['upload'])
			->getMock();
		$icon_manager->expects($this->exactly(2))
			->method('upload')
			->with('icon_file_single')
			->willReturnOnConsecutiveCalls(
				['error' => null, 'filename' => 'one.svg'],
				['error' => 'INVALID', 'filename' => null]
			);

		$request = $this->createMock(request_interface::class);
		$request->expects($this->once())
			->method('variable')
			->with('icon_file', ['name' => 'none'], true, request_interface::FILES)
			->willReturn([
				'name' => ['One.svg', 'Two.png'],
				'type' => ['image/svg+xml', 'image/png'],
				'tmp_name' => ['first.tmp', 'second.tmp'],
				'error' => [0, 0],
				'size' => [100, 200],
			]);

		$overwrites = [];
		$request->expects($this->exactly(3))
			->method('overwrite')
			->willReturnCallback(static function (string $name, mixed $value, int $scope) use (&$overwrites): void
			{
				$overwrites[] = [$name, $value, $scope];
			});

		$method = new \ReflectionMethod(albums_module::class, 'upload_icons');
		$results = $method->invoke(new albums_module(), $icon_manager, $request, 'icon_file');

		$this->assertSame([
			['error' => null, 'filename' => 'one.svg'],
			['error' => 'INVALID', 'filename' => null],
		], $results);
		$this->assertSame('One.svg', $overwrites[0][1]['name']);
		$this->assertSame('Two.png', $overwrites[1][1]['name']);
		$this->assertSame(['icon_file_single', null, request_interface::FILES], $overwrites[2]);
	}
}
