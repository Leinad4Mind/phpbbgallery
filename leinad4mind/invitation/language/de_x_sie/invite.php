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
	'INVITE'								=> 'Einladen',
	'INVITE_DELETE_CONFIRM'					=> 'Falls Sie die Einladung löschen möchten, klicken Sie %sHIER%s.',
	'INVITE_DELETE_SUCCESS'					=> 'Ihre Einladung wurde erfolgreich gelöscht.',
	'INVITE_DELETE_SUCCESSES'				=> 'Ihre Einladungen wurde erfolgreich gelöscht.',
	'INVITE_DISABLED'						=> '<span class="meghivo_tred">Das Einladungssystem ist derzeit deaktiviert!</span>',
	'INVITE_EMAIL_BLOCK'					=> 'Blockiert!',
	'INVITE_INVITED'						=> 'Eingeladen von',
	'INVITE_INVITES'						=> 'Eingeladen',
	'INVITE_KEY_ERROR'						=> '<div class="meghivo_error">Die Einladung ist ungültig!</div>',
	'INVITE_PERSON'							=> '%s Person(en)',
	'INVITE_POINTS_PRESENT'					=> 'Für %s Einladung(en) sandten wir %s %s!',
	'INVITE_REGISTRATION'					=> '<div class="meghivo_error">Die Registrierung ist zurzeit nur mit einer Einladung möglich!</div>',
	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018',
));
