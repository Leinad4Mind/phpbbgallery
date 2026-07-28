<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

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
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'LOG_BBPREFIX_INCOMPLETE'		=> 'BBPrefix: refused to cache "%1$s" - only %2$d of %3$d rows were read from the database.',
	'LOG_BBPREFIX_CACHE_ERROR'		=> 'BBPrefix: error reading the "%1$s" cache: %2$s',
	'LOG_BBPREFIX_LOAD_ERROR'		=> 'BBPrefix: error loading "%1$s" from the database: %2$s',
	'LOG_BBPREFIX_COUNT_ERROR'		=> 'BBPrefix: error counting rows in "%1$s": %2$s',
]);
