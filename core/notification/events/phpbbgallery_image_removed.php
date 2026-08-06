<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\notification\events;

/** Neutral author-facing result of a moderated image removal. */
class phpbbgallery_image_removed extends phpbbgallery_image_approved
{
	public static $notification_option = [
		'lang' => 'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_REMOVED',
	];

	public function get_type(): string
	{
		return 'phpbbgallery.core.notification.image_removed';
	}

	public function get_title(): string
	{
		return $this->language->lang('NOTIFICATION_PHPBBGALLERY_IMAGE_REMOVED', $this->get_data('album_name'));
	}
}
