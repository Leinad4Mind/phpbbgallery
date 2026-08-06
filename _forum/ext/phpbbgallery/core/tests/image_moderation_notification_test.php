<?php
/**
 * phpBB Gallery - Image moderation notification tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\block;
use phpbbgallery\core\image\image;
use phpbbgallery\core\log;
use phpbbgallery\core\notification\helper as notification_helper;
use PHPUnit\Framework\TestCase;

final class image_moderation_notification_test extends TestCase
{
	public function test_unlock_restores_counters_logs_and_notifies_only_status_moderators(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturnCallback(
			static fn(string $field, array $values): string => $field . ' IN (' . implode(', ', $values) . ')'
		);
		$db->expects($this->exactly(2))->method('sql_query')->willReturnOnConsecutiveCalls('select', 'update');
		$db->expects($this->exactly(2))->method('sql_fetchrow')->with('select')->willReturnOnConsecutiveCalls([
			'image_id' => 21,
			'image_name' => 'Locked image',
			'image_user_id' => 6,
			'image_album_id' => 10,
			'image_filename' => 'locked.jpg',
			'previous_status' => block::STATUS_LOCKED,
		], false);
		$db->expects($this->once())->method('sql_freeresult')->with('select');

		$gallery_log = $this->createMock(log::class);
		$gallery_log->expects($this->once())->method('add_log')->with(
			'moderator',
			'unlock',
			10,
			21,
			['LOG_GALLERY_UNLOCKED', 'Locked image']
		);
		$notifications = $this->createMock(notification_helper::class);
		$notifications->expects($this->never())->method('notify');
		$notifications->expects($this->never())->method('new_image');
		$notifications->expects($this->once())->method('notify_moderation')->with(
			'unlocked',
			$this->callback(static fn(array $rows): bool => count($rows) === 1 && $rows[0]['image_id'] === 21),
			'm_status'
		);
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->expects($this->once())->method('trigger_event')
			->with('phpbbgallery.core.image.state_changed', $this->isType('array'))
			->willReturnArgument(1);

		$image = new class extends image {
			public array $counter_calls = [];

			public function __construct()
			{
			}

			public function handle_counter(array|int $image_id_ary, bool $add, bool $readd = false): void
			{
				$this->counter_calls[] = [$image_id_ary, $add, $readd];
			}
		};
		$reflection = new \ReflectionClass(image::class);
		foreach ([
			'db' => $db,
			'gallery_log' => $gallery_log,
			'notification_helper' => $notifications,
			'phpbb_dispatcher' => $dispatcher,
			'table_images' => 'gallery_images',
		] as $property => $value)
		{
			$reflection->getProperty($property)->setValue($image, $value);
		}

		$image->approve_images([21], 10);

		$this->assertSame([
			[[21], true, false],
		], $image->counter_calls);
	}
}
