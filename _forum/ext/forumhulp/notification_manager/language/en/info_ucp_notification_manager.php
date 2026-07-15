<?php
/**
*
* Notification_manager for the phpBB Forum Software package.
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
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

$lang = array_merge(
	$lang, array(
		'UCP_NOTIES'			=> 'Manage notifications',
		'UCP_NOTIES_EXPLAIN'	=> 'Manage your notifications',
		'MARK_DELETE_SINGLE'	=> 'Mark to delete',
		'MARK_READ_SINGLE'		=> 'Mark to read',
		'MARK_UNREAD_SINGLE'	=> 'Mark to unread',
		'MARK_DELETE'			=> 'Select all to delete',
		'MARK_READ'				=> 'Select all to read',
		'MARK_UNREAD'			=> 'Select all to unread',
		'UNMARK_DELETE'			=> 'Unselect all to delete',
		'UNMARK_READ'			=> 'Unselect all to read',
		'UNMARK_UNREAD'			=> 'Unselect all to unread',
		'MARK_DELETE_SELECTED'		=> 'Delete all marked',
		'MARK_READ_SELECTED'		=> 'Mark all as read',
		'MARK_UNREAD_SELECTED'		=> 'Mark all as unread',
		'UNMARK_DELETE_SELECTED'	=> 'Unmark all to delete',
		'UNMARK_READ_SELECTED'		=> 'Unmark all as read',
		'UNMARK_UNREAD_SELECTED'	=> 'Unmark all as unread',
		'UCP_NOTIES_SUBMIT'			=> 'Submit Selected',
	)
);
