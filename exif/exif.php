<?php
/**
 * phpBB Gallery - ACP Exif Extension
 *
 * @package   phpbbgallery/exif
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif;

/**
* Base class for Exif handling
*/
class exif
{
	/**
	* Default value for new users
	*/
	public const DEFAULT_DISPLAY = true;

	/**
	* phpBB will treat the time from the Exif data like UTC.
	* If your images were taken with an other timezone, you can insert an offset here.
	* The offset is than added to the timestamp before it is converted into the users time.
	*
	* Offset must be set in seconds.
	*/
	public const TIME_OFFSET = 0;

	/**
	* Constants for the status of the Exif data.
	*/
	public const UNAVAILABLE = 0;
	public const AVAILABLE = 1;
	public const UNKNOWN = 2;
	public const DBSAVED = 3;

	/**
	* Is the function available?
	*/
	public static ?bool $function_exists = null;

	/**
	* Exif data array with all allowed groups and keys.
	*/
	public array|false $data = [];

	/**
	* Filtered data array. We don't have empty or invalid values here.
	*/
	public array $prepared_data = [];

	/**
	* Does the image have exif data?
	* Values see constant declaration at the beginning of the class.
	*/
	public int $status = self::UNKNOWN;

	/**
	* Full data array encoded as JSON.
	*/
	public string $serialized = '';

	/**
	* Full link to the image-file
	*/
	public string $file = '';

	/**
	* Original status of the Exif data.
	*/
	public ?int $orig_status = null;

	/**
	* Image-ID, just needed to update the Exif status
	*/
	public int|false $image_id = false;

	/**
	* Constructor
	*
	* @param	string	$file		Full link to the image-file
	* @param	int|false	$image_id	False or integer
	*/
	public function __construct(string $file, int|false $image_id = false)
	{
		if (self::$function_exists === null)
		{
			self::$function_exists = (function_exists('exif_read_data')) ? true : false;
		}
		if ($image_id)
		{
			$this->image_id = (int) $image_id;
		}

		$this->file = $file;
	}

	/**
	* Interpret the values from the database, and read the data if we don't have it.
	*
	* @param	int		$status		Value of a status constant (see beginning of the class)
	* @param	string	$data		Either an empty string or the JSON-encoded Exif array from the database
	*/
	public function interpret(int $status, string $data): void
	{
		$this->orig_status = $status;
		$this->status = $status;
		if ($this->status == self::DBSAVED)
		{
			try
			{
				$decoded = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
				if (!is_array($decoded))
				{
					throw new \JsonException('EXIF data must decode to an array.');
				}
				$this->data = $decoded;
				$this->serialized = $data;
			}
			catch (\JsonException)
			{
				// EXIF is derived data, so legacy serialized caches can be rebuilt safely.
				$this->orig_status = null;
				$this->status = self::UNKNOWN;
				$this->read();
			}
		}
		else if (($this->status == self::AVAILABLE) || ($this->status == self::UNKNOWN))
		{
			$this->read();
		}
	}

	/**
	* Read Exif data from the image
	*/
	public function read(): void
	{
		if (!self::$function_exists || !$this->file || !file_exists($this->file))
		{
			return;
		}

		$this->data = @exif_read_data($this->file, 0, true);

		if (!empty($this->data['EXIF']))
		{
			// Unset invalid Exif's
			foreach ($this->data as $key => $array)
			{
				if (!in_array($key, self::$allowed_groups))
				{
					unset($this->data[$key]);
				}
				else
				{
					foreach ($this->data[$key] as $subkey => $array)
					{
						if (!in_array($subkey, self::$allowed_keys))
						{
							unset($this->data[$key][$subkey]);
						}
					}
				}
			}

			try
			{
				$this->serialized = json_encode(
					$this->data,
					JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR
				);
				$this->status = self::DBSAVED;
			}
			catch (\JsonException)
			{
				$this->data = [];
				$this->serialized = '';
				$this->status = self::UNAVAILABLE;
			}
		}
		else
		{
			$this->status = self::UNAVAILABLE;
		}

		if ($this->image_id)
		{
			$this->set_status();
		}
	}

