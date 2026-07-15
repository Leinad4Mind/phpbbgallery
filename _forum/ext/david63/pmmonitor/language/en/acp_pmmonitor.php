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
	'AUTHOR_IP'					=> 'Author IP',
	'CONFIRM_DELETE'			=> 'Confirm delete',
	'DELETE_PMS'				=> 'Delete PMs',
	'IS_GROUP'					=> 'G',
	'MSG_COUNT'					=> 'Message count',
	'NO_PM_DATA'				=> 'There is no PM data to display.',
	'NO_PM_SELECTED'			=> 'No PMs selected',

	'PM_BOX'					=> 'PM box',
	'PM_DELETED'			   	=> 'Deleted',
	'PM_FORWARDED'				=> 'Forward',
	'PM_HOLDBOX'				=> 'Held',
	'PM_INBOX'					=> 'Inbox',
	'PM_MARKED'					=> 'Marked',
	'PM_MONITOR_READ'			=> 'Private message list',
	'PM_MONITOR_READ_EXPLAIN'	=> 'Here is a list of all private messages from your board.',
	'PM_NEW'					=> 'New',
	'PM_NOBOX'					=> 'No box',
	'PM_OUTBOX'					=> 'Outbox',
	'PM_REPLIED'				=> 'Replied',
	'PM_SAVED'					=> 'Saved',
	'PM_SENTBOX'				=> 'Sent',
	'PM_UNREAD'					=> 'Unread',

	'SORT_BCC'					=> 'BCC',
	'SORT_FROM'					=> 'From',
	'SORT_PM_BOX'				=> 'PM box',
	'SORT_TO'					=> 'To',

	'VERSION'					=> 'Version',
));
