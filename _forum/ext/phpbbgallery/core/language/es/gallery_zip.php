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

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'El archivo ZIP contiene una entrada con una relación de compresión no segura.',
	'ZIP_DUPLICATE_PATH'              => 'El archivo ZIP contiene rutas de archivo duplicadas.',
	'ZIP_EXTENSION_NOT_AVAILABLE'     => 'La carga de archivos ZIP requiere la extensión Zip de PHP.',
	'ZIP_EXTRACTION_FAILED'           => 'El archivo ZIP no se pudo extraer de forma segura.',
	'ZIP_INVALID_ARCHIVE'             => 'El archivo ZIP cargado no es válido o no se puede leer.',
	'ZIP_INVALID_IMAGE_TYPE'          => 'El archivo «%s» del ZIP no es una imagen válida del tipo declarado.',
	'ZIP_NO_IMAGES'                   => 'El archivo ZIP no contiene imágenes permitidas.',
	'ZIP_SIZE_LIMIT_EXCEEDED'         => 'El archivo ZIP supera el tamaño de extracción permitido.',
	'ZIP_TOO_MANY_ENTRIES'            => 'El archivo ZIP contiene más de %d entradas.',
	'ZIP_TOO_MANY_IMAGES'             => 'El archivo ZIP contiene más de %d imágenes permitidas.',
	'ZIP_UNSAFE_PATH'                 => 'El archivo ZIP contiene una ruta de archivo no segura.',
]);
