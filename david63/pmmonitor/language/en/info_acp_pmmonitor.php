<?php
/**
*
* @package PM Monitor Extension
* @copyright (c) 2015 david63
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
	'ACP_USER_UTILS' => 'User utilities',
	'ACP_PM_MONITOR' => 'PM monitor',
	'LOG_PM_MONITOR_VIEW' => '<strong>Viewed private messages</strong><br>Page offset: %1$d',
	'LOG_PM_MONITOR_MESSAGE_VIEW' => '<strong>Opened a private message</strong><br>Message ID: %1$d; recipient user ID: %2$d',
	'LOG_PM_MONITOR_DELETE' => '<strong>Deleted private-message copies</strong><br>Copies: %1$d',
]);
