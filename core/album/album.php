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

namespace phpbbgallery\core\album;

class album
{
	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/** @var \phpbb\profilefields\manager */
	protected \phpbb\profilefields\manager $user_cpf;

	/** @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\cache */
	protected \phpbbgallery\core\cache $gallery_cache;

	/** @var \phpbbgallery\core\block */
	protected \phpbbgallery\core\block $block;

	/** @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\album\data_enricher */
	protected data_enricher $data_enricher;

	/** @var string */
	protected string $images_table;

	/** @var string */
	protected string $watch_table;

	/** @var string */
	protected string $albums_table;

	/**
	 * album constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\user                       $user
	 * @param \phpbb\language\language         $language
	 * @param \phpbb\profilefields\manager      $user_cpf
	 * @param \phpbbgallery\core\auth\auth      $gallery_auth
	 * @param \phpbbgallery\core\cache          $gallery_cache
	 * @param \phpbbgallery\core\block          $block
	 * @param \phpbbgallery\core\config         $gallery_config
	 * @param \phpbbgallery\core\album\data_enricher $data_enricher
	 * @param string                            $albums_table
	 * @param string                            $images_table
	 * @param string                            $watch_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\profilefields\manager $user_cpf,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\cache $gallery_cache, \phpbbgallery\core\block $block,
		\phpbbgallery\core\config $gallery_config, data_enricher $data_enricher,
		string $albums_table, string $images_table, string $watch_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->user_cpf = $user_cpf;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_cache = $gallery_cache;
		$this->block = $block;
		$this->gallery_config = $gallery_config;
		$this->data_enricher = $data_enricher;
		$this->albums_table = $albums_table;
		$this->images_table = $images_table;
		$this->watch_table = $watch_table;
	}

	/**
	 * Get album information
	 *
	 * @param int  $album_id
	 * @param bool $extended_info
	 * @return array
	 */
	public function get_info(int $album_id, bool $extended_info = true): array
	{
		$sql_array = [
			'SELECT' => 'a.*',
			'FROM'   => [$this->albums_table => 'a'],

			'WHERE' => 'a.album_id = ' . (int) $album_id,
		];

		if ($extended_info)
		{
			$sql_array['SELECT'] .= ', w.watch_id';
			$sql_array['LEFT_JOIN'] = [
				[
					'FROM' => [$this->watch_table => 'w'],
					'ON'   => 'a.album_id = w.album_id AND w.user_id = ' . (int) $this->user->data['user_id'],
				],
			];
		}
		$sql = $this->db->sql_build_query('SELECT', $sql_array);

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			throw new \phpbb\exception\http_exception(404, 'ALBUM_NOT_EXIST');
		}

