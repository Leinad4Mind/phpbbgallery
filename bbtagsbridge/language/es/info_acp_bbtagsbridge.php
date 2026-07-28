<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Las siguientes extensiones obligatorias no están disponibles o están desactivadas: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'La extensión se ha activado correctamente.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Políticas de etiquetas de la Galería',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Configura dónde están disponibles en la Galería las etiquetas del catálogo compartido de BBTags. La moderación de sugerencias permanece en el Panel de Control del Moderador.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Catálogo de etiquetas',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Etiqueta',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'El catálogo compartido no contiene etiquetas aprobadas.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Disponibilidad en la Galería',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Disponible en la Galería',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Desactivar una etiqueta la oculta de los campos y búsquedas de la Galería sin eliminarla de BBTags ni del foro.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Disponibilidad predeterminada',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'La regla explícita del álbum más cercano prevalece sobre este valor y las reglas heredadas.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Disponible salvo que se deniegue',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'No disponible salvo que se permita',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Reglas por álbum',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Heredar utiliza la regla del álbum padre más cercano y después la disponibilidad predeterminada.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Álbum',
	'ACP_BBTAGSBRIDGE_RULE' => 'Regla',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Heredar',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Permitir',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Denegar',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'No hay álbumes de la Galería que configurar.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'No se pudo guardar la política de etiquetas de la Galería.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'La política de etiquetas de la Galería se guardó correctamente.',
]);
