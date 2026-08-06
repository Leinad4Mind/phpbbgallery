<?php
/**
 * phpBB Gallery - Notification recipient tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\notification\helper as notification_helper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;

final class notification_recipients_test extends TestCase
{
	public function test_status_outcomes_reach_author_and_status_team_without_duplicates_or_actor(): void
	{
		[$helper, $manager] = $this->create_helper([
			'm_status' => [5, 7, 8, 8],
		]);

		$helper->notify('approved', [
			'targets' => [6, 7],
			'album_id' => 10,
			'last_image' => 21,
		]);
		$helper->notify('not_approved', [
			'targets' => [6, 7],
			'album_id' => 10,
			'last_image' => 22,
		]);

		$this->assertSame([6, 7, 8], $manager->calls[0]['data']['user_ids']);
		$this->assertSame([6, 7, 8], $manager->calls[1]['data']['user_ids']);
	}

	public function test_pending_approval_and_reports_only_reach_the_relevant_permission_team(): void
	{
		[$helper, $manager] = $this->create_helper([
			'm_status' => [5, 7, 8],
			'm_report' => [5, 8, 10],
		]);

		$helper->notify('approval', [
			'album_id' => 10,
			'last_image' => 21,
			'uploader' => 6,
		]);
		$helper->notify('new_report', [
			'reported_album_id' => 10,
			'reported_image_id' => 21,
			'report_id' => 31,
			'reporter_id' => 10,
		]);

		$this->assertSame([7, 8], $manager->calls[0]['data']['user_ids']);
		$this->assertSame([8], $manager->calls[1]['data']['user_ids']);
	}

	public function test_comments_reach_watchers_and_comment_moderators_but_not_the_poster(): void
	{
		[$helper, $manager] = $this->create_helper(
			['m_comments' => [5, 8, 9]],
			[6, 8, 10]
		);

		$helper->notify('new_comment', [
			'image_id' => 21,
			'album_id' => 10,
			'comment_id' => 41,
			'poster_id' => 10,
		]);

		$this->assertSame([6, 8, 9], $manager->calls[0]['data']['user_ids']);
	}

	public function test_direct_and_moderated_publication_do_not_duplicate_status_notifications(): void
	{
		[$helper, $manager] = $this->create_helper(
			['m_status' => [5, 8]],
			[],
			[6, 7, 8, 9]
		);

		$data = [
			'targets' => [6],
			'album_id' => 10,
			'last_image' => 21,
		];
		$helper->new_image($data);

		$this->assertSame([7, 8, 9], $manager->calls[0]['data']['user_ids']);

		[$helper, $manager] = $this->create_helper(
			['m_status' => [5, 8]],
			[],
			[6, 7, 8, 9]
		);
		$helper->new_image($data, false);
		$this->assertSame([7, 9], $manager->calls[0]['data']['user_ids']);
	}

	public function test_moderation_actions_group_rows_and_use_action_specific_permissions(): void
	{
		[$helper, $manager] = $this->create_helper([
			'm_delete' => [5, 8],
		]);

		$helper->notify_moderation('deleted', [
			['image_id' => 21, 'image_album_id' => 10, 'image_user_id' => 6],
			['image_id' => 22, 'image_album_id' => 10, 'image_user_id' => 7],
			['image_id' => 23, 'image_album_id' => 10, 'image_user_id' => 7],
		], 'm_delete', true);

		$this->assertCount(1, $manager->calls);
		$this->assertSame('phpbbgallery.core.notification.image_moderated', $manager->calls[0]['type']);
		$this->assertSame([8, 6, 7], $manager->calls[0]['data']['user_ids']);
		$this->assertSame(23, $manager->calls[0]['data']['last_image_id']);
		$this->assertSame('deleted', $manager->calls[0]['data']['action']);
	}

	/**
	 * @return array{notification_helper, object}
	 */
	private function create_helper(array $permissions, array $image_watchers = [], array $album_watchers = []): array
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$result_rows = [];
		if ($image_watchers)
		{
			$result_rows['image_result'] = array_map(static fn(int $id): array => ['user_id' => $id], $image_watchers);
		}
		if ($album_watchers)
		{
			$result_rows['album_result'] = array_map(static fn(int $id): array => ['user_id' => $id], $album_watchers);
		}
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use ($result_rows): string
		{
			return str_contains($sql, 'image_id') && isset($result_rows['image_result']) ? 'image_result' : 'album_result';
		});
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use (&$result_rows): array|false
		{
			$row = array_shift($result_rows[$result]);
			return $row === null ? false : $row;
		});

		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->method('acl_users_ids')->willReturnCallback(
			static fn(string $permission, int $album_id): array => $permissions[$permission] ?? []
		);
		$album_loader = $this->createMock(\phpbbgallery\core\album\loader::class);
		$album_loader->method('get')->willReturn(['album_name' => 'Album']);
		$controller_helper = $this->createMock(\phpbb\controller\helper::class);
		$controller_helper->method('route')->willReturn('/gallery/album/10');
		$url = $this->createMock(\phpbbgallery\core\url::class);
		$url->method('get_uri')->willReturnArgument(0);

		$user = new \phpbb\user();
		$user->data['user_id'] = 5;
		$manager = new class {
			public array $calls = [];

			public function add_notifications(string $type, array $data): void
			{
				$this->calls[] = ['type' => $type, 'data' => $data];
			}
		};
		$container = new Container();
		$container->set('notification_manager', $manager);

		$reflection = new \ReflectionClass(notification_helper::class);
		$helper = $reflection->newInstanceWithoutConstructor();
		foreach ([
			'db' => $db,
			'user' => $user,
			'gallery_auth' => $gallery_auth,
			'album_load' => $album_loader,
			'helper' => $controller_helper,
			'url' => $url,
			'phpbb_container' => $container,
			'watch_table' => 'gallery_watch',
		] as $property => $value)
		{
			$reflection->getProperty($property)->setValue($helper, $value);
		}

		return [$helper, $manager];
	}
}