	/**
	* Validate and prepare the data, so we can send it into the template.
	*/
	private function prepare_data(): void
	{
		global $user;

		$user->add_lang_ext('phpbbgallery/exif', 'info_exif');

		$this->prepared_data = [];
		if (isset($this->data['EXIF']['DateTimeOriginal']))
		{
			$timestamp_year = (int) substr($this->data['EXIF']['DateTimeOriginal'], 0, 4);
			$timestamp_month = (int) substr($this->data['EXIF']['DateTimeOriginal'], 5, 2);
			$timestamp_day = (int) substr($this->data['EXIF']['DateTimeOriginal'], 8, 2);
			$timestamp_hour = (int) substr($this->data['EXIF']['DateTimeOriginal'], 11, 2);
			$timestamp_minute = (int) substr($this->data['EXIF']['DateTimeOriginal'], 14, 2);
			$timestamp_second = (int) substr($this->data['EXIF']['DateTimeOriginal'], 17, 2);
			$timestamp = (int) @mktime($timestamp_hour, $timestamp_minute, $timestamp_second, $timestamp_month, $timestamp_day, $timestamp_year);
			if ($timestamp)
			{
				$this->prepared_data['exif_date'] = $user->format_date($timestamp + self::TIME_OFFSET);
			}
		}
		if (isset($this->data['EXIF']['FocalLength']) && !is_array($this->data['EXIF']['FocalLength']))
		{
			list($num, $den) = array_pad(explode('/', $this->data['EXIF']['FocalLength']), 2, 0);
			if (is_numeric($num) && is_numeric($den) && $den)
			{
				$this->prepared_data['exif_focal'] = sprintf($user->lang['EXIF_FOCAL_EXP'], ($num / $den));
			}
		}
		if (isset($this->data['EXIF']['ExposureTime']) && !is_array($this->data['EXIF']['ExposureTime']))
		{
			list($num, $den) = array_pad(explode('/', $this->data['EXIF']['ExposureTime']), 2, 0);
			$exif_exposure = '';
			if (is_numeric($num) && is_numeric($den))
			{
				if (($num > $den) && $den)
				{
					$exif_exposure = $num / $den;
				}
				else if ($num)
				{
					$exif_exposure = ' 1/' . $den / $num ;
				}
			}
			if ($exif_exposure)
			{
				$this->prepared_data['exif_exposure'] = sprintf($user->lang['EXIF_EXPOSURE_EXP'], $exif_exposure);
			}
		}
		if (isset($this->data['EXIF']['FNumber']) && !is_array($this->data['EXIF']['FNumber']))
		{
			list($num, $den) = array_pad(explode('/', $this->data['EXIF']['FNumber']), 2, 0);
			if (is_numeric($num) && is_numeric($den) && $den)
			{
				$this->prepared_data['exif_aperture'] = 'F/' . ($num / $den);
			}
		}
		if (isset($this->data['EXIF']['ISOSpeedRatings']) && !is_array($this->data['EXIF']['ISOSpeedRatings']))
		{
			$this->prepared_data['exif_iso'] = $this->data['EXIF']['ISOSpeedRatings'];
		}
		if (isset($this->data['EXIF']['WhiteBalance']))
		{
			$this->prepared_data['exif_whiteb'] = $user->lang['EXIF_WHITEB_' . (($this->data['EXIF']['WhiteBalance']) ? 'MANU' : 'AUTO')];
		}
		if (isset($this->data['EXIF']['Flash']))
		{
			if (isset($user->lang['EXIF_FLASH_CASE_' . $this->data['EXIF']['Flash']]))
			{
				$this->prepared_data['exif_flash'] = $user->lang['EXIF_FLASH_CASE_' . $this->data['EXIF']['Flash']];
			}
		}
		if (isset($this->data['IFD0']['Model']) && !is_array($this->data['IFD0']['Model']))
		{
			$this->prepared_data['exif_cam_model'] = ucwords($this->data['IFD0']['Model']);
		}
		if (isset($this->data['EXIF']['ExposureProgram']))
		{
			if (isset($user->lang['EXIF_EXPOSURE_PROG_' . $this->data['EXIF']['ExposureProgram']]))
			{
				$this->prepared_data['exif_exposure_prog'] = $user->lang['EXIF_EXPOSURE_PROG_' . $this->data['EXIF']['ExposureProgram']];
			}
		}
		if (isset($this->data['EXIF']['ExposureBiasValue']) && !is_array($this->data['EXIF']['ExposureBiasValue']))
		{
			list($num,$den) = array_pad(explode('/', $this->data['EXIF']['ExposureBiasValue']), 2, 0);
			if (is_numeric($num) && is_numeric($den) && $den)
			{
				if (($num / $den) == 0)
				{
					$exif_exposure_bias = 0;
				}
				else
				{
					$exif_exposure_bias = $this->data['EXIF']['ExposureBiasValue'];
				}
				$this->prepared_data['exif_exposure_bias'] = sprintf($user->lang['EXIF_EXPOSURE_BIAS_EXP'], $exif_exposure_bias);
			}
		}
		if (isset($this->data['EXIF']['MeteringMode']))
		{
			if (isset($user->lang['EXIF_METERING_MODE_' . $this->data['EXIF']['MeteringMode']]))
			{
				$this->prepared_data['exif_metering_mode'] = $user->lang['EXIF_METERING_MODE_' . $this->data['EXIF']['MeteringMode']];
			}
		}
	}

