<?php
/**
 * phpBB Gallery unread-image counter tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album_access;
use phpbbgallery\core\policy\image_visibility;
use phpbbgallery\core\unread_counter;
use PHPUnit\Framework\TestCase;

class unread_counter_test extends TestCase
{
	public function test_read_marker_identifiers_are_cast_at_the_sql_boundary(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/unread_counter.php');

		$this->assertSame(2, substr_count($source, "WHERE user_id = ' . (int) \$user_id"));
		$this->assertStringContainsString("AND image_id = ' . (int) \$image_id", $source);
	}

	public function test_counter_is_wired_into_the_page_header_listener(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.unread_counter:', $services);
		$this->assertStringContainsString('class: phpbbgallery\core\unread_counter', $services);
		$this->assertStringContainsString("- '@phpbbgallery.core.unread_counter'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_tracking%'", $services);
		$this->assertMatchesRegularExpression(
			'~phpbbgallery\\.core\\.unread_counter:\\R'
			. "\\s+class: phpbbgallery\\\\core\\\\unread_counter\\R"
			. '\\s+arguments:(?:\\R\\s+- .+){7}\\R'
			. "\\s+- '%phpbbgallery\\.tables\\.gallery_image_tracking%'~",
			$services
		);
	}

	public function test_album_listing_marks_only_its_bounded_page_without_adding_views(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');
		$query = strpos($source, '$this->db->sql_query_limit($sql, $limit, $start)');
		$mark = strpos($source, '$this->unread_counter->mark_viewed_many($image_ids)', (int) $query);
		$display = strpos($source, 'foreach ($images as $row)', (int) $mark);

		$this->assertIsInt($query);
		$this->assertIsInt($mark);
		$this->assertIsInt($display);
		$this->assertLessThan($mark, $query);
		$this->assertLessThan($display, $mark);
		$this->assertStringNotContainsString('SET image_view_count = image_view_count + 1', $source);
	}

	public function test_guests_and_bots_never_load_permissions_or_query_images(): void
	{
		foreach ([
			['user_id' => 1, 'is_registered' => false, 'is_bot' => false],
			['user_id' => 7, 'is_registered' => true, 'is_bot' => true],
		] as $user_data)
		{
			$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
			$db->expects($this->never())->method('sql_query_limit');
			$access = $this->createMock(album_access::class);
			$access->expects($this->never())->method('resolve');
			$counter = $this->counter($db, $access, $user_data);

			$this->assertSame(0, $counter->count());
		}
	}

	public function test_non_positive_limit_avoids_permission_and_database_work(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query_limit');
		$access = $this->createMock(album_access::class);
		$access->expects($this->never())->method('resolve');

		$this->assertSame(0, $this->counter($db, $access)->count(0));
	}

	public function test_no_visible_albums_avoids_image_query(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query_limit');
		$access = $this->createMock(album_access::class);
		$access->expects($this->once())->method('resolve')->willReturn([
			'viewable' => [],
			'moderated' => [],
			'visible' => [],
		]);

		$this->assertSame(0, $this->counter($db, $access)->count());
	}

	public function test_query_uses_permission_filtered_albums_statuses_privacy_and_read_markers(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static function (string $field, array $values): string
			{
				if ($field === 'i.image_album_id')
				{
					TestCase::assertSame([2, 4, 6], $values);
					return 'i.image_album_id IN (2, 4, 6)';
				}

				TestCase::assertSame('i.image_status', $field);
				TestCase::assertSame([1, 2], $values);
				return 'i.image_status IN (1, 2)';
			});
		$db->expects($this->once())
			->method('sql_query_limit')
			->with($this->callback(static function (string $sql): bool
			{
				TestCase::assertStringContainsString('LEFT JOIN phpbb_gallery_albums_track t', $sql);
				TestCase::assertStringContainsString('t.user_id = 42', $sql);
				TestCase::assertStringContainsString('i.image_album_id IN (2, 4, 6)', $sql);
				TestCase::assertStringContainsString('i.image_status IN (1, 2)', $sql);
				TestCase::assertStringContainsString('(i.image_contest = 0)', $sql);
				TestCase::assertStringContainsString('i.image_time > 1234', $sql);
				TestCase::assertStringContainsString('i.image_time > t.mark_time', $sql);
				return true;
			}), 100)
			->willReturn('result');
		$db->expects($this->exactly(3))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls(['image_id' => 11], ['image_id' => 12], false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		$access = $this->createMock(album_access::class);
		$access->expects($this->once())->method('resolve')->willReturn([
			'viewable' => [2, 4],
			'moderated' => [4, 6],
			'visible' => [2, 4, 6],
		]);
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->user_id = 42;
		$gallery_user->expects($this->once())->method('get_data')->with('user_lastmark')->willReturn(1234);
		$visibility = $this->createMock(image_visibility::class);
		$visibility->expects($this->once())
			->method('get_visibility_sql_for_results')
			->with('i', [4, 6])
			->willReturn('(i.image_contest = 0)');

		$this->assertSame(2, $this->counter($db, $access, [
			'user_id' => 2,
			'user_perm_from' => 42,
			'is_registered' => true,
			'is_bot' => false,
		], $gallery_user, $visibility)->count(500));
	}

	public function test_album_listing_marks_only_new_unique_page_images_as_read(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('image_id', [8, 7])
			->willReturn('image_id IN (8, 7)');
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static function (string $sql): bool
			{
				TestCase::assertStringContainsString('FROM phpbb_gallery_images_track', $sql);
				TestCase::assertStringContainsString('user_id = 42', $sql);
				TestCase::assertStringContainsString('image_id IN (8, 7)', $sql);
				return true;
			}))
			->willReturn('read-images');
		$db->expects($this->exactly(2))
			->method('sql_fetchrow')
			->with('read-images')
			->willReturnOnConsecutiveCalls(['image_id' => 7], false);
		$db->expects($this->once())->method('sql_freeresult')->with('read-images');
		$db->expects($this->once())
			->method('sql_multi_insert')
			->with('phpbb_gallery_images_track', $this->callback(static function (array $rows): bool
			{
				TestCase::assertCount(1, $rows);
				TestCase::assertSame(42, $rows[0]['user_id']);
				TestCase::assertSame(8, $rows[0]['image_id']);
				TestCase::assertGreaterThan(0, $rows[0]['mark_time']);
				return true;
			}));

		$counter = $this->counter($db, $this->createStub(album_access::class), [
			'user_id' => 42,
			'is_registered' => true,
			'is_bot' => false,
		]);
		$counter->mark_viewed_many([8, 7, 8, 0, -2]);
	}

	public function test_album_listing_does_not_write_read_markers_for_guests_or_bots(): void
	{
		foreach ([
			['user_id' => ANONYMOUS, 'is_registered' => false, 'is_bot' => false],
			['user_id' => 42, 'is_registered' => true, 'is_bot' => true],
		] as $user_data)
		{
			$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
			$db->expects($this->never())->method('sql_query');
			$db->expects($this->never())->method('sql_multi_insert');

			$this->counter($db, $this->createStub(album_access::class), $user_data)
				->mark_viewed_many([7, 8]);
		}
	}

	private function counter(
		\phpbb\db\driver\driver_interface $db,
		album_access $access,
		?array $user_data = null,
		?\phpbbgallery\core\user $gallery_user = null,
		?image_visibility $visibility = null
	): unread_counter
	{
		$user = new \phpbb\user();
		$user->data = $user_data ?? [
			'user_id' => 7,
			'is_registered' => true,
			'is_bot' => false,
		];

		return new unread_counter(
			$db,
			$user,
			$access,
			$gallery_user ?? $this->createStub(\phpbbgallery\core\user::class),
			$visibility ?? $this->createStub(image_visibility::class),
			'phpbb_gallery_images',
			'phpbb_gallery_albums_track',
			'phpbb_gallery_images_track'
		);
	}
}
