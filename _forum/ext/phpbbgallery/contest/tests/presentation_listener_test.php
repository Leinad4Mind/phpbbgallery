<?php
/**
 * phpBB Gallery Contest presentation listener tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\event\presentation_listener;
use PHPUnit\Framework\TestCase;

final class presentation_listener_test extends TestCase
{
	public function test_navigation_receives_contest_schedule(): void
	{
		$start = time() + 3600;
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')
			->willReturnCallback(static fn(string $key, string $date): string => $key . ':' . $date);
		$user = $this->createMock(\phpbb\user::class);
		$user->method('format_date')
			->willReturnCallback(static fn(int $timestamp): string => (string) $timestamp);
		$event = new \phpbb\event\data([
			'context' => 'navigation',
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_start' => $start,
				'contest_rating' => 600,
				'contest_end' => 1200,
			],
			'template_vars' => ['ALBUM_ID' => 7],
		]);

		(new presentation_listener($language, $user))->enrich_album_template_vars($event);

		$template_vars = (array) $event['template_vars'];
		$this->assertSame('CONTEST_STARTS:' . $start, $template_vars['ALBUM_CONTEST_START']);
		$this->assertSame('CONTEST_RATING_STARTS:' . ($start + 600), $template_vars['ALBUM_CONTEST_RATING']);
		$this->assertSame('CONTEST_ENDS:' . ($start + 1200), $template_vars['ALBUM_CONTEST_END']);
	}

	public function test_regular_album_is_not_modified(): void
	{
		$event = new \phpbb\event\data([
			'context' => 'navigation',
			'album_data' => ['album_type' => \phpbbgallery\core\block::TYPE_UPLOAD],
			'template_vars' => ['ALBUM_ID' => 8],
		]);
		$listener = new presentation_listener(
			$this->createStub(\phpbb\language\language::class),
			$this->createStub(\phpbb\user::class)
		);

		$listener->enrich_album_template_vars($event);

		$this->assertSame(['ALBUM_ID' => 8], $event['template_vars']);
	}
}
