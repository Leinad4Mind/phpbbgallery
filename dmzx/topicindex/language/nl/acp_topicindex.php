<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
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
// ’ » “ ” …
//

// Merge the following language entries into the lang array
$lang = array_merge($lang, array(
	'OFFICIAL_TOPIC_INDEX'			=> 'Beheer Officiële Topic Index Extensie',
	'ADD_NEW_TOPICS_LIST'			=> 'Voeg nieuwe lijst toe',
	'LIST_NAME'						=> 'Lijst naam',
	'OINDEX_CFG_SETUP'				=> 'Configureer Officiële Topic Index',
	'OVERFLOW_IN_TOPIC'				=> 'Sta scroll bar toe in de binnenste topic lijst',
	'NAME_FORUM_LIST_EMPTY'			=> 'De lijst naam kan niet leeg zijn.',
	'SELECT_FORUM_LIST_EMPTY'		=> 'Er moet op zijn minst een forum geselecteerd zijn.',
	'OINDEX_ADDED_LIST'				=> 'Lijst succesvol opgeslagen.',
	'OINDEX_DELETED_LIST'			=> 'Lijst succesvol verwijderd.',
	'OINDEX_EDIT_CFG'				=> 'Configuratie van Officiële Topic Index succesvol bewerkt.',
	'OINDEX_FORUMS'					=> 'Forums',
	'OINDEX_SELECT_FORUM'			=> 'Selecteer een forum',
	'OTINDEX_LIST_ALONE_DSC'		=> 'Maak een externe lijst van alle topics in een bepaald forum of meerdere forums samen. De externe lijst hoeft niet geactiveerd te zijn in het forum. Maar zal in dat geval alle topics opnemen.',
	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Maak een georganiseerde topic lijst die zal verschijnen in een gekozen onderwerp. Zodra je deze functie activeert zullen bij elke eerste post van een topic nieuwe iconen verschijnen om de topic toe te voegen of te verwijderen van de lijst.',
	'ACTIVE_TOPIC_INDEX'			=> 'Activeer en selecteer de topic voor de lijst',
	'TOPIC_INDEX_DEFAULT'			=> 'Kies welke topics er standaard worden toegevoegd.',
	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Kies de topic van een sticky of een mededeling. Topics zullen een lijst worden. Je moet dus op zijn minst 1 topic in het forum hebben.',
	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Kies het systeem waarmee de onderwerpen opgenomen worden in de lijst',
	'ACTIVE_INDEX_FILTER'			=> 'Actieve tag filter',
	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Je moet dit activeren als je topics hebt met gemeenschappelijke TAGS hebt in de titel. We ondersteunen tags met dit formaat, enkel of dubbel: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
));
