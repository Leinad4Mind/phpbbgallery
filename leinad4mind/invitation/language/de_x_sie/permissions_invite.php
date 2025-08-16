<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
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
	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
));
