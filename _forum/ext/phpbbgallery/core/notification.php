<?php
/**
*
* @package phpBB Gallery
* @version $Id$
* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

namespace phpbbgallery\core;

class notification
{
	/**
	 * phpBB database connection
	 *
	 * @var \phpbb\db\driver\driver_interface
	 */
	protected \phpbb\db\driver\driver_interface $db;

	/**
	 * Current phpBB user
	 *
	 * @var \phpbb\user
	 */
	protected \phpbb\user $user;

	/**
	 * Gallery watch table
	 *
	 * @var string
	 */
	protected string $watch_table;

	/**
	 * notification constructor.
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\user $user
	 * @param string $watch_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user,
								string $watch_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->watch_table = $watch_table;
	}

	/**
	 * Add images to watch-list
	 *
	 * @param    mixed 		$image_ids Array or integer with image_id where we delete from the watch-list.
	 * @param 	bool|int 	$user_id   If not set, it uses the currents user_id
	 */
	public function add(array|int $image_ids, int|false $user_id = false): void
	{
		$image_ids = self::cast_mixed_int2array($image_ids);
		if (!$image_ids)
		{
			return;
		}

		$user_id = (int) (($user_id) ? $user_id : $this->user->data['user_id']);

		// First check if we are not subscribed already for some
		$sql = 'SELECT * FROM ' . $this->watch_table . '  WHERE user_id = ' . (int) $user_id . ' AND ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$exclude = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$exclude[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);
		$image_ids = array_diff($image_ids, $exclude);

		foreach ($image_ids as $image_id)
		{
			$sql_ary = [
				'image_id'		=> (int) $image_id,
				'user_id'		=> (int) $user_id,
			];
			$sql = 'INSERT INTO ' . $this->watch_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Add albums to watch-list
	 *
	 * @param    mixed 		$album_ids Array or integer with album_id where we delete from the watch-list.
	 * @param 	bool|int 	$user_id   If not set, it uses the currents user_id
	 */
	public function add_albums(array|int $album_ids, int|false $user_id = false): void
	{
		$album_ids = self::cast_mixed_int2array($album_ids);
		if (!$album_ids)
		{
			return;
		}

		$user_id = (int) (($user_id) ? $user_id : $this->user->data['user_id']);

		// First check if we are not subscribed already for some
		$sql = 'SELECT * FROM ' . $this->watch_table . '  WHERE user_id = ' . (int) $user_id . ' AND ' . $this->db->sql_in_set('album_id', $album_ids);
		$result = $this->db->sql_query($sql);
		$exclude = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$exclude[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);
		$album_ids = array_diff($album_ids, $exclude);

		foreach ($album_ids as $album_id)
		{
			$sql_ary = [
				'album_id'		=> (int) $album_id,
				'user_id'		=> (int) $user_id,
			];
			$sql = 'INSERT INTO ' . $this->watch_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
	}

	/**
	* Remove images from watch-list
	*
	* @param	mixed	$image_ids		Array or integer with image_id where we delete from the watch-list.
	* @param	mixed	$user_ids		If not set, it uses the currents user_id
	*/
	public function remove(array|int $image_ids, array|int|false $user_ids = false): void
	{
		$image_ids = self::cast_mixed_int2array($image_ids);
		$user_ids = self::cast_mixed_int2array((($user_ids) ? $user_ids : $this->user->data['user_id']));
		if (!$image_ids || !$user_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->watch_table . ' 
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids) . '
				AND ' . $this->db->sql_in_set('image_id', $image_ids);
		$this->db->sql_query($sql);
	}

	/**
	* Remove albums from watch-list
	*
	* @param	mixed	$album_ids		Array or integer with album_id where we delete from the watch-list.
	* @param	mixed	$user_ids		If not set, it uses the currents user_id
	*/
	public function remove_albums(array|int $album_ids, array|int|false $user_ids = false): void
	{
		$album_ids = self::cast_mixed_int2array($album_ids);
		$user_ids = self::cast_mixed_int2array((($user_ids) ? $user_ids : $this->user->data['user_id']));
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
	* Delete given image_ids from watch-list
	*
	* @param	mixed	$image_ids		Array or integer with image_id where we delete from watch-list.
	*/
	public function delete_images(array|int $image_ids): void
	{
		$image_ids = self::cast_mixed_int2array($image_ids);
		if (!$image_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->watch_table . ' 
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$this->db->sql_query($sql);
	}


	/**
	* Delete given album_ids from watch-list
	*
	* @param	mixed	$album_ids		Array or integer with album_id where we delete from watch-list.
	*/
	public function delete_albums(array|int $album_ids): void
	{
		$album_ids = self::cast_mixed_int2array($album_ids);
		if (!$album_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->watch_table . ' 
			WHERE ' . $this->db->sql_in_set('album_id', $album_ids);

		$this->db->sql_query($sql);
	}

	public static function cast_mixed_int2array(array|int $ids): array
	{
		if (is_array($ids))
		{
			return array_values(array_unique(array_map('intval', $ids)));
		}

		return [(int) $ids];
	}
}
