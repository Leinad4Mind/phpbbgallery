<?php
/**
 * phpBB Gallery Contest ACP listener tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\event\acp_listener;
use PHPUnit\Framework\TestCase;

final class acp_listener_test extends TestCase
{
	public function test_listener_adds_contest_switch_after_general_pagination_setting(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with('contest_acp', 'phpbbgallery/contest');
		$listener = $this->listener($language);
		$event = new \phpbb\event\data([
			'mode' => 'main',
			'return_ary' => [
				'vars' => [
					'GALLERY_CONFIG' => [
						'title' => ['lang' => 'GALLERY_TITLE'],
						'items_per_page' => ['lang' => 'ITEMS_PER_PAGE'],
						'allow_comments' => ['lang' => 'COMMENT_SYSTEM'],
					],
				],
			],
		]);

		$listener->add_config($event);

		$settings = $event['return_ary']['vars']['GALLERY_CONFIG'];
		$this->assertSame(
			['title', 'items_per_page', 'allow_contests', 'contest_winner_thumbnail', 'allow_comments'],
			array_keys($settings)
		);
		$this->assertSame('CONTEST_CREATION', $settings['allow_contests']['lang']);
		$this->assertSame('radio:yes_no', $settings['allow_contests']['type']);
		$this->assertSame('contest', $settings['allow_contests']['addon']['id']);
		$this->assertSame('#c2410c', $settings['allow_contests']['addon']['accent']);
		$this->assertSame('CONTEST_WINNER_THUMBNAIL', $settings['contest_winner_thumbnail']['lang']);
		$this->assertSame('radio:yes_no', $settings['contest_winner_thumbnail']['type']);
	}

	public function test_listener_ignores_other_configuration_modes(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->never())->method('add_lang');
		$listener = $this->listener($language);
		$event = new \phpbb\event\data([
			'mode' => 'image',
			'return_ary' => ['vars' => []],
		]);

		$listener->add_config($event);

		$this->assertSame(['vars' => []], $event['return_ary']);
	}

	public function test_listener_owns_album_type_request_defaults_and_template_data(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/event/acp_listener.php');
		$core = (string) file_get_contents(dirname(__DIR__, 2) . '/core/acp/albums_module.php');

		$this->assertStringContainsString("variable('contest_start', '')", $source);
		$this->assertStringContainsString("'contest_rating' => 3 * 86400", $source);
		$this->assertStringContainsString("'contest_winner_thumbnail' => manager::THUMBNAIL_INHERIT", $source);
		$this->assertStringContainsString("get_contest((int) \$album_data['album_id'], 'album')", $source);
		$this->assertStringContainsString("'S_ALBUM_CONTEST'", $source);
		$this->assertSame(4, substr_count($source, "'Y-m-d\\TH:i'"));
		$this->assertStringContainsString('(intdiv(time(), 60) + 1) * 60', $source);
		$this->assertGreaterThanOrEqual(4, substr_count($source, '$this->load_acp_language();'));
		$this->assertStringContainsString("'album_type_data'", $core);
		$this->assertStringNotContainsString("variable('contest_start', '')", $core);
		$this->assertStringNotContainsString("get('phpbbgallery.core.contest')", $core);
	}

	public function test_album_thumbnail_policy_request_is_normalized_and_defaults_to_inherit(): void
	{
		$request = $this->createStub(\phpbb\request\request_interface::class);
		$request->method('variable')->willReturnMap([
			['contest_start', '', '2026-08-01 10:00'],
			['contest_rating', '', '2026-08-02 10:00'],
			['contest_end', '', '2026-08-03 10:00'],
			['contest_winner_thumbnail', \phpbbgallery\contest\manager::THUMBNAIL_INHERIT, 99],
		]);
		$listener = new acp_listener(
			$this->createStub(\phpbb\language\language::class),
			$request,
			$this->createStub(\phpbb\template\template::class),
			$this->createStub(\phpbb\user::class),
			$this->createStub(\phpbbgallery\contest\manager::class)
		);
		$request_event = new \phpbb\event\data(['album_type_data' => []]);
		$default_event = new \phpbb\event\data(['album_type_data' => []]);
		$before = time();

		$listener->request_album_type_data($request_event);
		$listener->default_album_type_data($default_event);

		$this->assertSame(
			\phpbbgallery\contest\manager::THUMBNAIL_INHERIT,
			$request_event['album_type_data']['contest_winner_thumbnail']
		);
		$this->assertSame(
			\phpbbgallery\contest\manager::THUMBNAIL_INHERIT,
			$default_event['album_type_data']['contest_winner_thumbnail']
		);
		$this->assertGreaterThan($before, $default_event['album_type_data']['contest_start']);
		$this->assertLessThanOrEqual($before + 60, $default_event['album_type_data']['contest_start']);
		$this->assertSame(0, $default_event['album_type_data']['contest_start'] % 60);
	}

	public function test_existing_contest_locks_the_album_type_selector(): void
	{
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_vars')
			->with($this->callback(static function (array $vars): bool
			{
				return $vars['S_ALBUM_ORIG_CONTEST'] === true
					&& $vars['S_ALBUM_CONTEST'] === true;
			}));
		$template->expects($this->once())->method('assign_block_vars');
		$user = $this->createStub(\phpbb\user::class);
		$user->method('format_date')->willReturn('2026-08-20T12:00');
		$listener = new acp_listener(
			$language,
			$this->createStub(\phpbb\request\request_interface::class),
			$template,
			$user,
			$this->createStub(\phpbbgallery\contest\manager::class)
		);
		$event = new \phpbb\event\data([
			'album_data' => ['album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE],
			'album_type_data' => [
				'contest_start' => time() + 3600,
				'contest_rating' => 3600,
				'contest_end' => 7200,
			],
			'old_album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
			'album_type_locked' => false,
			'album_type_lock_explain' => '',
		]);

		$listener->send_album_type_to_template($event);

		$this->assertTrue($event['album_type_locked']);
		$this->assertSame('ALBUM_WITH_CONTEST_NO_TYPE_CHANGE', $event['album_type_lock_explain']);
	}

	public function test_listener_resyncs_contest_after_album_ratings_are_reset(): void
	{
		$manager = $this->createMock(\phpbbgallery\contest\manager::class);
		$manager->expects($this->once())->method('resync')->with(7);
		$listener = new acp_listener(
			$this->createStub(\phpbb\language\language::class),
			$this->createStub(\phpbb\request\request_interface::class),
			$this->createStub(\phpbb\template\template::class),
			$this->createStub(\phpbb\user::class),
			$manager
		);

		$listener->resync_contest_results(new \phpbb\event\data([
			'album_id' => 7,
			'image_ids' => [12, 34],
		]));
	}

	private function listener(\phpbb\language\language $language): acp_listener
	{
		return new acp_listener(
			$language,
			$this->createStub(\phpbb\request\request_interface::class),
			$this->createStub(\phpbb\template\template::class),
			$this->createStub(\phpbb\user::class),
			$this->createStub(\phpbbgallery\contest\manager::class)
		);
	}
}
