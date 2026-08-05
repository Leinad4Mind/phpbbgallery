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

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for Exif data
*/
$lang = array_merge($lang, [
	'EXIF_DATA'					=> 'Exif Data',
	'EXIF_APERTURE'				=> 'F-number',
	'EXIF_CAM_MODEL'			=> 'Camera-model',
	'EXIF_DATE'					=> 'Image taken on',
	'EXIF_EXPOSURE'				=> 'Shutter speed',
	'EXIF_EXPOSURE_EXP'			=> '%s Sec',// 'EXIF_EXPOSURE' unit
	'EXIF_EXPOSURE_BIAS'		=> 'Exposure bias',
	'EXIF_EXPOSURE_BIAS_EXP'	=> '%s EV',// 'EXIF_EXPOSURE_BIAS' unit
	'EXIF_EXPOSURE_PROG'		=> 'Exposure program',
	'EXIF_EXPOSURE_PROG_0'		=> 'Not defined',
	'EXIF_EXPOSURE_PROG_1'		=> 'Manual',
	'EXIF_EXPOSURE_PROG_2'		=> 'Normal program',
	'EXIF_EXPOSURE_PROG_3'		=> 'Aperture priority',
	'EXIF_EXPOSURE_PROG_4'		=> 'Shutter priority',
	'EXIF_EXPOSURE_PROG_5'		=> 'Creative program (biased toward depth of field)',
	'EXIF_EXPOSURE_PROG_6'		=> 'Action program (biased toward fast shutter speed)',
	'EXIF_EXPOSURE_PROG_7'		=> 'Portrait mode (for closeup photos with the background out of focus)',
	'EXIF_EXPOSURE_PROG_8'		=> 'Landscape mode (for landscape photos with the background in focus)',
	'EXIF_FLASH'				=> 'Flash',
	'EXIF_FLASH_CASE_0'			=> 'Flash did not fire',
	'EXIF_FLASH_CASE_1'			=> 'Flash fired',
	'EXIF_FLASH_CASE_5'			=> 'return light not detected',
	'EXIF_FLASH_CASE_7'			=> 'return light detected',
	'EXIF_FLASH_CASE_8'			=> 'On, Flash did not fire',
	'EXIF_FLASH_CASE_9'			=> 'Flash fired, compulsory flash mode',
	'EXIF_FLASH_CASE_13'		=> 'Flash fired, compulsory flash mode, return light not detected',
	'EXIF_FLASH_CASE_15'		=> 'Flash fired, compulsory flash mode, return light detected',
	'EXIF_FLASH_CASE_16'		=> 'Flash did not fire, compulsory flash mode',
	'EXIF_FLASH_CASE_20'		=> 'Off, Flash did not fire, return light not detected',
	'EXIF_FLASH_CASE_24'		=> 'Flash did not fire, auto mode',
	'EXIF_FLASH_CASE_25'		=> 'Flash fired, auto mode',
	'EXIF_FLASH_CASE_29'		=> 'Flash fired, auto mode, return light not detected',
	'EXIF_FLASH_CASE_31'		=> 'Flash fired, auto mode, return light detected',
	'EXIF_FLASH_CASE_32'		=> 'No flash function',
	'EXIF_FLASH_CASE_48'		=> 'Off, No flash function',
	'EXIF_FLASH_CASE_65'		=> 'Flash fired, red-eye reduction mode',
	'EXIF_FLASH_CASE_69'		=> 'Flash fired, red-eye reduction mode, return light not detected',
	'EXIF_FLASH_CASE_71'		=> 'Flash fired, red-eye reduction mode, return light detected',
	'EXIF_FLASH_CASE_73'		=> 'Flash fired, compulsory flash mode, red-eye reduction mode',
	'EXIF_FLASH_CASE_77'		=> 'Flash fired, compulsory flash mode, red-eye reduction mode, return light not detected',
	'EXIF_FLASH_CASE_79'		=> 'Flash fired, compulsory flash mode, red-eye reduction mode, return light detected',
	'EXIF_FLASH_CASE_80'		=> 'Off, Red-eye reduction',
	'EXIF_FLASH_CASE_88'		=> 'Auto, Did not fire, Red-eye reduction',
	'EXIF_FLASH_CASE_89'		=> 'Flash fired, auto mode, red-eye reduction mode',
	'EXIF_FLASH_CASE_93'		=> 'Flash fired, auto mode, return light not detected, red-eye reduction mode',
	'EXIF_FLASH_CASE_95'		=> 'Flash fired, auto mode, return light detected, red-eye reduction mode',
	'EXIF_FOCAL'				=> 'Focus length',
	'EXIF_FOCAL_EXP'			=> '%s mm',// 'EXIF_FOCAL' unit
	'EXIF_ISO'					=> 'ISO speed rating',
	'EXIF_METERING_MODE'		=> 'Metering mode',
	'EXIF_METERING_MODE_0'		=> 'Unknown',
	'EXIF_METERING_MODE_1'		=> 'Average',
	'EXIF_METERING_MODE_2'		=> 'Center-weighted average',
	'EXIF_METERING_MODE_3'		=> 'Spot',
	'EXIF_METERING_MODE_4'		=> 'Multi-Spot',
	'EXIF_METERING_MODE_5'		=> 'Pattern',
	'EXIF_METERING_MODE_6'		=> 'Partial',
	'EXIF_METERING_MODE_255'	=> 'Other',
	'EXIF_NOT_AVAILABLE'		=> 'not available',
	'EXIF_WHITEB'				=> 'Whitebalance',
	'EXIF_WHITEB_AUTO'			=> 'Auto',
	'EXIF_WHITEB_MANU'			=> 'Manual',

	'DISP_EXIF_DATA'			=> 'Display Exif-data',
	'DISP_EXIF_DATA_EXP'		=> 'This option requires the PHP EXIF extension and its exif_read_data() function.',
	'DISP_EXIF_DATE'      => 'Show “Image taken on”',
	'DISP_EXIF_FOCAL'     => 'Show focus length',
	'DISP_EXIF_EXPOSURE'  => 'Show shutter speed',
	'DISP_EXIF_APERTURE'  => 'Show F-number',
	'DISP_EXIF_ISO'       => 'Show ISO speed rating',
	'DISP_EXIF_WHITEB'    => 'Show whitebalance',
	'DISP_EXIF_FLASH'     => 'Show flash',
	'DISP_EXIF_CAM_MODEL' => 'Show camera model',
	'DISP_EXIF_EXPOSURE_PROG' => 'Show exposure program',
	'DISP_EXIF_EXPOSURE_BIAS' => 'Show exposure bias',
	'DISP_EXIF_METERING_MODE' => 'Show metering mode',
	'SHOW_EXIF'					=> 'show/hide',
	'VIEWEXIFS_DEFAULT'			=> 'View Exif-Data by default',

	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
	'ACP_GALLERY_EXIF'           => 'EXIF metadata',
	'ACP_GALLERY_EXIF_EXPLAIN'   => 'Manage the indexed image capture dates used by Gallery sorting.',
	'ACP_EXIF_CAPTURE_INDEX'     => 'Capture-date index',
	'ACP_EXIF_INDEXED_IMAGES'    => 'Images with an indexed capture date',
	'ACP_EXIF_SYNC_EXPLAIN'      => 'Rebuild the index from cached EXIF metadata and, when necessary, from the original JPEG files. The operation runs in small resumable batches.',
	'ACP_EXIF_SYNC_CONFIRM'      => 'Are you sure you want to rebuild the EXIF capture-date index?',
	'ACP_EXIF_SYNC_PROGRESS'     => 'EXIF synchronization in progress: %1$d images scanned, %2$d capture dates indexed and %3$d source files temporarily unavailable.',
	'ACP_EXIF_SYNC_COMPLETE'     => 'EXIF synchronization complete: %1$d images scanned, %2$d capture dates indexed and %3$d source files unavailable.',
]);
