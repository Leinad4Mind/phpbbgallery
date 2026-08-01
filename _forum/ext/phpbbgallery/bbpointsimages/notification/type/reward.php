<?php
/**
 * phpBB Gallery - image publication reward notification
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\notification\type;

use phpbb\notification\type\base;
use phpbbgallery\bbpointsimages\notification\helper;

final class reward extends base
{
	public static $notification_option = [
		'lang' => 'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD',
		'group' => 'NOTIFICATION_GROUP_MISCELLANEOUS',
	];

	public function get_type(): string
	{
		return helper::REWARD_TYPE;
	}

	public function is_available(): bool
	{
		return true;
	}

	public static function get_item_id(mixed $data): int
	{
		return (int) $data['image_id'];
	}

	public static function get_item_parent_id(mixed $data): int
	{
		return (int) $data['album_id'];
	}

	public function find_users_for_notification(mixed $data, mixed $options = []): array
	{
		$user_ids = array_values(array_unique(array_map('intval', (array) $data['user_ids'])));
		return $this->check_user_notification_options($user_ids, $options);
	}

	public function get_title(): string
	{
		return $this->language->lang(
			'NOTIFICATION_BBPOINTSIMAGES_REWARD',
			(int) $this->get_data('amount'),
			utf8_htmlspecialchars((string) $this->get_data('image_name'))
		);
	}

	public function get_url(): string
	{
		return (string) $this->get_data('image_url');
	}

	public function get_email_template(): bool
	{
		return false;
	}

	public function get_email_template_variables(): array
	{
		return [];
	}

	public function users_to_query(): array
	{
		return [];
	}

	public function create_insert_array(mixed $data, mixed $pre_create_data = []): void
	{
		$this->set_data('image_name', (string) $data['image_name']);
		$this->set_data('amount', (int) $data['amount']);
		$this->set_data('image_url', (string) $data['image_url']);
		parent::create_insert_array($data, $pre_create_data);
	}
}
