<?php
/**
 * phpBB Gallery - Index controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\index;
use PHPUnit\Framework\TestCase;

final class controller_index_types_test extends TestCase
{
	public function test_index_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(index::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === index::class)
			{
				$this->assertNotNull($property->getType(), index::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== index::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), index::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), index::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_route_actions_return_responses_and_use_integer_pages(): void
	{
		$reflection = new \ReflectionClass(index::class);

		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('base')->getReturnType());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('personal')->getReturnType());
		$this->assertSame('int', (string) $reflection->getMethod('personal')->getParameters()[0]->getType());
		$this->assertSame('?Symfony\\Component\\HttpFoundation\\Response', (string) $reflection->getMethod('watch_all')->getReturnType());
		$this->assertSame('string', (string) $reflection->getMethod('watch_all')->getParameters()[0]->getType());
	}

	public function test_personal_gallery_pages_are_clamped_to_the_first_page(): void
	{
		$reflection = new \ReflectionClass(index::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_page');

		$this->assertSame(1, $normalizer->invoke($controller, -3));
		$this->assertSame(1, $normalizer->invoke($controller, 0));
		$this->assertSame(4, $normalizer->invoke($controller, 4));
	}

	public function test_rrc_mode_flags_remain_stable(): void
	{
		$this->assertSame(4, index::RRC_MODE_RECENT_COMMENTS);
		$this->assertSame(2, index::RRC_MODE_RANDOM_IMAGES);
		$this->assertSame(1, index::RRC_MODE_RECENT_IMAGES);
		$this->assertSame(8, index::RRC_MODE_MOST_VIEWED);
		$this->assertSame(16, index::RRC_MODE_TOP_RATED);
	}

	public function test_ranked_index_blocks_are_bounded_and_extensible(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertStringContainsString("'pegas_index_viewed_count'", $source);
		$this->assertStringContainsString("'pegas_index_rated_count'", $source);
		$this->assertStringContainsString("'most_viewed'", $source);
		$this->assertStringContainsString("'top_rated'", $source);
		$this->assertStringContainsString('phpbbgallery.core.index.image_blocks', $source);
	}

	public function test_personal_albums_are_only_emitted_when_enabled_on_the_index(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertStringContainsString('$show_personal_albums = (bool) $this->gallery_config->get(\'pegas_index_album\')', $source);
		$this->assertStringContainsString('if ($show_personal_albums)', $source);
		$this->assertStringContainsString('$this->assign_dropdown_links(\'phpbbgallery_core_index\', $show_personal_albums)', $source);
		$this->assertStringContainsString('$show_personal_albums ? \'PUBLIC_ALBUMS\' : \'ALBUMS\'', $source);
		$this->assertStringNotContainsString("'S_USERS_PERSONAL_GALLERIES'", $source);
		$this->assertStringNotContainsString('normalize_last_image', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$index_service = strstr($services, 'phpbbgallery.core.controller.index:');
		$index_service = strstr($index_service, 'phpbbgallery.core.controller.search:', true);
		$this->assertStringNotContainsString("- '@phpbbgallery.core.user'", $index_service);
		$this->assertStringNotContainsString("- '@phpbbgallery.core.image'", $index_service);
		$this->assertStringNotContainsString("- '@phpbbgallery.core.policy.image_visibility'", $index_service);
	}

	public function test_optional_index_links_are_added_through_neutral_event(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/index.php');

		$this->assertStringContainsString('phpbbgallery.core.index.dropdown_links', $source);
		$this->assertStringContainsString('$this->template->assign_vars($dropdown_links)', $source);
		$this->assertStringNotContainsString('has_visible_contest_winners()', $source);
		$this->assertStringNotContainsString("'U_G_SEARCH_CONTESTS'", $source);
	}

	public function test_bulk_subscriptions_only_include_visible_viewable_real_albums(): void
	{
		$reflection = new \ReflectionClass(index::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->exactly(2))
			->method('acl_album_ids')
			->willReturnCallback(static function (string $permission, string $return, bool $rrc, bool $personal): array
			{
				TestCase::assertSame('array', $return);
				TestCase::assertFalse($rrc);
				TestCase::assertFalse($personal);
				return $permission === 'a_list' ? [2, 3, 4, 5] : [3, 4, 5, 6];
			});
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([4]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('album_id', [3, 5])
			->willReturn('album_id IN (3, 5)');
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static function (string $sql): bool
			{
				return str_contains($sql, 'FROM gallery_albums')
					&& str_contains($sql, 'album_id IN (3, 5)')
					&& str_contains($sql, 'album_type <> 0');
			}))
			->willReturn('result');
		$db->expects($this->exactly(3))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls(['album_id' => '5'], ['album_id' => 3], false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$reflection->getProperty('gallery_auth')->setValue($controller, $gallery_auth);
		$reflection->getProperty('db')->setValue($controller, $db);
		$reflection->getProperty('table_albums')->setValue($controller, 'gallery_albums');

		$this->assertSame([5, 3], $reflection->getMethod('get_watchable_album_ids')->invoke($controller, false));
	}

	public function test_bulk_subscription_writes_are_limited_to_batches_of_250(): void
	{
		$reflection = new \ReflectionClass(index::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$album_ids = range(1, 501);

		foreach (['subscribe' => 'add_albums', 'unsubscribe' => 'remove_albums'] as $mode => $method)
		{
			$batches = [];
			$notifications = $this->createMock(\phpbbgallery\core\notification\helper::class);
			$notifications->expects($this->exactly(3))
				->method($method)
				->willReturnCallback(static function (array $batch) use (&$batches): void
				{
					$batches[] = $batch;
				});
			$reflection->getProperty('notifications_helper')->setValue($controller, $notifications);

			$reflection->getMethod('update_album_subscriptions')->invoke($controller, $mode, $album_ids);

			$this->assertSame([250, 250, 1], array_map('count', $batches), $mode);
			$this->assertSame($album_ids, array_merge(...$batches), $mode);
		}
	}

	public function test_bulk_subscription_route_is_confirmed_and_present_in_every_index_style(): void
	{
		$root = dirname(__DIR__);
		$routing = (string) file_get_contents($root . '/config/routing.yml');
		$services = (string) file_get_contents($root . '/config/services_controller.yml');
		$source = (string) file_get_contents($root . '/controller/index.php');

		$this->assertStringContainsString('phpbbgallery_core_index_watch_all:', $routing);
		$this->assertStringContainsString('mode: subscribe|unsubscribe', $routing);
		$this->assertStringContainsString("- '@phpbbgallery.core.notification.helper'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_albums%'", $services);
		$this->assertStringContainsString('if (confirm_box(true))', $source);
		$this->assertStringContainsString("'a_list', 'array', false, \$include_personal", $source);
		$this->assertStringContainsString("'i_view', 'array', false, \$include_personal", $source);
		$this->assertStringContainsString('get_exclude_zebra()', $source);
		$this->assertSame(2, substr_count($source, 'array_chunk($album_ids, 250)'));

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/styles/' . $style . '/template/gallery/index_body.html');
			$this->assertStringContainsString('{% if U_WATCH_ALL_ALBUMS %}', $template, $style);
			$this->assertStringContainsString('{{ WATCH_ALL_ALBUMS_LABEL }}', $template, $style);
			$this->assertStringContainsString('S_WATCHING_ALL_ALBUMS', $template, $style);
		}
	}
}
