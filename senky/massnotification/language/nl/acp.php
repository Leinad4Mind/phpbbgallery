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
	'MASSNOTIFICATION_DESC'	=> 'Hier kunt u een forum notificatie sturen naar al uw gebruikers of specifieke gebruikers of groepen.',

	'COMPOSE'				=> 'Maak massa notificatie',
	'ALL_USERS'				=> 'Alle gebruikers',
	'SEND_TO_GROUP'			=> 'Verzend naar groep',
	'SEND_TO_USERS'			=> 'Verzend naar gebruikers',
	'SEND_TO_USERS_EXPLAIN'	=> 'Het invoeren van namen hier overschrijft elke groep die hierboven is geselecteerd. Voer elke gebruikersnaam op een nieuwe regel in.',
	'TITLE'					=> 'Notificatie titel',
	'MESSAGE_EXPLAIN'		=> 'Houd het kort, bij voorkeur onder 150 karakters. Je kan HTML gebruiken.',
	'URL'					=> 'Omleiding URL',
	'URL_EXPLAIN'			=> 'Voer de URL in waarnaar de gebruiker wordt omgeleid nadat hij op de melding heeft geklikt.',
	'AUTHOR_EXPLAIN'		=> 'Voer de auteur van de melding in. Leeg laten voor generieke melding zonder auteur.',
	'SEND_NOTIFICATION'		=> 'Verzend notificatie',

	'NO_NOTIFICATION_TITLE'		=> 'U moet de titel van de notificatie opgeven.',
	'NO_NOTIFICATION_MESSAGE'	=> 'U moet een notificatie bericht opgeven.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Auteur bestaat niet.',

	'NOTIFICATION_SEND'	=> 'Uw notificatie is verzonden.',
));
