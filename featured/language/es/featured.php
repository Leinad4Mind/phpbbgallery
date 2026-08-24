<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Imágenes destacadas',
	'FEATURED_SETTINGS' => 'Imágenes destacadas y presentación',
	'FEATURE_IMAGE' => 'Destacar imagen',
	'UNFEATURE_IMAGE' => 'Quitar de las imágenes destacadas',
	'FEATURED_IMAGE_ADDED' => 'La imagen se ha añadido a la selección destacada.',
	'FEATURED_IMAGE_REMOVED' => 'La imagen se ha quitado de la selección destacada.',
	'FEATURED_NOT_AUTHORISED' => 'No estás autorizado para gestionar imágenes destacadas en este álbum.',
	'FEATURED_APPROVED_ONLY' => 'Solo se pueden destacar imágenes aprobadas.',
	'FEATURED_ENABLE' => 'Mostrar imágenes destacadas',
	'FEATURED_ENABLE_EXPLAIN' => 'Muestra en el índice de la Galería la selección realizada por los moderadores.',
	'FEATURED_COUNT' => 'Número de imágenes destacadas',
	'FEATURED_COUNT_EXPLAIN' => 'Número de imágenes destacadas visibles que se mostrarán, de 1 a 20. Los permisos se filtran por separado para cada visitante.',
	'FEATURED_SLIDESHOW' => 'Usar presentación de diapositivas',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Muestra una imagen destacada grande cada vez con navegación accesible. Si se desactiva, se usa el diseño de tarjetas configurado en la Galería.',
	'FEATURED_AUTOPLAY' => 'Iniciar la presentación automáticamente',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'La reproducción automática se desactiva para quienes solicitan movimiento reducido y siempre puede pausarse.',
	'FEATURED_INTERVAL' => 'Intervalo de la presentación',
	'FEATURED_INTERVAL_EXPLAIN' => 'Tiempo entre cambios automáticos, de 3 a 30 segundos.',
	'FEATURED_INCLUDE_PERSONAL' => 'Incluir imágenes de álbumes personales',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Permite mostrar imágenes seleccionadas de álbumes personales cuando el visitante tiene permiso para verlas.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Controles de imágenes destacadas',
	'FEATURED_PREVIOUS' => 'Imagen destacada anterior',
	'FEATURED_NEXT' => 'Imagen destacada siguiente',
	'FEATURED_PLAY' => 'Reproducir presentación',
	'FEATURED_PAUSE' => 'Pausar presentación',
	'FEATURED_GO_TO' => 'Mostrar imagen destacada %d',
	'GALLERY_CORE_NOT_FOUND' => 'Gallery Core 4.2.0 o posterior debe estar instalado y activado antes de activar Imágenes destacadas.',
]);
