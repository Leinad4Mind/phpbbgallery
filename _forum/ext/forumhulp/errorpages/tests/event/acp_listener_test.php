<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\tests\event;

use forumhulp\errorpages\event\acp_listener;
use phpbb\event\data;
use phpbb\language\language;
use PHPUnit\Framework\TestCase;

class acp_listener_test extends TestCase
{
	public function test_settings_are_inserted_before_submit_legend()
	{
		$language = $this->createMock(language::class);
		$language->expects(self::once())->method('add_lang')->with('info_acp_errorpages', 'forumhulp/errorpages');
		$listener = new acp_listener($language);
		$event = new data([
			'mode' => 'features',
			'display_vars' => [
				'title' => 'ACP_BOARD_FEATURES',
				'vars' => [
					'legend1' => 'ACP_BOARD_FEATURES',
					'allow_quick_reply' => [],
					'legend2' => 'ACP_SUBMIT_CHANGES',
				],
			],
		]);

		$listener->load_config_on_setup($event);

		$keys = array_keys($event['display_vars']['vars']);
		self::assertSame([
			'legend1',
			'allow_quick_reply',
			'error_pages_explain',
			'error_pages_log',
			'legend2',
		], $keys);
		self::assertSame('bool', $event['display_vars']['vars']['error_pages_log']['validate']);
	}

	public function test_other_modes_are_ignored()
	{
		$language = $this->createMock(language::class);
		$language->expects(self::never())->method('add_lang');
		$listener = new acp_listener($language);
		$event = new data(['mode' => 'email', 'display_vars' => ['vars' => []]]);

		$listener->load_config_on_setup($event);

		self::assertSame([], $event['display_vars']['vars']);
	}
}
