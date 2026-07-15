<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
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
	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Verwalte Schlüsselwörter',

	'KEYWORD'					=> 'Schlüsselwort',
	'SEARCH_TYPE'				=> 'Suchtype',
	'ACTIONS'					=> 'Aktion',
	'KEYWORDS'			        => 'Schlüsselwörter',
	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'			=> 'Du kannst hier Schlüsselwörter für automatische Suchen definieren. <strong>Sollte dein gewünschtes Wort im Betreff eines Themas oder im Inhalt eines Beitrags gefunden werden, so wirst du per E-Mail und per Benachrichtung darüber informiert.</strong><br /><br />Dies ermöglich dir bestimmte Schlüsselwörter als Suchwörter zu hinterlegen um automatisiert über interessante Beiträge und Themen informiert bzw. benachrichtigt zu werden. So kannst du garantiert nichts übersehen oder verpassen!',
	'NO_UCP_KEYWORDS'			=> 'Du hast noch keine Schlüsselwörter definiert. Füge welche dazu, um schnellstmöglich über interessante Themen informiert zu werden.',
	'ADD_NEW_KEYWORD'			=> 'Schlüsselwort hinzufügen',
	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Wort suchen im Betreff eines Themas',
	'SEARCH_TYPE_POST_CONTENT'	=> 'Wort suchen im Inhalt eines Beitrags',

	'KEYWORD_TOO_LONG'	=> 'Schlüsselwort ist zu lang. Maximumal 255 Zeichen sind erlaubt.',
	'KEYWORD_EXISTS'	=> 'Du hast bereits dieses Schlüsselwort definiert.',
	'KEYWORD_ADDED'		=> 'Schlüsselwort wurde hinzugefügt. Du wirst nun über das Aufkommen informiert.',
	'KEYWORD_DELETED'	=> 'Schlüsselwort wurde entfernt. Du wirst nun nicht mehr über das Aufkomomen informiert.',

	// notifications
	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'BBwatchlist',
	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Jemand hat ein von dir gesuchtes Wort im Thema verwendet',
	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Jemand hat ein von dir gesuchtes Wort im Beitrag verwendet',
));
