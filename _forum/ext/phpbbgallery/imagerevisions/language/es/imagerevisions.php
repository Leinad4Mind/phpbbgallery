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
	'REPLACE_IMAGE'                => 'Reemplazar el archivo de imagen',
	'REPLACE_IMAGE_EXPLAIN'        => 'Selecciona un archivo nuevo. Se conservan el ID, la descripción, los comentarios, las valoraciones y el contador de visitas.',
	'IMAGE_REVISIONS'              => 'Archivos de imagen anteriores',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Los archivos conservados se pueden previsualizar y restaurar. Al restaurar, el archivo actual se guarda en el historial.',
	'RESTORE_REVISION'             => 'Restaurar esta versión',
	'IMAGE_REPLACE_FAILED'         => 'No se pudo aplicar el archivo de reemplazo de forma segura.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Esta revisión de la imagen ya no está disponible.',
	'IMAGE_REVISION_RESTORED'      => 'La revisión de la imagen se restauró correctamente.',
]);
