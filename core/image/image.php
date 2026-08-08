<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

class image
{
	/** @var \phpbb\db\driver\driver_interface  */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\user  */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language  */
	protected \phpbb\language\language $language;

	/** @var \phpbb\template\template  */
	protected \phpbb\template\template $template;

	/** @var \phpbb\event\dispatcher_interface  */
	protected \phpbb\event\dispatcher_interface $phpbb_dispatcher;

	/** @var \phpbbgallery\core\auth\auth  */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\album\album  */
	protected \phpbbgallery\core\album\album $album;

	/** @var \phpbbgallery\core\config  */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbb\controller\helper  */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\url  */
	protected \phpbbgallery\core\url $url;

	/** @var \phpbbgallery\core\log  */
	protected \phpbbgallery\core\log $gallery_log;

	/** @var \phpbbgallery\core\notification\helper  */
	protected \phpbbgallery\core\notification\helper $notification_helper;

	/** @var \phpbbgallery\core\cache  */
	protected \phpbbgallery\core\cache $gallery_cache;

	/** @var \phpbbgallery\core\report  */
	protected \phpbbgallery\core\report $gallery_report;

	/** @var \phpbbgallery\core\user  */
	protected \phpbbgallery\core\user $gallery_user;

	/** @var \phpbbgallery\core\policy\image_visibility */
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;

	/** @var \phpbbgallery\core\policy\album_operation */
	protected \phpbbgallery\core\policy\album_operation $album_operation;

	/** @var \phpbbgallery\core\file\file  */
	protected \phpbbgallery\core\file\file $file;

	/** Active-provider workspace for synchronous add-on processing. */
	protected \phpbbgallery\core\storage\workspace $storage_workspace;

	/** @var string */
	protected string $table_images;

	public const IMAGE_SHOW_RESOLUTION = 256;
	public const IMAGE_SHOW_IP = 128;
	public const IMAGE_SHOW_RATINGS = 64;
	public const IMAGE_SHOW_USERNAME = 32;
	public const IMAGE_SHOW_VIEWS = 16;
	public const IMAGE_SHOW_TIME = 8;
	public const IMAGE_SHOW_IMAGENAME = 4;
	public const IMAGE_SHOW_COMMENTS = 2;
	public const IMAGE_SHOW_ALBUM = 1;

