<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
// Some characters you may want to copy&paste: ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'INVITE'								=> 'Invite',
	'INVITE_DELETE_CONFIRM'					=> 'If you want to delete the invitation, click %sHERE%s.',
	'INVITE_DELETE_SUCCESS'					=> 'Your invitation was successfully deleted.',
	'INVITE_DELETE_SUCCESSES'				=> 'Your invitations were successfully deleted.',
	'INVITE_DISABLED'						=> '<span class="meghivo_tred">The invitation system is currently disabled!</span>',
	'INVITE_EMAIL_BLOCK'					=> 'Blocked!',
	'INVITE_INVITED'						=> 'Invited by',
	'INVITE_INVITES'						=> 'Invited',
	'INVITE_KEY_ERROR'						=> '<div class="meghivo_error">The invitation is not valid!</div>',
	'INVITE_PERSON'							=> '%s person(s)',
	'INVITE_POINTS_PRESENT'					=> 'For %s invitation(s), we sent %s %s !',
	'INVITE_REGISTRATION'					=> '<div class="meghivo_error">Registration is currently by invitation only!</div>',
	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018',
));
