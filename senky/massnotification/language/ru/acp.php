<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'MASSNOTIFICATION_DESC'	=> 'Здесь вы можете послать уведомление всем или определенной группе.',

	'COMPOSE'				=> 'Составить массовое уведомление',
	'ALL_USERS'				=> 'Все пользователи',
	'SEND_TO_GROUP'			=> 'Отослать группе',
	'SEND_TO_USERS'			=> 'Отослать пользователям',
	'SEND_TO_USERS_EXPLAIN'	=> 'Ввод имени здесь переопределит любую группу, выбранную выше. Введите каждое имя пользователя в новой строке.',
	'TITLE'					=> 'Название уведомления',
	'MESSAGE_EXPLAIN'		=> 'Постарайтесь описать короче, предпочтительно ниже 150 символов. Вы можете использовать HTML.',
	'URL'					=> 'Перенаправление URL ',
	'URL_EXPLAIN'			=> 'Введите URL на который пользователь будет перенаправлен после нажатия на уведомление.',
	'AUTHOR_EXPLAIN'		=> 'Enter author of the notification. Leave blank for generic notification without author.',
	'SEND_NOTIFICATION'		=> 'Отправить уведомление',

	'NO_NOTIFICATION_TITLE'		=> 'Вы должны указать название уведомления.',
	'NO_NOTIFICATION_MESSAGE'	=> 'Вы должны написать уведомление.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Author does not exist.',

	'NOTIFICATION_SEND'	=> 'Ваше уведомление было отправлено.',
));
