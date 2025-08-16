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
	'MASSNOTIFICATION_DESC'	=> 'Here you can send a board notification to either all of your users or specific users or groups.',

	'COMPOSE'				=> 'Toplu bildirim oluştur',
	'ALL_USERS'				=> 'Tüm kullanıcılar',
	'SEND_TO_GROUP'			=> 'Gruba gönder',
	'SEND_TO_USERS'			=> 'Kullanıcılara gönder',
	'SEND_TO_USERS_EXPLAIN'	=> 'Buraya isim girerseniz yukarıda seçili grup yoksayılacaktır. Her yeni satıra bir isim girin.',
	'TITLE'					=> 'Bildirim başlığı',
	'MESSAGE_EXPLAIN'		=> 'Tercihen 150 karakteri geçmeyecek şekilde kısa tutun. HTML kullanabilirsiniz.',
	'URL'					=> 'URL yönlendir',
	'URL_EXPLAIN'			=> 'Kullanıcılar bildirime tıkladığında yönlendirilecekleri URLyi girin.',
	'AUTHOR_EXPLAIN'		=> 'Enter author of the notification. Leave blank for generic notification without author.',
	'SEND_NOTIFICATION'		=> 'Bildirim gönder',

	'NO_NOTIFICATION_TITLE'		=> 'Bildirim başlığı belirlemek zorundasınız.',
	'NO_NOTIFICATION_MESSAGE'	=> 'Bildirim mesajı belirlemek zorundasınız.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Author does not exist.',

	'NOTIFICATION_SEND'	=> 'Bildiriminiz gönderildi.',
));
