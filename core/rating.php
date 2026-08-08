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

class rating
{
	/**
	* @var \phpbb\db\driver\driver_interface
	*/
	protected \phpbb\db\driver\driver_interface $db;

	/**
	* @var \phpbb\template\template
	*/
	protected \phpbb\template\template $template;

	/**
	* @var \phpbb\user
	*/
	protected \phpbb\user $user;

	/**
	* @var \phpbb\language\language
	*/
	protected \phpbb\language\language $language;

	/**
	* @var \phpbb\request\request
	*/
	protected \phpbb\request\request $request;

	/**
	* @var \phpbbgallery\core\config
	*/
	protected \phpbbgallery\core\config $gallery_config;

	/**
	* @var \phpbbgallery\core\auth\auth
	*/
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/**
	* @var \phpbbgallery\core\policy\album_operation
	*/
	protected \phpbbgallery\core\policy\album_operation $album_operation;

	/**
	* @var \phpbbgallery\core\policy\image_visibility
	*/
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;

	/**
	* @var string
	*/
	protected string $images_table;

	/**
	* @var string
	*/
	protected string $albums_table;

	/**
	* @var string
	*/
	protected string $rates_table;

	/**
	* The image ID we want to rate
	*/
	public int $image_id = 0;

	/**
	* Private objects with the values for the image/album from the database
	*/
	private ?array $image_data = null;
	private ?array $album_data = null;

	/**
	* Rating the user gave the image.
	*/
	public array $user_rating = [];

	/**
	* Is rating currently possible?
	* Might be blocked by the album type policy.
	*/
	public bool $rating_enabled = false;

