<?php
/**
 * phpBB Gallery - ACP Import Extension [Spanish Translation]
 *
 * @package   phpbbgallery/acpimport
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
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
	'ACP_IMPORT_ALBUMS'         => 'Importar imágenes',
	'ACP_IMPORT_ALBUMS_EXPLAIN' => 'Aquí puede importar imágenes por lotes desde el sistema de archivos. Antes de importarlas, asegúrese de cambiar su tamaño manualmente.',

	'IMPORT_ARCHIVES'            => 'Archivos ZIP',
	'IMPORT_ARCHIVES_SELECT'     => 'Elija los archivos que quiere descomprimir. Sus imágenes se colocan en la carpeta de importación, donde después puede elegir las que quiere importar. Los archivos descomprimidos se eliminan.',
	'IMPORT_EXTRACT'             => 'Extraer',
	'IMPORT_NO_ARCHIVES'         => 'No hay archivos ZIP en la carpeta de importación.',
	'IMPORT_ZIP_ALL_EXTRACTED'   => 'Se extrajeron %1$d imágenes de %2$d archivos. Elija abajo las que quiere importar.',
	'IMPORT_ZIP_EXTRACTED'       => 'Se extrajeron %1$d imágenes de “%2$s”.',
	'IMPORT_ZIP_FAILED'          => 'No se pudo extraer el archivo “%s”.',
	'IMPORT_ZIP_MAX_IMAGES'      => 'Imágenes por archivo',
	'IMPORT_ZIP_MAX_IMAGES_EXPLAIN' => 'Cuántas imágenes puede aportar un solo archivo. Un archivo nunca se lee más allá de 1000 entradas, así que ese es también el valor máximo útil.',
	'IMPORT_ZIP_SETTINGS'        => 'Archivos ZIP',
	'IMPORT_ZIP_SETTINGS_SAVED'  => 'Se guardaron los ajustes de los archivos.',
	'IMPORT_ALBUM'               => 'Álbum de destino:',
	'IMPORT_DEBUG_MES'           => 'Se importaron %1$s imágenes. Quedan %2$s imágenes.',
	'IMPORT_DIR_EMPTY'           => 'La carpeta %s está vacía. Debe subir las imágenes antes de importarlas.',
	'IMPORT_FINISHED'            => 'Las %1$s imágenes se importaron correctamente.',
	'IMPORT_FINISHED_ERRORS'     => 'Se importaron correctamente %1$s imágenes, pero se produjeron los errores siguientes:<br /><br />',
	'IMPORT_MISSING_ALBUM'       => 'Seleccione el álbum al que desea importar las imágenes.',
	'IMPORT_SELECT'              => 'Seleccione las imágenes que desea importar. Las imágenes importadas correctamente se eliminarán; las demás permanecerán disponibles.',
	'IMPORT_SCHEMA_CREATED'      => 'El estado de importación se creó correctamente. Espere mientras se importan las imágenes.',
	'IMPORT_INVALID_IMAGE'       => 'El archivo seleccionado “%s” no es una imagen permitida de la carpeta de importación.',
	'IMPORT_SCHEMA_WRITE_FAILED' => 'El estado de importación no se pudo guardar de forma segura.',
	'IMPORT_TOO_MANY_IMAGES'     => 'Puede importar como máximo %d imágenes a la vez.',
	'IMPORT_UNREADABLE_FILES'    => 'Se ignoraron %d archivos con nombres ilegibles.',
	'IMPORT_USER'                => 'Subidas por',
	'IMPORT_USER_EXP'            => 'Aquí puede asignar las imágenes a otro usuario.',
	'IMPORT_USERS_PEGA'          => 'Subir a la galería personal de los usuarios.',

	'MISSING_IMPORT_SCHEMA' => 'No se encontró el estado de importación especificado (%s).',

	'NO_FILE_SELECTED' => 'Debe seleccionar al menos un archivo.',

	'GALLERY_CORE_NOT_FOUND'   => 'Primero debe instalar y activar la extensión principal phpBB Gallery.',
	'EXTENSION_ENABLE_SUCCESS' => 'La extensión se activó correctamente.',
]);
