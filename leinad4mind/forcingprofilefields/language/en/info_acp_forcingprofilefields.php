<?php

/**
 *
 * Forcing Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH'			=> 'Skip meta-refresh when redirecting user to update his profile',
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH_EXPLAIN'	=> 'If set to yes, the user is sent to the UCP profile edit page without a redirect page.',
	'FORCINGPROFILEFIELDS_ENABLE_NOTICE'			=> '<div style="margin:20px"><p>The setting for this extension is in <strong>%1$s</strong> » <strong>%2$s</strong> » <strong>%3$s</strong>.</p></div>',
]);
