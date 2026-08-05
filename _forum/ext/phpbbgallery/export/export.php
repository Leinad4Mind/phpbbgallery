<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export;

/**
 * Decide what may be exported, and hand the writer everything it needs.
 *
 * Permissions are applied once, when a job is created, so a job that is already
 * running cannot widen its own reach; the archive writer only ever sees a list of
 * image ids that were allowed at that moment.
 */
class export
{
	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $auth;

	/** @var \phpbbgallery\core\cache */
	protected \phpbbgallery\core\cache $cache;

	/** @var string */
	protected string $table_albums;

	/** @var string */
	protected string $table_images;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db           Database object
	 * @param \phpbbgallery\core\auth\auth      $gallery_auth Gallery auth object
	 * @param \phpbbgallery\core\cache          $gallery_cache Gallery cache object
	 * @param string                            $albums_table Albums table
	 * @param string                            $images_table Images table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\cache $gallery_cache, string $albums_table, string $images_table)
	{
		$this->db = $db;
		$this->auth = $gallery_auth;
		$this->cache = $gallery_cache;
		$this->table_albums = $albums_table;
		$this->table_images = $images_table;
	}

	/**
	 * Collect every image an administrator asked for.
	 *
	 * @param array $album_ids Albums to export, empty for the whole gallery
	 * @return array Selection with 'image_ids' and 'bytes'
	 */
	public function resolve_admin_selection(array $album_ids): array
	{
		$where = 'image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
			AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
			AND image_filemissing = 0';

		$album_ids = $this->clean_ids($album_ids);
		if (!empty($album_ids))
		{
			$where .= ' AND ' . $this->db->sql_in_set('image_album_id', $album_ids);
		}

		return $this->fetch_selection($where);
	}

	/**
	 * Collect the images a member uploaded themselves.
	 *
	 * A member keeps their own images even while they wait for approval, but an album
	 * they have since lost access to drops out of the selection - the same bound the
	 * gallery puts on any other listing of images a member once touched.
	 *
	 * @param int $user_id Member the images belong to
	 * @return array Selection with 'image_ids' and 'bytes'
	 */
	public function resolve_own_images(int $user_id): array
	{
		$this->auth->load_user_permissions($user_id);
		$visible_albums = $this->auth->acl_album_ids('i_view');

		if (empty($visible_albums))
		{
			return ['image_ids' => [], 'bytes' => 0];
		}

		$where = 'image_user_id = ' . (int) $user_id . '
			AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
			AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
			AND image_filemissing = 0
			AND ' . $this->db->sql_in_set('image_album_id', $visible_albums);

		return $this->fetch_selection($where);
	}

	/**
	 * Read the images of one batch, with everything the archive and manifest need.
	 *
	 * @param array $image_ids Images to read
	 * @return array Rows in the order the ids were given
	 */
	public function get_rows(array $image_ids): array
	{
		$image_ids = $this->clean_ids($image_ids);
		if (empty($image_ids))
		{
			return [];
		}

		$albums = $this->cache->get_albums();

		$sql = 'SELECT i.image_id, i.image_user_id, i.image_name, i.image_filename, i.image_username, i.image_time,
				i.image_view_count, i.filesize_upload, i.image_desc, i.image_desc_uid, i.image_desc_bitfield,
				i.image_album_id, a.album_name, a.album_user_id, u.username AS album_owner
			FROM ' . $this->table_images . ' i
			LEFT JOIN ' . $this->table_albums . ' a
				ON (i.image_album_id = a.album_id)
			LEFT JOIN ' . USERS_TABLE . ' u
				ON (u.user_id = a.album_user_id)
			WHERE ' . $this->db->sql_in_set('i.image_id', $image_ids);
		$result = $this->db->sql_query($sql);

		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_id = (int) $row['image_album_id'];
			$rows[(int) $row['image_id']] = [
				'image_id' => (int) $row['image_id'],
				'author_id' => (int) $row['image_user_id'],
				'album_id' => $album_id,
				'album_name' => (string) $row['album_name'],
				'album_segments' => $this->album_segments($album_id, $albums, (string) $row['album_owner']),
				'image_name' => (string) $row['image_name'],
				'image_filename' => (string) $row['image_filename'],
				'uploader' => (string) $row['image_username'],
				'image_time' => (int) $row['image_time'],
				'image_view_count' => (int) $row['image_view_count'],
				'filesize_upload' => (int) $row['filesize_upload'],
				'description' => $this->flatten_description((string) $row['image_desc'], (string) $row['image_desc_uid'], (string) $row['image_desc_bitfield']),
			];
		}
		$this->db->sql_freeresult($result);

		// Keep the caller's order so an archive is written in a predictable sequence.
		$ordered = [];
		foreach ($image_ids as $image_id)
		{
			if (isset($rows[$image_id]))
			{
				$ordered[] = $rows[$image_id];
			}
		}

		return $ordered;
	}

	/**
	 * Read the album names a single-album export can be labelled with.
	 *
	 * @param int $album_id Album identifier
	 * @return string Album name, empty when the album is unknown
	 */
	public function get_album_name(int $album_id): string
	{
		$albums = $this->cache->get_albums();

		return isset($albums[$album_id]) ? (string) $albums[$album_id]['album_name'] : '';
	}

	/**
	 * Walk an album up to the root, producing the folders it lives under.
	 *
	 * Personal albums are grouped under one folder per member, so a gallery with
	 * hundreds of them does not spill its members' albums across the archive root.
	 *
	 * @param int    $album_id   Album identifier
	 * @param array  $albums     Album tree from the gallery cache
	 * @param string $owner_name Username owning the album, for personal albums
	 * @return array Album names from the root down
	 */
	public function album_segments(int $album_id, array $albums, string $owner_name = ''): array
	{
		if (!isset($albums[$album_id]))
		{
			return ['album_' . $album_id];
		}

		$segments = [];
		$current = $album_id;
		$seen = [];

		// A parent chain is data, and data can be broken; stop rather than loop.
		while (isset($albums[$current]) && !isset($seen[$current]))
		{
			$seen[$current] = true;
			array_unshift($segments, (string) $albums[$current]['album_name']);
			$current = (int) $albums[$current]['parent_id'];
			if ($current === 0)
			{
				break;
			}
		}

		if ((int) $albums[$album_id]['album_user_id'] > \phpbbgallery\core\block::PUBLIC_ALBUM)
		{
			array_unshift($segments, archive::PERSONAL_ROOT, $owner_name !== '' ? $owner_name : 'user_' . (int) $albums[$album_id]['album_user_id']);
		}

		return $segments;
	}

	/**
	 * Run the selection query and total the space it needs.
	 *
	 * @param string $where SQL condition
	 * @return array Selection with 'image_ids' and 'bytes'
	 */
	protected function fetch_selection(string $where): array
	{
		$sql = 'SELECT image_id, filesize_upload
			FROM ' . $this->table_images . '
			WHERE ' . $where . '
			ORDER BY image_album_id ASC, image_id ASC';
		// One over the ceiling, so the caller can tell "at the limit" from "over it".
		$result = $this->db->sql_query_limit($sql, job_storage::MAX_IMAGES + 1);

		$image_ids = [];
		$bytes = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_ids[] = (int) $row['image_id'];
			$bytes += (int) $row['filesize_upload'];
		}
		$this->db->sql_freeresult($result);

		return ['image_ids' => $image_ids, 'bytes' => $bytes];
	}

	/**
	 * Render a stored description down to the plain text a manifest can carry.
	 *
	 * @param string $text     Stored description
	 * @param string $uid      BBCode uid
	 * @param string $bitfield BBCode bitfield
	 * @return string
	 */
	protected function flatten_description(string $text, string $uid, string $bitfield): string
	{
		if ($text === '')
		{
			return '';
		}

		$text = generate_text_for_display($text, $uid, $bitfield, 7);
		$text = str_replace(['<br />', '<br>'], "\n", $text);

		return trim(html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8'));
	}

	/**
	 * @param array $ids Candidate identifiers
	 * @return array Positive integers, without duplicates
	 */
	protected function clean_ids(array $ids): array
	{
		$clean = [];
		foreach ($ids as $id)
		{
			$id = (int) $id;
			if ($id > 0)
			{
				$clean[$id] = $id;
			}
		}

		return array_values($clean);
	}
}
