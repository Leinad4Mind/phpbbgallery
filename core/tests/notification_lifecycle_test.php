<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\ext as gallery_extension;

class notification_lifecycle_test extends TestCase
{
	private const TYPES = [
		'phpbbgallery.core.notification.image_for_approval',
		'phpbbgallery.core.notification.image_approved',
		'phpbbgallery.core.notification.image_not_approved',
		'phpbbgallery.core.notification.new_comment',
		'phpbbgallery.core.notification.new_image',
		'phpbbgallery.core.notification.new_report',
	];

	public function test_enable_uses_every_registered_notification_type(): void
	{
		$manager = $this->create_notification_manager();
		$extension = $this->create_extension($manager);

		$this->assertSame('notifications', $extension->enable_step(''));
		$this->assertSame(self::TYPES, $manager->enabled);
	}

	public function test_enable_advertises_the_optional_addons(): void
	{
		$manager = $this->create_notification_manager();
		$extension = $this->create_extension($manager);

		$extension->enable_step('');

		$this->assertSame([['phpbbgallery/core', 'install_gallery']], $manager->languages);
		$this->assertSame('GALLERY_CORE_ENABLE_SUCCESS', $manager->success_message);
	}

	public function test_enable_reports_when_galleryimage_is_selected_to_preserve_an_existing_image_bbcode(): void
	{
		$manager = $this->create_notification_manager();
		$extension = $this->create_extension($manager, null, 'galleryimage');

		$extension->enable_step('');
		$this->assertFalse($extension->enable_step('notifications'));

		$this->assertSame('GALLERY_CORE_ENABLE_BBCODE_FALLBACK', $manager->success_message);
	}

	public function test_disable_uses_the_same_types_and_disables_sub_extensions(): void
	{
		$manager = $this->create_notification_manager();
		$extension_manager = $this->create_extension_manager();
		$extension = $this->create_extension($manager, $extension_manager);

		$this->assertSame('notifications', $extension->disable_step(''));
		$this->assertSame(self::TYPES, $manager->disabled);
		// Every packaged add-on rides along, so none is left enabled against a
		// disabled core.
		$this->assertSame([
			'phpbbgallery/acpcleanup',
			'phpbbgallery/acpimport',
			'phpbbgallery/exif',
			'phpbbgallery/export',
			'phpbbgallery/favorite',
			'phpbbgallery/feed',
			'phpbbgallery/imagerevisions',
			'phpbbgallery/bbtagsimages',
			'phpbbgallery/bbpointsimages',
		], $extension_manager->disabled);
	}

	public function test_every_packaged_addon_is_disabled_with_the_core(): void
	{
		$reflection = new \ReflectionClass(gallery_extension::class);
		$extension = $reflection->newInstanceWithoutConstructor();
		$sub_extensions = $reflection->getProperty('sub_extensions')->getValue($extension);
		$packaged_addons = [];

		foreach (glob(dirname(__DIR__, 2) . '/*/ext.php') as $extension_file)
		{
			$extension_name = basename(dirname($extension_file));
			if ($extension_name !== 'core')
			{
				$packaged_addons[] = 'phpbbgallery/' . $extension_name;
			}
		}

		sort($packaged_addons);
		sort($sub_extensions);
		$this->assertSame($packaged_addons, $sub_extensions);
	}

	public function test_purge_removes_every_registered_notification_type(): void
	{
		$manager = $this->create_notification_manager();
		$extension = $this->create_extension($manager);

		$this->assertSame('notifications', $extension->purge_step(''));
		$this->assertSame(self::TYPES, $manager->purged);
	}

	public function test_purge_continues_after_a_legacy_missing_type_exception(): void
	{
		$manager = $this->create_notification_manager('phpbbgallery.core.notification.image_approved');
		$extension = $this->create_extension($manager);

		$this->assertSame('notifications', $extension->purge_step(''));
		$this->assertSame(self::TYPES, $manager->purged);
	}