		return $this->data_enricher->enrich($row);
	}

	/**
	 * Check whether the album_user is the user who wants to do something
	 *
	 * @param int       $album_id
	 * @param int|false $user_id
	 * @return bool
	 */
	public function check_user(int $album_id, int|false $user_id = false): bool
	{
		if ($user_id === false)
		{
			$user_id = (int) $this->user->data['user_id'];
		}

		$sql = 'SELECT album_id
			FROM ' . $this->albums_table . '
			WHERE album_id = ' . (int) $album_id . '
				AND album_user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row === false)
		{
			throw new \phpbb\exception\http_exception(403, 'NO_ALBUM_STEALING');
		}

		return true;
	}

	/**
	 * Generate gallery-albumbox
	 *
	 * @param bool        $ignore_personals     list personal albums
	 * @param string      $select_name          request_var() for the select-box
	 * @param bool|int    $select_id            selected album
	 * @param bool|string $requested_permission Exp: for moving a image you need i_upload permissions or a_moderate
	 * @param bool        $ignore_id
	 * @param int         $album_user_id        for the select-boxes of the ucp so you only can attach to your own
	 *                                          albums
	 * @param int         $requested_album_type only albums of the album_type are allowed
	 * @return string $gallery_albumbox        if ($select_name) {full select-box} else {list with options}
	 *                                          else {list with options}
	 *
	 * comparable to make_forum_select (includes/functions_admin.php)
	 *           where the image is now
	 */
	public function get_albumbox(bool $ignore_personals, string|false $select_name, array|int|false $select_id = false, string|false $requested_permission = false, array|int|false $ignore_id = false, int $album_user_id = \phpbbgallery\core\block::PUBLIC_ALBUM, int $requested_album_type = -1): string
	{
		// Instead of the query we use the cache
		$album_data = $this->gallery_cache->get('albums');

		$right = $last_a_u_id = 0;
		$access_own = $access_personal = $requested_own = $requested_personal = false;
		$c_access_own = $c_access_personal = false;
		$padding_store = ['0' => ''];
		$padding = $album_list = '';
		$check_album_type = ($requested_album_type >= 0) ? true : false;
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		// Sometimes it could happen that albums will be displayed here not be displayed within the index page
		// This is the result of albums not displayed at index and a parent of a album with no permissions.
		// If this happens, the padding could be "broken", see includes/functions_admin.php > make_forum_select

		foreach ($album_data as $row)
		{
			$list = false;
			if ($row['album_user_id'] != $last_a_u_id)
			{
				if (!$last_a_u_id && $this->gallery_auth->acl_check('a_list', $this->gallery_auth->get_personal_album()) && !$ignore_personals)
				{
					$album_list .= '<option disabled="disabled" class="disabled-option">' . $this->language->lang('PERSONAL_ALBUMS') . '</option>';
				}
				$padding = '';
				$padding_store[$row['parent_id']] = '';
			}
			if ($row['left_id'] < $right)
			{
				$padding .= '&nbsp; &nbsp;';
				$padding_store[$row['parent_id']] = $padding;
			}
			else if ($row['left_id'] > $right + 1)
			{
				$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : '';
			}

			$right = $row['right_id'];
			$last_a_u_id = $row['album_user_id'];
			$disabled = false;

			if (
				// Is in the ignore_id
				((is_array($ignore_id) && in_array($row['album_id'], $ignore_id)) || $row['album_id'] == $ignore_id)
				||
				// Need the matching destination permission when moving.
				(($requested_permission == 'm_move') && (($row['album_type'] == (int) \phpbbgallery\core\block::TYPE_CAT) || !$this->gallery_auth->acl_check('m_move', $row['album_id'], $row['album_user_id'])))
				||
				(($requested_permission == 'i_move') && (($row['album_type'] == (int) \phpbbgallery\core\block::TYPE_CAT) || (!$this->gallery_auth->acl_check('i_upload', $row['album_id'], $row['album_user_id']) && !$this->gallery_auth->acl_check('m_move', $row['album_id'], $row['album_user_id']))))
				||
				// album_type does not fit
				($check_album_type && ($row['album_type'] != $requested_album_type))
			)
			{
				$disabled = true;
			}

			if (($select_id == $this->gallery_auth->get_setting_permissions()) && !$row['album_user_id'])
			{
				$list = true;
			}
			else if (!$row['album_user_id'])
			{
				if ($this->gallery_auth->acl_check('a_list', $row['album_id'], $row['album_user_id']) || defined('IN_ADMIN'))
				{
					$list = true;
				}
			}
			else if (!$ignore_personals)
			{
				if ($row['album_user_id'] == $this->user->data['user_id'])
				{
					if (!$c_access_own)
					{
						$c_access_own = true;
						$access_own = $this->gallery_auth->acl_check('a_list', $this->gallery_auth->get_own_album());
						if ($requested_permission)
						{
							$requested_own = !$this->gallery_auth->acl_check($requested_permission, $this->gallery_auth->get_own_album());
						}
						else
						{
							$requested_own = false; // We need the negated version of true here
						}
					}
					$list = (!$list) ? $access_own : $list;
					$disabled = (!$disabled) ? $requested_own : $disabled;
				}
				else if ($row['album_user_id'])
				{
					if (!$c_access_personal)
					{
						$c_access_personal = true;
						$access_personal = $this->gallery_auth->acl_check('a_list', $this->gallery_auth->get_personal_album());
						if ($requested_permission)
						{
							$requested_personal = !$this->gallery_auth->acl_check($requested_permission, $this->gallery_auth->get_personal_album());
						}
						else
						{
							$requested_personal = false; // We need the negated version of true here
						}
					}
					$list = (!$list) ? $access_personal : $list;
					$disabled = (!$disabled) ? $requested_personal : $disabled;
				}
			}
			if (($album_user_id != (int) \phpbbgallery\core\block::PUBLIC_ALBUM) && ($album_user_id != $row['album_user_id']))
			{
				$list = false;
			}
			else if (($album_user_id != (int) \phpbbgallery\core\block::PUBLIC_ALBUM) && ($row['parent_id'] == 0))
			{
				$disabled = true;
			}

			if ($list)
			{
				$selected = (is_array($select_id)) ? ((in_array($row['album_id'], $select_id)) ? ' selected="selected"' : '') : (($row['album_id'] == $select_id) ? ' selected="selected"' : '');
				$album_list .= '<option value="' . $row['album_id'] . '"' . (($disabled) ? ' disabled="disabled" class="disabled-option"' : $selected) . '>' . $padding . $row['album_name'] . ' (ID: ' . $row['album_id'] . ')</option>';
			}
		}
		unset($padding_store);

		if ($select_name)
		{
			$gallery_albumbox = "<select name='$select_name' id='$select_name' class=\"selectpicker show-tick\" data-container=\"body\" data-style=\"btn-sm btn btn-default\">";
			$gallery_albumbox .= $album_list;
			$gallery_albumbox .= '</select>';
		}
		else
		{
			$gallery_albumbox = $album_list;
		}

		return $gallery_albumbox;
	}

	/**
	 * Update album information
	 * Resets the following columns with the correct value:
	 * - album_images, _real
	 * - album_last_image_id, _time, _name
	 * - album_last_username, _user_colour, _user_id
	 *
	 * @param int $album_id
	 * @return array|false
	 */
	public function update_info(int $album_id): array|false
	{
		$images_real = $images = $album_user_id = 0;

		// Get the album_user_id, so we can keep the user_colour
		$sql = 'SELECT album_user_id
			FROM ' . $this->albums_table . '
			WHERE album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$album_user_id = $this->db->sql_fetchfield('album_user_id');
		$this->db->sql_freeresult($result);

		// Number of not unapproved images
		$sql = 'SELECT COUNT(image_id) images
			FROM ' . $this->images_table . ' 
			WHERE image_status <> ' . (int) $this->block->get_image_status_unapproved() . '
				AND image_status <> ' . (int) $this->block->get_image_status_orphan() . '
				AND image_album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$images = $this->db->sql_fetchfield('images');
		$this->db->sql_freeresult($result);

		// Number of total images
		$sql = 'SELECT COUNT(image_id) images_real
			FROM ' . $this->images_table . '
			WHERE image_status <> ' . (int) $this->block->get_image_status_orphan() . '
				AND image_album_id = ' . (int) $album_id;
		$result = $this->db->sql_query($sql);
		$images_real = $this->db->sql_fetchfield('images_real');
		$this->db->sql_freeresult($result);

		// Data of the last not unapproved image
		$sql = 'SELECT image_id, image_time, image_name, image_username, image_user_colour, image_user_id
			FROM ' . $this->images_table . '
			WHERE image_status <> ' . (int) $this->block->get_image_status_unapproved() . '
				AND image_status <> ' . (int) $this->block->get_image_status_orphan() . '
				AND image_album_id = ' . (int) $album_id . '
			ORDER BY image_time DESC';
		$result = $this->db->sql_query($sql);
		if ($row = $this->db->sql_fetchrow($result))
		{
			$sql_ary = [
				'album_images_real'      => $images_real,
				'album_images'           => $images,
				'album_last_image_id'    => $row['image_id'],
				'album_last_image_time'  => $row['image_time'],
				'album_last_image_name'  => $row['image_name'],
				'album_last_username'    => $row['image_username'],
				'album_last_user_colour' => $row['image_user_colour'],
				'album_last_user_id'     => $row['image_user_id'],
			];
		}
		else
		{
			// No approved image, so we clear the columns
			$sql_ary = [
				'album_images_real'      => $images_real,
				'album_images'           => $images,
				'album_last_image_id'    => 0,
				'album_last_image_time'  => 0,
				'album_last_image_name'  => '',
				'album_last_username'    => '',
				'album_last_user_colour' => '',
				'album_last_user_id'     => 0,
			];
			if ($album_user_id)
			{
				unset($sql_ary['album_last_user_colour']);
			}
		}
		$this->db->sql_freeresult($result);

		$sql = 'UPDATE ' . $this->albums_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE album_id = ' . (int) $album_id;
		$this->db->sql_query($sql);

		return $row;
	}

	/**
	 * Refresh image counts and last-image data for multiple albums.
	 *
	 * @param array $album_ids Album identifiers
	 */
	public function update_infos(array $album_ids): void
	{
		$this->update_image_counts($album_ids);
		$this->update_last_images($album_ids);
	}

	/**
	 * Refresh image counters for multiple albums in bounded batches.
	 *
	 * @param array $album_ids Album identifiers
	 */
	private function update_image_counts(array $album_ids): void
	{
		$album_ids = array_values(array_unique(array_filter(array_map('intval', $album_ids))));

		foreach (array_chunk($album_ids, 250) as $batch_ids)
		{
			$album_data = [];
			foreach ($batch_ids as $album_id)
			{
				$album_data[$album_id] = [
					'album_images_real' => 0,
					'album_images'      => 0,
				];
			}

			$sql = 'SELECT image_album_id, COUNT(image_id) AS album_images_real,
					SUM(CASE
						WHEN image_status <> ' . (int) $this->block->get_image_status_unapproved() . ' THEN 1
						ELSE 0
					END) AS album_images
				FROM ' . $this->images_table . '
				WHERE image_status <> ' . (int) $this->block->get_image_status_orphan() . '
					AND ' . $this->db->sql_in_set('image_album_id', $batch_ids) . '
				GROUP BY image_album_id';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$album_id = (int) $row['image_album_id'];
				$album_data[$album_id] = [
					'album_images_real' => (int) $row['album_images_real'],
					'album_images'      => (int) $row['album_images'],
				];
			}
			$this->db->sql_freeresult($result);

			$this->update_album_rows($album_data, ['album_images_real', 'album_images']);
		}
	}

	/**
	 * Refresh the last-image columns for multiple albums in bounded batches.
	 *
	 * Empty personal albums retain their owner colour, matching update_info().
	 *
	 * @param array $album_ids Album identifiers
	 */
	public function update_last_images(array $album_ids): void
	{
		$album_ids = array_values(array_unique(array_filter(array_map('intval', $album_ids))));

		foreach (array_chunk($album_ids, 250) as $batch_ids)
		{
			$album_data = [];
			$sql = 'SELECT album_id, album_user_id
				FROM ' . $this->albums_table . '
				WHERE ' . $this->db->sql_in_set('album_id', $batch_ids);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$album_id = (int) $row['album_id'];
				$album_data[$album_id] = [
					'album_last_image_id'    => 0,
					'album_last_image_time'  => 0,
					'album_last_image_name'  => '',
					'album_last_username'    => '',
					'album_last_user_colour' => ((int) $row['album_user_id'] === (int) \phpbbgallery\core\block::PUBLIC_ALBUM) ? '' : null,
					'album_last_user_id'     => 0,
				];
			}
			$this->db->sql_freeresult($result);

			if (empty($album_data))
			{
				continue;
			}

			$sql = 'SELECT i.image_id, i.image_album_id, i.image_time, i.image_name,
					i.image_username, i.image_user_colour, i.image_user_id
				FROM ' . $this->images_table . ' i
				WHERE i.image_status <> ' . (int) $this->block->get_image_status_unapproved() . '
					AND i.image_status <> ' . (int) $this->block->get_image_status_orphan() . '
					AND ' . $this->db->sql_in_set('i.image_album_id', array_keys($album_data)) . '
					AND NOT EXISTS (
						SELECT 1
						FROM ' . $this->images_table . ' newer
						WHERE newer.image_album_id = i.image_album_id
							AND newer.image_status <> ' . (int) $this->block->get_image_status_unapproved() . '
							AND newer.image_status <> ' . (int) $this->block->get_image_status_orphan() . '
							AND (newer.image_time > i.image_time
								OR (newer.image_time = i.image_time AND newer.image_id > i.image_id))
					)';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$album_id = (int) $row['image_album_id'];
				$album_data[$album_id] = [
					'album_last_image_id'    => (int) $row['image_id'],
					'album_last_image_time'  => (int) $row['image_time'],
					'album_last_image_name'  => (string) $row['image_name'],
					'album_last_username'    => (string) $row['image_username'],
					'album_last_user_colour' => (string) $row['image_user_colour'],
					'album_last_user_id'     => (int) $row['image_user_id'],
				];
			}
			$this->db->sql_freeresult($result);

			$this->update_album_rows($album_data, [
				'album_last_image_id',
				'album_last_image_time',
				'album_last_user_id',
			]);
		}
	}

	/**
	 * Persist album data with one conditional update.
	 *
	 * @param array $album_data      Album data indexed by album ID
	 * @param array $integer_columns Columns that contain integers
	 */
	private function update_album_rows(array $album_data, array $integer_columns): void
	{
		$assignments = [];

		foreach (array_keys(reset($album_data)) as $column)
		{
			$cases = [];
			foreach ($album_data as $album_id => $data)
			{
				if ($data[$column] === null)
				{
					continue;
				}

				$value = in_array($column, $integer_columns, true)
					? (string) (int) $data[$column]
					: "'" . $this->db->sql_escape((string) $data[$column]) . "'";
				$cases[] = 'WHEN ' . (int) $album_id . ' THEN ' . $value;
			}

			if (!empty($cases))
			{
				$assignments[] = $column . ' = CASE album_id ' . implode(' ', $cases) . ' ELSE ' . $column . ' END';
			}
		}

		$sql = 'UPDATE ' . $this->albums_table . '
			SET ' . implode(', ', $assignments) . '
			WHERE ' . $this->db->sql_in_set('album_id', array_keys($album_data));
		$this->db->sql_query($sql);
	}

	/**
	 * Generate personal album for user, when moving image into it
	 *
	 * @param string                      $album_name
	 * @param int                         $user_id
	 * @param string                      $user_colour
	 * @param \phpbbgallery\core\user    $gallery_user
	 * @return int
	 */
	public function generate_personal_album(string $album_name, int $user_id, string $user_colour, \phpbbgallery\core\user $gallery_user): int
	{
		$album_data = [
			'album_name'             => $this->db->sql_escape($album_name),
			'parent_id'              => 0,
			//left_id and right_id default by db
			'album_desc_options'     => 7,
			'album_desc'             => '',
			'album_parents'          => '',
			'album_type'             => (int) \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status'           => (int) \phpbbgallery\core\block::ALBUM_OPEN,
			'album_user_id'          => (int) $user_id,
			'album_last_username'    => '',
			'album_last_user_colour' => $user_colour,
		];
		$this->db->sql_query('INSERT INTO ' . $this->albums_table . ' ' . $this->db->sql_build_array('INSERT', $album_data));
		$personal_album_id = (int) $this->db->sql_nextid();

		$gallery_user->update_data([
			'personal_album_id' => $personal_album_id,
		]);

		// Fill album CPF.
		$cpf_vars = [
			'pf_gallery_palbum' => (int) $personal_album_id,
		];
		$this->user_cpf->update_profile_field_data((int) $user_id, $cpf_vars);

		$this->gallery_config->inc('num_pegas', 1);

		// Update the config for the statistic on the index
		$this->gallery_config->set('newest_pega_user_id', $user_id);
		$this->gallery_config->set('newest_pega_username', $album_name);
		$this->gallery_config->set('newest_pega_user_colour', $user_colour);
		$this->gallery_config->set('newest_pega_album_id', $personal_album_id);

		$this->gallery_cache->destroy('_albums');
		$this->gallery_cache->destroy('sql', $this->albums_table);

		return $personal_album_id;
	}

	/**
	 * Create array of album IDs that are public
	 */
	public function get_public_albums(): array
	{
		$sql = 'SELECT album_id
				FROM ' . $this->albums_table . '
				WHERE album_user_id = ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM;
		$result = $this->db->sql_query($sql);
		$id_ary = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$id_ary[] = (int) $row['album_id'];
		}
		$this->db->sql_freeresult($result);
		return $id_ary;
	}
}
