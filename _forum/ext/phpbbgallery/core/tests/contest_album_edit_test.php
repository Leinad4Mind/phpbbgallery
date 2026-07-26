<?php
/**
 * phpBB Gallery - Contest album edit tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\manage;
use PHPUnit\Framework\TestCase;

final class contest_album_edit_test extends TestCase
{
	public function test_contest_dates_use_the_offset_at_the_selected_date(): void
	{
		$user = new \phpbb\user();
		$user->data = ['user_timezone' => 'Europe/Amsterdam'];
		$manager = $this->manager($this->createStub(\phpbb\db\driver\driver_interface::class), $user);
		$parse = new \ReflectionMethod($manager, 'parse_contest_date');

		$this->assertSame(
			(new \DateTimeImmutable('2026-01-15 12:00', new \DateTimeZone('Europe/Amsterdam')))->getTimestamp(),
			$parse->invoke($manager, '2026-01-15 12:00')
		);
		$this->assertSame(
			(new \DateTimeImmutable('2026-07-15 12:00', new \DateTimeZone('Europe/Amsterdam')))->getTimestamp(),
			$parse->invoke($manager, '2026-07-15 12:00')
		);
		$this->assertFalse($parse->invoke($manager, '2026-02-31 12:00'));
		$this->assertFalse($parse->invoke($manager, 'not-a-date'));
	}

	public function test_completed_contest_is_reopened_from_the_new_end_date(): void
	{
		$manager = $this->manager($this->createStub(\phpbb\db\driver\driver_interface::class));
		$should_reopen = new \ReflectionMethod($manager, 'should_reopen_contest');
		$existing = ['contest_marked' => \phpbbgallery\core\block::NO_CONTEST];

		$this->assertTrue($should_reopen->invoke($manager, $existing, ['contest_start' => 1_000, 'contest_end' => 500], 1_499));
		$this->assertFalse($should_reopen->invoke($manager, $existing, ['contest_start' => 1_000, 'contest_end' => 500], 1_500));
	}

	public function test_edited_contest_and_reopened_images_are_persisted(): void
	{
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_build_array')
			->with('UPDATE', [
				'contest_start' => 1_000,
				'contest_rating' => 200,
				'contest_end' => 500,
				'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
			])
			->willReturn('contest_fields');
		$db->expects($this->exactly(2))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return 'result';
			});
		$manager = $this->manager($db);

		(new \ReflectionMethod($manager, 'update_contest_data'))->invoke($manager, 17, [
			'contest_id' => 4,
			'contest_start' => 1_000,
			'contest_rating' => 200,
			'contest_end' => 500,
			'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
		], true);

		$this->assertStringContainsString('UPDATE phpbb_gallery_contests', $queries[0]);
		$this->assertStringContainsString('WHERE contest_id = 4', $queries[0]);
		$this->assertStringContainsString('UPDATE phpbb_gallery_images', $queries[1]);
		$this->assertStringContainsString('image_contest = ' . \phpbbgallery\core\block::IN_CONTEST, $queries[1]);
		$this->assertStringContainsString('WHERE image_album_id = 17', $queries[1]);

		$source = (string) file_get_contents(dirname(__DIR__) . '/album/manage.php');
		$this->assertStringContainsString('$this->update_contest_data($album_id, $contest_data, $reset_marked_images);', $source);
	}

	private function manager(\phpbb\db\driver\driver_interface $db, ?\phpbb\user $user = null): manage
	{
		$reflection = new \ReflectionClass(manage::class);
		$manager = $reflection->newInstanceWithoutConstructor();
		$user ??= new \phpbb\user();
		$reflection->getProperty('db')->setValue($manager, $db);
		$reflection->getProperty('user')->setValue($manager, $user);
		$reflection->getProperty('contests_table')->setValue($manager, 'phpbb_gallery_contests');
		$reflection->getProperty('images_table')->setValue($manager, 'phpbb_gallery_images');

		return $manager;
	}
}