	public function test_lifecycle_types_match_notification_services_and_event_classes(): void
	{
		$services = file_get_contents(dirname(__DIR__) . '/config/services_notification_types.yml');
		preg_match_all('/^    (phpbbgallery\.core\.notification\.[a-z_]+):\r?$/m', $services, $matches);
		$this->assertSame(self::TYPES, $matches[1]);

		foreach (self::TYPES as $type)
		{
			$event_name = 'phpbbgallery_' . substr($type, strrpos($type, '.') + 1);
			$event = file_get_contents(dirname(__DIR__) . '/notification/events/' . $event_name . '.php');
			$this->assertStringContainsString("return '$type';", $event);
		}

		$extension = file_get_contents(dirname(__DIR__) . '/ext.php');
		$this->assertStringNotContainsString("image_not_approve'", $extension);
	}

	/**
	 * @param object      $notification_manager
	 * @param object|null $extension_manager
	 * @return gallery_extension
	 */
	private function create_extension($notification_manager, $extension_manager = null, string $bbcode_tag = 'image')
	{
		if ($extension_manager === null)
		{
			$extension_manager = $this->create_extension_manager();
		}

		$container = new class($notification_manager, $extension_manager, $bbcode_tag) {
			/** @var object */
			private $notification_manager;

			/** @var object */
			private $extension_manager;

			private string $bbcode_tag;

			public function __construct($notification_manager, $extension_manager, string $bbcode_tag)
			{
				$this->notification_manager = $notification_manager;
				$this->extension_manager = $extension_manager;
				$this->bbcode_tag = $bbcode_tag;
			}

			public function get($service)
			{
				if ($service === 'notification_manager')
				{
					return $this->notification_manager;
				}

				if ($service === 'ext.manager')
				{
					return $this->extension_manager;
				}

				if ($service === 'config')
				{
					return new \ArrayObject(['phpbb_gallery_bbcode_tag' => $this->bbcode_tag]);
				}

				if ($service === 'user')
				{
					return new class($this->notification_manager) {
						private object $manager;

						public function __construct(object $manager)
						{
							$this->manager = $manager;
						}

						public function add_lang_ext(string $extension, string $file): void
						{
							$this->manager->languages[] = [$extension, $file];
						}

						public function lang(string $key): string
						{
							return $key;
						}
					};
				}

				if ($service === 'template')
				{
					return new class($this->notification_manager) {
						private object $manager;

						public function __construct(object $manager)
						{
							$this->manager = $manager;
						}

						public function assign_var(string $name, string $value): void
						{
							$this->manager->success_message = $value;
						}
					};
				}

				throw new \RuntimeException('Unexpected service: ' . $service);
			}
		};

		$extension = (new \ReflectionClass(gallery_extension::class))->newInstanceWithoutConstructor();
		$set_container = \Closure::bind(function ($container): void
		{
			$this->container = $container;
		}, $extension, gallery_extension::class);
		$set_container($container);

		return $extension;
	}

	/**
	 * @param string $fail_purge_type
	 * @return object
	 */
	private function create_notification_manager($fail_purge_type = '')
	{
		return new class($fail_purge_type) {
			/** @var array */
			public $enabled = [];

			/** @var array */
			public $disabled = [];

			/** @var array */
			public $purged = [];

			/** @var string */
			private $fail_purge_type;

			/** @var array */
			public $languages = [];

			/** @var string */
			public $success_message = '';

			public function __construct($fail_purge_type)
			{
				$this->fail_purge_type = $fail_purge_type;
			}

			public function enable_notifications($type): void
			{
				$this->enabled[] = $type;
			}

			public function disable_notifications($type): void
			{
				$this->disabled[] = $type;
			}

			public function purge_notifications($type): void
			{
				$this->purged[] = $type;
				if ($type === $this->fail_purge_type)
				{
					throw new \phpbb\notification\exception('Missing test notification type');
				}
			}
		};
	}

	/**
	 * @return object
	 */
	private function create_extension_manager()
	{
		return new class {
			/** @var array */
			public $disabled = [];

			public function disable($extension): void
			{
				$this->disabled[] = $extension;
			}

			public function all_disabled()
			{
				return [];
			}
		};
	}
}
