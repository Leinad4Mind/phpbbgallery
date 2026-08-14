<?php
/**
 * phpBB Gallery - ACP CleanUp Extension [Spanish Translation]
 *
 * @package   phpbbgallery/acpcleanup
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
	'ACP_GALLERY_CLEANUP' => 'Limpiar galería',

	'ACP_GALLERY_CLEANUP_EXPLAIN' => 'Aquí puede eliminar datos y archivos residuales.',

	'CLEAN_AUTHORS_DONE'       => 'Se eliminaron las imágenes sin autor válido.',
	'CLEAN_CHANGED'            => 'El autor se cambió a “Invitado”.',
	'CLEAN_COMMENTS_DONE'      => 'Se eliminaron los comentarios sin autor válido.',
	'CLEAN_ENTRIES_DONE'       => 'Se eliminaron los archivos sin entrada en la base de datos.',
	'CLEAN_GALLERY'            => 'Limpiar galería',
	'CLEAN_GALLERY_ABORT'      => 'Se canceló la limpieza.',
	'CLEAN_NO_ACTION'          => 'No se completó ninguna acción. Se produjo un error.',
	'CLEAN_PERSONALS_DONE'     => 'Se eliminaron los álbumes personales sin propietario válido.',
	'CLEAN_PERSONALS_BAD_DONE' => 'Se eliminaron los álbumes personales de los usuarios seleccionados.',
	'CLEAN_PRUNE_DONE'         => 'Las imágenes se purgaron correctamente.',
	'CLEAN_PRUNE_NO_PATTERN'   => 'No se especificó ningún criterio de búsqueda.',
	'CLEAN_SOURCES_DONE'       => 'Se eliminaron las imágenes sin archivo.',

	'SOURCE_CHECK_PROGRESS' => 'Comprobando los archivos fuente de la Galería',
	'SOURCE_CHECK_COMPLETE' => 'Comprobación de archivos fuente completada',
	'SOURCE_CHECK_RESULT' => 'Comprobados: %1$d; archivos fuente ausentes: %2$d.',
	'SOURCE_CHECK_RUN' => 'Comprobar de nuevo los archivos fuente',
	'MISSING_SOURCE_DIAGNOSTIC_EXPLAIN' => 'Este diagnóstico comprueba el proveedor de almacenamiento activo en lotes reanudables de 25. La ausencia de archivos medium o mini no invalida un registro, pues esos derivados pueden regenerarse desde la fuente.',
	'MISSING_SOURCE_SUMMARY' => 'Hay %1$d registros sin archivo fuente en el proveedor activo %2$s.',
	'MISSING_SOURCE_CONTEXT' => 'Álbum y autor',
	'MISSING_SOURCE_EXPECTED_KEY' => 'Objeto fuente esperado',
	'MISSING_SOURCE_DERIVATIVES' => 'Derivados existentes',
	'MISSING_SOURCE_MEDIUM' => 'Medium',
	'MISSING_SOURCE_MINI' => 'Mini',
	'MISSING_SOURCE_RESTORE_EXPLAIN' => 'Restaura los originales recuperables en el proveedor y la clave fuente exactos indicados arriba y repite la comprobación. Selecciona y elimina únicamente registros cuyos originales no puedan recuperarse; la eliminación requiere confirmación y mantiene coherentes los datos relacionados.',
	'MISSING_SOURCE_STATUS_UNAPPROVED' => 'Pendiente de aprobación',
	'MISSING_SOURCE_STATUS_APPROVED' => 'Aprobada',
	'MISSING_SOURCE_STATUS_LOCKED' => 'Bloqueada',
	'MISSING_SOURCE_STATUS_ORPHAN' => 'Carga sin terminar',
	'MISSING_SOURCE_STATUS_DELETE_REQUESTED' => 'Eliminación solicitada',
	'MISSING_SOURCE_STATUS_UNKNOWN' => 'Desconocido',

	'CONFIRM_CLEAN'               => 'Este paso no se puede deshacer.',
	'CONFIRM_CLEAN_AUTHORS'       => '¿Eliminar las imágenes sin autor válido?',
	'CONFIRM_CLEAN_COMMENTS'      => '¿Eliminar los comentarios sin autor válido?',
	'CONFIRM_CLEAN_ENTRIES'       => '¿Eliminar los archivos sin entrada en la base de datos?',
	'CONFIRM_CLEAN_PERSONALS'     => '¿Eliminar los álbumes personales sin propietario válido?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_PERSONALS_BAD' => '¿Eliminar los álbumes personales de los usuarios seleccionados?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_SOURCES'       => '¿Eliminar las imágenes sin archivo?',
	'CONFIRM_PRUNE'               => '¿Eliminar todas las imágenes que cumplen las condiciones siguientes?<br /><br />%s<br />',

	'PRUNE'                  => 'Purgar',
	'PRUNE_ALBUMS'           => 'Purgar álbumes',
	'PRUNE_CHECK_OPTION'     => 'Comprobar esta opción al purgar imágenes.',
	'PRUNE_COMMENTS'         => 'Menos de x comentarios',
	'PRUNE_PATTERN_ALBUM_ID' => 'La imagen está en uno de los álbumes siguientes:<br />&raquo; <strong>%s</strong>',
	'PRUNE_PATTERN_COMMENTS' => 'La imagen tiene menos de <strong>%d</strong> comentarios.',
	'PRUNE_PATTERN_RATES'    => 'La imagen tiene menos de <strong>%d</strong> valoraciones.',
	'PRUNE_PATTERN_RATE_AVG' => 'La imagen tiene una valoración media inferior a <strong>%s</strong>.',
	'PRUNE_PATTERN_TIME'     => 'La imagen se subió antes del “<strong>%s</strong>”.',
	'PRUNE_PATTERN_USER_ID'  => 'La imagen fue subida por uno de los usuarios siguientes:<br />&raquo; <strong>%s</strong>',
	'PRUNE_RATINGS'          => 'Menos de x valoraciones',
	'PRUNE_RATING_AVG'       => 'Valoración media inferior a',
	'PRUNE_RATING_AVG_EXP'   => 'Purgar solo las imágenes con una valoración media inferior a “<samp>x.yz</samp>”.',
	'PRUNE_TIME'             => 'Subidas antes de',
	'PRUNE_TIME_EXP'         => 'Purgar solo las imágenes subidas antes de “<samp>AAAA-MM-DD</samp>”.',
	'PRUNE_USERNAME'         => 'Subidas por',
	'PRUNE_USERNAME_EXP'     => 'Purgar solo las imágenes de determinados usuarios. Para incluir las imágenes de invitados, marque la casilla situada junto al campo de nombre de usuario.',

	// Log
	'LOG_CLEANUP_DELETE_FILES'             => 'Se eliminaron %s imágenes sin entradas en la base de datos.',
	'LOG_CLEANUP_DELETE_ENTRIES'           => 'Se eliminaron %s imágenes sin archivos.',
	'LOG_CLEANUP_DELETE_NO_AUTHOR'         => 'Se eliminaron %s imágenes sin autor válido.',
	'LOG_CLEANUP_COMMENT_DELETE_NO_AUTHOR' => 'Se eliminaron %s comentarios sin autor válido.',

	'MOVE_TO_IMPORT'       => 'Mover imágenes al directorio de importación',
	'MOVE_TO_USER'         => 'Mover al usuario',
	'MOVE_TO_USER_EXP'     => 'Las imágenes y los comentarios se asignarán al usuario indicado. Si no selecciona ninguno, se usará el usuario anónimo.',
	'CLEAN_USER_NOT_FOUND' => 'El usuario seleccionado no existe.',

	'GALLERY_LEGACY_BBCODE_MIGRATE' => 'Migrar BBCodes heredados de la galería',
	'GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN' => 'Busca el alias oculto [album] en mensajes, mensajes privados y firmas. Después de la confirmación, cada ejecución vuelve a procesar hasta %1$d registros como %2$s y mantiene coherentes los metadatos de BBCode de phpBB. Repite la acción hasta que no queden registros.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM' => '¿Convertir el siguiente lote de [album] a %2$s? Actualmente quedan %1$d registros.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_NONE' => 'No quedan registros heredados con [album].',
	'GALLERY_LEGACY_BBCODE_MIGRATE_RESULT' => 'Se convirtieron %1$d registros. No se pudieron convertir %2$d registros. Quedan %3$d registros.',
	'GALLERY_CORE_NOT_FOUND'   => 'Primero debe instalar y activar la extensión principal phpBB Gallery.',
	'EXTENSION_ENABLE_SUCCESS' => 'La extensión se activó correctamente.',
]);
