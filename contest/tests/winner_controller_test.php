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

		$this->assertStringContainsString('phpbbgallery_contest_search:', $addon_routes);
		$this->assertStringContainsString('phpbbgallery.contest.controller.winners:base', $addon_routes);
		$this->assertStringNotContainsString('phpbbgallery_contest_search:', $core_routes);
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
		$this->assertStringContainsString("get('items_per_page')", $source);
		$this->assertStringNotContainsString("get('album_rows')", $source);
		$this->assertStringContainsString('$this->winner_search->display(', $source);
		$this->assertStringContainsString("'@phpbbgallery_core/gallery/search_results.html'", $source);
	}

	public function test_core_search_has_no_contest_dependency_and_templates_support_placeholders(): void
	{
		$core_root = dirname(__DIR__, 2) . '/core';
		$core_search = (string) file_get_contents($core_root . '/search.php');
		$core_controller = (string) file_get_contents($core_root . '/controller/search.php');
		$core_services = (string) file_get_contents($core_root . '/config/services.yml');

		$this->assertStringNotContainsString('contests_table', $core_search);
		$this->assertStringNotContainsString('contest_winners', $core_search);
		$this->assertStringNotContainsString('function contests', $core_controller);
		$service_start = strpos($core_services, '    phpbbgallery.core.search:');
		$service_end = strpos($core_services, '    phpbbgallery.core.image.selector:', $service_start ?: 0);
		$search_service = substr($core_services, $service_start, $service_end - $service_start);
		$this->assertStringNotContainsString('gallery_contests', $search_service);

		foreach (\gallery_test_existing_files([
			$core_root . '/styles/prosilver/template/gallery/search_results.html',
			$core_root . '/styles/BBOOTS/template/gallery/imageblock_polaroid.html',
			$core_root . '/styles/FLATBOOTS/template/gallery/imageblock_polaroid.html',
		]) as $template)
		{
			$source = (string) file_get_contents($template);
			$this->assertStringContainsString('S_IMAGE_AWARD_PLACEHOLDER', $source, $template);
			$this->assertStringContainsString('gallery-image-award-placeholder', $source, $template);
		}

		foreach (\gallery_test_existing_styles($core_root) as $style)
		{
			$results = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/search_results.html');
			$this->assertStringContainsString("'@phpbbgallery_core/gallery/gallery_header.html'", $results, $style);
			$this->assertStringContainsString("'@phpbbgallery_core/gallery/gallery_footer.html'", $results, $style);
		}
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
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with('contest', 'phpbbgallery/contest');
		$event = new \phpbb\event\data(['dropdown_links' => ['U_GALLERY_SEARCH' => '/gallery/search']]);

		(new index_listener($auth, $config, $helper, $language, $search))->add_winner_search_link($event);

		$this->assertSame('/gallery/search/contests', $event['dropdown_links']['U_G_SEARCH_CONTESTS']);
	}
}
