<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'NOTIFICATION_PHPBBGALLERY_IMAGE_FOR_APPROVAL'      => '%2$s enviou imagens para aprovação no álbum <strong>%1$s</strong>',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_FOR_APPROVE'  => 'Imagens aguardando aprovação',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_APPROVED'     => 'Imagens aprovadas',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_APPROVED'          => 'Imagens no álbum <strong>%1$s</strong> foram aprovadas',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_NOT_APPROVED' => 'Imagens não aprovadas',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_NOT_APPROVED'      => 'Imagens no álbum <strong>%1$s</strong> não foram aprovadas',
	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_IMAGE'          => 'Novas imagens',
	'NOTIFICATION_PHPBBGALLERY_NEW_IMAGE'               => 'Novas imagens foram enviadas no álbum <strong>%1$s</strong>',
	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_COMMENT'        => 'Novos comentários',
	'NOTIFICATION_PHPBBGALLERY_NEW_COMMENT'             => '<strong>%1$s</strong> comentou a imagem que você acompanha',
	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_REPORT'         => 'Nova denúncia de imagem',
	'NOTIFICATION_PHPBBGALLERY_NEW_REPORT'              => '<strong>%1$s</strong> reportou imagem',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_MODERATED'       => 'Ações de moderação da Galeria',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_LOCKED'     => '<strong>%1$s</strong> bloqueou imagens no álbum <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_UNLOCKED'   => '<strong>%1$s</strong> desbloqueou imagens no álbum <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_UNAPPROVED' => '<strong>%1$s</strong> devolveu imagens do álbum <strong>%2$s</strong> à fila de aprovação',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_DELETED'    => '<strong>%1$s</strong> removeu imagens do álbum <strong>%2$s</strong>',
]);
