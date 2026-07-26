<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [German [de]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery feed
*/
$lang = array_merge($lang, [
	'FEED'						=> 'Feed',
	'FEED_SETTINGS'				=> 'Feed-Einstellungen',

	'FEED_ENABLED'				=> 'Galerie-Feed aktivieren',
	'FEED_ENABLED_EXPLAIN'		=> 'Wenn aktiviert, veröffentlicht die Galerie einen ATOM-Feed der neuesten Bilder.',
	'FEED_ENABLED_PEGAS'		=> 'Persönliche Galerien einbeziehen',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Wenn aktiviert, können auch Bilder aus persönlichen Galerien im Feed erscheinen. Album- und Anzeigerechte werden immer berücksichtigt.',
	'FEED_LIMIT'				=> 'Anzahl der Einträge',
	'FEED_LIMIT_EXPLAIN'		=> 'Maximale Anzahl der in einem Feed veröffentlichten Bilder.',

	'ALBUM_FEED'				=> 'Dieses Album im Feed veröffentlichen',
	'ALBUM_FEED_EXPLAIN'		=> 'Wenn deaktiviert, erscheinen Bilder dieses Albums nie im Galerie-Feed.',

	'NO_FEED'					=> 'Für dieses Album ist kein Feed verfügbar.',
	'NO_FEED_ENABLED'			=> 'Der Galerie-Feed ist in diesem Forum nicht aktiviert.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'Die Erweiterung wurde erfolgreich aktiviert.',
]);
