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
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Revisiones de imágenes para este álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Cada ajuste puede heredar el valor efectivo del álbum padre más cercano o del valor global.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Heredar',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Ajuste efectivo: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Valor efectivo: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Revisiones por álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Este resumen de solo lectura sigue la jerarquía de álbumes. Usa Editar para cambiar un álbum o subálbum.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Álbum',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Heredado',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Ajuste directo',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Establecido en %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'No hay álbumes públicos en la Galería.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Puede gestionar la configuración de revisiones de imágenes',
]);
