<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
	'INVITE'								=> 'Meghívó',
	'INVITE_DELETE_CONFIRM'					=> 'Ha szeretnéd törölni a meghívod akkor kattints %sIDE%s.',
	'INVITE_DELETE_SUCCESS'					=> 'A meghívód törlése sirequest.',
	'INVITE_DELETE_SUCCESSES'				=> 'A meghívók törlése sirequest.',
	'INVITE_DISABLED'						=> '<span class="invitation_tred">A meghívó rendszer jelenleg ki van kapcsolva!</span>',
	'INVITE_EMAIL_BLOCK'					=> 'Blokkolva!',
	'INVITE_INVITED'						=> 'Meghívta',
	'INVITE_INVITES'						=> 'Meghívott',
	'INVITE_KEY_ERROR'						=> '<div class="invitation_error">A meghívód érvénytelen!</div>',
	'INVITE_PERSON'							=> '%s személyt',
	'INVITE_POINTS_PRESENT'					=> '%s meghívásáért jóváírtunk számodra %s %sot.',
	'INVITE_REGISTRATION'					=> '<div class="invitation_error">Jelenleg csak meghívóval lehet regisztrálni!</div>',
	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018-2022',
));
