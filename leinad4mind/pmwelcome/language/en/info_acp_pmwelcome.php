<?php

/**
*
* @package PM Welcome [English]
* @copyright (c) 2019 Leinad4Mind
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

if (empty($lang) || !is_[$lang])
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_PMWELCOME'					=> 'Welcome message',
	'ACP_PMWELCOME_EXPLAIN'			=> 'You can specify the text of the personal message that will be sent to the user upon registration.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Settings welcome message.',
	'ACP_PMWELCOME_USER'			=> 'Sender',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'id User Forum, on behalf of which will be sent to a private message.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Post subject',
	'ACP_PMWELCOME_TEXT'			=> 'Text of the greeting message',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'You can use bbcode and smilies, and this tokens "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} and {BOARD_SIG}".'
]);
