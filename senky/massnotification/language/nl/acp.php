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

	'COMPOSE'				=> 'Maak massa notificatie',
	'ALL_USERS'				=> 'Alle gebruikers',
	'SEND_TO_GROUP'			=> 'Verzend naar groep',
	'SEND_TO_USERS'			=> 'Verzend naar gebruikers',
	'SEND_TO_USERS_EXPLAIN'	=> 'Het invoeren van namen hier overschrijft elke groep die hierboven is geselecteerd. Voer elke gebruikersnaam op een nieuwe regel in.',
	'TITLE'					=> 'Notificatie titel',
	'MESSAGE_EXPLAIN'		=> 'Houd het kort, bij voorkeur onder 150 karakters. Je kan HTML gebruiken.',
	'URL'					=> 'Omleidings-URL',
	'URL_EXPLAIN'			=> 'Voer de URL in waarnaar de gebruiker wordt omgeleid nadat hij op de melding heeft geklikt.',
	'SEND_NOTIFICATION'		=> 'Verzend notificatie',

	'NO_NOTIFICATION_TITLE'		=> 'U moet de titel van de notificatie opgeven.',
	'NO_NOTIFICATION_MESSAGE'	=> 'U moet een notificatie bericht opgeven.',

	'NOTIFICATION_SEND'	=> 'Uw notificatie is verzonden.',
));
