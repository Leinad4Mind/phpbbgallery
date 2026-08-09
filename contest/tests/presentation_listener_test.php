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
				'album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
				'contest_start' => $start,
				'contest_rating' => 600,
				'contest_end' => 1200,
			],
			'template_vars' => ['ALBUM_ID' => 7],
		]);

		(new presentation_listener(
			$language,
			$user,
			$this->createStub(\phpbb\controller\helper::class)
		))->enrich_album_template_vars($event);

		$template_vars = (array) $event['template_vars'];
		$this->assertTrue($template_vars['S_ALBUM_TYPE_DETAILS']);
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
			$this->createStub(\phpbb\user::class),
			$this->createStub(\phpbb\controller\helper::class)
		);

		$listener->enrich_album_template_vars($event);

		$this->assertSame(['ALBUM_ID' => 8], $event['template_vars']);
	}

	public function test_album_list_uses_the_validated_winner_without_changing_chronology(): void
	{
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->exactly(2))
			->method('route')
			->willReturnMap([
				['phpbbgallery_core_image_file_mini', ['image_id' => 71], '/gallery/image/71/mini'],
				['phpbbgallery_core_image', ['image_id' => 71], '/gallery/image/71'],
			]);
		$event = new \phpbb\event\data([
			'context' => 'album_list',
			'album_data' => [
				'album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
				'contest_thumbnail_image_id' => 71,
				'album_image' => '',
			],
			'template_vars' => [
				'UC_THUMBNAIL' => '/gallery/image/99/mini',
				'UC_FAKE_THUMBNAIL' => '/gallery/image/99/mini',
				'UC_IMAGE_URL' => '/gallery/image/99',
				'LAST_IMAGE_TIME' => 'Yesterday',
				'LAST_USER_FULL' => 'Latest author',
			],
		]);
		$listener = new presentation_listener(
			$this->createStub(\phpbb\language\language::class),
			$this->createStub(\phpbb\user::class),
			$helper
		);

		$listener->enrich_album_template_vars($event);

		$this->assertSame('/gallery/image/71/mini', $event['template_vars']['UC_THUMBNAIL']);
		$this->assertSame('/gallery/image/71/mini', $event['template_vars']['UC_FAKE_THUMBNAIL']);
		$this->assertSame('/gallery/image/71', $event['template_vars']['UC_IMAGE_URL']);
		$this->assertSame('Yesterday', $event['template_vars']['LAST_IMAGE_TIME']);
		$this->assertSame('Latest author', $event['template_vars']['LAST_USER_FULL']);
	}

	public function test_manual_album_image_and_disabled_thumbnails_keep_core_presentation(): void
	{
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$listener = new presentation_listener(
			$this->createStub(\phpbb\language\language::class),
			$this->createStub(\phpbb\user::class),
			$helper
		);
		foreach ([
			['album_image' => 'images/custom.png', 'UC_THUMBNAIL' => '/custom.png'],
			['album_image' => '', 'UC_THUMBNAIL' => ''],
		] as $case)
		{
			$event = new \phpbb\event\data([
				'context' => 'album_list',
				'album_data' => [
					'contest_thumbnail_image_id' => 71,
					'album_image' => $case['album_image'],
				],
				'template_vars' => ['UC_THUMBNAIL' => $case['UC_THUMBNAIL']],
			]);
			$listener->enrich_album_template_vars($event);
			$this->assertSame($case['UC_THUMBNAIL'], $event['template_vars']['UC_THUMBNAIL']);
		}
	}

	public function test_private_contest_identity_receives_contest_label(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->with('CONTEST_USERNAME')->willReturn('<strong>Contest</strong>');
		$listener = new presentation_listener(
			$language,
			$this->createStub(\phpbb\user::class),
			$this->createStub(\phpbb\controller\helper::class)
		);
		$event = new \phpbb\event\data([
			'image_data' => [
				'image_contest' => \phpbbgallery\contest\manager::STATE_ACTIVE,
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
		$listener = new presentation_listener(
			$language,
			$user,
			$this->createStub(\phpbb\controller\helper::class)
		);
		$event = new \phpbb\event\data([
			'image_data' => [
				'image_contest' => \phpbbgallery\contest\manager::STATE_ACTIVE,
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

	public function test_hidden_contest_results_receive_compact_and_detailed_messages(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(
			static fn(string $key, string $date = ''): string => $key . ($date !== '' ? ':' . $date : '')
		);
		$user = $this->createStub(\phpbb\user::class);
		$user->method('format_date')->willReturnCallback(static fn(int $timestamp): string => (string) $timestamp);
		$listener = new presentation_listener(
			$language,
			$user,
			$this->createStub(\phpbb\controller\helper::class)
		);
		$base = [
			'image_data' => ['image_contest' => \phpbbgallery\contest\manager::STATE_ACTIVE],
			'album_data' => ['contest_start' => 1_000, 'contest_end' => 300],
			'can_moderate' => false,
			'message' => 'Results hidden',
		];
		$compact = new \phpbb\event\data($base + ['detailed' => false]);
		$detailed = new \phpbb\event\data($base + ['detailed' => true]);

		$listener->hidden_results_message($compact);
		$listener->hidden_results_message($detailed);

		$this->assertSame('CONTEST_RATING_HIDDEN', $compact['message']);
		$this->assertSame('CONTEST_RESULT_HIDDEN:1300', $detailed['message']);
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
				'album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
				'contest_start' => 1_000,
				'contest_end' => 300,
			],
			'image_data' => ['image_id' => 7],
			'message' => 'Comments unavailable',
		]);

		(new presentation_listener(
			$language,
			$user,
			$this->createStub(\phpbb\controller\helper::class)
		))->album_operation_message($event);

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

		(new presentation_listener(
			$language,
			$this->createStub(\phpbb\user::class),
			$this->createStub(\phpbb\controller\helper::class)
		))->image_award($event);

		$this->assertSame(2, $event['rank']);
		$this->assertSame('CONTEST_RESULT_2', $event['label']);
		$this->assertSame('CONTEST_RESULT', $event['title']);
	}
}
