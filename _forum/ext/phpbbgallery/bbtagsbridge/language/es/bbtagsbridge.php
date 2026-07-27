<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Imágenes de la galería',
	'BBTAGSBRIDGE_TAGS' => 'Etiquetas',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Añade hasta %1$d etiquetas separadas por comas. Cada etiqueta debe tener entre %2$d y %3$d caracteres. Las etiquetas nuevas se envían a los moderadores para su aprobación.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Cada etiqueta debe tener al menos %2$d caracteres.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Cada etiqueta puede tener como máximo %3$d caracteres.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'No puedes añadir más de %1$d etiquetas a una imagen.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'Las etiquetas nuevas permanecen ocultas hasta que un moderador las apruebe.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'No se pudieron guardar las etiquetas de la imagen.',
]);
