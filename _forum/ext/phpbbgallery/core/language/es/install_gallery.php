<?php
/**
 * phpBB Gallery - ACP Core Extension [Spanish Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator
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
	'GALLERY_BBCODE_CONFLICT' => 'No se puede instalar el BBCode %s porque esa etiqueta pertenece a un BBCode personalizado incompatible. Cambie el nombre o elimine el BBCode personalizado y vuelva a intentarlo.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'No se puede instalar el BBCode %s porque se ha alcanzado el límite de BBCode. Elimine un BBCode y vuelva a intentarlo.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core se ha activado. También están disponibles los complementos opcionales ACP Cleanup, ACP Import y EXIF.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core se ha activado. Se conservó el BBCode [image] existente porque pertenece a otra definición; la galería usará [galleryimage] para el contenido nuevo. [album] permanece oculto solo para mostrar publicaciones antiguas y nunca se genera.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery no se puede activar. Faltan componentes obligatorios: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'Debe desinstalar la extensión: <br /><strong>%s</strong><br /> antes de desinstalar la extensión principal.',
		2 => 'Debe desinstalar las extensiones: <br /><strong>%s</strong><br /> antes de desinstalar la extensión principal.',
	],
]);
