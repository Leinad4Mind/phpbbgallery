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
	'INVITE'								=> 'Nodig uit',
	'INVITE_DELETE_CONFIRM'					=> 'Als je deze uitnodiging wilt verwijderen, klik %sHIER%s.',
	'INVITE_DELETE_SUCCESS'					=> 'Je uitnodiging is succesvol verwijderd.',
	'INVITE_DELETE_SUCCESSES'				=> 'Je uitnodigingen zijn succesvol verwijderd.',
	'INVITE_DISABLED'						=> '<span class="meghivo_tred">Het uitnodigings systeem is momenteel uitgezet!</span>',
	'INVITE_EMAIL_BLOCK'					=> 'Blocked!',
	'INVITE_INVITED'						=> 'Uitgenodigd door',
	'INVITE_INVITES'						=> 'Uitgenodigd',
	'INVITE_KEY_ERROR'						=> '<div class="meghivo_error">De uitnodiging is niet geldig!</div>',
	'INVITE_PERSON'							=> '%s gebruiker(s)',
	'INVITE_POINTS_PRESENT'					=> 'Voor %s uitnodiging(en), zenden we %s %s !',
	'INVITE_REGISTRATION'					=> '<div class="meghivo_error">Registratie is momenteel alleen op uitnodiging mogelijk!</div>',
	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018',
));
