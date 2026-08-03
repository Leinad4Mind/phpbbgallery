<?php
/**
 *
 * @package User Defaults Extension
 * @copyright (c) 2016 david63
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
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
	'DEFAULT_ALL_POSTS'    => '<strong>Default = All posts</strong>',
	'DEFAULT_ALL_TOPICS'   => '<strong>Default = All topics</strong>',
	'DEFAULT_ASC'          => '<strong>Default = Ascending</strong>',
	'DEFAULT_DATE_FORMAT'  => '<strong>Default = %s</strong>',
	'DEFAULT_DESC'         => '<strong>Default = Descending</strong>',
	'DEFAULT_EMAIL'        => '<strong>Default = Email</strong>',
	'DEFAULT_NO'           => '<strong>Default = No</strong>',
	'DEFAULT_NOTIFICATION' => '<strong>Default = Notification</strong>',
	'DEFAULT_POST_TIME'    => '<strong>Default = Post time</strong>',
	'DEFAULT_YES'          => '<strong>Default = Yes</strong>',
	'DISPLAY_SETTINGS'     => 'Display options',
	'DISPLAY_ONLINE_STATUS' => 'Display online status',

	'EMAIL' => 'Email',

	'GLOBAL_SETTINGS' => 'Global settings',

	'NOTIFICATION' => 'Notification',

	'POSTING_SETTINGS' => 'Posting defaults',
	'POPUP_ON_PM' => 'Pop up a window for new private messages',

	'SYNC_USERS' => 'Synchronize existing users',
	'SYNC_USERS_EXPLAIN' => 'Apply these defaults to normal users and founders that already exist.',
	'SYNC_USERS_WARNING' => 'This changes existing user preferences and notification subscriptions. The operation cannot be automatically undone.',
	'SYNC_USERS_CONFIRM' => 'I understand that existing user preferences will be changed.',
	'SYNC_USERS_CONFIRM_REQUIRED' => 'You must confirm the synchronization before it can start.',
	'SYNC_USERS_RUNNING' => 'Synchronizing users...',
	'SYNC_USERS_COMPLETE' => 'Synchronization complete',
	'SYNC_USERS_BATCH_COMPLETE' => 'Synchronized %1$d of %2$d users. Use the button again to continue when JavaScript is unavailable.',

	'USER_DEFAULTS_EXPLAIN' => 'Set here the values that you want as the default values for <strong>new</strong> users.<br>Any changes made via this form will <strong>not</strong> affect existing users.',
]);
