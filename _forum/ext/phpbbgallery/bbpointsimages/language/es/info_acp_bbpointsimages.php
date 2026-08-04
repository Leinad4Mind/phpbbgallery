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
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Este resumen de solo lectura sigue la jerarquía de la Galería. Edita un álbum para cambiar sus valores directos; los valores en negrita son los que están vigentes.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Usa -1 para que cada valor numérico herede independientemente del ancestro configurado más cercano o de la configuración global.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Heredar',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Usa -1 para heredar el valor del ancestro configurado más cercano o de la configuración global.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Valor efectivo: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Configuración efectiva: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Heredado',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Valor directo: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Configuración directa',
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
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Permitir asignar colaboradores',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Permite a los autores y editores de imágenes indicar colaboradores. Los colaboradores existentes conservan su atribución y su parte de las descargas pagadas al desactivar esta opción.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Colaboradores en todos los álbumes',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Establece una opción explícita en todos los álbumes públicos o restablece todos para que hereden la configuración global. Se conservan las excepciones de recompensa y coste.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Hacer que todos hereden',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'Activar en todos los álbumes',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'Desactivar en todos los álbumes',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Aplicar a todos los álbumes',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => '¿Seguro que quieres cambiar la asignación de colaboradores en todos los álbumes públicos de la Galería?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'La asignación de colaboradores se actualizó en todos los álbumes públicos de la Galería.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Colaboradores',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Introduce un nombre de usuario registrado por línea, hasta %1$d. El autor de la imagen se excluye automáticamente.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'No se encontraron estos colaboradores o están inactivos: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Una imagen no puede tener más de %1$d colaboradores.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Recompensas de imágenes de la Galería',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'Has recibido %1$d puntos por publicar la imagen <strong>%2$s</strong>.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Ventas de originales de la Galería',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s compró el archivo original de <strong>%3$s</strong>; has recibido %2$d puntos.',
]);
