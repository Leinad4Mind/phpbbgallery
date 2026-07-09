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
	'ACL_A_INVITE'			=> 'Szinkronizálhatja az adatokat',
	'ACL_A_INVITE_CONFIG'	=> 'Módosíthatja a beállításokat',
	'ACL_A_INVITE_DELETE'	=> 'Törölheti a felhasználók meghívóját',
	'ACL_A_INVITE_SIZE'		=> 'Kezelheti a meghívó kérelmeket',
	'ACL_A_INVITE_SEND'		=> 'Kiutalhat meghívókat',
	'ACL_A_INVITE_PEND'		=> 'Kezelheti a függőben lévő meghívókat',
	'ACL_A_INVITE_USERS'	=> 'Láthatja a meghívott személyek listáját',
	'ACL_M_INVITE_SIZE'		=> 'Jóváhagyhat meghívó iránti kérelmet',
	'ACL_U_INVITE_DELETE'	=> 'Törölheti a már kiküldött meghívót<br /><em>Ha rossz címre küldi netán a meghívót akkor esélye van azt törölni.</em>',
	'ACL_U_INVITE_REQUEST'	=> 'Igényelhet meghívót',
	'ACL_U_INVITE_SEND'		=> 'Meghívhat új tagot az pagera',
	'ACL_U_INVITE_MAX'		=> 'Korlátlan meghívóval rendelkezzen',
	'ACL_U_INVITE_USERS'	=> 'Megtekintheti a mások által meghívott felhasználók listáját.',
));
