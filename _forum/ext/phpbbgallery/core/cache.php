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

namespace phpbbgallery\core;

class cache
{
	private \phpbb\cache\service $phpbb_cache;
	private \phpbb\db\driver\driver_interface $phpbb_db;
	protected string $table_albums;
	protected string $table_images;
	private ?array $albums = null;
	private array $images = [];
	private bool $images_loaded = false;

	/**
	* cache constructor.
	* @param \phpbb\cache\service $cache
	* @param \phpbb\db\driver\driver_interface $db
	* @param string $albums_table
	* @param string $images_table
	*/
	public function __construct(\phpbb\cache\service $cache, \phpbb\db\driver\driver_interface $db,
								string $albums_table, string $images_table)
	{
		$this->phpbb_cache = $cache;
		$this->phpbb_db = $db;
		$this->table_albums = $albums_table;
		$this->table_images = $images_table;
	}

	public function get(string $data = 'albums'): array|false
	{
		switch ($data)
		{
			case 'albums':
				return $this->get_albums();
			default:
				return false;
		}
	}

	public function get_albums(): array
	{
		if ($this->albums !== null)
		{
			return $this->albums;
		}

		$albums = $this->phpbb_cache->get('_albums');
		if (!is_array($albums))
		{
			$sql = 'SELECT a.album_id, a.parent_id, a.album_name, a.album_type, a.left_id, a.right_id, a.album_user_id, a.display_in_rrc, a.album_auth_access
				FROM ' . $this->table_albums. ' a
				LEFT JOIN ' . USERS_TABLE . ' u
					ON (u.user_id = a.album_user_id)
				ORDER BY u.username_clean, a.album_user_id, a.left_id ASC';
			$result = $this->phpbb_db->sql_query($sql);

			$albums = array();
			while ($row = $this->phpbb_db->sql_fetchrow($result))
			{
				$albums[(int) $row['album_id']] = array(
					'album_id'			=> (int) $row['album_id'],
					'parent_id'			=> (int) $row['parent_id'],
					'album_name'		=> $row['album_name'],
					'album_type'		=> (int) $row['album_type'],
					'left_id'			=> (int) $row['left_id'],
					'right_id'			=> (int) $row['right_id'],
					'album_user_id'		=> (int) $row['album_user_id'],
					'display_in_rrc'	=> (bool) $row['display_in_rrc'],
					'album_auth_access'	=> (int) $row['album_auth_access'],
				);
			}
			$this->phpbb_db->sql_freeresult($result);
			$this->phpbb_cache->put('_albums', $albums);
		}

		$this->albums = $albums;
		return $this->albums;
	}

	/**
	 * Get images cache - get some images and put them in cache
	 * @param    (array)    $image_ids_array    Array of images to be put in cache
	 * return    (array)    $images                Array of the information we have for that images
	 * @return array
	 */
	public function get_images(array $image_ids_array): array
	{
		$image_ids = array_values(array_unique(array_map('intval', $image_ids_array)));
		if (empty($image_ids))
		{
			return [];
		}

		if (!$this->images_loaded)
		{
			$cached_images = $this->phpbb_cache->get('_images');
			$this->images = is_array($cached_images) ? $cached_images : [];
			$this->images_loaded = true;
		}

		$missing_image_ids = array_values(array_diff($image_ids, array_map('intval', array_keys($this->images))));
		if (!empty($missing_image_ids))
		{
			$sql_array = array(
				'SELECT'	=> 'i.*, a.album_name',
				'FROM'	=> array(
					$this->table_images	=> 'i',
					$this->table_albums	=> 'a'
				),
				'WHERE'	=> $this->phpbb_db->sql_in_set('image_id', $missing_image_ids) . ' AND i.image_album_id = a.album_id'
			);
			$sql = $this->phpbb_db->sql_build_query('SELECT', $sql_array);
			$result = $this->phpbb_db->sql_query($sql);

			while ($row = $this->phpbb_db->sql_fetchrow($result))
			{
				$this->images[(int) $row['image_id']] = array(
					'image_id'				=> $row['image_id'],
					'image_filename'		=> $row['image_filename'],
					'image_name'			=> $row['image_name'],
					'image_name_clean'		=> $row['image_name_clean'],
					'image_desc'			=> $row['image_desc'],
					'image_desc_uid'		=> $row['image_desc_uid'],
					'image_desc_bitfield'	=> $row['image_desc_bitfield'],
					'image_user_id'			=> $row['image_user_id'],
					'image_username'		=> $row['image_username'],
					'image_username_clean'	=> $row['image_username_clean'],
					'image_user_colour'		=> $row['image_user_colour'],
					'image_user_ip'			=> $row['image_user_ip'],
					'image_time'			=> $row['image_time'],
					'image_album_id'		=> $row['image_album_id'],
					'image_view_count'		=> $row['image_view_count'],
					'image_status'			=> $row['image_status'],
					'image_filemissing'		=> $row['image_filemissing'],
					'image_rates'			=> $row['image_rates'],
					'image_rate_points'		=> $row['image_rate_points'],
					'image_rate_avg'		=> $row['image_rate_avg'],
					'image_comments'		=> $row['image_comments'],
					'image_last_comment'	=> $row['image_last_comment'],
					'image_allow_comments'	=> $row['image_allow_comments'],
					'image_favorited'		=> $row['image_favorited'],
					'image_reported'		=> $row['image_reported'],
					'filesize_upload'		=> $row['filesize_upload'],
					'filesize_medium'		=> $row['filesize_medium'],
					'filesize_cache'		=> $row['filesize_cache'],
					'album_name'			=> $row['album_name'],
				);
			}
			$this->phpbb_db->sql_freeresult($result);
			$this->phpbb_cache->put('_images', $this->images);
		}

		return array_intersect_key($this->images, array_fill_keys($image_ids, true));
	}

	/**
	* Destroy images cache - if we had updated image information or we want other set - we will have to destroy cache
	*/
	public function destroy_images(): void
	{
		$this->phpbb_cache->destroy('_images');
		$this->images = [];
		$this->images_loaded = false;
	}

	/**
	* Destroy album cache
	* Basically some tests fail due album cache not destroyed ...
	* So lets try it now?
	*/
	public function destroy_albums(): void
	{
		$this->phpbb_cache->destroy('_albums');
		$this->albums = null;
	}

	/**
	 * Destroy interface for phpbb_cache destroy
	 * @param $target
	 * @param bool $subtarget
	 */
	public function destroy(string $target, string|false $subtarget = false): void
	{
		if ($target === '_images')
		{
			$this->images = [];
			$this->images_loaded = false;
		}
		else if ($target === '_albums')
		{
			$this->albums = null;
		}

		if ($subtarget)
		{
			$this->phpbb_cache->destroy($target, $subtarget);
		}
		else
		{
			$this->phpbb_cache->destroy($target);
		}
	}
}
