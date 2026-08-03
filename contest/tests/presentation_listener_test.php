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

	public function test_private_contest_identity_receives_contest_label(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->with('CONTEST_USERNAME')->willReturn('<strong>Contest</strong>');
		$listener = new presentation_listener($language, $this->createStub(\phpbb\user::class));
		$event = new \phpbb\event\data([
			'image_data' => [
				'image_contest' => \phpbbgallery\core\block::IN_CONTEST,
				'image_user_id' => 7,
			],
			'viewer_id' => 8,
			'can_moderate' => false,
			'label' => 'Hidden user',
		]);

		$listener->private_data_label($event);

		$this->assertSame('<strong>Contest</strong>', $event['label']);
	}

	public function test_private_contest_description_includes_end_date(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(
			static fn(string $key, string $date): string => $key . ':' . $date
		);
		$user = $this->createStub(\phpbb\user::class);
		$user->method('format_date')->willReturnCallback(static fn(int $timestamp): string => (string) $timestamp);
		$listener = new presentation_listener($language, $user);
		$event = new \phpbb\event\data([
			'image_data' => [
				'image_contest' => \phpbbgallery\core\block::IN_CONTEST,
				'image_user_id' => 7,
			],
			'album_data' => ['contest_start' => 1_000, 'contest_end' => 300],
			'viewer_id' => 8,
			'can_moderate' => false,
			'description' => 'Hidden description',
		]);

		$listener->private_data_description($event);

		$this->assertSame('CONTEST_IMAGE_DESC:1300', $event['description']);
	}

	public function test_blocked_contest_comment_includes_start_date(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(
			static fn(string $key, string $date): string => $key . ':' . $date
		);
		$user = $this->createStub(\phpbb\user::class);
		$user->method('format_date')->willReturnCallback(static fn(int $timestamp): string => (string) $timestamp);
		$event = new \phpbb\event\data([
			'operation' => 'comment',
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_start' => 1_000,
				'contest_end' => 300,
			],
			'image_data' => ['image_id' => 7],
			'message' => 'Comments unavailable',
		]);

		(new presentation_listener($language, $user))->album_operation_message($event);

		$this->assertSame('CONTEST_COMMENTS_STARTS:1300', $event['message']);
	}

	public function test_contest_rank_becomes_generic_image_award(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$event = new \phpbb\event\data([
			'image_data' => ['image_contest_rank' => 2],
			'rank' => 0,
			'label' => '',
			'title' => '',
		]);

		(new presentation_listener($language, $this->createStub(\phpbb\user::class)))->image_award($event);

		$this->assertSame(2, $event['rank']);
		$this->assertSame('CONTEST_RESULT_2', $event['label']);
		$this->assertSame('CONTEST_RESULT', $event['title']);
	}
}
