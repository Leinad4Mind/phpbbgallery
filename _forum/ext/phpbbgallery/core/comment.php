<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

class comment
{
	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $config;

	/** @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $auth;

	/** @var \phpbbgallery\core\block */
	protected \phpbbgallery\core\block $block;

	/** @var \phpbbgallery\core\policy\album_operation */
	protected \phpbbgallery\core\policy\album_operation $album_operation;

	/** @var string */
	protected string $comments_table;

	/** @var string */
	protected string $images_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user                       $user
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbbgallery\core\config         $config
	 * @param \phpbbgallery\core\auth\auth      $auth
	 * @param \phpbbgallery\core\block         $block
	 * @param \phpbbgallery\core\policy\album_operation $album_operation
	 * @param string                            $comments_table
	 * @param string                            $images_table
	 */

	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db,
								\phpbbgallery\core\config $config, \phpbbgallery\core\auth\auth $auth, \phpbbgallery\core\block $block,
								\phpbbgallery\core\policy\album_operation $album_operation,
								string $comments_table, string $images_table)
	{
		$this->user = $user;
		$this->db = $db;
		$this->config = $config;
		$this->auth = $auth;
		$this->block = $block;
		$this->album_operation = $album_operation;
		$this->comments_table = $comments_table;
		$this->images_table = $images_table;
	}

	/**
	 * Is the user allowed to comment?
	 * Following statements must be true:
	 *    - User must have permissions.
	 *    - User is neither owner of the image nor guest.
	 *    - Album and image are not locked.
	 *
	 * @param array $album_data
	 * @param array $image_data
	 * @return bool
	 */
	public function is_allowed(array $album_data, array $image_data): bool
	{
		return $this->config->get('allow_comments') && (!$this->config->get('comment_user_control') || $image_data['image_allow_comments']) &&
			($this->auth->acl_check('m_status', $album_data['album_id'], $album_data['album_user_id']) ||
			(($image_data['image_status'] == $this->block->get_image_status_approved()) && ($album_data['album_status'] != $this->block->get_album_status_locked())));
	}

	/**
	 * Is the user able to comment?
	 * Following statements must be true:
	 *    - User must be allowed to comment.
	 *    - The album type policy must allow comments.
	 *
	 * @param array $album_data
	 * @param array $image_data
	 * @return bool
	 */
	public function is_able(array $album_data, array $image_data): bool
	{
		return $this->is_allowed($album_data, $image_data) &&
			$this->album_operation->allows('comment', $album_data);
	}

	/**
	 * Add a comment
	 *
	 * @param array  $data
	 * @param string $comment_username
	 * @return int|false
	 */
	public function add(array $data, string $comment_username = ''): int|false
	{
		if (!isset($data['comment_image_id']) || !isset($data['comment']))
		{
			return false;
		}

		$data = $data + [
			'comment_user_id'		=> $this->user->data['user_id'],
			'comment_username'		=> ($this->user->data['user_id'] != ANONYMOUS) ? $this->user->data['username'] : $comment_username,
			'comment_user_colour'	=> $this->user->data['user_colour'],
			'comment_user_ip'		=> $this->user->ip,
			'comment_time'			=> time(),
		];

		$this->db->sql_query('INSERT INTO ' .$this->comments_table .' ' . $this->db->sql_build_array('INSERT', $data));
		$newest_comment_id = (int) $this->db->sql_nextid();
		$this->config->inc('num_comments', 1);

		$sql = 'UPDATE ' . $this->images_table . ' 
			SET image_comments = image_comments + 1,
				image_last_comment = ' . (int) $newest_comment_id . '
			WHERE image_id = ' . (int) $data['comment_image_id'];
		$this->db->sql_query($sql);

		return $newest_comment_id;
	}

	/**
	 * Edit comment
	 * @param int   $comment_id
	 * @param array $data
	 * @return bool
	 */
	public function edit(int $comment_id, array $data): bool
	{
		if (!isset($data['comment']))
		{
			return false;
		}

		$data = $data + [
			'comment_edit_time'		=> time(),
			'comment_edit_user_id'	=> $this->user->data['user_id'],
		];

		$sql = 'UPDATE ' . $this->comments_table . '
			SET ' . $this->db->sql_build_array('UPDATE', $data) . '
			WHERE comment_id = ' . (int) $comment_id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Sync last comment information
	 * @param array|int|false $image_ids
	 * @return void
	 */
	public function sync_image_comments(array|int|false $image_ids = false): void
	{
		$sql_where = $sql_where_image = '';
		$resync = [];
		if ($image_ids != false)
		{
			$image_ids = $this->cast_mixed_int2array($image_ids);
			$sql_where = 'WHERE ' . $this->db->sql_in_set('comment_image_id', $image_ids);
			$sql_where_image = 'WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		}

		$sql = 'SELECT comment_image_id, COUNT(comment_id) AS num_comments, MAX(comment_id) AS last_comment
			FROM ' . $this->comments_table . ' 
			' . $sql_where . '
			GROUP BY comment_image_id
			ORDER BY last_comment DESC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$resync[$row['comment_image_id']] = [
				'last_comment'	=> $row['last_comment'],
				'num_comments'	=> $row['num_comments'],
			];
		}
		$this->db->sql_freeresult($result);

		if (empty($resync))
		{
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_last_comment = 0,
					image_comments = 0
				' . $sql_where_image;
			$this->db->sql_query($sql);
			return;
		}

		$last_comment_case = $comment_count_case = 'CASE image_id';
		foreach ($resync as $image_id => $data)
		{
			$last_comment_case .= ' WHEN ' . (int) $image_id . ' THEN ' . (int) $data['last_comment'];
			$comment_count_case .= ' WHEN ' . (int) $image_id . ' THEN ' . (int) $data['num_comments'];
		}
		$last_comment_case .= ' ELSE 0 END';
		$comment_count_case .= ' ELSE 0 END';

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_last_comment = ' . $last_comment_case . ',
				image_comments = ' . $comment_count_case . '
			' . $sql_where_image;
		$this->db->sql_query($sql);
	}

	/**
	* Delete comments
	*
	* @param	array|int	$comment_ids	Array or integer with comment_id we delete.
	* @return	void
	*/
	public function delete_comments(array|int $comment_ids): void
	{
		$comment_ids = $this->cast_mixed_int2array($comment_ids);

		$sql = 'SELECT comment_image_id, COUNT(comment_id) AS num_comments
			FROM ' . $this->comments_table . '
			WHERE ' . $this->db->sql_in_set('comment_id', $comment_ids) . '
			GROUP BY comment_image_id';
		$result = $this->db->sql_query($sql);

		$image_ids = [];
		$total_comments = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_ids[] = (int) $row['comment_image_id'];
			$total_comments += $row['num_comments'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'DELETE FROM ' . $this->comments_table . '
			WHERE ' . $this->db->sql_in_set('comment_id', $comment_ids);
		$this->db->sql_query($sql);

		$this->sync_image_comments($image_ids);

		$this->config->dec('num_comments', $total_comments);
	}

	/**
	* Delete comments for given image_ids
	*
	* @param	array|int	$image_ids		Array or integer with image_id where we delete the comments.
	* @param	bool	$reset_stats	Shall we also reset the statistics? We can save that query, when the images are deleted anyway.
	* @return	void
	*/
	public function delete_images(array|int $image_ids, bool $reset_stats = false): void
	{
		$image_ids = $this->cast_mixed_int2array($image_ids);

		$sql = 'DELETE FROM ' . $this->comments_table . '
			WHERE ' . $this->db->sql_in_set('comment_image_id', $image_ids);
		$this->db->sql_query($sql);

		if ($reset_stats)
		{
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_comments = 0,
					image_last_comment = 0
				WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Normalize one or more identifiers to integers.
	 *
	 * @param array|int $ids Identifiers to normalize
	 * @return array
	 */
	public function cast_mixed_int2array(array|int $ids): array
	{
		if (is_array($ids))
		{
			return array_map('intval', $ids);
		}
		else
		{
			return [(int) $ids];
		}
	}
}