	/**
	* Classic-rating box with a dropdown.
	*/
	public const MODE_SELECT = 1;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\template\template          $template
	 * @param \phpbb\user                       $user
	 * @param \phpbb\language\language          $language
	 * @param \phpbb\request\request            $request
	 * @param config                            $gallery_config
	 * @param auth\auth                         $gallery_auth
	 * @param policy\album_operation            $album_operation
	 * @param policy\image_visibility           $image_visibility
	 * @param string                            $images_table
	 * @param string                            $albums_table
	 * @param string                            $rates_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\request\request $request, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\policy\album_operation $album_operation,
		\phpbbgallery\core\policy\image_visibility $image_visibility,
		string $images_table, string $albums_table, string $rates_table)
	{
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
		$this->album_operation = $album_operation;
		$this->image_visibility = $image_visibility;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
		$this->rates_table = $rates_table;
	}

	/**
	 * Load data for the class to work with
	 *
	 * @param    int $image_id
	 * @param array|bool $image_data Array with values from the image-table of the image
	 * @param array|bool $album_data Array with values from the album-table of the image's album
	 */
	public function loader(int $image_id, array|false $image_data = false, array|false $album_data = false): void
	{
		$this->image_id = $image_id;
		$this->image_data = $image_data ?: null;
		$this->album_data = $album_data ?: null;
		$this->user_rating = [];
		$this->rating_enabled = false;
	}

	/**
	 * Returns the value of image_data key.
	 * If the value is missing, it is queried from the database.
	 * @param string|bool $key Image-data key, or true to return the whole array.
	 * @return mixed
	 */
	private function image_data(string|bool $key): mixed
	{
		if ($this->image_data === null)
		{
			$sql = 'SELECT *
				FROM ' . $this->images_table . '
				WHERE image_id = ' . (int) $this->image_id;
			$result = $this->db->sql_query($sql);
			$image_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!is_array($image_data))
			{
				trigger_error('IMAGE_NOT_EXIST');
				return null;
			}

			$this->image_data = $image_data;
		}

		return ($key === true) ? $this->image_data : $this->image_data[$key];
	}

	/**
	 * Returns the value of album_data key.
	 * If the value is missing, it is queried from the database.
	 *
	 * @param string|bool $key The album-data key, or true to return the whole array.
	 * @return mixed
	 */
	private function album_data(string|bool $key): mixed
	{
		if ($this->album_data === null)
		{
			$sql = 'SELECT *
				FROM ' . $this->albums_table . '
				WHERE album_id = ' . (int) $this->image_data('image_album_id');
			$result = $this->db->sql_query($sql);
			$album_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!is_array($album_data))
			{
				trigger_error('ALBUM_NOT_EXIST');
				return null;
			}

			$this->album_data = $album_data;
		}

		return ($key === true) ? $this->album_data : $this->album_data[$key];
	}

	/**
	* Displays the box where the user can rate the image.
	*/
	public function display_box(): void
	{
		$this->template->assign_var('GALLERY_RATING', self::MODE_SELECT);

		for ($i = 1; $i <= $this->gallery_config->get('max_rating'); $i++)
		{
			$this->template->assign_block_vars('rate_scale', [
				'RATE_POINT'	=> $i,
			]);
		}

		$this->rating_enabled = true;
	}

	/**
	 * Get rating for a image
	 *
	 * @param int|false $user_rating Personal rating of the user, when available
	 * @param bool      $detailed_hidden_result Whether an add-on may include details in its hidden-results message
	 * @return string Returns a string containing the information how the image was rated in average and how often.
	 */
	public function get_image_rating(int|false $user_rating = false, bool $detailed_hidden_result = true): string
	{
		$this->template->assign_var('GALLERY_RATING', self::MODE_SELECT);

		$image_data = (array) $this->image_data(true);
		$album_data = (array) $this->album_data(true);
		$can_moderate = $this->gallery_auth->acl_check(
			'm_status',
			(int) $album_data['album_id'],
			(int) $album_data['album_user_id']
		);
		if ($this->image_visibility->hides_results($image_data, $can_moderate))
		{
			return $this->image_visibility->hidden_results_message(
				$image_data,
				$album_data,
				$can_moderate,
				$detailed_hidden_result,
				$this->language->lang('GALLERY_RESULTS_HIDDEN')
			);
		}

		if ($user_rating)
		{
			return $this->language->lang('RATING_STRINGS_USER', (int) $this->image_data('image_rates'), $this->get_image_rating_value(), $user_rating);
		}
		return $this->language->lang('RATING_STRINGS', (int) $this->image_data('image_rates'), $this->get_image_rating_value());
	}

	/**
	* Get rated value for a image
	*/
	private function get_image_rating_value(): float
	{
		return ((float) $this->image_data('image_rate_avg') / 100);
	}

	/**
	* Is the user allowed to rate?
	* Following statements must be true:
	*	- User must have permissions.
	*	- User is neither owner of the image nor guest.
	*	- Album and image are not locked.
	*
	* @return	bool
	*/
	public function is_allowed(): bool
	{
		return $this->gallery_auth->acl_check('i_rate', $this->album_data('album_id'), $this->album_data('album_user_id')) &&
			($this->user->data['user_id'] != $this->image_data('image_user_id')) && ($this->user->data['user_id'] != ANONYMOUS) &&
			($this->album_data('album_status') != (int) \phpbbgallery\core\block::ALBUM_LOCKED) && ($this->image_data('image_status') == (int) \phpbbgallery\core\block::STATUS_APPROVED);
	}

	/**
	* Is the user able to rate?
	* Following statements must be true:
	*	- User must be allowed to rate
	*	- The album type policy must allow rating
	*
	* @return	bool
	*/
	public function is_able(): bool
	{
		return $this->is_allowed() &&
			$this->album_operation->allows('rate', $this->album_data(true));
	}

	/**
	* Get rating from a user for a given image
	*
	* @param	int		$user_id
	*
	* @return	mixed	False if the user did not rate or is guest, otherwise int the points.
	*/
	public function get_user_rating(int $user_id): int|false
	{
		if (isset($this->user_rating[$user_id]))
		{
			return $this->user_rating[$user_id];
		}
		if ($user_id == ANONYMOUS)
		{
			return false;
		}

		$sql = 'SELECT rate_point
			FROM ' . $this->rates_table . '
			WHERE rate_image_id = ' . (int) $this->image_id . '
				AND rate_user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$rating = $this->db->sql_fetchfield('rate_point');
		$this->db->sql_freeresult($result);

		$this->user_rating[$user_id] = (is_bool($rating)) ? $rating : (int) $rating;
		return $this->user_rating[$user_id];
	}

	/**
	 * Get the ratings submitted by one user for a bounded image set.
	 *
	 * @param int[] $image_ids Image identifiers from the current result page
	 * @param int   $user_id   User identifier
	 * @return array<int, int> Rating points keyed by image identifier
	 */
	public function get_user_ratings(array $image_ids, int $user_id): array
	{
		if ($user_id == ANONYMOUS)
		{
			return [];
		}

		$image_ids = array_values(array_unique(array_filter(
			array_map('intval', $image_ids),
			static fn (int $image_id): bool => $image_id > 0
		)));
		if (!$image_ids)
		{
			return [];
		}

		$sql = 'SELECT rate_image_id, rate_point
			FROM ' . $this->rates_table . '
			WHERE rate_user_id = ' . (int) $user_id . '
				AND ' . $this->db->sql_in_set('rate_image_id', $image_ids);
		$result = $this->db->sql_query($sql);

		$ratings = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ratings[(int) $row['rate_image_id']] = (int) $row['rate_point'];
		}
		$this->db->sql_freeresult($result);

		return $ratings;
	}

	/**
	 * Submit rating for an image.
	 *
	 * @param bool|int $user_id
	 * @param bool|int $points
	 * @param bool|string $user_ip Can be empty, function falls back to $user->ip
	 * @return bool
	 */
	public function submit_rating(int|false $user_id = false, int|false $points = false, string|false $user_ip = false): bool
	{
		$user_id = ($user_id) ? $user_id : (int) $this->user->data['user_id'];
		$points = ($points) ? $points : (int) $this->request->variable('rating', 0);
		$points = max(1, min($points, (int) $this->gallery_config->get('max_rating')));

		if (($user_id == ANONYMOUS) || !$this->is_able() || $this->get_user_rating($user_id))
		{
			return false;
		}

		$this->insert_rating($user_id, $points, $user_ip);

		$this->recalc_image_rating($this->image_id);
		$this->user_rating[$user_id] = $points;

		return true;
	}

	/**
	 * Insert the rating into the database.
	 *
	 * @param    int $user_id
	 * @param    int $points
	 * @param bool|string $user_ip Can be empty, function falls back to $user->ip
	 */
	private function insert_rating(int $user_id, int $points, string|false $user_ip = false): void
	{
		$sql_ary = [
			'rate_image_id'	=> $this->image_id,
			'rate_user_id'	=> $user_id,
			'rate_user_ip'	=> ($user_ip) ? $user_ip : $this->user->ip,
			'rate_point'	=> $points,
		];
		$this->db->sql_query('INSERT INTO ' . $this->rates_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
	}

	/**
	* Recalculate the average image-rating and such stuff.
	*
	* @param	mixed	$image_ids	Array or integer with image_id where we recalculate the rating.
	*/
	public function recalc_image_rating(array|int $image_ids): void
	{
		if (is_array($image_ids))
		{
			$image_ids = array_map('intval', $image_ids);
		}
		else
		{
			$image_ids = (int) $image_ids;
		}

		$sql = 'SELECT rate_image_id, COUNT(rate_user_ip) image_rates, AVG(rate_point) image_rate_avg, SUM(rate_point) image_rate_points
			FROM ' . $this->rates_table . '
			WHERE ' . $this->db->sql_in_set('rate_image_id', $image_ids, false, true) . '
			GROUP BY rate_image_id';
		$result = $this->db->sql_query($sql);

		$resync = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$resync[(int) $row['rate_image_id']] = [
				'image_rates' => (int) $row['image_rates'],
				'image_rate_points' => (int) $row['image_rate_points'],
				'image_rate_avg' => (int) (round((float) $row['image_rate_avg'], 2) * 100),
			];
		}
		$this->db->sql_freeresult($result);

		if (!$resync)
		{
			return;
		}

		$rates_case = $points_case = $average_case = 'CASE image_id';
		foreach ($resync as $image_id => $data)
		{
			$rates_case .= ' WHEN ' . $image_id . ' THEN ' . $data['image_rates'];
			$points_case .= ' WHEN ' . $image_id . ' THEN ' . $data['image_rate_points'];
			$average_case .= ' WHEN ' . $image_id . ' THEN ' . $data['image_rate_avg'];
		}
		$rates_case .= ' END';
		$points_case .= ' END';
		$average_case .= ' END';

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_rates = ' . $rates_case . ',
				image_rate_points = ' . $points_case . ',
				image_rate_avg = ' . $average_case . '
			WHERE ' . $this->db->sql_in_set('image_id', array_keys($resync));
		$this->db->sql_query($sql);
	}

	/**
	* Delete all ratings for given image_ids
	*
	* @param	mixed	$image_ids		Array or integer with image_id where we delete the rating.
	* @param	bool	$reset_average	Shall we also reset the average? We can save that query, when the images are deleted anyway.
	*/
	public function delete_ratings(array|int $image_ids, bool $reset_average = false): void
	{
		if (is_array($image_ids))
		{
			$image_ids = array_map('intval', $image_ids);
		}
		else
		{
			$image_ids = (int) $image_ids;
		}

		$sql = 'DELETE FROM ' . $this->rates_table . '
			WHERE ' . $this->db->sql_in_set('rate_image_id', $image_ids, false, true);
		$this->db->sql_query($sql);

		if ($reset_average)
		{
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_rates = 0,
					image_rate_points = 0,
					image_rate_avg = 0
				WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
			$this->db->sql_query($sql);
		}
	}
}
