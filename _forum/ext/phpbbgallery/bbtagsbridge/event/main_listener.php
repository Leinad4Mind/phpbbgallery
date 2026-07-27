<?php
/**
 * phpBB Gallery BBTags Bridge lifecycle listener.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\event;

use phpbb\event\data;
use phpbbgallery\bbtagsbridge\image_tag_manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	private image_tag_manager $image_tags;

	public function __construct(image_tag_manager $image_tags)
	{
		$this->image_tags = $image_tags;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.user_setup' => 'load_language_on_setup',
			'phpbbgallery.core.image.delete_images' => 'delete_image_tags',
		];
	}

	public function load_language_on_setup(data $event): void
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'phpbbgallery/bbtagsbridge',
			'lang_set' => 'bbtagsbridge',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function delete_image_tags(data $event): void
	{
		$this->image_tags->delete_for_images((array) $event['images']);
	}
}
