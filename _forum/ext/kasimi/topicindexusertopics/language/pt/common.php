<?php

/**
 *
 * Topic Index - User Topics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	// On viewprofile
	'TOPIC_INDEX_USER_TOPICS'			=> 'Partilhas',
	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver partilhas do utilizador',
	'TOPIC_INDEX_TOPICS_SELF'			=> 'Minhas Partilhas',

	// On topic index page
	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'partilhadas por %1$s',
	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Clique para listar todos',
]);