	/**
	 * construct
	 *
	 * @param \phpbb\db\driver\driver_interface      $db
	 * @param \phpbb\user                            $user
	 * @param \phpbb\language\language               $language
	 * @param \phpbb\template\template               $template
	 * @param \phpbb\event\dispatcher_interface      $phpbb_dispatcher
	 * @param \phpbbgallery\core\auth\auth           $gallery_auth
	 * @param \phpbbgallery\core\album\album         $album
	 * @param \phpbbgallery\core\config              $gallery_config
	 * @param \phpbb\controller\helper               $helper
	 * @param \phpbbgallery\core\url                 $url
	 * @param \phpbbgallery\core\log                 $gallery_log
	 * @param \phpbbgallery\core\notification\helper $notification_helper
	 * @param \phpbbgallery\core\report              $report
	 * @param \phpbbgallery\core\cache               $gallery_cache
	 * @param \phpbbgallery\core\user                $gallery_user
	 * @param \phpbbgallery\core\policy\image_visibility $image_visibility
	 * @param \phpbbgallery\core\policy\album_operation $album_operation
	 * @param \phpbbgallery\core\file\file           $file
	 * @param \phpbbgallery\core\storage\workspace   $storage_workspace
	 * @param string                                 $table_images
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\language\language $language,
		\phpbb\template\template $template, \phpbb\event\dispatcher_interface $phpbb_dispatcher, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\album\album $album, \phpbbgallery\core\config $gallery_config, \phpbb\controller\helper $helper,
		\phpbbgallery\core\url $url, \phpbbgallery\core\log $gallery_log, \phpbbgallery\core\notification\helper $notification_helper,
		\phpbbgallery\core\report $report, \phpbbgallery\core\cache $gallery_cache, \phpbbgallery\core\user $gallery_user,
		\phpbbgallery\core\policy\image_visibility $image_visibility,
		\phpbbgallery\core\policy\album_operation $album_operation,
		\phpbbgallery\core\file\file $file,
		\phpbbgallery\core\storage\workspace $storage_workspace,
		string $table_images)
	{
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->template = $template;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->gallery_auth = $gallery_auth;
		$this->album = $album;
		$this->gallery_config = $gallery_config;
		$this->helper = $helper;
		$this->url = $url;
		$this->gallery_log = $gallery_log;
		$this->notification_helper = $notification_helper;
		$this->gallery_cache = $gallery_cache;
		$this->gallery_report = $report;
		$this->gallery_user = $gallery_user;
		$this->image_visibility = $image_visibility;
		$this->album_operation = $album_operation;
		$this->file = $file;
		$this->storage_workspace = $storage_workspace;
		$this->table_images = $table_images;
	}

	private function notify_state_change(string $operation, array $image_rows, array $album_ids): void
	{
		$album_ids = array_values(array_unique(array_filter(array_map('intval', $album_ids))));
		if (!$image_rows || !$album_ids)
		{
			return;
		}

		/**
		 * Notify optional providers after image state changes have been persisted.
		 *
		 * @event phpbbgallery.core.image.state_changed
		 * @var string operation  Mutation that was performed
		 * @var array  image_rows Image rows captured for the mutation
		 * @var array  album_ids  Affected album identifiers
		 * @since 4.1.0
		 */
		$vars = ['operation', 'image_rows', 'album_ids'];
		extract($this->phpbb_dispatcher->trigger_event(
			'phpbbgallery.core.image.state_changed',
			compact($vars)
		));
	}

	/**
	 * Resolve the database identity of an image author.
	 *
	 * @param string $username Requested phpBB username
	 * @return array|false User row, or false when no user matches
	 */
	public function get_new_author_info(string $username): array|false
	{
		// Who is the new uploader?
		if (!$username)
		{
			return false;
		}
		$user_id = 0;
		if ($username)
		{
			if (!function_exists('user_get_id_name'))
			{
				$this->url->_include('functions_user', 'phpbb');
			}
			user_get_id_name($user_id, $username);
		}

		if (empty($user_id))
		{
			return false;
		}

		$sql = 'SELECT username, user_colour, user_id
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $user_id[0];
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * Change the registered author of multiple images and keep user counters balanced.
	 *
	 * @param array $image_ids Image identifiers
	 * @param array $author    Trusted phpBB user row
	 * @return int Number of updated images
	 */
	public function change_author(array $image_ids, array $author): int
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids), static fn (int $image_id): bool => $image_id > 0)));
		$author_user_id = (int) ($author['user_id'] ?? 0);
		$author_username = (string) ($author['username'] ?? '');
		if (!$image_ids || $author_user_id < 1 || $author_username === '')
		{
			return 0;
		}

		$sql = 'SELECT image_id, image_album_id, image_name, image_user_id
			FROM ' . $this->table_images . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$image_data = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_data[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);
		$image_ids = array_keys($image_data);
		if (!$image_ids)
		{
			return 0;
		}

		$this->db->sql_transaction('begin');
		try
		{
			$this->handle_counter($image_ids, false);
			$sql_ary = [
				'image_user_id'        => $author_user_id,
				'image_username'       => $author_username,
				'image_username_clean' => utf8_clean_string($author_username),
				'image_user_colour'    => $author['user_colour'] ?? '',
			];
			$sql = 'UPDATE ' . $this->table_images . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
			$this->db->sql_query($sql);
			$this->handle_counter($image_ids, true);

			foreach ($image_data as $row)
			{
				$this->gallery_log->add_log('moderator', 'edit', (int) $row['image_album_id'], (int) $row['image_id'], ['LOG_GALLERY_EDITED', $row['image_name']]);
			}
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->gallery_cache->destroy_images();
		/**
		 * Notify add-ons after image authorship and counters are committed.
		 *
		 * @event phpbbgallery.core.image.change_author_after
		 * @var array image_ids  Changed image identifiers
		 * @var array image_data Previous image rows
		 * @var array author     New trusted phpBB user row
		 * @since 3.4.0
		 */
		$vars = ['image_ids', 'image_data', 'author'];
		extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.image.change_author_after', compact($vars)));

		return count($image_ids);
	}

	/**
	 * Rename multiple images using an image-id-to-name map.
	 *
	 * @return int Number of updated images
	 */
	public function rename_images(array $image_names): int
	{
		$normalized_names = [];
		foreach ($image_names as $image_id => $image_name)
		{
			$image_id = (int) $image_id;
			$image_name = utf8_normalize_nfc(trim((string) $image_name));
			if ($image_id < 1 || utf8_clean_string($image_name) === '' || utf8_strlen($image_name) > 255)
			{
				throw new \InvalidArgumentException('Invalid image name.');
			}
			$normalized_names[$image_id] = $image_name;
		}
		if (!$normalized_names)
		{
			return 0;
		}

		$sql = 'SELECT image_id, image_album_id, image_name
			FROM ' . $this->table_images . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', array_keys($normalized_names));
		$result = $this->db->sql_query($sql);
		$image_data = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_data[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);
		if (!$image_data)
		{
			return 0;
		}

		$this->db->sql_transaction('begin');
		try
		{
			foreach ($normalized_names as $image_id => $image_name)
			{
				if (!isset($image_data[$image_id]))
				{
					continue;
				}
				$sql_ary = [
					'image_name'       => $image_name,
					'image_name_clean' => utf8_clean_string($image_name),
				];
				$sql = 'UPDATE ' . $this->table_images . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE image_id = ' . (int) $image_id;
				$this->db->sql_query($sql);
				$this->gallery_log->add_log('moderator', 'edit', (int) $image_data[$image_id]['image_album_id'], $image_id, ['LOG_GALLERY_EDITED', $image_name]);
			}
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->gallery_cache->destroy_images();

		return count(array_intersect_key($normalized_names, $image_data));
	}

	/**
	 * Delete an image completely.
	 *
	 * @param    array $images Array with the image_id(s)
	 * @param    array $filenames Array with filenames for the image_ids. If a filename is missing it's queried from the database.
	 *                                    Format: $image_id => $filename
	 * @param bool $resync_albums
	 * @param    bool $skip_files If set to true, we won't try to delete the source files.
	 * @return bool
	 */
	public function delete_images(array $images, array $filenames = [], bool $resync_albums = true, bool $skip_files = false): bool
	{
		return !empty($this->delete_images_internal($images, $filenames, $resync_albums, $skip_files));
	}

	/**
	 * Delete only images that still have the expected status when the DELETE is executed.
	 *
	 * This protects resumable-upload cancellation and pruning from deleting a draft
	 * that another request finalized after it was selected.
	 *
	 * @param array $images Image IDs
	 * @param int $required_status Status that must still be present
	 * @param array $filenames Known filenames indexed by image ID
	 * @param bool $resync_albums Whether affected albums should be resynchronized
	 * @param bool $skip_files Whether source and derived files should be preserved
	 * @return int Number of rows actually deleted
	 */
	public function delete_images_matching_status(array $images, int $required_status, array $filenames = [], bool $resync_albums = true, bool $skip_files = false): int
	{
		return count($this->delete_images_matching_status_ids($images, $required_status, $filenames, $resync_albums, $skip_files));
	}

	/**
	 * Delete images that still have the expected status and return their IDs.
	 *
	 * @return int[] IDs confirmed as deleted
	 */
	public function delete_images_matching_status_ids(array $images, int $required_status, array $filenames = [], bool $resync_albums = true, bool $skip_files = false): array
	{
		return $this->delete_images_internal($images, $filenames, $resync_albums, $skip_files, $required_status);
	}

	/**
	 * Delete images and finish their dependent cleanup.
	 *
	 * @return int[] IDs confirmed as deleted
	 */
	private function delete_images_internal(array $images, array $filenames, bool $resync_albums, bool $skip_files, ?int $required_status = null): array
	{
		$images = array_values(array_unique(array_filter(array_map('intval', $images))));
		if (!$images)
		{
			return [];
		}
		$sql = 'SELECT *
			FROM ' . $this->table_images . '
			WHERE ' . $this->db->sql_in_set('image_id', $images);
		if ($required_status !== null)
		{
			$sql .= '
				AND image_status = ' . (int) $required_status;
		}
		$result = $this->db->sql_query($sql);
		$image_rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_rows[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);
		if (!$image_rows)
		{
			return [];
		}

		$deleted_rows = [];
		if ($required_status === null)
		{
			$sql = 'DELETE FROM ' . $this->table_images . '
				WHERE ' . $this->db->sql_in_set('image_id', array_keys($image_rows));
			$this->db->sql_query($sql);
			$deleted_rows = $image_rows;
		}
		else
		{
			foreach ($image_rows as $image_id => $row)
			{
				$sql = 'DELETE FROM ' . $this->table_images . '
					WHERE image_id = ' . (int) $image_id . '
						AND image_status = ' . (int) $required_status;
				$this->db->sql_query($sql);
				if ($this->db->sql_affectedrows() === 1)
				{
					$deleted_rows[$image_id] = $row;
				}
			}
		}

		if (!$deleted_rows)
		{
			return [];
		}

		$images = array_keys($deleted_rows);
		$filenames = [];
		foreach ($deleted_rows as $image_id => $row)
		{
			$filenames[$image_id] = (string) $row['image_filename'];
		}
		if (!$skip_files)
		{
			$this->file->delete($filenames);
		}

		/**
		* Event delete images
		*
		* @event phpbbgallery.core.image.delete_images
		* @var	array	images			array of the image ids confirmed as deleted
		* @var	array	filenames		array of the image filenames
		* @since 1.2.0
		*/
		$vars = ['images', 'filenames'];
		extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.image.delete_images', compact($vars)));

		$resync_album_ids = $targets = [];
		$deleted_views = 0;
		foreach ($deleted_rows as $row)
		{
			$resync_album_ids[] = (int) $row['image_album_id'];
			if ($row['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED)
			{
				$album_id = (int) $row['image_album_id'];
				$targets[$album_id]['authors'][] = (int) $row['image_user_id'];
				$targets[$album_id]['last_image'] = (int) $row['image_id'];
			}
			$deleted_views += (int) $row['image_view_count'];
		}

		// Let's prepare notifications
		if (!empty($targets))
		{
			foreach ($targets as $album => $target)
			{
				$data = [
					'targets'	=> array_values(array_unique($target['authors'])),
					'album_id'	=> $album,
					'last_image'	=> $target['last_image'],
				];
				$this->notification_helper->notify('not_approved', $data);
			}

		}

		$resync_album_ids = array_unique($resync_album_ids);
		if ($deleted_views > 0)
		{
			$this->gallery_config->dec('num_views', $deleted_views, false);
		}

		$this->notify_state_change('delete', array_values($deleted_rows), $resync_album_ids);
		if ($resync_albums)
		{
			$this->album->update_infos($resync_album_ids);
		}

		return $images;
	}

	/**
	* Get the real filenames, so we can load/delete/edit the image-file.
	*
	* @param	array|int	$images		Array or integer with the image_id(s)
	* @return	array		Format: $image_id => $filename
	*/
	public function get_filenames(array|int $images): array
	{
		if (empty($images))
		{
			return [];
		}

		$filenames = [];
		$sql = 'SELECT image_id, image_filename
			FROM ' . $this->table_images . '
			WHERE ' . $this->db->sql_in_set('image_id', $images);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$filenames[(int) $row['image_id']] = $row['image_filename'];
		}
		$this->db->sql_freeresult($result);

		return $filenames;
	}

	/**
	 * Generate link to image
	 *
	 * @param    string $content what's in the link: image_name, thumbnail, fake_thumbnail, medium or lastimage_icon
	 * @param    string $mode where does the link lead to: image_page, image, next, none, or an event-provided mode
	 * @param    int $image_id
	 * @param    string $image_name
	 * @param    int $album_id
	 * @param    bool $is_gif we need to know whether we display a gif, so we can use a better medium-image
	 * @param    bool $count shall the image-link be counted as view? (Set to false from image_page.php to deny double increment)
	 * @param    string $additional_parameters additional parameters for the url, (starting with &amp;)
	 * @param int $next_image
	 * @return string
	 */
	public function generate_link(string $content, string $mode, int $image_id, string $image_name, int $album_id, bool $is_gif = false, bool $count = true, string $additional_parameters = '', int $next_image = 0): string
	{
		$image_page_url = $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $image_id]);
		// Embedded files are private application resources, so keep phpBB's
		// current session context for boards that transport the SID in URLs.
		// Shareable URLs are built separately by url::get_uri(), which removes it.
		$image_url = $this->helper->route('phpbbgallery_core_image_file_medium', ['image_id' => $image_id]);
		$thumb_url = $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id]);
		$medium_url = $image_url;
		switch ($content)
		{
			case 'image_name':
				$shorten_image_name = $image_name;
				$content = '<span style="font-weight: bold; display: inline;">' . $shorten_image_name . '</span>';
			break;
			case 'image_name_unbold':
				$shorten_image_name = $image_name;
				$content = $shorten_image_name;
			break;
			case 'thumbnail':
				$content = '<img src="{U_THUMBNAIL}" alt="{IMAGE_NAME}" title="{IMAGE_NAME}" style="max-width: 100%; max-height: 100%"/>';
				$content = str_replace(['{U_THUMBNAIL}', '{IMAGE_NAME}'], [$thumb_url, $image_name], $content);
			break;
			case 'fake_thumbnail':
				$content = '<img src="{U_THUMBNAIL}" alt="{IMAGE_NAME}" title="{IMAGE_NAME}" style="max-width: {FAKE_THUMB_SIZE}px; max-height: {FAKE_THUMB_SIZE}px;" />';
				$content = str_replace(['{U_THUMBNAIL}', '{IMAGE_NAME}', '{FAKE_THUMB_SIZE}'], [$thumb_url, $image_name, $this->gallery_config->get('mini_thumbnail_size')], $content);
			break;
			case 'medium':
				$content = '<img src="{U_MEDIUM}" alt="{IMAGE_NAME}" title="{IMAGE_NAME}" class="postimage" />';
				$content = str_replace(['{U_MEDIUM}', '{IMAGE_NAME}'], [$medium_url, $image_name], $content);
				//cheat for animated/transparent gif
				if ($is_gif)
				{
					$content = '<img src="{U_MEDIUM}" alt="{IMAGE_NAME}" title="{IMAGE_NAME}" style="max-width: {MEDIUM_WIDTH_SIZE}px; max-height: {MEDIUM_HEIGHT_SIZE}px;" />';
					$content = str_replace(['{U_MEDIUM}', '{IMAGE_NAME}', '{MEDIUM_HEIGHT_SIZE}', '{MEDIUM_WIDTH_SIZE}'], [$image_url, $image_name, $this->gallery_config->get('medium_height'), $this->gallery_config->get('medium_width')], $content);
				}
			break;
			case 'lastimage_icon':
				$content = $this->user->img('icon_topic_latest', 'VIEW_LATEST_IMAGE');
			break;
		}

		$url = $image_page_url;

		switch ($mode)
		{
			case 'image_page':
				$tpl = '<a href="{IMAGE_URL}" title="{IMAGE_NAME}" style="display: inline;">{CONTENT}</a>';
			break;
			case 'image_page_next':
				$tpl = '<a href="{IMAGE_URL}" title="{IMAGE_NAME}" class="right-box right">{CONTENT}</a>';
			break;
			case 'image_page_prev':
				$tpl = '<a href="{IMAGE_URL}" title="{IMAGE_NAME}" class="left-box left">{CONTENT}</a>';
			break;
			case 'image':
				$url = $image_url;
				$tpl = '<a href="{IMAGE_URL}" title="{IMAGE_NAME}">{CONTENT}</a>';
			break;
			case 'none':
				$tpl = '{CONTENT}';
			break;
			case 'next':
				if ($next_image)
				{
					$url = $this->url->append_sid('image_page', "album_id=$album_id&amp;image_id=$next_image{$additional_parameters}");
					$tpl = '<a href="{IMAGE_URL}" title="{IMAGE_NAME}">{CONTENT}</a>';
				}
				else
				{
					$tpl = '{CONTENT}';
				}
			break;
			default:
				$url = $image_url;

				$tpl = '{CONTENT}';

				/**
				* Event generate link
				*
				* @event phpbbgallery.core.image.generate_link
				* @var	string	mode	type of link
				* @var	string	tpl		html to be outputted
				* @since 1.2.0
				*/
				$vars = ['mode', 'tpl'];
				extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.image.generate_link', compact($vars)));
			break;
		}

		return str_replace(['{IMAGE_URL}', '{IMAGE_NAME}', '{CONTENT}'], [$url, $image_name, $content], $tpl);
	}

	/**
	* Handle user- & total image_counter
	*
	* @param	array	$image_id_ary	array with the image_ids which changed their status
	* @param	bool	$add			are we adding or removing the images
	* @param	bool	$readd			is it possible that there are images which aren't really changed
	* @return	void
	*/
	public function handle_counter(array|int $image_id_ary, bool $add, bool $readd = false): void
	{
		if (empty($image_id_ary))
		{
			return;
		}

		$num_images = $num_comments = 0;
		$sql = 'SELECT SUM(image_comments) as comments
			FROM ' . $this->table_images .'
			WHERE image_status ' . (($readd) ? '=' : '<>') . ' ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$result = $this->db->sql_query($sql);
		$num_comments = (int) $this->db->sql_fetchfield('comments');
		$this->db->sql_freeresult($result);

		$sql = 'SELECT COUNT(image_id) images, image_user_id
			FROM ' . $this->table_images .' 
			WHERE image_status ' . (($readd) ? '=' : '<>') . ' ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary) . '
			GROUP BY image_user_id';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$sql_ary = [
				'user_id'				=> (int) $row['image_user_id'],
				'user_images'			=> (int) $row['images'],
			];
			$num_images = $num_images + $row['images'];

			$this->gallery_user->set_user_id((int) $row['image_user_id'], false);
			$this->gallery_user->update_images((($add) ? $row['images'] : 0 - $row['images']));
		}
		$this->db->sql_freeresult($result);

		if ($add)
		{
			$this->gallery_config->inc('num_images', (int) $num_images);
			$this->gallery_config->inc('num_comments', (int) $num_comments);
		}
		else
		{
			$this->gallery_config->dec('num_images', (int) $num_images);
			$this->gallery_config->dec('num_comments', (int) $num_comments);
		}
	}

	/**
	 * Load an image row.
	 *
	 * @param int $image_id Image identifier
	 * @return array|false Image row, or false when it does not exist
	 */
	public function get_image_data(int $image_id): array|false
	{
		if (empty($image_id))
		{
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table_images .' WHERE image_id = ' . (int) $image_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row)
		{
			return $row;
		}

		return false;
	}

	/**
	 * Load an image row or stop the current request with a 404 response.
	 *
	 * @param int $image_id Image identifier
	 * @return array Image row
	 * @throws \phpbb\exception\http_exception When the image does not exist
	 */
	public function get_image_data_or_fail(int $image_id): array
	{
		$image_data = $this->get_image_data($image_id);
		if ($image_data === false)
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_NOT_EXIST');
		}

		return $image_data;
	}

	/**
	 * Hide an author's completed image until a moderator reviews its deletion.
	 *
	 * @return array|false Updated image row, or false when the request lost authorization/state
	 */
	public function request_deletion(int $image_id, int $requester_id): array|false
	{
		$request_time = time();
		$image_data = $this->get_image_data($image_id);
		if ($image_data === false
			|| $requester_id <= ANONYMOUS
			|| (int) $image_data['image_user_id'] !== $requester_id)
		{
			return false;
		}

		$previous_status = (int) $image_data['image_status'];
		if (!in_array($previous_status, [
			\phpbbgallery\core\block::STATUS_UNAPPROVED,
			\phpbbgallery\core\block::STATUS_APPROVED,
			\phpbbgallery\core\block::STATUS_LOCKED,
		], true))
		{
			return false;
		}

		$sql = 'UPDATE ' . $this->table_images . '
			SET image_status = ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . ',
				image_delete_previous_status = ' . (int) $previous_status . ',
				image_delete_request_user_id = ' . (int) $requester_id . ',
				image_delete_request_time = ' . (int) $request_time . '
			WHERE image_id = ' . (int) $image_id . '
				AND image_user_id = ' . (int) $requester_id . '
				AND image_status = ' . (int) $previous_status;
		$this->db->sql_query($sql);
		if ((int) $this->db->sql_affectedrows() !== 1)
		{
			return false;
		}

		$image_data['image_delete_previous_status'] = $previous_status;
		$image_data['image_delete_request_user_id'] = $requester_id;
		$image_data['image_delete_request_time'] = $request_time;
		$image_data['image_status'] = \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;
		$this->adjust_visible_counters([$image_data], false);
		$this->album->update_info((int) $image_data['image_album_id']);
		$this->gallery_cache->destroy_images();
		$this->notify_state_change('delete_request', [$image_data], [(int) $image_data['image_album_id']]);

		return $image_data;
	}

	/**
	 * Restore moderator-selected deletion requests to their previous state.
	 *
	 * @return int[] IDs confirmed as restored
	 */
	public function restore_deletion_requests(array $image_ids): array
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids))));
		if (!$image_ids)
		{
			return [];
		}

		$sql = 'SELECT *
			FROM ' . $this->table_images . '
			WHERE image_status = ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$pending = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$pending[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$restored = [];
		foreach ($pending as $image_id => $row)
		{
			$previous_status = (int) $row['image_delete_previous_status'];
			if (!in_array($previous_status, [
				\phpbbgallery\core\block::STATUS_UNAPPROVED,
				\phpbbgallery\core\block::STATUS_APPROVED,
				\phpbbgallery\core\block::STATUS_LOCKED,
			], true))
			{
				$previous_status = \phpbbgallery\core\block::STATUS_APPROVED;
			}
			$sql = 'UPDATE ' . $this->table_images . '
				SET image_status = ' . (int) $previous_status . ',
					image_delete_previous_status = ' . (int) \phpbbgallery\core\block::STATUS_APPROVED . ',
					image_delete_request_user_id = 0,
					image_delete_request_time = 0
				WHERE image_id = ' . (int) $image_id . '
					AND image_status = ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;
			$this->db->sql_query($sql);
			if ((int) $this->db->sql_affectedrows() === 1)
			{
				$row['image_status'] = $previous_status;
				$restored[$image_id] = $row;
			}
		}

		if (!$restored)
		{
			return [];
		}

		$this->adjust_visible_counters(array_values($restored), true);
		$album_ids = array_values(array_unique(array_map(
			static fn(array $row): int => (int) $row['image_album_id'],
			$restored
		)));
		$this->album->update_infos($album_ids);
		$this->gallery_cache->destroy_images();
		$this->notify_state_change('delete_restore', array_values($restored), $album_ids);

		return array_keys($restored);
	}

	private function adjust_visible_counters(array $image_rows, bool $add): void
	{
		$num_images = 0;
		$num_comments = 0;
		$user_images = [];
		foreach ($image_rows as $row)
		{
			$status = (int) ($row['image_delete_previous_status'] ?? $row['image_status']);
			if ($status === \phpbbgallery\core\block::STATUS_UNAPPROVED)
			{
				continue;
			}
			$num_images++;
			$num_comments += (int) $row['image_comments'];
			$user_id = (int) $row['image_user_id'];
			$user_images[$user_id] = ($user_images[$user_id] ?? 0) + 1;
		}

		foreach ($user_images as $user_id => $count)
		{
			$this->gallery_user->set_user_id($user_id, false);
			$this->gallery_user->update_images($add ? $count : -$count);
		}
		if ($add)
		{
			$this->gallery_config->inc('num_images', $num_images);
			$this->gallery_config->inc('num_comments', $num_comments);
		}
		else
		{
			$this->gallery_config->dec('num_images', $num_images);
			$this->gallery_config->dec('num_comments', $num_comments);
		}
	}

	/**
	* Approve image
	* @param	array	$image_id_ary	The image ID array to be approved
	* @param	int		$album_id		The album image is approved to (just save some queries for log)
	* @return	void
	*/
	public function approve_images(array $image_id_ary, int $album_id): void
	{
		$sql = 'SELECT image_id, image_name, image_user_id, image_album_id,
				image_filename, image_status AS previous_status
			FROM ' . $this->table_images . ' 
			WHERE ' . $this->db->sql_in_set('image_status', [
				\phpbbgallery\core\block::STATUS_UNAPPROVED,
				\phpbbgallery\core\block::STATUS_LOCKED,
			]) . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$result = $this->db->sql_query($sql);
		$targets = [];
		$approved_images = [];
		$unlocked_images = [];
		$changed_ids = [];
		$approved_ids = [];
		$unlocked_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$changed_ids[] = (int) $row['image_id'];
			$row['image_status'] = \phpbbgallery\core\block::STATUS_APPROVED;
			if ((int) $row['previous_status'] === (int) \phpbbgallery\core\block::STATUS_LOCKED)
			{
				$this->gallery_log->add_log('moderator', 'unlock', $album_id, $row['image_id'], ['LOG_GALLERY_UNLOCKED', $row['image_name']]);
				$unlocked_images[] = $row;
				$unlocked_ids[] = (int) $row['image_id'];
			}
			else
			{
				$this->gallery_log->add_log('moderator', 'approve', $album_id, $row['image_id'], ['LOG_GALLERY_APPROVED', $row['image_name']]);
				$targets[] = $row['image_user_id'];
				$approved_images[] = $row;
				$approved_ids[] = (int) $row['image_id'];
				$last_img = $row['image_id'];
			}
		}
		$this->db->sql_freeresult($result);
		if (!$changed_ids)
		{
			return;
		}

		if ($approved_ids)
		{
			$this->handle_counter($approved_ids, true, true);
		}
		if ($unlocked_ids)
		{
			$this->handle_counter($unlocked_ids, true);
		}
		$sql = 'UPDATE ' . $this->table_images . '
			SET image_status = ' . (int) \phpbbgallery\core\block::STATUS_APPROVED . '
			WHERE ' . $this->db->sql_in_set('image_id', $changed_ids);
		$this->db->sql_query($sql);

		if ($targets)
		{
			$data = [
				'targets'	=> $targets,
				'album_id'	=> $album_id,
				'last_image'	=> $last_img,
			];
			$this->notification_helper->notify('approved', $data);
			$this->notification_helper->new_image($data, false);
		}
		if ($approved_images)
		{
			$this->notification_helper->notify_moderation('approved', $approved_images, 'm_status');
		}
		$this->notify_state_change('approve', $approved_images, [$album_id]);
		$this->notify_state_change('unlock', $unlocked_images, [$album_id]);
		$this->notification_helper->notify_moderation('unlocked', $unlocked_images, 'm_status');
		if ($approved_images)
		{
			$this->notify_approved_images($approved_images, $album_id);
		}
	}

	/** Materialize approved sources only for the duration of synchronous listeners. */
	private function notify_approved_images(array $approved_images, int $album_id): void
	{
		$source_objects = [];
		foreach ($approved_images as &$image_data)
		{
			try
			{
				$source = $this->storage_workspace->materialize(
					\phpbbgallery\core\storage\provider_interface::SOURCE,
					(string) $image_data['image_filename']
				);
				$source_objects[] = $source;
				$image_data['source_path'] = $source->get_path();
			}
			catch (\RuntimeException)
			{
				$image_data['source_path'] = '';
			}
		}
		unset($image_data);

		try
		{
			/**
			 * Notify add-ons after images become approved.
			 *
			 * Source paths are verified workspace leases and are valid only while
			 * the synchronous event is being dispatched.
			 *
			 * @event phpbbgallery.core.image.approve_after
			 * @var array approved_images Approved rows with temporary source paths
			 * @var int   album_id       Album used by the moderation action
			 * @since 3.4.0
			 */
			$vars = ['approved_images', 'album_id'];
			extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.image.approve_after', compact($vars)));
		}
		finally
		{
			foreach ($source_objects as $source)
			{
				$source->release();
			}
		}
	}

	/**
	* UnApprove image
	* @param	array	$image_id_ary	The image ID array to be unapproved
	* @param	int		$album_id		The album image is approved to (just save some queries for log)
	* @return	void
	*/
	public function unapprove_images(array $image_id_ary, int $album_id): void
	{
		$this->handle_counter($image_id_ary, false);

		$sql = 'UPDATE ' . $this->table_images .' 
			SET image_status = ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$this->db->sql_query($sql);

		$sql = 'SELECT image_id, image_name, image_user_id, image_album_id
			FROM ' . $this->table_images .' 
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$result = $this->db->sql_query($sql);
		$changed_images = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->gallery_log->add_log('moderator', 'unapprove', $album_id, $row['image_id'], ['LOG_GALLERY_UNAPPROVED', $row['image_name']]);
			$changed_images[] = $row;
		}
		$this->db->sql_freeresult($result);
		$this->notify_state_change('unapprove', $changed_images, [$album_id]);
		$this->notification_helper->notify_moderation('unapproved', $changed_images, 'm_status');
	}

	/**
	 * Move image
	 * @param array $image_id_ary
	 * @param int $album_id
	 * @return void
	 */
	public function move_image(array $image_id_ary, int $album_id): void
	{
		$target_data = $this->album->get_info($album_id);
		if (!$this->album_operation->allows('move_in', $target_data))
		{
			throw new \phpbb\exception\http_exception(403, 'NO_PERMISSIONS');
		}

		$sql = 'SELECT image_id, image_album_id
			FROM ' . $this->table_images . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$result = $this->db->sql_query($sql);
		$moved_image_ids = [];
		$moved_image_rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$source_album_id = (int) $row['image_album_id'];
			if ($source_album_id === $album_id)
			{
				continue;
			}

			$moved_image_ids[] = (int) $row['image_id'];
			$moved_image_rows[] = $row;
		}
		$this->db->sql_freeresult($result);
		if (!$moved_image_ids)
		{
			return;
		}

		// Store images to cache (so we can log them)
		$image_cache = $this->gallery_cache->get_images($moved_image_ids);
		$image_move_data = [
			'image_album_id' => (int) $album_id,
		];

		/**
		 * Allow optional album-type providers to add fields to an image move.
		 *
		 * @event phpbbgallery.core.image.prepare_move
		 * @var array target_data     Destination album data
		 * @var array moved_image_ids Image identifiers that will be moved
		 * @var array image_move_data Fields persisted by the atomic move query
		 * @since 4.1.0
		 */
		$vars = ['target_data', 'moved_image_ids', 'image_move_data'];
		extract($this->phpbb_dispatcher->trigger_event(
			'phpbbgallery.core.image.prepare_move',
			compact($vars)
		));

		$sql = 'UPDATE ' . $this->table_images . '
			SET ' . $this->db->sql_build_array('UPDATE', $image_move_data) . '
			WHERE ' . $this->db->sql_in_set('image_id', $moved_image_ids);
		$this->db->sql_query($sql);

		$this->gallery_report->move_images($moved_image_ids, $album_id);

		foreach ($moved_image_ids as $image)
		{
			$this->gallery_log->add_log('moderator', 'move', 0, $image, ['LOG_GALLERY_MOVED', $image_cache[$image]['image_name'], $target_data['album_name']]);
		}
		$this->gallery_cache->destroy_images();
		$this->notify_state_change(
			'move',
			$moved_image_rows,
			array_column($moved_image_rows, 'image_album_id')
		);
	}

	/**
	* Lock images
	* @param	array	$image_id_ary	Array of images we want to lock
	* @param	int		$album_id		Album id, so we can log the action
	* @return	void
	*/
	public function lock_images(array $image_id_ary, int $album_id): void
	{
		$this->handle_counter($image_id_ary, false);

		$sql = 'UPDATE ' . $this->table_images . ' 
			SET image_status = ' . (int) \phpbbgallery\core\block::STATUS_LOCKED . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$this->db->sql_query($sql);

		$sql = 'SELECT image_id, image_name, image_user_id, image_album_id
			FROM ' . $this->table_images . ' 
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND ' . $this->db->sql_in_set('image_id', $image_id_ary);
		$result = $this->db->sql_query($sql);
		$changed_images = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->gallery_log->add_log('moderator', 'lock', $album_id, $row['image_id'], ['LOG_GALLERY_LOCKED', $row['image_name']]);
			$changed_images[] = $row;
		}
		$this->db->sql_freeresult($result);
		$this->notify_state_change('lock', $changed_images, [$album_id]);
		$this->notification_helper->notify_moderation('locked', $changed_images, 'm_status');
	}

	/**
	* Get the last accessible public image.
	*
	* @return array|false Image row, or false when no image is available
	*/
	public function get_last_image(): array|false
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$public = $this->album->get_public_albums();
		$sql_order = 'image_id DESC';
		$sql_limit = 1;
		$sql = 'SELECT * 
			FROM ' . $this->table_images . '
			WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
				AND (
					(
						' . $this->db->sql_in_set('image_album_id', $this->gallery_auth->acl_album_ids('i_view'), false, true) . '
						AND (
							image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
							OR image_user_id = ' . (int) $this->user->data['user_id'] . '
						)
					)
					OR ' . $this->db->sql_in_set('image_album_id', $this->gallery_auth->acl_album_ids('m_status'), false, true) . '
				)
				AND ' . $this->db->sql_in_set('image_album_id', $public, true, true) . '
			ORDER BY ' . $sql_order;
		$result = $this->db->sql_query_limit($sql, $sql_limit);

		$row = $this->db->sql_fetchrow($result);

		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * Assign an image summary to a template block.
	 *
	 * @param string $image_block_name Template block name
	 * @param array  $image_data       Image and album data
	 * @param int    $display_option   Bitmask of IMAGE_SHOW_* options
	 * @param string $thumbnail_link   Thumbnail destination mode
	 * @param string $imagename_link   Image-name destination mode
	 * @param array  $additional_vars Add-on template variables for this image
	 * @return void
	 */
	public function assign_block(string $image_block_name, array $image_data, int $display_option = 0, string $thumbnail_link = 'image_page', string $imagename_link = 'image_page', array $additional_vars = []): void
	{
		// Now let's get display options
		$show_ip         = ($display_option & self::IMAGE_SHOW_IP) !== 0;
		$show_ratings    = ($display_option & self::IMAGE_SHOW_RATINGS) !== 0;
		$show_username   = ($display_option & self::IMAGE_SHOW_USERNAME) !== 0;
		$show_views      = ($display_option & self::IMAGE_SHOW_VIEWS) !== 0;
		$show_time       = ($display_option & self::IMAGE_SHOW_TIME) !== 0;
		$show_imagename  = ($display_option & self::IMAGE_SHOW_IMAGENAME) !== 0;
		$show_comments   = ($display_option & self::IMAGE_SHOW_COMMENTS) !== 0;
		$show_album      = ($display_option & self::IMAGE_SHOW_ALBUM) !== 0;
		$show_resolution = ($display_option & self::IMAGE_SHOW_RESOLUTION) !== 0;

		switch ($thumbnail_link)
		{
			case 'image_page':
				$action = $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $image_data['image_id']]);
				break;
			case 'image':
				$action = $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => (int) $image_data['image_id']]);
				break;
			default:
				$action = false;
				break;
		}

		switch ($imagename_link)
		{
			case 'image_page':
				$action_image = $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $image_data['image_id']]);
				break;
			case 'image':
				$action_image = $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => (int) $image_data['image_id']]);
				break;
			default:
				$action_image = false;
				break;
		}

		$can_moderate = $this->gallery_auth->acl_check('m_status', $image_data['image_album_id'], $image_data['album_user_id']);
		$hide_private_data = $this->image_visibility->hides_private_data(
			$image_data,
			(int) $this->user->data['user_id'],
			$can_moderate
		);
		$private_data_label = $hide_private_data ? $this->image_visibility->private_data_label(
			$image_data,
			(int) $this->user->data['user_id'],
			$can_moderate,
			$this->language->lang('GALLERY_PRIVATE_USER')
		) : '';
		$hide_results = $this->image_visibility->hides_results($image_data, $can_moderate);
		$image_award = $this->image_visibility->award($image_data);
		$image_width = max(0, (int) ($image_data['image_width'] ?? 0));
		$image_height = max(0, (int) ($image_data['image_height'] ?? 0));

		$template_vars = [
			'IMAGE_ID'		=> $image_data['image_id'],
			'U_IMAGE'		=> $show_imagename ? $action_image : false,
			'UC_IMAGE_NAME'	=> $show_imagename ? $image_data['image_name'] : false,
			'U_ALBUM'	=> $show_album ? $this->helper->route('phpbbgallery_core_album', ['album_id' => (int) $image_data['album_id']]) : false,
			'ALBUM_NAME'	=> $show_album ? $image_data['album_name'] : false,
			'IMAGE_VIEWS'	=> $show_views ? $image_data['image_view_count'] : -1,
			//'UC_THUMBNAIL'	=> 'self::generate_link('thumbnail', $phpbb_ext_gallery->config->get('link_thumbnail'), $image_data['image_id'], $image_data['image_name'], $image_data['image_album_id']),
			'UC_THUMBNAIL'		=> $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => (int) $image_data['image_id']]),
			'UC_THUMBNAIL_ACTION'	=> $action,
			'S_UNAPPROVED'	=> ($can_moderate && ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED)) ? true : false,
			'S_LOCKED'		=> ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_LOCKED) ? true : false,
			'S_REPORTED'	=> ($this->gallery_auth->acl_check('m_report', $image_data['image_album_id'], $image_data['album_user_id']) && $image_data['image_reported']) ? true : false,
			'POSTER'		=> $show_username ? ($hide_private_data ? $private_data_label : get_username_string('full', $image_data['image_user_id'], $image_data['image_username'], $image_data['image_user_colour'])) : false,
			'TIME'			=> $show_time ? $this->user->format_date($image_data['image_time']) : false,
			'IMAGE_RESOLUTION' => ($show_resolution && $image_width > 0 && $image_height > 0)
				? $this->language->lang('IMAGE_RESOLUTION_VALUE', $image_width, $image_height)
				: false,
			'IMAGE_AWARD'	=> $image_award['label'],
			'IMAGE_AWARD_TITLE' => $image_award['title'],
			'S_IMAGE_AWARD_RANK' => $image_award['rank'],

			'S_RATINGS'		=> (!$hide_results && $this->gallery_config->get('allow_rates') == 1 && $show_ratings) ? ($image_data['image_rates'] > 0 ? $image_data['image_rate_avg'] / 100 : $this->language->lang('NOT_RATED')) : false,
			'U_RATINGS'		=> !$hide_results ? $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $image_data['image_id']]) . '#rating' : false,
			'L_COMMENTS'	=> !$hide_results ? (($image_data['image_comments'] == 1) ? $this->language->lang('COMMENT') : $this->language->lang('COMMENTS')) : false,
			'S_COMMENTS'	=> (!$hide_results && $show_comments) ? (($this->gallery_config->get('allow_comments') && $this->gallery_auth->acl_check('c_read', $image_data['image_album_id'], $image_data['album_user_id'])) ? (($image_data['image_comments']) ? $image_data['image_comments'] : $this->language->lang('NO_COMMENTS')) : '') : false,
			'U_COMMENTS'	=> !$hide_results ? $this->helper->route('phpbbgallery_core_image', ['image_id' => (int) $image_data['image_id']]) . '#comments' : false,
			'U_USER_IP'		=> $show_ip && $can_moderate ? $image_data['image_user_ip'] : false,

			'S_IMAGE_REPORTED'		=> $image_data['image_reported'],
			'U_IMAGE_REPORTED'		=> ($image_data['image_reported'] && $this->gallery_auth->acl_check('m_report', $image_data['image_album_id'], $image_data['album_user_id'])) ? $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => (int) $image_data['image_id']]) : '',
			'S_STATUS_APPROVED'		=> ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_APPROVED) ? true : false,
			'S_STATUS_UNAPPROVED'	=> ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED) ? true : false,
			'S_STATUS_UNAPPROVED_ACTION'	=> ($can_moderate && $image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED) ? $this->helper->route('phpbbgallery_core_moderate_image_approve', ['image_id' => (int) $image_data['image_id']]) : '',
			'S_STATUS_LOCKED'		=> ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_LOCKED) ? true : false,

			'U_REPORT'	=> ($this->gallery_auth->acl_check('m_report', $image_data['image_album_id'], $image_data['album_user_id']) && $image_data['image_reported']) ? $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => (int) $image_data['image_id']]) : '',
			'U_STATUS'	=> $can_moderate ? $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => (int) $image_data['image_id']]) : '',
			'L_STATUS'	=> ($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED) ? $this->language->lang('APPROVE_IMAGE') : (($image_data['image_status'] == (int) \phpbbgallery\core\block::STATUS_APPROVED) ? $this->language->lang('CHANGE_IMAGE_STATUS') : $this->language->lang('UNLOCK_IMAGE')),
		];
		$this->template->assign_block_vars($image_block_name, array_merge($template_vars, $additional_vars));
	}
}
