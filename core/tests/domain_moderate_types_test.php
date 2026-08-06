<?php
/**
 * phpBB Gallery - Core moderation domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\comment;
use phpbbgallery\core\image\image;
use phpbbgallery\core\moderate;
use phpbbgallery\core\notification;
use phpbbgallery\core\notification\helper as notification_helper;
use phpbbgallery\core\rating;
use phpbbgallery\core\report;
use PHPUnit\Framework\TestCase;

final class domain_moderate_types_test extends TestCase
{
	public function test_moderation_domain_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(moderate::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === moderate::class)
			{
				$this->assertNotNull($property->getType(), moderate::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== moderate::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), moderate::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$expected_return = match ($method->getName())
				{
					'delete_requested_images' => 'int',
					'load_notification_rows' => 'array',
					default => 'void',
				};
				$this->assertSame($expected_return, (string) $method->getReturnType(), moderate::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_image_deletion_delegates_to_every_domain_service(): void
	{
		$reflection = new \ReflectionClass(moderate::class);
		$moderate = $reflection->newInstanceWithoutConstructor();
		$images = [11, 14];
		$files = [11 => 'one.jpg', 14 => 'two.png'];
		$rating = $this->createMock(rating::class);
		$comment = $this->createMock(comment::class);
		$notification = $this->createMock(notification::class);
		$report = $this->createMock(report::class);
		$image = $this->createMock(image::class);

		$rating->expects($this->once())->method('loader')->with(0);
		$rating->expects($this->once())->method('delete_ratings')->with($images);
		$comment->expects($this->once())->method('delete_images')->with($images);
		$notification->expects($this->once())->method('delete_images')->with($images);
		$report->expects($this->once())->method('delete_images')->with($images);
		$image->expects($this->once())->method('delete_images')->with($images, $files);
		$image->expects($this->once())->method('handle_counter')->with($images, false);

		$reflection->getProperty('gallery_rating')->setValue($moderate, $rating);
		$reflection->getProperty('comment')->setValue($moderate, $comment);
		$reflection->getProperty('gallery_notification')->setValue($moderate, $notification);
		$reflection->getProperty('report')->setValue($moderate, $report);
		$reflection->getProperty('image')->setValue($moderate, $image);

		$moderate->delete_images($images, $files);
	}

	public function test_legacy_false_filename_map_is_normalized_before_image_deletion(): void
	{
		$reflection = new \ReflectionClass(moderate::class);
		$moderate = $reflection->newInstanceWithoutConstructor();
		$images = [21];
		$rating = $this->createStub(rating::class);
		$comment = $this->createStub(comment::class);
		$notification = $this->createStub(notification::class);
		$report = $this->createStub(report::class);
		$image = $this->createMock(image::class);

		$image->expects($this->once())->method('delete_images')->with($images, []);
		$image->expects($this->once())->method('handle_counter')->with($images, false);

		$reflection->getProperty('gallery_rating')->setValue($moderate, $rating);
		$reflection->getProperty('comment')->setValue($moderate, $comment);
		$reflection->getProperty('gallery_notification')->setValue($moderate, $notification);
		$reflection->getProperty('report')->setValue($moderate, $report);
		$reflection->getProperty('image')->setValue($moderate, $image);

		$moderate->delete_images($images, false);
	}

	public function test_requested_deletion_cleans_dependants_only_after_status_matched_delete(): void
	{
		$moderate = (new \ReflectionClass(moderate::class))->newInstanceWithoutConstructor();
		$requested = [11, 14];
		$deleted = [11];
		$rating = $this->createMock(rating::class);
		$comment = $this->createMock(comment::class);
		$notification = $this->createMock(notification::class);
		$report = $this->createMock(report::class);
		$image = $this->createMock(image::class);

		$image->expects($this->once())->method('delete_images_matching_status_ids')
			->with($requested, \phpbbgallery\core\block::STATUS_DELETE_REQUESTED)
			->willReturn($deleted);
		$rating->expects($this->once())->method('loader')->with(0);
		$rating->expects($this->once())->method('delete_ratings')->with($deleted);
		$comment->expects($this->once())->method('delete_images')->with($deleted);
		$notification->expects($this->once())->method('delete_images')->with($deleted);
		$report->expects($this->once())->method('delete_images')->with($deleted);

		$reflection = new \ReflectionClass(moderate::class);
		$reflection->getProperty('gallery_rating')->setValue($moderate, $rating);
		$reflection->getProperty('comment')->setValue($moderate, $comment);
		$reflection->getProperty('gallery_notification')->setValue($moderate, $notification);
		$reflection->getProperty('report')->setValue($moderate, $report);
		$reflection->getProperty('image')->setValue($moderate, $image);

		$this->assertSame(1, $moderate->delete_requested_images($requested));
	}

	public function test_moderated_deletion_notifies_author_and_delete_team_after_success(): void
	{
		$moderate = (new \ReflectionClass(moderate::class))->newInstanceWithoutConstructor();
		$images = [11];
		$row = [
			'image_id' => 11,
			'image_user_id' => 7,
			'image_album_id' => 3,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
		];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_in_set')->with('image_id', $images)->willReturn('image_id IN (11)');
		$db->expects($this->once())->method('sql_query')->willReturn('rows');
		$db->expects($this->exactly(2))->method('sql_fetchrow')->with('rows')->willReturnOnConsecutiveCalls($row, false);
		$db->expects($this->once())->method('sql_freeresult')->with('rows');
		$image = $this->createMock(image::class);
		$image->expects($this->once())->method('handle_counter')->with($images, false);
		$image->expects($this->once())->method('delete_images')->with($images, [])->willReturn(true);
		$helper = $this->createMock(notification_helper::class);
		$helper->expects($this->once())->method('notify_moderation')->with('deleted', [$row], 'm_delete', true);

		$reflection = new \ReflectionClass(moderate::class);
		foreach ([
			'db' => $db,
			'images_table' => 'gallery_images',
			'gallery_rating' => $this->createStub(rating::class),
			'comment' => $this->createStub(comment::class),
			'gallery_notification' => $this->createStub(notification::class),
			'report' => $this->createStub(report::class),
			'image' => $image,
			'notification_helper' => $helper,
		] as $property => $value)
		{
			$reflection->getProperty($property)->setValue($moderate, $value);
		}

		$moderate->delete_images($images);
	}

	public function test_waiting_queue_loads_album_names_in_the_listing_query(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/moderate.php');

		$this->assertStringContainsString("INNER JOIN ' . \$this->albums_table . ' a", $source);
		$this->assertStringContainsString("'album_name'     => \$row['album_name']", $source);
		$this->assertStringNotContainsString("get_info(\$image_data['image_album_id'])", $source);
	}
}
