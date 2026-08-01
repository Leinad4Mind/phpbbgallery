<?php
/**
 * phpBB Gallery - original source purchase notification
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\notification\type;

use phpbb\notification\type\base;
use phpbb\user_loader;
use phpbbgallery\bbpointsimages\notification\helper;

final class source_purchase extends base
{
	public static $notification_option = [
		'lang' => 'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE',
		'group' => 'NOTIFICATION_GROUP_MISCELLANEOUS',
	];

	protected user_loader $user_loader;

	public function set_user_loader(user_loader $user_loader): void
	{
		$this->user_loader = $user_loader;
	}

	public function get_type(): string
	{
		return helper::SOURCE_PURCHASE_TYPE;
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
		return (int) $data['buyer_id'];
	}

	public function find_users_for_notification(mixed $data, mixed $options = []): array
	{
		$user_ids = array_values(array_unique(array_map('intval', (array) $data['user_ids'])));
		$this->user_loader->load_users(array_values(array_unique([...$user_ids, (int) $data['buyer_id']])));
		return $this->check_user_notification_options($user_ids, $options);
	}

	public function get_avatar(): string
	{
		return $this->user_loader->get_avatar((int) $this->get_data('buyer_id'), false, true);
	}

	public function get_title(): string
	{
		return $this->language->lang(
			'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE',
			$this->user_loader->get_username((int) $this->get_data('buyer_id'), 'no_profile'),
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
		return [(int) $this->get_data('buyer_id')];
	}

	public function create_insert_array(mixed $data, mixed $pre_create_data = []): void
	{
		$this->set_data('buyer_id', (int) $data['buyer_id']);
		$this->set_data('image_name', (string) $data['image_name']);
		$this->set_data('amount', (int) $data['amount']);
		$this->set_data('image_url', (string) $data['image_url']);
		parent::create_insert_array($data, $pre_create_data);
	}
}
