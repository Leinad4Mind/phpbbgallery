<?php
/**
 *
 * @package Friends & Foes Extension
 * @copyright (c) 2014 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	$lang = [];
}

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'ALL' => 'All',

	'FF_CLEAR_FILTER'          => 'Clear filters',
	'FILTER_BY'                => 'Filter Username by',
	'FOE'                      => 'Made a foe of',
	'FRIEND'                   => 'Made friends with',
	'FRIENDS_AND_FOES_EXPLAIN' => 'This gives you a list of the friends & foes of each member (where set).',

	'NO_FF_DATA' => 'There are no friends and foes to display',

	'OTHER' => 'Other',

	'SELECT_CHAR'   => 'Select character',
	'SORT_FOE'      => 'Foes',
	'SORT_FRIEND'   => 'Friends',
	'SORT_USERNAME' => 'Username',

	'TOTAL_USERS' => 'Freinds & Foes count : <strong>%1$s</strong>',

	'YES' => 'Yes',

	// Translators - set these to whatever is most appropriate in your language
	// These are used to populate the filter keys
	'START_CHARACTER' => 'A',
	'END_CHARACTER'   => 'Z',
]);
