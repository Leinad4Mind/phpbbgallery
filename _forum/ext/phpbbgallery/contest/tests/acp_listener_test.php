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
		$listener = new acp_listener($language);
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
			['title', 'items_per_page', 'allow_contests', 'allow_comments'],
			array_keys($settings)
		);
		$this->assertSame('CONTEST_CREATION', $settings['allow_contests']['lang']);
		$this->assertSame('radio:yes_no', $settings['allow_contests']['type']);
	}

	public function test_listener_ignores_other_configuration_modes(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->never())->method('add_lang');
		$listener = new acp_listener($language);
		$event = new \phpbb\event\data([
			'mode' => 'image',
			'return_ary' => ['vars' => []],
		]);

		$listener->add_config($event);

		$this->assertSame(['vars' => []], $event['return_ary']);
	}
}
