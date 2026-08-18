<?php
/**
 * phpBB Gallery - ACP Exif Extension [Spanish Translation]
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
	'EXIF_DATA'                  => 'Datos EXIF',
	'EXIF_APERTURE'              => 'Número f',
	'EXIF_CAM_MODEL'             => 'Modelo de cámara',
	'EXIF_DATE'                  => 'Fecha de captura',
	'EXIF_RESOLUTION'            => 'Densidad de resolución',
	'EXIF_EXPOSURE'              => 'Tiempo de exposición',
	'EXIF_EXPOSURE_EXP'          => '%s s',
	'EXIF_EXPOSURE_BIAS'         => 'Compensación de exposición',
	'EXIF_EXPOSURE_BIAS_EXP'     => '%s EV',
	'EXIF_EXPOSURE_PROG'         => 'Programa de exposición',
	'EXIF_EXPOSURE_PROG_0'       => 'No definido',
	'EXIF_EXPOSURE_PROG_1'       => 'Manual',
	'EXIF_EXPOSURE_PROG_2'       => 'Programa normal',
	'EXIF_EXPOSURE_PROG_3'       => 'Prioridad de apertura',
	'EXIF_EXPOSURE_PROG_4'       => 'Prioridad de obturación',
	'EXIF_EXPOSURE_PROG_5'       => 'Programa creativo (prioriza la profundidad de campo)',
	'EXIF_EXPOSURE_PROG_6'       => 'Programa de acción (prioriza una velocidad de obturación rápida)',
	'EXIF_EXPOSURE_PROG_7'       => 'Modo retrato (para primeros planos con el fondo desenfocado)',
	'EXIF_EXPOSURE_PROG_8'       => 'Modo paisaje (para paisajes con el fondo enfocado)',
	'EXIF_FLASH'                  => 'Flash',
	'EXIF_FLASH_CASE_0'           => 'El flash no se disparó',
	'EXIF_FLASH_CASE_1'           => 'El flash se disparó',
	'EXIF_FLASH_CASE_5'           => 'No se detectó luz de retorno',
	'EXIF_FLASH_CASE_7'           => 'Se detectó luz de retorno',
	'EXIF_FLASH_CASE_8'           => 'Activado, el flash no se disparó',
	'EXIF_FLASH_CASE_9'           => 'El flash se disparó en modo obligatorio',
	'EXIF_FLASH_CASE_13'          => 'El flash se disparó en modo obligatorio; no se detectó luz de retorno',
	'EXIF_FLASH_CASE_15'          => 'El flash se disparó en modo obligatorio; se detectó luz de retorno',
	'EXIF_FLASH_CASE_16'          => 'El flash no se disparó en modo obligatorio',
	'EXIF_FLASH_CASE_20'          => 'Desactivado, el flash no se disparó y no se detectó luz de retorno',
	'EXIF_FLASH_CASE_24'          => 'El flash no se disparó en modo automático',
	'EXIF_FLASH_CASE_25'          => 'El flash se disparó en modo automático',
	'EXIF_FLASH_CASE_29'          => 'El flash se disparó en modo automático; no se detectó luz de retorno',
	'EXIF_FLASH_CASE_31'          => 'El flash se disparó en modo automático; se detectó luz de retorno',
	'EXIF_FLASH_CASE_32'          => 'Sin función de flash',
	'EXIF_FLASH_CASE_48'          => 'Desactivado, sin función de flash',
	'EXIF_FLASH_CASE_65'          => 'El flash se disparó con reducción de ojos rojos',
	'EXIF_FLASH_CASE_69'          => 'El flash se disparó con reducción de ojos rojos; no se detectó luz de retorno',
	'EXIF_FLASH_CASE_71'          => 'El flash se disparó con reducción de ojos rojos; se detectó luz de retorno',
	'EXIF_FLASH_CASE_73'          => 'El flash se disparó en modo obligatorio con reducción de ojos rojos',
	'EXIF_FLASH_CASE_77'          => 'El flash se disparó en modo obligatorio con reducción de ojos rojos; no se detectó luz de retorno',
	'EXIF_FLASH_CASE_79'          => 'El flash se disparó en modo obligatorio con reducción de ojos rojos; se detectó luz de retorno',
	'EXIF_FLASH_CASE_80'          => 'Desactivado, reducción de ojos rojos',
	'EXIF_FLASH_CASE_88'          => 'Automático, no se disparó, reducción de ojos rojos',
	'EXIF_FLASH_CASE_89'          => 'El flash se disparó en modo automático con reducción de ojos rojos',
	'EXIF_FLASH_CASE_93'          => 'El flash se disparó en modo automático con reducción de ojos rojos; no se detectó luz de retorno',
	'EXIF_FLASH_CASE_95'          => 'El flash se disparó en modo automático con reducción de ojos rojos; se detectó luz de retorno',
	'EXIF_FOCAL'                  => 'Distancia focal',
	'EXIF_FOCAL_EXP'              => '%s mm',
	'EXIF_ISO'                    => 'Sensibilidad ISO',
	'EXIF_METERING_MODE'          => 'Modo de medición',
	'EXIF_METERING_MODE_0'        => 'Desconocido',
	'EXIF_METERING_MODE_1'        => 'Promedio',
	'EXIF_METERING_MODE_2'        => 'Promedio ponderado al centro',
	'EXIF_METERING_MODE_3'        => 'Puntual',
	'EXIF_METERING_MODE_4'        => 'Multipunto',
	'EXIF_METERING_MODE_5'        => 'Patrón',
	'EXIF_METERING_MODE_6'        => 'Parcial',
	'EXIF_METERING_MODE_255'      => 'Otro',
	'EXIF_NOT_AVAILABLE'          => 'no disponible',
	'EXIF_WHITEB'                 => 'Balance de blancos',
	'EXIF_WHITEB_AUTO'            => 'Automático',
	'EXIF_WHITEB_MANU'            => 'Manual',

	'DISP_EXIF_DATA'              => 'Mostrar datos EXIF',
	'DISP_EXIF_DATA_EXP'          => 'Esta función no está disponible porque la instalación de PHP no incluye la función “exif_read_data”.',
	'DISP_EXIF_DATE'              => 'Mostrar “Imagen tomada el”',
	'DISP_EXIF_FOCAL'             => 'Mostrar distancia focal',
	'DISP_EXIF_EXPOSURE'          => 'Mostrar velocidad de obturación',
	'DISP_EXIF_APERTURE'          => 'Mostrar número F',
	'DISP_EXIF_ISO'               => 'Mostrar sensibilidad ISO',
	'DISP_EXIF_WHITEB'            => 'Mostrar balance de blancos',
	'DISP_EXIF_FLASH'             => 'Mostrar flash',
	'DISP_EXIF_CAM_MODEL'         => 'Mostrar modelo de cámara',
	'DISP_EXIF_RESOLUTION'        => 'Mostrar densidad de resolución',
	'DISP_EXIF_EXPOSURE_PROG'     => 'Mostrar programa de exposición',
	'DISP_EXIF_EXPOSURE_BIAS'     => 'Mostrar compensación de exposición',
	'DISP_EXIF_METERING_MODE'     => 'Mostrar modo de medición',
	'SHOW_EXIF'                   => 'mostrar/ocultar',
	'VIEWEXIFS_DEFAULT'           => 'Mostrar los datos EXIF de forma predeterminada',

	'GALLERY_CORE_NOT_FOUND'      => 'Primero debe instalar y activar la extensión principal phpBB Gallery.',
	'EXTENSION_ENABLE_SUCCESS'    => 'La extensión se activó correctamente.',
	'ACP_GALLERY_EXIF'           => 'Metadatos EXIF',
	'ACP_GALLERY_EXIF_EXPLAIN'   => 'Gestiona las fechas de captura indexadas usadas para ordenar la Galería.',
	'ACP_EXIF_CAPTURE_INDEX'     => 'Índice de fechas de captura',
	'ACP_EXIF_INDEXED_IMAGES'    => 'Imágenes con fecha de captura indexada',
	'ACP_EXIF_SYNC_EXPLAIN'      => 'Reconstruye el índice desde los metadatos EXIF guardados y, cuando sea necesario, desde los archivos JPEG originales. La operación usa pequeños lotes reanudables.',
	'ACP_EXIF_SYNC_CONFIRM'      => '¿Seguro que deseas reconstruir el índice de fechas de captura EXIF?',
	'ACP_EXIF_SYNC_PROGRESS'     => 'Sincronización EXIF en curso: %1$d imágenes revisadas, %2$d fechas indexadas y %3$d archivos de origen temporalmente no disponibles.',
	'DISP_EXIF_DATA_EXPLAIN' => 'Activa globalmente la presentación EXIF. Si se desactiva, se ignoran las selecciones EXIF tanto de la página individual de la imagen como de las tarjetas de miniaturas.',
	'EXIF_IMAGE_PAGE_FIELD_EXPLAIN' => 'Controla este valor únicamente en la página individual de la imagen. Para mostrarlo bajo las miniaturas, selecciónalo por separado en la opción de información de tarjetas correspondiente.',
	'ACP_EXIF_SYNC_COMPLETE'     => 'Sincronización EXIF terminada: %1$d imágenes revisadas, %2$d fechas indexadas y %3$d archivos de origen no disponibles.',
]);
