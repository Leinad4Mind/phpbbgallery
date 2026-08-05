<?php
/**
 * phpBB Gallery unread-image counter tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\auth\auth;
use phpbbgallery\core\policy\image_visibility;
use phpbbgallery\core\unread_counter;
use PHPUnit\Framework\TestCase;

class unread_counter_test extends TestCase
{
	public function test_counter_is_wired_into_the_page_header_listener(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.unread_counter:', $services);
		$this->assertStringContainsString('class: phpbbgallery\core\unread_counter', $services);
		$this->assertStringContainsString("- '@phpbbgallery.core.unread_counter'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_tracking%'", $services);
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
			$gallery_auth = $this->createMock(auth::class);
			$gallery_auth->expects($this->never())->method('load_user_permissions');
			$counter = $this->counter($db, $gallery_auth, $user_data);

			$this->assertSame(0, $counter->count());
		}
	}

	public function test_non_positive_limit_avoids_permission_and_database_work(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query_limit');
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->never())->method('load_user_permissions');

		$this->assertSame(0, $this->counter($db, $gallery_auth)->count(0));
	}

	public function test_no_visible_albums_avoids_image_query(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query_limit');
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->method('get_exclude_zebra')->willReturn([2, 3]);
		$gallery_auth->method('acl_album_ids')->willReturnMap([
			['i_view', 'array', false, true, [2]],
			['m_status', 'array', false, true, [3]],
		]);

		$this->assertSame(0, $this->counter($db, $gallery_auth)->count());
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
				TestCase::assertStringContainsString('t.user_id = 7', $sql);
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

		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->method('get_exclude_zebra')->willReturn([3]);
		$gallery_auth->method('acl_album_ids')->willReturnMap([
			['i_view', 'array', false, true, [2, 3, 4]],
			['m_status', 'array', false, true, [4, 6]],
		]);
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->expects($this->once())->method('get_data')->with('user_lastmark')->willReturn(1234);
		$visibility = $this->createMock(image_visibility::class);
		$visibility->expects($this->once())
			->method('get_visibility_sql_for_results')
			->with('i', [4, 6])
			->willReturn('(i.image_contest = 0)');

		$this->assertSame(2, $this->counter($db, $gallery_auth, null, $gallery_user, $visibility)->count(500));
	}

	private function counter(
		\phpbb\db\driver\driver_interface $db,
		auth $gallery_auth,
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
			$gallery_auth,
			$gallery_user ?? $this->createStub(\phpbbgallery\core\user::class),
			$visibility ?? $this->createStub(image_visibility::class),
			'phpbb_gallery_images',
			'phpbb_gallery_albums_track'
		);
	}
}
