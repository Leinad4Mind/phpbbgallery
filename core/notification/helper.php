<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\notification;

use Symfony\Component\DependencyInjection\Container;

class helper
{
	/** @var \phpbb\config\config phpBB configuration */
	protected \phpbb\config\config $config;

	/** @var \phpbb\db\driver\driver_interface phpBB database connection */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\request\request_interface phpBB request service */
	protected \phpbb\request\request_interface $request;

	/** @var \phpbb\template\template phpBB template service */
	protected \phpbb\template\template $template;

	/** @var \phpbb\user Current phpBB user */
	protected \phpbb\user $user;

	/** @var \phpbbgallery\core\auth\auth Gallery authorization service */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\album\loader Gallery album loader */
	protected \phpbbgallery\core\album\loader $album_load;

	/** @var \phpbb\controller\helper phpBB controller helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\url Gallery URL service */
	protected \phpbbgallery\core\url $url;

	/** @var Container phpBB service container */
	protected Container $phpbb_container;

	/** @var string phpBB root path */
	protected string $root_path;

	/** @var string phpBB file extension */
	protected string $php_ext;

	/** @var string Gallery watch table */
	protected string $watch_table;

	/** @var \phpbbgallery\core\image\image Gallery image service */
	protected \phpbbgallery\core\image\image $image;

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\user $user,
	\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\album\loader $album_load, \phpbb\controller\helper $helper, \phpbbgallery\core\url $url,
	Container $phpbb_container, string $root_path, string $php_ext, string $watch_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->gallery_auth = $gallery_auth;
		$this->album_load = $album_load;
		$this->helper = $helper;
		$this->url = $url;
		$this->phpbb_container = $phpbb_container;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->watch_table = $watch_table;
	}

	/**
	 * Main notification function
	 *
	 * @param string $type   Notification operation
	 * @param array  $target Notification data
	 * @throws \Exception
	 */
	public function notify(string $type, array $target): void
	{
		$phpbb_notifications = $this->phpbb_container->get('notification_manager');
		switch ($type)
		{
			case 'approval':
				$targets = $this->notification_targets(
					$this->gallery_auth->acl_users_ids('m_status', $target['album_id'])
				);
				$album_data = $this->album_load->get($target['album_id']);
				$notification_data = [
					'user_ids' => $targets,
					'album_id' => $target['album_id'],
					'album_name' => $album_data['album_name'],
					'last_image_id'	=> $target['last_image'],
					'uploader'	=> $target['uploader'],
					'album_url'	=> $this->url->get_uri($this->helper->route('phpbbgallery_core_album', ['album_id' => $target['album_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.image_for_approval', $notification_data);
			break;
			case 'approved':
				$moderators = $this->gallery_auth->acl_users_ids('m_status', $target['album_id']);
				$targets = $this->notification_targets(array_diff($target['targets'], $moderators));
				$album_data = $this->album_load->get($target['album_id']);
				$notification_data = [
					'user_ids' => $targets,
					'album_id' => $target['album_id'],
					'album_name' => $album_data['album_name'],
					'last_image_id'	=> $target['last_image'],
					'album_url'	=> $this->url->get_uri($this->helper->route('phpbbgallery_core_album', ['album_id' => $target['album_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.image_approved', $notification_data);
			break;
			case 'not_approved':
				$moderators = $this->gallery_auth->acl_users_ids('m_status', $target['album_id']);
				$targets = $this->notification_targets(array_diff($target['targets'], $moderators));
				$album_data = $this->album_load->get($target['album_id']);
				$notification_data = [
					'user_ids' => $targets,
					'album_id' => $target['album_id'],
					'album_name' => $album_data['album_name'],
					'last_image_id'	=> $target['last_image'],
					'album_url'	=> $this->url->get_uri($this->helper->route('phpbbgallery_core_album', ['album_id' => $target['album_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.image_not_approved', $notification_data);
			break;
			case 'removed':
				$album_data = $this->album_load->get($target['album_id']);
				$notification_data = [
					'user_ids' => $this->notification_targets($target['targets']),
					'album_id' => $target['album_id'],
					'album_name' => $album_data['album_name'],
					'last_image_id' => $target['last_image'],
					'album_url' => $this->url->get_uri($this->helper->route('phpbbgallery_core_album', ['album_id' => $target['album_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.image_removed', $notification_data);
			break;
			case 'new_image':
				$targets = $this->notification_targets($target['targets']);
				$album_data = $this->album_load->get($target['album_id']);
				$notification_data = [
					'user_ids' => $targets,
					'album_id' => $target['album_id'],
					'album_name' => $album_data['album_name'],
					'last_image_id'	=> $target['last_image'],
					'album_url'	=> $this->url->get_uri($this->helper->route('phpbbgallery_core_album', ['album_id' => $target['album_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.new_image', $notification_data);
			break;
			case 'new_comment':
				$targets = array_merge(
					$this->get_image_watchers($target['image_id']),
					$this->gallery_auth->acl_users_ids('m_comments', $target['album_id'])
				);
				$notification_data = [
					'user_ids'	=> $this->notification_targets($targets, [$target['poster_id']]),
					'image_id'	=> $target['image_id'],
					'comment_id'	=> $target['comment_id'],
					'poster'	=> $target['poster_id'],
					'url'		=> $this->url->get_uri($this->helper->route('phpbbgallery_core_image', ['image_id' => $target['image_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.new_comment', $notification_data);
			break;
			case 'new_report':
				if ($target['reported_album_id'] == 0)
				{
					$image_data = $this->image->get_image_data($target['reported_image_id']);
					if ($image_data === false)
					{
						return;
					}
					$target['reported_album_id'] = $image_data['image_album_id'];
				}
				$notification_data = [
					'user_ids'	=> $this->notification_targets(
						$this->gallery_auth->acl_users_ids('m_report', $target['reported_album_id']),
						[$target['reporter_id']]
					),
					'item_id'	=> $target['report_id'],
					'reporter'	=> $target['reporter_id'],
					'reported_image_id' => $target['reported_image_id'],
					'url'		=> $this->url->get_uri($this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $target['reported_image_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.new_report', $notification_data);
			break;
			case 'moderated':
				$album_data = $this->album_load->get($target['album_id']);
				$notification_data = [
					'user_ids' => $this->notification_targets($target['targets']),
					'album_id' => $target['album_id'],
					'album_name' => $album_data['album_name'],
					'last_image_id' => $target['last_image'],
					'actor_id' => (int) ($this->user->data['user_id'] ?? 0),
					'action' => $target['action'],
					'album_url' => $this->url->get_uri($this->helper->route('phpbbgallery_core_album', ['album_id' => $target['album_id']])),
				];
				$phpbb_notifications->add_notifications('phpbbgallery.core.notification.image_moderated', $notification_data);
			break;
		}
	}

	/**
	 * Notify the relevant Gallery team about a moderation state change. Rows
	 * are grouped per album to keep batches useful without flooding the
	 * notification centre.
	 *
	 * @param string $action          Moderation action language suffix
	 * @param array  $image_rows      Affected image rows
	 * @param string $permission      Gallery moderator permission
	 */
	public function notify_moderation(string $action, array $image_rows, string $permission): void
	{
		if (!in_array($action, ['approved', 'deleted', 'locked', 'rejected', 'unapproved', 'unlocked'], true))
		{
			throw new \InvalidArgumentException('Unsupported Gallery moderation notification action.');
		}

		$grouped = [];
		foreach ($image_rows as $row)
		{
			$album_id = (int) ($row['image_album_id'] ?? 0);
			$image_id = (int) ($row['image_id'] ?? 0);
			if ($album_id <= 0 || $image_id <= 0)
			{
				continue;
			}

			$grouped[$album_id]['last_image'] = $image_id;
		}

		foreach ($grouped as $album_id => $data)
		{
			$targets = $this->gallery_auth->acl_users_ids($permission, $album_id);
			$this->notify('moderated', [
				'targets' => $targets,
				'album_id' => $album_id,
				'last_image' => $data['last_image'],
				'action' => $action,
			]);
		}
	}

	/**
	 * Notify ordinary image authors of a moderated removal without revealing
	 * the moderator. Authors who belong to the delete team receive only the
	 * detailed internal moderation notification.
	 *
	 * @param array $image_rows Removed image rows
	 */
	public function notify_removed_authors(array $image_rows): void
	{
		$grouped = [];
		foreach ($image_rows as $row)
		{
			$album_id = (int) ($row['image_album_id'] ?? 0);
			$image_id = (int) ($row['image_id'] ?? 0);
			$author_id = (int) ($row['image_user_id'] ?? 0);
			if ($album_id <= 0 || $image_id <= 0 || $author_id <= 0)
			{
				continue;
			}

			$grouped[$album_id]['authors'][] = $author_id;
			$grouped[$album_id]['last_image'] = $image_id;
		}

		foreach ($grouped as $album_id => $data)
		{
			$moderators = $this->gallery_auth->acl_users_ids('m_delete', $album_id);
			$this->notify('removed', [
				'targets' => array_diff($data['authors'], $moderators),
				'album_id' => $album_id,
				'last_image' => $data['last_image'],
			]);
		}
	}

	/**
	 * Normalize recipient IDs, remove duplicates and prevent self-notifications.
	 *
	 * @param array $targets Candidate recipients
	 * @param array $exclude Additional recipients to exclude
	 * @return array
	 */
	private function notification_targets(array $targets, array $exclude = []): array
	{
		$exclude[] = (int) ($this->user->data['user_id'] ?? 0);
		$exclude[] = defined('ANONYMOUS') ? (int) ANONYMOUS : 1;
		$targets = array_values(array_unique(array_filter(array_map('intval', $targets))));

		return array_values(array_diff($targets, array_unique(array_map('intval', $exclude))));
	}
	public function delete_notifications(string $type, mixed $target): void
	{
		$phpbb_notifications = $this->phpbb_container->get('notification_manager');
		switch ($type)
		{
			case 'report':
				$phpbb_notifications->delete_notifications('phpbbgallery.core.notification.new_report', $target);
			break;
		}
	}

	// Read notification (in some cases it is needed)
	public function read(string $type, int $target): void
	{
		$phpbb_notifications = $this->phpbb_container->get('notification_manager');
		switch ($type)
		{
			case 'approval':
				$phpbb_notifications->mark_notifications_read_by_parent('phpbbgallery.core.notification.image_for_approval', $target, false);
			break;
		}
	}

	/**
	 * Get watched for album
	 *
	 * @param int       $album_id Album to check
	 * @param int|false $user_id  User to check, or false for the current user
	 * @return int
	 */
	public function get_watched_album(int $album_id, int|false $user_id = false): int
	{
		if (!$user_id)
		{
			$user_id = $this->user->data['user_id'];
		}
		$sql = 'SELECT COUNT(watch_id) as count FROM ' . $this->watch_table . ' WHERE album_id = ' . (int) $album_id . ' and user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return (int) $row['count'];
	}

	/**
	 * Get album watchers
	 * @param int $album_id
	 * @return array
	 */
	public function get_album_watchers(int $album_id): array
	{
		$sql = 'SELECT user_id FROM ' . $this->watch_table . ' WHERE album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$watchers = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$watchers[] = (int) $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		return $watchers;
	}

	/**
	 * Get album watchers
	 * @param int $image_id
	 * @return array
	 */
	public function get_image_watchers(int $image_id): array
	{
		$sql = 'SELECT user_id FROM ' . $this->watch_table . ' WHERE image_id = ' . (int) $image_id;
		$result = $this->db->sql_query($sql);
		$watchers = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$watchers[] = (int) $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		return $watchers;
	}

	/**
	 * Add albums to watch-list
	 *
	 * @param    mixed $album_ids Array or integer with album_id where we delete from the watch-list.
	 * @param bool|int $user_id If not set, it uses the currents user_id
	 */
	public function add_albums(array|int $album_ids, int|false $user_id = false): void
	{
		$album_ids = $this->cast_mixed_int2array($album_ids);
		if (!$album_ids)
		{
			return;
		}

		$user_id = (int) (($user_id) ? $user_id : $this->user->data['user_id']);

		// First check if we are not subscribed already for some
		$sql = 'SELECT * FROM ' . $this->watch_table . ' WHERE user_id = ' . $user_id . ' and ' . $this->db->sql_in_set('album_id', $album_ids);
		$result = $this->db->sql_query($sql);
		$exclude = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$exclude[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);
		$album_ids = array_diff($album_ids, $exclude);
		$sql_ary = [];
		foreach ($album_ids as $album_id)
		{
			$sql_ary[] = [
				'album_id'		=> (int) $album_id,
				'user_id'		=> $user_id,
			];
		}
		if ($sql_ary)
		{
			$this->db->sql_multi_insert($this->watch_table, $sql_ary);
		}
	}

	/**
	* Remove albums from watch-list
	*
	* @param	mixed	$album_ids		Array or integer with album_id where we delete from the watch-list.
	* @param	mixed	$user_ids		If not set, it uses the currents user_id
	*/
	public function remove_albums(array|int $album_ids, array|int|false $user_ids = false): void
	{
		$album_ids = $this->cast_mixed_int2array($album_ids);
		$user_ids = $this->cast_mixed_int2array((($user_ids) ? $user_ids : $this->user->data['user_id']));
		if (!$album_ids || !$user_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->watch_table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids) . '
				AND ' . $this->db->sql_in_set('album_id', $album_ids);
		$this->db->sql_query($sql);
	}

	/**
	 *
	 * Cast int or array to array
	 *
	 * @param array|int $ids
	 * @return array
	 */
	public static function cast_mixed_int2array(array|int $ids): array
	{
		if (is_array($ids))
		{
			return array_values(array_unique(array_map('intval', $ids)));
		}

		return [(int) $ids];
	}

	/**
	 *
	 * New image in album
	 * @param array $data
	 */
	public function new_image(array $data, bool $notify_moderators = true): void
	{
		$get_watchers = $this->get_album_watchers($data['album_id']);
		$moderators = $this->gallery_auth->acl_users_ids('m_status', $data['album_id']);
		// Authors never need a notification about their own upload. When approval
		// generated a status notification, moderators are excluded here as well.
		$targets = array_diff($get_watchers, $data['targets'], $notify_moderators ? [] : $moderators);
		if ($notify_moderators)
		{
			$targets = array_merge($targets, $moderators);
		}

		$data['targets'] = $targets;
		$this->notify('new_image', $data);
	}

	public function set_image(\phpbbgallery\core\image\image $image): void
	{
		$this->image = $image;
	}
}
