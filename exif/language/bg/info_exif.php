<?php
/**
 * phpBB Gallery - ACP Exif Extension [Bulgarian Translation]
 *
 * @package   phpbbgallery/exif
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator Lucifer <https://www.anavaro.com>
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
	'EXIF_RESOLUTION'			=> 'Плътност на разделителната способност',
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
	'DISP_EXIF_DATA_EXP'		=> 'This feature can not be used at the moment, as the need function “exif_read_data“ is not included in your PHP Installation.',
	'DISP_EXIF_DATE'      => 'Показване на „Заснето на“',
	'DISP_EXIF_FOCAL'     => 'Показване на фокусното разстояние',
	'DISP_EXIF_EXPOSURE'  => 'Показване на скоростта на затвора',
	'DISP_EXIF_APERTURE'  => 'Показване на блендата',
	'DISP_EXIF_ISO'       => 'Показване на ISO чувствителността',
	'DISP_EXIF_WHITEB'    => 'Показване на баланса на бялото',
	'DISP_EXIF_FLASH'     => 'Показване на светкавицата',
	'DISP_EXIF_CAM_MODEL' => 'Показване на модела на камерата',
	'DISP_EXIF_RESOLUTION' => 'Показване на плътността на разделителната способност',
	'DISP_EXIF_EXPOSURE_PROG' => 'Показване на програмата на експонация',
	'DISP_EXIF_EXPOSURE_BIAS' => 'Показване на корекцията на експонацията',
	'DISP_EXIF_METERING_MODE' => 'Показване на режима на измерване',
	'SHOW_EXIF'					=> 'show/hide',
	'VIEWEXIFS_DEFAULT'			=> 'View Exif-Data by default',

	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
	'ACP_GALLERY_EXIF'           => 'EXIF метаданни',
	'ACP_GALLERY_EXIF_EXPLAIN'   => 'Управлява индексираните дати на заснемане, използвани за сортиране на Галерията.',
	'ACP_EXIF_CAPTURE_INDEX'     => 'Индекс на датите на заснемане',
	'ACP_EXIF_INDEXED_IMAGES'    => 'Изображения с индексирана дата на заснемане',
	'ACP_EXIF_SYNC_EXPLAIN'      => 'Възстановява индекса от запазените EXIF данни и при нужда от оригиналните JPEG файлове. Операцията се изпълнява на малки възобновяеми партиди.',
	'DISP_EXIF_DATA_EXPLAIN' => 'Активира показването на EXIF глобално. Когато е изключено, EXIF настройките за страницата на изображението и картите с миниатюри се игнорират.',
	'EXIF_IMAGE_PAGE_FIELD_EXPLAIN' => 'Управлява тази стойност само на страницата на отделното изображение. За показване под миниатюри я изберете отделно в съответната настройка за информация на картите.',
	'ACP_EXIF_SYNC_CONFIRM'      => 'Сигурни ли сте, че искате да възстановите EXIF индекса?',
	'ACP_EXIF_SYNC_PROGRESS'     => 'EXIF синхронизация: %1$d проверени изображения, %2$d индексирани дати и %3$d временно недостъпни изходни файла.',
	'ACP_EXIF_SYNC_COMPLETE'     => 'EXIF синхронизацията завърши: %1$d проверени изображения, %2$d индексирани дати и %3$d недостъпни изходни файла.',
]);
