<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'Las extensiones necesarias no están activadas: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints en imágenes',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configura las recompensas por publicar en la Galería y el coste de acceso a los archivos originales.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Configuración global',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Recompensa por imagen aprobada',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Puntos concedidos una sola vez al autor final cuando se aprueba la imagen. Usa 0 para desactivar las recompensas.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Coste del archivo original',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Puntos necesarios para comprar el acceso al archivo original. Usa 0 para permitir acceso gratuito.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Excepciones por álbum',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Cada valor reemplaza de forma independiente al ancestro más cercano. Usa -1 para heredar.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Usa -1 para heredar el valor del ancestro configurado más cercano o de la configuración global.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'No hay álbumes disponibles en la Galería.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Se guardó la configuración de BBPoints en imágenes.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Recompensas de imágenes existentes',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analiza las imágenes existentes aprobadas y concede la recompensa configurada. Se omiten las recompensas existentes y los archivos exactamente duplicados.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Sincronizar recompensas existentes',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => '¿Seguro que quieres recompensar todas las imágenes existentes elegibles con las reglas actuales de los álbumes?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'La sincronización continúa. Hasta ahora se analizaron %1$d imágenes y se concedieron %2$d recompensas.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'La sincronización terminó. Se analizaron %1$d imágenes y se concedieron %2$d recompensas.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Debes iniciar sesión para comprar este archivo de imagen original.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Descargar este archivo de imagen original cuesta %1$d puntos. ¿Quieres continuar?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Tienes %1$d puntos, pero este archivo de imagen original requiere %2$d puntos.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'No se puede comprar el archivo de imagen original en este momento.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Descargas del original',
]);
