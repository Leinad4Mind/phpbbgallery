<?php
/**
 * phpBB Gallery - ACP Core Extension [Bulgarian Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator Lucifer <https://www.anavaro.com>
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
	'NOTIFICATION_PHPBBGALLERY_IMAGE_FOR_APPROVAL'     => '%2$s качи изображения за одобрение в албум <strong>%1$s</strong>',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_FOR_APPROVE' => 'Изображения чакащи одобрение',

	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_APPROVED' => 'Одобрени изображения',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_APPROVED'      => 'Изображенията в албум <strong>%1$s</strong> бяха одобрени',

	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_NOT_APPROVED' => 'Отхвърлени изображения',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_NOT_APPROVED'      => 'Изображенията в албум <strong>%1$s</strong> бяха отхвърлени',

	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_IMAGE' => 'Нови изображения',
	'NOTIFICATION_PHPBBGALLERY_NEW_IMAGE'      => 'В албум <strong>%1$s</strong> бяха качени нови изобаржения',

	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_COMMENT' => 'Нови коментари',
	'NOTIFICATION_PHPBBGALLERY_NEW_COMMENT'      => '<strong>%1$s</strong> коментира изображение което следите',

	'NOTIFICATION_TYPE_PHPBBGALLERY_NEW_REPORT' => 'Нов доклад на изображение',
	'NOTIFICATION_PHPBBGALLERY_NEW_REPORT'      => '<strong>%1$s</strong> докладва изображение',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_MODERATED'       => 'Действия за модериране на галерията',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_APPROVED'   => '<strong>%1$s</strong> одобри изображения в албум <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_REJECTED'   => '<strong>%1$s</strong> отхвърли изображения в албум <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_LOCKED'     => '<strong>%1$s</strong> заключи изображения в албум <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_UNLOCKED'   => '<strong>%1$s</strong> отключи изображения в албум <strong>%2$s</strong>',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_UNAPPROVED' => '<strong>%1$s</strong> върна изображения от албум <strong>%2$s</strong> за одобрение',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_MODERATED_DELETED'    => '<strong>%1$s</strong> премахна изображения от албум <strong>%2$s</strong>',
	'NOTIFICATION_TYPE_PHPBBGALLERY_IMAGE_REMOVED'         => 'Изображения, премахнати от модераторите',
	'NOTIFICATION_PHPBBGALLERY_IMAGE_REMOVED'              => 'Изображения в албум <strong>%1$s</strong> бяха премахнати от екипа за модериране',
]);
