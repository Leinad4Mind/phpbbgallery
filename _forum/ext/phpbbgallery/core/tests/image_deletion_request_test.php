<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\album;
use phpbbgallery\core\block;
use phpbbgallery\core\cache;
use phpbbgallery\core\config;
use phpbbgallery\core\image\image;
use phpbbgallery\core\user;
use PHPUnit\Framework\TestCase;

class image_deletion_request_test extends TestCase
{
	public function test_owner_request_hides_image_and_balances_visible_counters(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))->method('sql_query')->willReturnOnConsecutiveCalls(1, 2);
		$db->expects($this->once())->method('sql_fetchrow')->with(1)->willReturn([
			'image_id' => 12,
			'image_album_id' => 7,
			'image_user_id' => 10,
			'image_status' => block::STATUS_APPROVED,
			'image_comments' => 2,
		]);
		$db->expects($this->once())->method('sql_freeresult')->with(1);
		$db->expects($this->once())->method('sql_affectedrows')->willReturn(1);

		$gallery_user = $this->createMock(user::class);
		$gallery_user->expects($this->once())->method('set_user_id')->with(10, false);
		$gallery_user->expects($this->once())->method('update_images')->with(-1)->willReturn(true);

		$counter_calls = [];
		$gallery_config = $this->createMock(config::class);
		$gallery_config->expects($this->exactly(2))->method('dec')
			->willReturnCallback(static function (string $name, int $value) use (&$counter_calls): void
			{
				$counter_calls[$name] = $value;
			});

		$gallery_album = $this->createMock(album::class);
		$gallery_album->expects($this->once())->method('update_info')->with(7);
		$gallery_cache = $this->createMock(cache::class);
		$gallery_cache->expects($this->once())->method('destroy_images');
		$dispatcher = $this->dispatcher('delete_request', [7]);

		$service = $this->service($db, $gallery_album, $gallery_config, $gallery_cache, $gallery_user, $dispatcher);
		$result = $service->request_deletion(12, 10);

		$this->assertIsArray($result);
		$this->assertSame(block::STATUS_DELETE_REQUESTED, $result['image_status']);
		$this->assertSame(block::STATUS_APPROVED, $result['image_delete_previous_status']);
		$this->assertSame(['num_images' => 1, 'num_comments' => 2], $counter_calls);
	}

	public function test_non_owner_cannot_request_deletion(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_query')->willReturn(1);
		$db->expects($this->once())->method('sql_fetchrow')->willReturn([
			'image_id' => 12,
			'image_user_id' => 10,
			'image_status' => block::STATUS_APPROVED,
		]);
		$db->expects($this->once())->method('sql_freeresult');
		$db->expects($this->never())->method('sql_affectedrows');

		$service = $this->service(
			$db,
			$this->createMock(album::class),
			$this->createMock(config::class),
			$this->createMock(cache::class),
			$this->createMock(user::class),
			$this->createMock(\phpbb\event\dispatcher_interface::class)
		);

		$this->assertFalse($service->request_deletion(12, 11));
	}

	public function test_restore_preserves_previous_state_and_only_readds_visible_rows(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturn('image_id IN (12, 13)');
		$db->expects($this->exactly(3))->method('sql_query')->willReturnOnConsecutiveCalls(1, 2, 3);
		$rows = [
			[
				'image_id' => 12,
				'image_album_id' => 7,
				'image_user_id' => 10,
				'image_status' => block::STATUS_DELETE_REQUESTED,
				'image_delete_previous_status' => block::STATUS_APPROVED,
				'image_comments' => 2,
			],
			[
				'image_id' => 13,
				'image_album_id' => 8,
				'image_user_id' => 11,
				'image_status' => block::STATUS_DELETE_REQUESTED,
				'image_delete_previous_status' => block::STATUS_UNAPPROVED,
				'image_comments' => 3,
			],
			false,
		];
		$db->expects($this->exactly(3))->method('sql_fetchrow')
			->willReturnCallback(static function () use (&$rows)
			{
				return array_shift($rows);
			});
		$db->expects($this->once())->method('sql_freeresult')->with(1);
		$db->expects($this->exactly(2))->method('sql_affectedrows')->willReturn(1);

		$gallery_user = $this->createMock(user::class);
		$gallery_user->expects($this->once())->method('set_user_id')->with(10, false);
		$gallery_user->expects($this->once())->method('update_images')->with(1)->willReturn(true);
		$counter_calls = [];
		$gallery_config = $this->createMock(config::class);
		$gallery_config->expects($this->exactly(2))->method('inc')
			->willReturnCallback(static function (string $name, int $value) use (&$counter_calls): void
			{
				$counter_calls[$name] = $value;
			});

		$gallery_album = $this->createMock(album::class);
		$gallery_album->expects($this->once())->method('update_infos')->with([7, 8]);
		$gallery_cache = $this->createMock(cache::class);
		$gallery_cache->expects($this->once())->method('destroy_images');
		$dispatcher = $this->dispatcher('delete_restore', [7, 8]);

		$service = $this->service($db, $gallery_album, $gallery_config, $gallery_cache, $gallery_user, $dispatcher);

		$this->assertSame([12, 13], $service->restore_deletion_requests([12, 13, 13]));
		$this->assertSame(['num_images' => 1, 'num_comments' => 2], $counter_calls);
	}

	private function dispatcher(string $operation, array $album_ids): \phpbb\event\dispatcher_interface
	{
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->expects($this->once())->method('trigger_event')
			->with(
				'phpbbgallery.core.image.state_changed',
				$this->callback(static function (array $data) use ($operation, $album_ids): bool
				{
					return $data['operation'] === $operation && $data['album_ids'] === $album_ids;
				})
			)
			->willReturnCallback(static fn(string $event, array $data): array => $data);

		return $dispatcher;
	}

	private function service(
		\phpbb\db\driver\driver_interface $db,
		album $gallery_album,
		config $gallery_config,
		cache $gallery_cache,
		user $gallery_user,
		\phpbb\event\dispatcher_interface $dispatcher
	): image
	{
		$service = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function () use ($db, $gallery_album, $gallery_config, $gallery_cache, $gallery_user, $dispatcher): void
		{
			$this->db = $db;
			$this->album = $gallery_album;
			$this->gallery_config = $gallery_config;
			$this->gallery_cache = $gallery_cache;
			$this->gallery_user = $gallery_user;
			$this->phpbb_dispatcher = $dispatcher;
			$this->table_images = 'gallery_images';
		}, $service, image::class);
		$initialize();

		return $service;
	}
}