	/**
	* Sends the Exif into the template
	*
	* @param	bool	$expand_view	Shall we expand the Exif data on page view or collapse?
	* @param	string	$block			Name of the template loop the Exif's are displayed in.
	*/
	public function send_to_template(bool $expand_view = true, string $block = 'exif_value'): void
	{
		$this->prepare_data();

		if (!empty($this->prepared_data))
		{
			global $template, $user;

			foreach ($this->prepared_data as $exif => $value)
			{
				$template->assign_block_vars($block, [
					'EXIF_NAME'			=> $user->lang[strtoupper($exif)],
					'EXIF_VALUE'		=> utf8_htmlspecialchars($value),
				]);
			}
			$template->assign_vars([
				'S_EXIF_DATA'	=> true,
				'S_VIEWEXIF'	=> $expand_view,
			]);
		}
	}

	/**
	* Save the new Exif status in the database
	*
	* @return bool|null False when unchanged, otherwise null after persisting.
	*/
	public function set_status(): ?bool
	{
		if (!$this->image_id || ($this->orig_status == $this->status))
		{
			return false;
		}

		global $db, $table_prefix;

		$update_data = ($this->status == self::DBSAVED) ? ", image_exif_data = '" . $db->sql_escape($this->serialized) . "'" : '';
		$sql = 'UPDATE ' . $table_prefix . 'gallery_images 
			SET image_has_exif = ' . $this->status . $update_data . '
			WHERE image_id = ' . (int) $this->image_id;
		$db->sql_query($sql);
	}

	/**
	* There are lots of possible Exif Groups and Values.
	* But you will never heard of the missing ones. so we just allow the most common ones.
	*/
	private static array $allowed_groups = [
		'EXIF',
		'IFD0',
	];

	private static array $allowed_keys = [
		'DateTimeOriginal',
		'FocalLength',
		'ExposureTime',
		'FNumber',
		'ISOSpeedRatings',
		'WhiteBalance',
		'Flash',
		'Model',
		'ExposureProgram',
		'ExposureBiasValue',
		'MeteringMode',
	];
}
