<?php
/**
 * phpBB Gallery - Notification event type tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\notification\events\phpbbgallery_image_approved;
use phpbbgallery\core\notification\events\phpbbgallery_image_for_approval;
use phpbbgallery\core\notification\events\phpbbgallery_image_moderated;
use phpbbgallery\core\notification\events\phpbbgallery_image_not_approved;
use phpbbgallery\core\notification\events\phpbbgallery_image_removed;
use phpbbgallery\core\notification\events\phpbbgallery_new_comment;
use phpbbgallery\core\notification\events\phpbbgallery_new_image;
use phpbbgallery\core\notification\events\phpbbgallery_new_report;
use PHPUnit\Framework\TestCase;

final class notification_event_types_test extends TestCase
{
	private const TYPES = [
		phpbbgallery_image_approved::class => [
			'type' => 'phpbbgallery.core.notification.image_approved',
			'data' => ['last_image_id' => '21', 'album_id' => '4', 'album_name' => 'Approved', 'album_url' => '/album/4'],
			'item_id' => 21,
			'parent_id' => 4,
			'stored' => ['album_name' => 'Approved', 'album_url' => '/album/4', 'album_id' => '4'],
		],
		phpbbgallery_image_for_approval::class => [
			'type' => 'phpbbgallery.core.notification.image_for_approval',
			'data' => ['last_image_id' => '22', 'album_id' => '5', 'album_name' => 'Review', 'album_url' => '/album/5', 'uploader' => 8],
			'item_id' => 22,
			'parent_id' => 5,
			'stored' => ['album_name' => 'Review', 'album_url' => '/album/5', 'album_id' => '5', 'uploader' => 8],
		],
		phpbbgallery_image_not_approved::class => [
			'type' => 'phpbbgallery.core.notification.image_not_approved',
			'data' => ['last_image_id' => '23', 'album_id' => '6', 'album_name' => 'Rejected', 'album_url' => '/album/6'],
			'item_id' => 23,
			'parent_id' => 6,
			'stored' => ['album_name' => 'Rejected', 'album_url' => '/album/6', 'album_id' => '6'],
		],
		phpbbgallery_image_moderated::class => [
			'type' => 'phpbbgallery.core.notification.image_moderated',
			'data' => ['last_image_id' => '25', 'album_id' => '8', 'album_name' => 'Moderated', 'album_url' => '/album/8', 'actor_id' => 11, 'action' => 'locked'],
			'item_id' => 25,
			'parent_id' => 8,
			'stored' => ['album_name' => 'Moderated', 'album_url' => '/album/8', 'album_id' => '8', 'actor_id' => 11, 'action' => 'locked'],
		],
		phpbbgallery_image_removed::class => [
			'type' => 'phpbbgallery.core.notification.image_removed',
			'data' => ['last_image_id' => '26', 'album_id' => '9', 'album_name' => 'Removed', 'album_url' => '/album/9'],
			'item_id' => 26,
			'parent_id' => 9,
			'stored' => ['album_name' => 'Removed', 'album_url' => '/album/9', 'album_id' => '9'],
		],
		phpbbgallery_new_comment::class => [
			'type' => 'phpbbgallery.core.notification.new_comment',
			'data' => ['image_id' => '31', 'comment_id' => '41', 'poster' => 9, 'url' => '/image/31'],
			'item_id' => 41,
			'parent_id' => 31,
			'stored' => ['image_id' => '31', 'comment_id' => '41', 'poster_id' => 9, 'url' => '/image/31'],
		],
		phpbbgallery_new_image::class => [
			'type' => 'phpbbgallery.core.notification.new_image',
			'data' => ['last_image_id' => '24', 'album_id' => '7', 'album_name' => 'New', 'album_url' => '/album/7'],
			'item_id' => 24,
			'parent_id' => 7,
			'stored' => ['album_name' => 'New', 'album_url' => '/album/7', 'album_id' => '7'],
		],
		phpbbgallery_new_report::class => [
			'type' => 'phpbbgallery.core.notification.new_report',
			'data' => ['item_id' => '51', 'reporter' => 10, 'reported_image_id' => 32, 'url' => '/moderate/32'],
			'item_id' => 51,
			'parent_id' => 0,
			'stored' => ['item_id' => '51', 'reporter' => 10, 'reported_image_id' => 32, 'url' => '/moderate/32'],
		],
	];

	public function test_notification_event_classes_are_compatible_with_phpbb_base(): void
	{
		foreach (array_keys(self::TYPES) as $class_name)
		{
			$this->assertTrue(is_subclass_of($class_name, \phpbb\notification\type\base::class));
		}
	}

	public function test_notification_event_classes_have_complete_compatible_contracts(): void
	{
		foreach (array_keys(self::TYPES) as $class_name)
		{
			$reflection = new \ReflectionClass($class_name);

			foreach ($reflection->getProperties() as $property)
			{
				if ($property->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}

				if ($property->getName() === 'notification_option')
				{
					$this->assertNull($property->getType(), $class_name . '::$notification_option must match the untyped phpBB base property');
					continue;
				}

				$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
			}

			foreach ($reflection->getMethods() as $method)
			{
				if ($method->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}

				foreach ($method->getParameters() as $parameter)
				{
					$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName() . '($' . $parameter->getName() . ')');
				}
				$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_notification_identity_and_insert_data_remain_stable(): void
	{
		foreach (self::TYPES as $class_name => $expected)
		{
			$reflection = new \ReflectionClass($class_name);
			$notification = $reflection->newInstanceWithoutConstructor();
			$notification->set_initial_data([]);

			$this->assertSame($expected['type'], $notification->get_type());
			$this->assertSame($expected['item_id'], $class_name::get_item_id($expected['data']));
			$this->assertSame($expected['parent_id'], $class_name::get_item_parent_id($expected['data']));
			$this->assertTrue($notification->is_available());
			$this->assertFalse($notification->get_email_template());
			$this->assertSame([], $notification->get_email_template_variables());
			$this->assertSame([], $notification->users_to_query());

			$notification->create_insert_array($expected['data']);
			$insert = $notification->get_insert_array();
			$this->assertSame($expected['item_id'], $insert['item_id']);
			$this->assertSame($expected['parent_id'], $insert['item_parent_id']);
			$this->assertSame($expected['stored'], unserialize($insert['notification_data']));
		}
	}

	public function test_empty_notification_presentation_values_are_strings(): void
	{
		foreach ([phpbbgallery_image_approved::class, phpbbgallery_image_not_approved::class, phpbbgallery_new_image::class] as $class_name)
		{
			$notification = (new \ReflectionClass($class_name))->newInstanceWithoutConstructor();
			$this->assertSame('', $notification->get_avatar());
		}

		foreach ([phpbbgallery_image_for_approval::class, phpbbgallery_new_comment::class, phpbbgallery_new_image::class] as $class_name)
		{
			$notification = (new \ReflectionClass($class_name))->newInstanceWithoutConstructor();
			$this->assertSame('', $notification->get_reference());
		}
	}

	public function test_fallback_urls_are_always_strings(): void
	{
		$fallbacks = [
			phpbbgallery_image_approved::class => ['album_url' => '/album/4'],
			phpbbgallery_image_for_approval::class => ['album_url' => '/album/5'],
			phpbbgallery_image_not_approved::class => ['album_url' => '/album/6'],
			phpbbgallery_image_moderated::class => ['album_url' => '/album/8'],
			phpbbgallery_image_removed::class => ['album_url' => '/album/9'],
			phpbbgallery_new_comment::class => ['url' => '/image/31'],
			phpbbgallery_new_image::class => ['album_url' => '/album/7'],
			phpbbgallery_new_report::class => ['url' => '/moderate/32'],
		];

		foreach ($fallbacks as $class_name => $data)
		{
			$notification = (new \ReflectionClass($class_name))->newInstanceWithoutConstructor();
			$notification->set_initial_data(['notification_data' => serialize($data)]);
			$this->assertSame(reset($data), $notification->get_url());
		}
	}
}
