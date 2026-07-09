<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 * Estonian translation by phpBBestonia.eu <https://www.phpbbestonia.eu>
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

	'COMPOSE'				=> 'Koostage massteatis',
	'ALL_USERS'				=> 'Kõik kasutajad',
	'SEND_TO_GROUP'			=> 'Saada grupile',
	'SEND_TO_USERS'			=> 'Saada kasutajatele',
	'SEND_TO_USERS_EXPLAIN'	=> 'Nimede sisestamine tühistab kõik ülaltoodud valikud. Sisestage iga kasutajanimi uuele reale.',
	'TITLE'					=> 'Teatise pealkiri',
	'MESSAGE_EXPLAIN'		=> 'Hoidke see lühike, eelistatavalt alla 150 tähemärgi. Võite kasutada HTML.',
	'URL'					=> 'Ümbersuunamise URL',
	'URL_EXPLAIN'			=> 'Sisestage URL, millele kasutaja pärast teate klõpsamist suunatakse.',
	'AUTHOR_EXPLAIN'		=> 'Enter author of the notification. Leave blank for generic notification without author.',
	'SEND_NOTIFICATION'		=> 'Saada teatis',

	'NO_NOTIFICATION_TITLE'		=> 'Peate määrama teate pealkirja.',
	'NO_NOTIFICATION_MESSAGE'	=> 'Peate määrama teate sõnumi.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Author does not exist.',

	'NOTIFICATION_SEND'	=> 'Teie teade on saadetud.',
));
