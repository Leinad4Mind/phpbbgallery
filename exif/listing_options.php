<?php
/**
 * phpBB Gallery - EXIF listing display options
 *
 * @package   phpbbgallery/exif
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif;

/**
 * EXIF bits contributed to the shared Gallery card-information masks.
 *
 * Core owns bits 0-10. EXIF reserves bits 11-22; optional add-ons must use
 * different bits so independently selected values remain independently visible.
 */
class listing_options
{
	public const EXIF_DATE = 2048;
	public const EXIF_FOCAL = 4096;
	public const EXIF_EXPOSURE = 8192;
	public const EXIF_APERTURE = 16384;
	public const EXIF_ISO = 32768;
	public const EXIF_WHITEB = 65536;
	public const EXIF_FLASH = 131072;
	public const EXIF_CAM_MODEL = 262144;
	public const EXIF_EXPOSURE_PROG = 524288;
	public const EXIF_EXPOSURE_BIAS = 1048576;
	public const EXIF_METERING_MODE = 2097152;
	public const EXIF_RESOLUTION = 4194304;

	public const FIELDS = [
		'exif_date' => self::EXIF_DATE,
		'exif_focal' => self::EXIF_FOCAL,
		'exif_exposure' => self::EXIF_EXPOSURE,
		'exif_aperture' => self::EXIF_APERTURE,
		'exif_iso' => self::EXIF_ISO,
		'exif_whiteb' => self::EXIF_WHITEB,
		'exif_flash' => self::EXIF_FLASH,
		'exif_cam_model' => self::EXIF_CAM_MODEL,
		'exif_exposure_prog' => self::EXIF_EXPOSURE_PROG,
		'exif_exposure_bias' => self::EXIF_EXPOSURE_BIAS,
		'exif_metering_mode' => self::EXIF_METERING_MODE,
		'exif_resolution' => self::EXIF_RESOLUTION,
	];

	public static function selected_fields(int $display_options): array
	{
		return array_keys(array_filter(
			self::FIELDS,
			static fn (int $bit): bool => ($display_options & $bit) !== 0
		));
	}
}
