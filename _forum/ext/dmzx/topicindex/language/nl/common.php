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

$lang = array_merge($lang, array(
	'ADD_INILIST'					=> '+Lijst',
	'REMOVE_INILIST'				=> '-Lijst',
	'OTINDEX_LINK_TITLE'			=> 'Topics lijst',
	'NUM'							=> 'N°',
	'POSTER'						=> 'Gepost door',
	'INDEX_POST_PRES'				=> 'Kijk eerst eens in deze lijst dat de topic niet reeds bestaat alvorens een nieuwe topic te openen.<br />Bedankt.',
	'NON_ACTIVE'					=> 'Inactief',
	'DEF_ALL_TOPICS_IN'				=> 'Alle nieuwe topics automatisch',
	'DEF_ALL_TOPICS_OFF'			=> 'Voeg manueel topics toe in de lijst.',
	'REMOVE_FROM_LIST'				=> 'verwijder',
	'TOPICINDEX_VERSION'			=> 'Versie',
	'ALL'							=> 'Alle',
	'09'							=> '0-9',
	'SYMB'							=> '#&%',
	'ANY_TOPIC_IN_LIST'				=> 'Alle topics',
	'SELECT_A_LIST'					=> 'Selecteer een lijst',
	'OIINDEX_HEADER'				=> 'Officiële Topic Index - Topics Lijst',
));
