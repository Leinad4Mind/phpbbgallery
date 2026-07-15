<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
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
	'STICKYELEMENTS_ADD'				=> 'Add sticky element',
	'STICKYELEMENTS_EDIT'				=> 'Edit sticky element',

	'STICKYELEMENTS_CREATED'			=> 'Your sticky element was added.',
	'STICKYELEMENTS_MODIFIED'			=> 'Your sticky element was updated.',
	'STICKYELEMENTS_DELETED'			=> 'The selected sticky element was removed.',

	'STICKYELEMENTS_ONLY_INDEX'			=> 'Display on Index only',
	'STICKYELEMENTS_ONLY_INDEX_EXPLAIN'	=> 'If no, the sticky element is display on every page.',
	'STICKYELEMENTS_TEXT'				=> 'Text',
	'STICKYELEMENTS_TEXT_EXPLAIN'		=> 'BBCodes are allowed.',
	'STICKYELEMENTS_COLOR'				=> 'Background colour',
]);
