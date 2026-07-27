<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Revisiones de imágenes',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configura el historial opcional de reemplazo y restauración de imágenes.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Configuración de revisiones',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Activar revisiones de imágenes',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Permite a los editores reemplazar archivos y restaurar versiones conservadas. Cada revisión usa almacenamiento adicional.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Revisiones conservadas por imagen',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Elige entre 1 y 50. Los archivos más antiguos se eliminan automáticamente.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'La configuración de revisiones se actualizó correctamente.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Puede gestionar la configuración de revisiones de imágenes',
]);
