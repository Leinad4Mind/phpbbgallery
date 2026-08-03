<?php
/**
 * phpBB Gallery Contest album lifecycle tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\event\album_lifecycle_listener;
use PHPUnit\Framework\TestCase;

final class album_lifecycle_listener_test extends TestCase
{
	public function test_validation_uses_the_offset_at_the_selected_date(): void
	{
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'Europe/Amsterdam'];
		$listener = $this->listener($user, true);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => '2026-01-15 12:00',
				'contest_rating' => '2026-07-15 12:00',
				'contest_end' => '2026-07-16 12:00',
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$data = $event['album_type_data'];
		$this->assertSame(
			(new \DateTimeImmutable('2026-01-15 12:00', new \DateTimeZone('Europe/Amsterdam')))->getTimestamp(),
			$data['contest_start']
		);
		$this->assertSame(
			(new \DateTimeImmutable('2026-07-15 12:00', new \DateTimeZone('Europe/Amsterdam')))->getTimestamp()
				- $data['contest_start'],
			$data['contest_rating']
		);
		$this->assertSame([], $event['errors']);
	}

	public function test_disabled_creation_and_invalid_dates_fail_server_side(): void
	{
		$listener = $this->listener(new \phpbb\user(), false);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => 'invalid',
				'contest_rating' => 'invalid',
				'contest_end' => 'invalid',
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$this->assertContains('CONTEST_CREATION_DISABLED', $event['errors']);
		$this->assertContains('CONTEST_START_INVALID', $event['errors']);
		$this->assertContains('CONTEST_RATING_INVALID', $event['errors']);
		$this->assertContains('CONTEST_END_INVALID', $event['errors']);
	}

	public function test_listener_owns_creation_edit_and_reopen_persistence(): void
	{
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_build_array')
			->with('UPDATE', [
				'contest_start' => 1_000,
				'contest_rating' => 200,
				'contest_end' => 500,
				'contest_marked' => \phpbbgallery\contest\manager::STATE_ACTIVE,
			])
			->willReturn('contest_fields');
		$db->expects($this->exactly(2))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return 'result';
			});
		$listener = $this->listener(new \phpbb\user(), true, $db);
		$event = new \phpbb\event\data([
			'album_id' => 17,
			'album_data_sql' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_id' => 4,
				'contest_start' => 1_000,
				'contest_rating' => 200,
				'contest_end' => 500,
				'contest_marked' => \phpbbgallery\contest\manager::STATE_ACTIVE,
			],
			'album_type_state' => ['reset_marked_images' => true],
			'row' => [],
		]);

		$listener->updated($event);

		$this->assertStringContainsString('UPDATE gallery_contests', $queries[0]);
		$this->assertStringContainsString('WHERE contest_id = 4', $queries[0]);
		$this->assertStringContainsString('UPDATE gallery_images', $queries[1]);
		$this->assertStringContainsString('image_contest = ' . \phpbbgallery\contest\manager::STATE_ACTIVE, $queries[1]);
		$this->assertStringContainsString('WHERE image_album_id = 17', $queries[1]);
	}

	public function test_album_content_cleanup_is_owned_by_the_addon(): void
	{
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return 'result';
			});
		$listener = $this->listener(new \phpbb\user(), true, $db);
		$move = new \phpbb\event\data([
			'from_id' => 12,
			'to_id' => 24,
			'image_move_data' => ['image_album_id' => 24],
		]);

		$listener->prepare_move_album_content($move);
		$this->assertSame([
			'image_album_id' => 24,
			'image_contest_rank' => 0,
			'image_contest_end' => 0,
			'image_contest' => \phpbbgallery\contest\manager::STATE_INACTIVE,
		], $move['image_move_data']);

		$listener->moved_album_content(new \phpbb\event\data(['from_id' => 12]));
		$listener->deleted_album_content(new \phpbb\event\data(['album_id' => 36]));

		$this->assertStringContainsString('WHERE contest_album_id = 12', $queries[0]);
		$this->assertStringContainsString('WHERE contest_album_id = 36', $queries[1]);
	}

	private function listener(
		\phpbb\user $user,
		bool $can_create,
		?\phpbb\db\driver\driver_interface $db = null
	): album_lifecycle_listener
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$contest = $this->createMock(\phpbbgallery\contest\manager::class);
		$contest->method('can_create')->willReturn($can_create);

		return new album_lifecycle_listener(
			$db ?? $this->createStub(\phpbb\db\driver\driver_interface::class),
			$language,
			$user,
			$contest,
			'gallery_albums',
			'gallery_images',
			'gallery_contests'
		);
	}
}
