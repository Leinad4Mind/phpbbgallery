<?php
/**
 * phpBB Gallery - topic and private-message mini-profile tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\event\mini_profile_listener;
use PHPUnit\Framework\TestCase;

final class mini_profile_listener_test extends TestCase
{
	public function test_listener_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(mini_profile_listener::class);
		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), $property->getName());
		}
		foreach ($reflection->getMethods() as $method)
		{
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), $method->getName() . '($' . $parameter->getName() . ')');
			}
			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), $method->getName());
			}
		}
	}

	public function test_subscribed_events_cover_topics_and_private_messages(): void
	{
		$this->assertSame([
			'core.viewtopic_modify_post_data' => 'preload_viewtopic',
			'core.viewtopic_modify_post_row' => 'display_viewtopic',
			'core.ucp_pm_view_message' => 'display_private_message',
		], mini_profile_listener::getSubscribedEvents());
	}

	public function test_topic_authors_are_loaded_in_batches_and_personal_links_are_permission_filtered(): void
	{
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->exactly(3))->method('route')->willReturnCallback(
			static fn(string $route, array $params = []): string => $route === 'phpbbgallery_core_album'
				? 'album:' . $params['album_id']
				: 'search:' . $params['user_id'][0]
		);
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$phpbb_auth->expects($this->once())->method('acl_get')->with('u_search')->willReturn(true);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_in_set')->with('user_id', [2, 3])->willReturn('user_id IN (2, 3)');
		$db->expects($this->once())->method('sql_query')->with($this->stringContains('user_id IN (2, 3)'))->willReturn('albums');
		$db->expects($this->exactly(3))->method('sql_fetchrow')->with('albums')->willReturnOnConsecutiveCalls(
			['user_id' => 2, 'personal_album_id' => 31],
			['user_id' => 3, 'personal_album_id' => 32],
			false
		);
		$db->expects($this->once())->method('sql_freeresult')->with('albums');
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())->method('acl_album_ids')->with('i_view')->willReturn([31]);
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([]);
		$gallery_config = $this->createMock(\phpbbgallery\core\config::class);
		$gallery_config->method('get')->willReturnMap([
			['viewtopic_images', 1],
			['viewtopic_icon', 1],
			['viewtopic_link', 1],
		]);
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->once())->method('user_image_counts')->with([2, 3])->willReturn([2 => 5, 3 => 0]);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$listener = new mini_profile_listener(
			$helper,
			$phpbb_auth,
			new \phpbb\config\config(['load_search' => true]),
			$user,
			$db,
			$gallery_auth,
			$gallery_config,
			$gallery_search,
			'gallery_users'
		);

		$listener->preload_viewtopic(new \phpbb\event\data(['user_cache' => [ANONYMOUS => [], 2 => [], 3 => []]]));
		$first = new \phpbb\event\data(['poster_id' => 2, 'post_row' => ['POST_ID' => 10]]);
		$listener->display_viewtopic($first);
		$second = new \phpbb\event\data(['poster_id' => 3, 'post_row' => ['POST_ID' => 11]]);
		$listener->display_viewtopic($second);

		$this->assertTrue($first['post_row']['S_GALLERY_IMAGE_COUNT']);
		$this->assertSame(5, $first['post_row']['POSTER_GALLERY_IMAGES']);
		$this->assertSame('search:2', $first['post_row']['U_POSTER_GALLERY_SEARCH']);
		$this->assertSame('album:31', $first['post_row']['U_POSTER_PERSONAL_ALBUM']);
		$this->assertSame(0, $second['post_row']['POSTER_GALLERY_IMAGES']);
		$this->assertSame('', $second['post_row']['U_POSTER_PERSONAL_ALBUM']);
	}

	public function test_private_message_uses_the_same_visible_count_contract(): void
	{
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->once())->method('route')->with('phpbbgallery_core_search', ['user_id' => [4], 'submit' => 1])->willReturn('/gallery/search?user_id=4');
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$phpbb_auth->method('acl_get')->with('u_search')->willReturn(true);
		$gallery_config = $this->createMock(\phpbbgallery\core\config::class);
		$gallery_config->method('get')->willReturnMap([
			['viewtopic_images', 1],
			['viewtopic_icon', 0],
			['viewtopic_link', 1],
		]);
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->once())->method('user_image_counts')->with([4])->willReturn([4 => 2]);
		$listener = $this->listener($helper, $phpbb_auth, $gallery_config, $gallery_search);
		$event = new \phpbb\event\data([
			'user_info' => ['user_id' => 4],
			'message_row' => ['author_id' => 4],
			'msg_data' => ['MESSAGE_ID' => 8],
		]);

		$listener->display_private_message($event);

		$this->assertTrue($event['msg_data']['S_GALLERY_IMAGE_COUNT']);
		$this->assertSame(2, $event['msg_data']['POSTER_GALLERY_IMAGES']);
		$this->assertSame('/gallery/search?user_id=4', $event['msg_data']['U_POSTER_GALLERY_SEARCH']);
		$this->assertSame('', $event['msg_data']['U_POSTER_PERSONAL_ALBUM']);
	}

	public function test_disabled_options_add_safe_empty_variables_without_queries(): void
	{
		$gallery_config = $this->createMock(\phpbbgallery\core\config::class);
		$gallery_config->method('get')->willReturnMap([
			['viewtopic_images', 0],
			['viewtopic_icon', 0],
		]);
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->never())->method('user_image_counts');
		$listener = $this->listener(
			$this->createStub(\phpbb\controller\helper::class),
			$this->createStub(\phpbb\auth\auth::class),
			$gallery_config,
			$gallery_search
		);
		$event = new \phpbb\event\data(['poster_id' => 2, 'post_row' => []]);

		$listener->display_viewtopic($event);

		$this->assertFalse($event['post_row']['S_GALLERY_IMAGE_COUNT']);
		$this->assertSame('', $event['post_row']['POSTER_GALLERY_IMAGES']);
		$this->assertSame('', $event['post_row']['U_POSTER_GALLERY_SEARCH']);
		$this->assertSame('', $event['post_row']['U_POSTER_PERSONAL_ALBUM']);
	}

	private function listener(
		\phpbb\controller\helper $helper,
		\phpbb\auth\auth $phpbb_auth,
		\phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\search $gallery_search
	): mini_profile_listener
	{
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];

		return new mini_profile_listener(
			$helper,
			$phpbb_auth,
			new \phpbb\config\config(['load_search' => true]),
			$user,
			$this->createStub(\phpbb\db\driver\driver_interface::class),
			$this->createStub(\phpbbgallery\core\auth\auth::class),
			$gallery_config,
			$gallery_search,
			'gallery_users'
		);
	}
}
