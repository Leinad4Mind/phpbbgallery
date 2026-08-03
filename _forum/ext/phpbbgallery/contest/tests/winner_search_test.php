<?php
/**
 * phpBB Gallery Contest winner search tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\winner_search;
use PHPUnit\Framework\TestCase;

final class winner_search_test extends TestCase
{
	public function test_service_is_fully_typed_and_keeps_visibility_checks(): void
	{
		$reflection = new \ReflectionClass(winner_search::class);
		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType());
		}
		foreach ($reflection->getMethods() as $method)
		{
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType());
			}
			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType());
			}
		}

		$source = (string) file_get_contents(dirname(__DIR__) . '/winner_search.php');
		$this->assertStringContainsString("acl_album_ids('i_view')", $source);
		$this->assertStringContainsString('get_exclude_zebra()', $source);
		$this->assertStringContainsString('image_contest_end = c.contest_start + c.contest_end', $source);
		$this->assertStringContainsString('image_status', $source);
	}

	public function test_no_visible_album_avoids_database_queries(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$auth->expects($this->once())->method('load_user_permissions')->with(7);
		$auth->expects($this->once())->method('acl_album_ids')->with('i_view')->willReturn([]);
		$auth->expects($this->once())->method('get_exclude_zebra')->willReturn([]);
		$user = $this->createStub(\phpbb\user::class);
		$user->data = ['user_id' => 7];

		$search = new winner_search(
			$db,
			$this->createStub(\phpbb\template\template::class),
			$user,
			$this->createStub(\phpbb\language\language::class),
			$this->createStub(\phpbb\controller\helper::class),
			$this->createStub(\phpbbgallery\core\config::class),
			$auth,
			$this->createStub(\phpbbgallery\core\image\image::class),
			$this->createStub(\phpbb\pagination::class),
			'gallery_images',
			'gallery_albums',
			'gallery_contests'
		);

		$this->assertFalse($search->has_visible_winners());
	}
}
