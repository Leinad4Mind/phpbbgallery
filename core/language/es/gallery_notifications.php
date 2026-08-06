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
	'NOTIFICATION_PHPBBGALLERY_IMAGE_FOR_APPROVAL'     => '%2$s subió imágenes para su aprobación en el álbum <strong>%1$s</strong>',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_FOR_APPROVE' => 'Imágenes en espera de aprobación',

	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_APPROVED' => 'Imágenes aprobadas',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_APPROVED'      => 'Las imágenes del álbum <strong>%1$s</strong> fueron aprobadas',

	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_NOT_APPROVED' => 'Imágenes no aprobadas',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_NOT_APPROVED'      => 'Las imágenes del álbum <strong>%1$s</strong> no fueron aprobadas',

	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_IMAGE' => 'Nuevas imágenes',
	'NOTIFICATION_PHPBBGALLERY_NEW_IMAGE'      => 'Se subieron nuevas imágenes al álbum <strong>%1$s</strong>',

	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_COMMENT' => 'Nuevos comentarios',
	'NOTIFICATION_PHPBBGALLERY_NEW_COMMENT'      => '<strong>%1$s</strong> comentó la imagen que está viendo',

	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_REPORT' => 'Nuevo informe de imagen',
	'NOTIFICATION_PHPBBGALLERY_NEW_REPORT'      => '<strong>%1$s</strong> imagen reportada',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_MODERATED'       => 'Acciones de moderación de la Galería',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_LOCKED'     => '<strong>%1$s</strong> bloqueó imágenes en el álbum <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_UNLOCKED'   => '<strong>%1$s</strong> desbloqueó imágenes en el álbum <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_UNAPPROVED' => '<strong>%1$s</strong> devolvió imágenes del álbum <strong>%2$s</strong> a la cola de aprobación',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_DELETED'    => '<strong>%1$s</strong> eliminó imágenes del álbum <strong>%2$s</strong>',
]);
