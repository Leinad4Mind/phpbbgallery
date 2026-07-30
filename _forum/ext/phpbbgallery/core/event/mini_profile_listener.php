<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Add permission-filtered Gallery data to topic and private-message profiles.
 */
class mini_profile_listener implements EventSubscriberInterface
{
	private \phpbb\controller\helper $helper;
	private \phpbb\auth\auth $phpbb_auth;
	private \phpbb\config\config $phpbb_config;
	private \phpbb\user $user;
	private \phpbb\db\driver\driver_interface $db;
	private \phpbbgallery\core\auth\auth $gallery_auth;
	private \phpbbgallery\core\config $gallery_config;
	private \phpbbgallery\core\search $gallery_search;
	private string $users_table;
	private array $profiles = [];
	private ?bool $show_count = null;
	private ?bool $show_personal_album = null;
	private ?bool $link_count = null;

	public function __construct(
		\phpbb\controller\helper $helper,
		\phpbb\auth\auth $phpbb_auth,
		\phpbb\config\config $phpbb_config,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\search $gallery_search,
		string $users_table
	)
	{
		$this->helper = $helper;
		$this->phpbb_auth = $phpbb_auth;
		$this->phpbb_config = $phpbb_config;
		$this->user = $user;
		$this->db = $db;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_config = $gallery_config;
		$this->gallery_search = $gallery_search;
		$this->users_table = $users_table;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.viewtopic_modify_post_data' => 'preload_viewtopic',
			'core.viewtopic_modify_post_row' => 'display_viewtopic',
			'core.ucp_pm_view_message' => 'display_private_message',
		];
	}

	/**
	 * Preload every author displayed on the topic page.
	 *
	 * @param \phpbb\event\data $event phpBB viewtopic event
	 * @return void
	 */
	public function preload_viewtopic(\phpbb\event\data $event): void
	{
		$this->load_profiles(array_keys((array) $event['user_cache']));
	}

	/**
	 * Add the preloaded Gallery fields to one viewtopic row.
	 *
	 * @param \phpbb\event\data $event phpBB viewtopic event
	 * @return void
	 */
	public function display_viewtopic(\phpbb\event\data $event): void
	{
		$user_id = (int) $event['poster_id'];
		$this->load_profiles([$user_id]);

		$post_row = $event['post_row'];
		$event['post_row'] = array_merge($post_row, $this->template_data($user_id));
	}

	/**
	 * Add Gallery fields to the author profile of a private message.
	 *
	 * @param \phpbb\event\data $event phpBB private-message event
	 * @return void
	 */
	public function display_private_message(\phpbb\event\data $event): void
	{
		$user_info = (array) $event['user_info'];
		$message_row = (array) $event['message_row'];
		$user_id = (int) ($user_info['user_id'] ?? $message_row['author_id'] ?? 0);
		$this->load_profiles([$user_id]);

		$msg_data = $event['msg_data'];
		$event['msg_data'] = array_merge($msg_data, $this->template_data($user_id));
	}

	/**
	 * Load counts and visible personal albums for all missing users.
	 *
	 * @param array $user_ids phpBB user IDs
	 * @return void
	 */
	private function load_profiles(array $user_ids): void
	{
		$this->initialize_settings();
		$user_ids = array_values(array_unique(array_filter(array_map('intval', $user_ids), static fn(int $user_id): bool => $user_id > (int) ANONYMOUS)));
		$user_ids = array_values(array_diff($user_ids, array_keys($this->profiles)));
		if (!$user_ids || (!$this->show_count && !$this->show_personal_album))
		{
			return;
		}

		$counts = $this->show_count ? $this->gallery_search->user_image_counts($user_ids) : [];
		$personal_albums = $this->show_personal_album ? $this->visible_personal_albums($user_ids, $this->show_count) : [];
		foreach ($user_ids as $user_id)
		{
			$count = $counts[$user_id] ?? 0;
			$personal_album_id = $personal_albums[$user_id] ?? 0;
			$this->profiles[$user_id] = [
				'image_count' => $count,
				'search_url' => $this->link_count
					? $this->helper->route('phpbbgallery_core_search', ['user_id' => [$user_id], 'submit' => 1])
					: '',
				'personal_album_url' => $personal_album_id
					? $this->helper->route('phpbbgallery_core_album', ['album_id' => $personal_album_id])
					: '',
			];
		}
	}

	/**
	 * Find personal root albums that the active visitor may view.
	 *
	 * @param array $user_ids Target members
	 * @param bool  $permissions_loaded Whether the count query already loaded Gallery ACLs
	 * @return array<int, int> Personal album IDs keyed by member ID
	 */
	private function visible_personal_albums(array $user_ids, bool $permissions_loaded): array
	{
		if (!$permissions_loaded)
		{
			$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		}

		$visible_albums = array_flip(array_diff(
			$this->gallery_auth->acl_album_ids('i_view'),
			$this->gallery_auth->get_exclude_zebra()
		));
		if (!$visible_albums)
		{
			return [];
		}

		$personal_albums = [];
		$sql = 'SELECT user_id, personal_album_id
			FROM ' . $this->users_table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_id = (int) $row['personal_album_id'];
			if ($album_id > 0 && isset($visible_albums[$album_id]))
			{
				$personal_albums[(int) $row['user_id']] = $album_id;
			}
		}
		$this->db->sql_freeresult($result);

		return $personal_albums;
	}

	/**
	 * Resolve the three independent ACP switches once per request.
	 *
	 * @return void
	 */
	private function initialize_settings(): void
	{
		if ($this->show_count !== null)
		{
			return;
		}

		$this->show_count = (bool) $this->gallery_config->get('viewtopic_images');
		$this->show_personal_album = (bool) $this->gallery_config->get('viewtopic_icon');
		$this->link_count = $this->show_count
			&& (bool) $this->gallery_config->get('viewtopic_link')
			&& !empty($this->phpbb_config['load_search'])
			&& $this->phpbb_auth->acl_get('u_search');
	}

	/**
	 * Build variables that are safe for strict Twig rendering.
	 *
	 * @param int $user_id Profile owner
	 * @return array
	 */
	private function template_data(int $user_id): array
	{
		$profile = $this->profiles[$user_id] ?? [];

		return [
			'S_GALLERY_IMAGE_COUNT' => $this->show_count && $user_id > (int) ANONYMOUS,
			'POSTER_GALLERY_IMAGES' => $profile['image_count'] ?? '',
			'U_POSTER_GALLERY_SEARCH' => $profile['search_url'] ?? '',
			'U_POSTER_PERSONAL_ALBUM' => $profile['personal_album_url'] ?? '',
		];
	}
}
