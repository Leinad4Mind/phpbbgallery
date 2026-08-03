<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Spanish [es]] (2026)
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
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> '¡Falta phpBB Gallery Core! Descárguelo e instálelo antes que esta extensión.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'La extensión se activó correctamente.',

	'EXPORT_SELECTION'				=> 'Qué exportar',
	'EXPORT_ALBUMS'					=> 'Álbumes',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Elija uno o varios álbumes. Mantenga pulsada la tecla Ctrl para seleccionar varios.',
	'EXPORT_ALL_ALBUMS'				=> 'Exportar toda la galería, ignorando la selección anterior',
	'EXPORT_DELIVERY'				=> 'Destino del archivo',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Un archivo dejado en el servidor se escribe en %s y nunca se elimina automáticamente, de modo que puede recogerlo por FTP cuando quiera.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Ofrecerlo como descarga',
	'EXPORT_DELIVERY_SERVER'		=> 'Dejarlo en el servidor',
	'EXPORT_LIMITS'					=> 'Límites',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Como máximo %1$d imágenes y %2$s por exportación, escribiendo %3$d imágenes cada vez.',
	'EXPORT_SETTINGS'				=> 'Configuración de exportación',
	'EXPORT_MAX_IMAGES'				=> 'Máximo de imágenes por exportación',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Número máximo de imágenes permitido en una exportación. El límite de seguridad es %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Tamaño máximo por exportación (MiB)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Tamaño máximo combinado de los archivos originales. El límite de seguridad es %d MiB.',
	'EXPORT_BATCH_SIZE'				=> 'Imágenes por lote',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Número de imágenes escritas en cada solicitud. Los valores bajos reducen la memoria y el riesgo de timeout. El límite es %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'La configuración de exportación se ha guardado.',
	'EXPORT_START'					=> 'Iniciar exportación',
	'EXPORT_CONTINUE'				=> 'Continuar',
	'EXPORT_DOWNLOAD'				=> 'Descargar',

	'EXPORT_STARTED'				=> [
		1	=> 'Ha comenzado la exportación de %d imagen.',
		2	=> 'Ha comenzado la exportación de %d imágenes.',
	],
	'EXPORT_PROGRESS'				=> 'Exportadas %1$d de %2$d imágenes…',
	'EXPORT_FINISHED'				=> [
		1	=> 'La exportación terminó con %d imagen.',
		2	=> 'La exportación terminó con %d imágenes.',
	],

	'EXPORT_JOBS'					=> 'Exportaciones',
	'EXPORT_NO_JOBS'				=> 'Todavía no hay ninguna exportación.',
	'EXPORT_JOB_ARCHIVE'			=> 'Archivo',
	'EXPORT_JOB_CREATED'			=> 'Iniciada',
	'EXPORT_JOB_PROGRESS'			=> 'Progreso',
	'EXPORT_JOB_SIZE'				=> 'Tamaño',
	'EXPORT_JOB_ACTION'				=> 'Acción',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> 'No se pudo añadir %d imagen.',
		2	=> 'No se pudieron añadir %d imágenes.',
	],
	'EXPORT_JOB_DELETED'			=> 'La exportación se eliminó.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Esa exportación no existe o no le pertenece.',
	'EXPORT_STATUS_READY'			=> 'Lista',
	'EXPORT_STATUS_RUNNING'			=> 'En curso',

	'EXPORT_UCP_EXPLAIN'			=> 'Aquí puede descargar las imágenes que subió, con los nombres que muestra la galería en lugar de los nombres con los que se guardan en el disco. Hasta %d imágenes por exportación.',
	'EXPORT_UCP_DISABLED'			=> 'El administrador del foro ha desactivado la exportación de sus propias imágenes.',

	'EXPORT_NO_IMAGES'				=> 'No hay imágenes que exportar.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Una exportación puede abarcar como máximo %d imágenes. Exporte menos álbumes cada vez.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Una exportación puede ocupar como máximo %s. Exporte menos álbumes cada vez.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'No hay suficiente espacio libre en el servidor para esta exportación.',
	'EXPORT_ARCHIVE_FAILED'			=> 'No se pudo escribir el archivo.',
	'EXPORT_ARCHIVE_MISSING'		=> 'El archivo de esta exportación ya no está en el servidor.',
	'EXPORT_STATE_FAILED'			=> 'No se pudo guardar el estado de esta exportación. Compruebe que el directorio de exportación tiene permisos de escritura.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Se omitió la imagen %1$d: el fichero “%2$s” no está en el servidor.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Se omitió la imagen %1$d: no se pudo leer el fichero “%2$s”.',
	'EXPORT_ERROR_ARCHIVE'			=> 'No se pudo escribir el archivo “%s”.',
]);
