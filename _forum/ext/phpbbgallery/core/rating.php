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
	* Might be blocked because of contest-settings.
	*/
	public bool $rating_enabled = false;

	/**
	* Classic-rating box with a dropdown.
	*/
	public const MODE_SELECT = 1;

	/**
	* Rating with stars, like the old-system from youtube.
	//@todo: const MODE_STARS = 2;
	*/

	/**
	* Simple thumbs up or down.
	//@todo: const MODE_THUMB = 3;
	*/

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
	 * @param                                   $images_table
	 * @param                                   $albums_table
	 * @param                                   $rates_table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\request\request $request, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\auth $gallery_auth,
		string $images_table, string $albums_table, string $rates_table)
	{
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
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
	 * @param $key
	 * @return
	 */
	private function image_data(string $key): mixed
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

		return $this->image_data[$key];
	}

	/**
	 * Returns the value of album_data key.
	 * If the value is missing, it is queried from the database.
	 *
	 * @param    $key    string    The value of the album data, if true it returns the hole array.
	 * @return mixed|null
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
		$this->template->assign_var('GALLERY_RATING', self::MODE_SELECT);//@todo: phpbb_ext_gallery_core_config::get('rating_mode'));

		switch (self::MODE_SELECT)//@todo: phpbb_ext_gallery_core_config::get('rating_mode'))
		{
			//@todo: self::MODE_THUMB:
			//@todo: self::MODE_STARS:
			case self::MODE_SELECT:
			default:
				// @TODO We do not have contests for now
				/*if ($this->album_data('contest_id'))
				{
					if (time() < ($this->album_data('contest_start') + $this->album_data('contest_rating')))
					{
						$template->assign_var('GALLERY_NO_RATING_MESSAGE', $user->lang('CONTEST_RATING_STARTS', $user->format_date(($this->album_data('contest_start') + $this->album_data('contest_rating')), false, true)));
						return;
					}
					if (($this->album_data('contest_start') + $this->album_data('contest_end')) < time())
					{
						$template->assign_var('GALLERY_NO_RATING_MESSAGE', $user->lang('CONTEST_RATING_ENDED', $user->format_date(($this->album_data('contest_start') + $this->album_data('contest_end')), false, true)));
						return;
					}
				}*/
				for ($i = 1; $i <= $this->gallery_config->get('max_rating'); $i++)
				{
					$this->template->assign_block_vars('rate_scale', [
						'RATE_POINT'	=> $i,
					]);
				}
			break;
		}

		$this->rating_enabled = true;
	}

	/**
	 * Get rating for a image
	 *
	 * @param bool|Personal $user_rating Personal rating of the user is displayed in most cases.
	 * @param bool|Shall $display_contest_end Shall we display the end-time of the contest? This requires the album-data to be filled.
	 * @return string Returns a string containing the information how the image was rated in average and how often.
	 */
	public function get_image_rating(int|false $user_rating = false, bool $display_contest_end = true): string
	{
		$this->template->assign_var('GALLERY_RATING', self::MODE_SELECT);//@todo: phpbb_ext_gallery_core_config::get('rating_mode'));

		switch (self::MODE_SELECT)//@todo: phpbb_ext_gallery_core_config::get('rating_mode'))
		{
			//@todo: self::MODE_THUMB:
			//@todo: self::MODE_STARS:
			case self::MODE_SELECT:
			default:
				if ($this->image_data('image_contest'))
				{
					if (!$display_contest_end)
					{
						return $this->language->lang('CONTEST_RATING_HIDDEN');
					}
					return $this->language->lang('CONTEST_RESULT_HIDDEN', $this->user->format_date(($this->album_data('contest_start') + $this->album_data('contest_end')), false, true));
				}
				else
				{
					if ($user_rating)
					{
						return $this->language->lang('RATING_STRINGS_USER', (int) $this->image_data('image_rates'), $this->get_image_rating_value(), $user_rating);
					}
					return $this->language->lang('RATING_STRINGS', (int) $this->image_data('image_rates'), $this->get_image_rating_value());
				}
			break;
		}
	}

	/**
	* Get rated value for a image
	*/
	private function get_image_rating_value(): float
	{
		/*if (phpbb_ext_gallery_core_contest::$mode == phpbb_ext_gallery_core_contest::MODE_SUM)
		{
			return $this->image_data('image_rate_points');
		}
		else
		{*/
			return ((float) $this->image_data('image_rate_avg') / 100);
		//}
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
	*	- If the image is in a contest, it must be in the rating timespan
	*
	* @return	bool
	*/
	public function is_able(): bool
	{
		return $this->is_allowed(); //&& phpbb_ext_gallery_core_contest::is_step('rate', $this->album_data(true));
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
	 * Submit rating for an image.
	 *
	 * @param bool|int $user_id
	 * @param bool|int $points
	 * @param bool|string $user_ip Can be empty, function falls back to $user->ip
	 * @return bool
	 */
	public function submit_rating(int|false $user_id = false, int|false $points = false, string|false $user_ip = false): bool
	{
		switch (self::MODE_SELECT)//@todo: phpbb_ext_gallery_core_config::get('rating_mode'))
		{
			//@todo: self::MODE_THUMB:
			//@todo: self::MODE_STARS:
			case self::MODE_SELECT:
			default:
				$user_id = ($user_id) ? $user_id : (int) $this->user->data['user_id'];
				$points = ($points) ? $points : (int) $this->request->variable('rating', 0);
				$points = max(1, min($points, (int) $this->gallery_config->get('max_rating')));
			break;
		}

		if (($user_id == ANONYMOUS) || $this->get_user_rating($user_id))
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

		while ($row = $this->db->sql_fetchrow($result))
		{
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_rates = ' . (int) $row['image_rates'] . ',
					image_rate_points = ' . (int) $row['image_rate_points'] . ',
					image_rate_avg = ' . round($row['image_rate_avg'], 2) * 100 . '
				WHERE image_id = ' . (int) $row['rate_image_id'];
			$this->db->sql_query($sql);
		}
		$this->db->sql_freeresult($result);
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
