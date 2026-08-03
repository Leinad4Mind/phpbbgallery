<?php
/**
 * phpBB Gallery - Message editor image selector tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\auth\auth;
use phpbbgallery\core\image\selector;
use phpbbgallery\core\policy\image_visibility;
use PHPUnit\Framework\TestCase;

final class editor_selector_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();
		if (!class_exists(selector::class, false))
		{
			require_once dirname(__DIR__) . '/image/selector.php';
		}
	}

	public function test_page_is_filtered_by_acl_zebra_author_status_and_contest(): void
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())
			->method('load_user_permissions')
			->with(7);
		$gallery_auth->expects($this->once())
			->method('acl_album_ids')
			->with('i_view')
			->willReturn([30, 20, 30]);
		$gallery_auth->expects($this->once())
			->method('get_exclude_zebra')
			->willReturn([20]);

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static function (string $field, array $values): string
			{
				if ($field === 'i.image_album_id')
				{
					TestCase::assertSame([30], $values);
					return 'i.image_album_id IN (30)';
				}

				TestCase::assertSame('i.image_status', $field);
				TestCase::assertSame([1, 2], $values);
				return 'i.image_status IN (1, 2)';
			});

		$queries = [];
		$db->expects($this->exactly(2))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return count($queries) === 1 ? 'albums-result' : 'count-result';
			});
		$rows = [
			'albums-result' => [
				['album_id' => '30', 'album_name' => 'Public album', 'album_depth' => '2', 'left_id' => '4'],
				false,
			],
			'images-result' => [
				['image_id' => '91', 'image_name' => 'First', 'image_album_id' => '30', 'album_name' => 'Public album'],
				['image_id' => '87', 'image_name' => 'Second', 'image_album_id' => '30', 'album_name' => 'Public album'],
				false,
			],
		];
		$db->method('sql_fetchrow')
			->willReturnCallback(static function (string $result) use (&$rows): array|false
			{
				return array_shift($rows[$result]);
			});
		$db->expects($this->once())
			->method('sql_fetchfield')
			->with('total')
			->willReturn(25);

		$image_query = '';
		$db->expects($this->once())
			->method('sql_query_limit')
			->with($this->isType('string'), 10, 20)
			->willReturnCallback(static function (string $sql) use (&$image_query): string
			{
				$image_query = $sql;
				return 'images-result';
			});
		$db->expects($this->exactly(3))->method('sql_freeresult');

		$result = $this->selector($db, $gallery_auth)
			->get_page(7, 30, 9, 10);

		$this->assertTrue($result['authorized']);
		$this->assertSame(30, $result['album_id']);
		$this->assertSame([
			['album_id' => 30, 'album_name' => 'Public album', 'album_depth' => 2],
		], $result['albums']);
		$this->assertSame([
			['image_id' => 91, 'image_name' => 'First', 'album_id' => 30, 'album_name' => 'Public album'],
			['image_id' => 87, 'image_name' => 'Second', 'album_id' => 30, 'album_name' => 'Public album'],
		], $result['images']);
		$this->assertSame([
			'page' => 3,
			'pages' => 3,
			'per_page' => 10,
			'total' => 25,
		], $result['pagination']);

		$all_sql = implode("\n", array_merge($queries, [$image_query]));
		$this->assertStringContainsString('i.image_user_id = 7', $all_sql);
		$this->assertStringContainsString('i.image_album_id IN (30)', $all_sql);
		$this->assertStringNotContainsString('IN (20)', $all_sql);
		$this->assertStringContainsString('i.image_status IN (1, 2)', $all_sql);
		$this->assertStringContainsString('i.image_contest = 0', $all_sql);
		$this->assertStringContainsString('p.album_user_id = a.album_user_id', $all_sql);
		$this->assertStringContainsString('i.image_album_id = 30', $image_query);
		$this->assertStringContainsString('ORDER BY i.image_time DESC, i.image_id DESC', $image_query);
	}

	public function test_has_images_uses_the_same_permission_and_image_filters(): void
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->expects($this->once())->method('acl_album_ids')->with('i_view')->willReturn([30, 20]);
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([20]);

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static function (string $field, array $values): string
			{
				return $field . ' IN (' . implode(',', $values) . ')';
			});
		$query = '';
		$db->expects($this->once())
			->method('sql_query_limit')
			->with($this->isType('string'), 1)
			->willReturnCallback(static function (string $sql) use (&$query): string
			{
				$query = $sql;
				return 'exists-result';
			});
		$db->expects($this->once())->method('sql_fetchfield')->with('image_id')->willReturn(91);
		$db->expects($this->once())->method('sql_freeresult')->with('exists-result');

		$this->assertTrue($this->selector($db, $gallery_auth)->has_images(7));
		$this->assertStringContainsString('i.image_user_id = 7', $query);
		$this->assertStringContainsString('i.image_album_id IN (30)', $query);
		$this->assertStringNotContainsString('IN (20)', $query);
		$this->assertStringContainsString('i.image_status IN (1,2)', $query);
		$this->assertStringContainsString('i.image_contest = 0', $query);
	}

	public function test_has_images_returns_false_without_querying_when_no_album_is_viewable(): void
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->method('acl_album_ids')->with('i_view')->willReturn([]);
		$gallery_auth->method('get_exclude_zebra')->willReturn([]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query_limit');

		$this->assertFalse($this->selector($db, $gallery_auth)->has_images(7));
	}

	public function test_forbidden_album_returns_before_any_database_query(): void
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->method('acl_album_ids')->with('i_view')->willReturn([30]);
		$gallery_auth->method('get_exclude_zebra')->willReturn([]);

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$db->expects($this->never())->method('sql_query_limit');

		$result = $this->selector($db, $gallery_auth)
			->get_page(7, 99, 0, 99);

		$this->assertFalse($result['authorized']);
		$this->assertSame(99, $result['album_id']);
		$this->assertSame([], $result['albums']);
		$this->assertSame([], $result['images']);
		$this->assertSame([
			'page' => 1,
			'pages' => 1,
			'per_page' => 50,
			'total' => 0,
		], $result['pagination']);
	}

	public function test_zebra_can_remove_every_viewable_album_safely(): void
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(9);
		$gallery_auth->method('acl_album_ids')->with('i_view')->willReturn([12]);
		$gallery_auth->method('get_exclude_zebra')->willReturn([12]);

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$result = $this->selector($db, $gallery_auth)
			->get_page(9, 0, 4, 0);

		$this->assertTrue($result['authorized']);
		$this->assertSame(1, $result['pagination']['page']);
		$this->assertSame(1, $result['pagination']['per_page']);
		$this->assertSame(0, $result['pagination']['total']);
	}

	public function test_selector_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(selector::class);

		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), selector::class . '::$' . $property->getName());
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== selector::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), selector::class . '::' . $method->getName());
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), selector::class . '::' . $method->getName());
			}
		}
	}

	private function selector(\phpbb\db\driver\driver_interface $db, auth $gallery_auth): selector
	{
		$image_visibility = $this->createStub(image_visibility::class);
		$image_visibility->method('results_sql')
			->with('i', [])
			->willReturn('(i.image_contest = 0)');

		return new selector($db, $gallery_auth, $image_visibility, 'gallery_images', 'gallery_albums');
	}
}
