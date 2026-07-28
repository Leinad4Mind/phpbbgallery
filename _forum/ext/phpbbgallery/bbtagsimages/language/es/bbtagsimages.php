<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Imágenes de la galería',
	'BBTAGSIMAGES_TAGS' => 'Etiquetas',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Añade hasta %1$d etiquetas separadas por comas. Cada etiqueta debe tener entre %2$d y %3$d caracteres. Las etiquetas nuevas se envían a los moderadores para su aprobación.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Cada etiqueta debe tener al menos %2$d caracteres.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Cada etiqueta puede tener como máximo %3$d caracteres.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'No puedes añadir más de %1$d etiquetas a una imagen.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'Las etiquetas nuevas permanecen ocultas hasta que un moderador las apruebe.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'No se pudieron guardar las etiquetas de la imagen.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Buscar por etiquetas',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Introduce una o más etiquetas separadas por comas.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Coincidir con todas las etiquetas (Y)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Coincidir con cualquier etiqueta (O)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filtrar por más etiquetas',
]);
