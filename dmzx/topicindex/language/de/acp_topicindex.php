<?php
/**
*
* @version $Id: acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
* @package phpBB Extension - Topic Index [Deutsch]
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ‚ ‘ ’ « » „ “ ” …
//

// Merge the following language entries into the lang array
$lang = array_merge($lang, array(
	'OFFICIAL_TOPIC_INDEX'			=> 'Verwalte Official Topic Index Extension',
	'ADD_NEW_TOPICS_LIST'			=> 'Neue Liste hinzufügen',
	'LIST_NAME'						=> 'Listenname',
	'OINDEX_CFG_SETUP'				=> 'Konfiguriere Official Topic Index',
	'OVERFLOW_IN_TOPIC'				=> 'Erlaube Laufleiste auf der internen Themenliste',
	'NAME_FORUM_LIST_EMPTY'			=> 'Der Listenname darf nicht leer sein.',
	'SELECT_FORUM_LIST_EMPTY'		=> 'Mindestens ein Forum muss ausgewählt werden.',
	'OINDEX_ADDED_LIST'				=> 'Liste erfolgreich gespeichert.',
	'OINDEX_DELETED_LIST'			=> 'Liste erfolgreich gelöscht.',
	'OINDEX_EDIT_CFG'				=> 'Konfiguration von Official Topic Index erfolgreich geändert.',
	'OINDEX_FORUMS'					=> 'Foren',
	'OINDEX_SELECT_FORUM'			=> 'Wähle ein Forum',
	'OTINDEX_LIST_ALONE_DSC'		=> 'Erstelle eine externe Liste von allen Themen eines einzelnen Forums, oder aus einer Auswahl mehrerer Foren zusammen. Im Gegensatz zu einer Liste in einem Thema, muss die externe nicht direkt in dem Forum aktiviert werden. Aber in dem Fall werden alle Themen aufgelistet, ohne eine Auswahlmöglichkeit.',
	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Erstelle eine organisierte Themenliste, welche innerhalb eines ausgewählten Themas erscheinen wird. Sobald du diese Funktion aktiviert hast, erscheinen in jedem ersten Beitrag jedes Themas neue Icons zum Einfügen oder Entfernen des Themas aus der Liste.',
	'ACTIVE_TOPIC_INDEX'			=> 'Aktiviere, und wähle das Thema für die Liste',
	'TOPIC_INDEX_DEFAULT'			=> 'Wähle aus, welche Themen standardmäßig hinzuzufügen sind.',
	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Wähle ein Thema aus den <strong>Wichtigen Themen oder Ankündigungsthemen</strong>, dieses Thema wird die Themenliste werden. Du musst deshalb mindestens ein Thema in diesem Forum haben.',
	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Wähle das System, nach welchem die Themen in der Liste eingebunden werden sollen',
	'ACTIVE_INDEX_FILTER'			=> 'Aktiviere Tag-Filter',
	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Du musst dies aktivieren, wenn du Themen mit gemeinsamem TAG im Titel hasts. Wir unterstützen Tags mit diesem Format, einzeln oder doppelt: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
));
