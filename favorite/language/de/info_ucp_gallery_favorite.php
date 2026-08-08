<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
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
* Language for the Gallery favorites and UCP module
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Favoriten verwalten',
	'YOUR_FAVORITE_IMAGES'		=> 'Hier siehst du die Bilder, die du als Favorit gespeichert hast. Du kannst die entfernen, die du nicht mehr behalten möchtest.',

	'FAVORITE_IMAGE'			=> 'Zu Favoriten hinzufügen',
	'UNFAVORITE_IMAGE'			=> 'Aus Favoriten entfernen',
	'FAVORITED_IMAGE'			=> 'Das Bild wurde zu deinen Favoriten hinzugefügt.',
	'UNFAVORITED_IMAGE'			=> 'Das Bild wurde aus deinen Favoriten entfernt.',
	'UNFAVORITED_IMAGES'		=> 'Die Bilder wurden aus deinen Favoriten entfernt.',

	'REMOVE_FROM_FAVORITES'		=> 'Aus Favoriten entfernen',
	'NO_FAVORITES'				=> 'Du hast keine Favoriten.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Aktion auswählen',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Keine Favoriten',
		1	=> '%d Favorit',
		2	=> '%d Favoriten',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Du darfst dieses Bild nicht als Favorit speichern.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Du musst registriert und angemeldet sein, um Bilder zu deinen Favoriten hinzuzufügen.',

	'WATCH_FAVO'				=> 'Bilder abonnieren, die ich als Favorit speichere',
	'WATCH_FAVO_EXPLAIN'		=> 'Wenn aktiviert, wirst du beim Hinzufügen eines Bildes zu den Favoriten auch über neue Kommentare dazu benachrichtigt.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'Die Erweiterung wurde erfolgreich aktiviert.',
]);
