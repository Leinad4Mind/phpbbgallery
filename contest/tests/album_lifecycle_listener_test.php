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
		$year = (int) gmdate('Y') + 1;
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'Europe/Amsterdam'];
		$listener = $this->listener($user, true);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => $year . '-01-15T12:00',
				'contest_rating' => $year . '-07-15T12:00',
				'contest_end' => $year . '-07-16T12:00',
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$data = $event['album_type_data'];
		$this->assertSame(
			(new \DateTimeImmutable($year . '-01-15 12:00', new \DateTimeZone('Europe/Amsterdam')))->getTimestamp(),
			$data['contest_start']
		);
		$this->assertSame(
			(new \DateTimeImmutable($year . '-07-15 12:00', new \DateTimeZone('Europe/Amsterdam')))->getTimestamp()
				- $data['contest_start'],
			$data['contest_rating']
		);
		$this->assertSame([], $event['errors']);
	}

	public function test_legacy_space_separated_dates_remain_accepted(): void
	{
		$start = new \DateTimeImmutable('+1 year', new \DateTimeZone('UTC'));
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'UTC'];
		$listener = $this->listener($user, true);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => $start->format('Y-m-d H:i'),
				'contest_rating' => $start->modify('+3 days')->format('Y-m-d H:i'),
				'contest_end' => $start->modify('+7 days')->format('Y-m-d H:i'),
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$this->assertSame([], $event['errors']);
		$this->assertSame(
			\DateTimeImmutable::createFromFormat('Y-m-d H:i', $start->format('Y-m-d H:i'), new \DateTimeZone('UTC'))->getTimestamp(),
			$event['album_type_data']['contest_start']
		);
	}

	public function test_new_contest_rejects_every_past_schedule_date(): void
	{
		$start = new \DateTimeImmutable('-3 days', new \DateTimeZone('UTC'));
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'UTC'];
		$listener = $this->listener($user, true);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => $start->format('Y-m-d\TH:i'),
				'contest_rating' => $start->modify('+1 hour')->format('Y-m-d\TH:i'),
				'contest_end' => $start->modify('+2 hours')->format('Y-m-d\TH:i'),
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$this->assertSame([
			'CONTEST_DATE_MUST_BE_FUTURE',
			'CONTEST_DATE_MUST_BE_FUTURE',
			'CONTEST_DATE_MUST_BE_FUTURE',
		], $event['errors']);
	}

	public function test_unchanged_historical_dates_remain_valid_when_editing(): void
	{
		$stored_start = intdiv(time() - 3 * 86400, 60) * 60 + 37;
		$contest = [
			'contest_start' => $stored_start,
			'contest_rating' => 3600,
			'contest_end' => 7200,
		];
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'UTC'];
		$listener = $this->listener($user, true, null, null, $contest);
		$event = new \phpbb\event\data([
			'album_data' => [
				'album_id' => 17,
				'album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
			],
			'album_type_data' => [
				'contest_start' => gmdate('Y-m-d\TH:i', $stored_start),
				'contest_rating' => gmdate('Y-m-d\TH:i', $stored_start + 3600),
				'contest_end' => gmdate('Y-m-d\TH:i', $stored_start + 7200),
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$this->assertSame([], $event['errors']);
	}

	public function test_changed_historical_dates_are_rejected_when_editing(): void
	{
		$stored_start = intdiv(time() - 3 * 86400, 60) * 60;
		$changed_start = $stored_start - 86400;
		$contest = [
			'contest_start' => $stored_start,
			'contest_rating' => 3600,
			'contest_end' => 7200,
		];
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'UTC'];
		$listener = $this->listener($user, true, null, null, $contest);
		$event = new \phpbb\event\data([
			'album_data' => [
				'album_id' => 17,
				'album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
			],
			'album_type_data' => [
				'contest_start' => gmdate('Y-m-d\TH:i', $changed_start),
				'contest_rating' => gmdate('Y-m-d\TH:i', $changed_start + 3600),
				'contest_end' => gmdate('Y-m-d\TH:i', $changed_start + 7200),
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$this->assertSame([
			'CONTEST_DATE_MUST_BE_FUTURE',
			'CONTEST_DATE_MUST_BE_FUTURE',
			'CONTEST_DATE_MUST_BE_FUTURE',
		], $event['errors']);
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

	public function test_outdated_schema_is_rejected_before_album_creation(): void
	{
		$db_tools = $this->createMock(\phpbb\db\tools\tools_interface::class);
		$db_tools->expects($this->once())
			->method('sql_table_exists')
			->with('gallery_contests')
			->willReturn(true);
		$db_tools->expects($this->once())
			->method('sql_column_exists')
			->with('gallery_contests', 'contest_winner_thumbnail')
			->willReturn(false);
		$listener = $this->listener(new \phpbb\user(), true, null, $db_tools);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => '2026-08-11 12:00',
				'contest_rating' => '2026-08-12 12:00',
				'contest_end' => '2026-08-13 12:00',
			],
			'errors' => [],
		]);

		$listener->validate($event);

		$this->assertSame(['CONTEST_SCHEMA_OUTDATED'], $event['errors']);
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
				'contest_winner_thumbnail' => \phpbbgallery\contest\manager::THUMBNAIL_WINNER,
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
				'contest_winner_thumbnail' => \phpbbgallery\contest\manager::THUMBNAIL_WINNER,
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
		?\phpbb\db\driver\driver_interface $db = null,
		?\phpbb\db\tools\tools_interface $db_tools = null,
		array|false $existing_contest = false
	): album_lifecycle_listener
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$contest = $this->createMock(\phpbbgallery\contest\manager::class);
		$contest->method('can_create')->willReturn($can_create);
		$contest->method('get_contest')->willReturn($existing_contest);
		if ($db_tools === null)
		{
			$db_tools = $this->createStub(\phpbb\db\tools\tools_interface::class);
			$db_tools->method('sql_table_exists')->willReturn(true);
			$db_tools->method('sql_column_exists')->willReturn(true);
		}

		return new album_lifecycle_listener(
			$db ?? $this->createStub(\phpbb\db\driver\driver_interface::class),
			$db_tools,
			$language,
			$user,
			$contest,
			'gallery_albums',
			'gallery_images',
			'gallery_contests'
		);
	}
}
