<?php
/**
 * phpBB Gallery Contest winner route tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\controller\winners;
use phpbbgallery\contest\event\index_listener;
use phpbbgallery\contest\winner_search;
use PHPUnit\Framework\TestCase;

final class winner_controller_test extends TestCase
{
	public function test_addon_owns_the_legacy_winner_route_names(): void
	{
		$addon_routes = (string) file_get_contents(dirname(__DIR__) . '/config/routing.yml');
		$core_routes = (string) file_get_contents(dirname(__DIR__, 2) . '/core/config/routing.yml');

		$this->assertStringContainsString('phpbbgallery_core_search_contests:', $addon_routes);
		$this->assertStringContainsString('phpbbgallery.contest.controller.winners:base', $addon_routes);
		$this->assertStringNotContainsString('phpbbgallery_core_search_contests:', $core_routes);
	}

	public function test_controller_contract_is_typed_and_checks_phpbb_search_permission(): void
	{
		$reflection = new \ReflectionClass(winners::class);
		$this->assertSame('int', (string) $reflection->getMethod('base')->getParameters()[0]->getType());
		$this->assertSame(
			'Symfony\\Component\\HttpFoundation\\Response',
			(string) $reflection->getMethod('base')->getReturnType()
		);

		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/winners.php');
		$this->assertStringContainsString("acl_get('u_search')", $source);
		$this->assertStringContainsString("['load_search']", $source);
		$this->assertStringContainsString('$this->winner_search->display(', $source);
	}

	public function test_index_listener_adds_link_only_when_winners_are_visible(): void
	{
		$config = new \phpbb\config\config(['load_search' => 1]);
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$auth->method('acl_get')->with('u_search')->willReturn(true);
		$search = $this->createMock(winner_search::class);
		$search->method('has_visible_winners')->willReturn(true);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->method('route')->willReturn('/gallery/search/contests');
		$event = new \phpbb\event\data(['dropdown_links' => ['U_GALLERY_SEARCH' => '/gallery/search']]);

		(new index_listener($auth, $config, $helper, $search))->add_winner_search_link($event);

		$this->assertSame('/gallery/search/contests', $event['dropdown_links']['U_G_SEARCH_CONTESTS']);
	}
}
