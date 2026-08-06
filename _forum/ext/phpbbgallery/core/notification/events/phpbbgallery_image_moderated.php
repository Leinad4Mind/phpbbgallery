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

class phpbbgallery_image_moderated extends \phpbb\notification\type\base
{
	public static $notification_option = [
		'lang' => 'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_MODERATED',
	];

	/** @var \phpbb\user_loader */
	protected \phpbb\user_loader $user_loader;

	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	public function get_type(): string
	{
		return 'phpbbgallery.core.notification.image_moderated';
	}

	public function set_config(\phpbb\config\config $config): void
	{
		$this->config = $config;
	}

	public function set_user_loader(\phpbb\user_loader $user_loader): void
	{
		$this->user_loader = $user_loader;
	}

	public function is_available(): bool
	{
		return true;
	}

	public static function get_item_id(mixed $data): int
	{
		return (int) $data['last_image_id'];
	}

	public static function get_item_parent_id(mixed $data): int
	{
		return (int) $data['album_id'];
	}

	public function find_users_for_notification(mixed $data, mixed $options = []): array
	{
		$this->user_loader->load_users($data['user_ids']);
		return $this->check_user_notification_options($data['user_ids'], $options);
	}

	public function get_avatar(): string
	{
		$actor_id = (int) $this->get_data('actor_id');
		$this->user_loader->load_users([$actor_id]);
		return (string) $this->user_loader->get_avatar($actor_id);
	}

	public function get_title(): string
	{
		$actor_id = (int) $this->get_data('actor_id');
		$this->user_loader->load_users([$actor_id]);
		$username = $this->user_loader->get_username($actor_id, 'no_profile');
		$key = 'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_' . strtoupper((string) $this->get_data('action'));

		return $this->language->lang($key, $username, $this->get_data('album_name'));
	}

	public function get_email_template(): bool
	{
		return false;
	}

	public function get_email_template_variables(): array
	{
		return [];
	}

	public function get_url(): string
	{
		return (string) ($this->get_data('album_id')
			? append_sid($this->phpbb_root_path . 'gallery/album/' . $this->get_data('album_id'))
			: $this->get_data('album_url'));
	}

	public function users_to_query(): array
	{
		return [];
	}

	public function create_insert_array(mixed $data, mixed $pre_create_data = []): void
	{
		$this->set_data('album_name', $data['album_name']);
		$this->set_data('album_url', $data['album_url']);
		$this->set_data('album_id', $data['album_id']);
		$this->set_data('actor_id', $data['actor_id']);
		$this->set_data('action', $data['action']);
		parent::create_insert_array($data, $pre_create_data);
	}
}
