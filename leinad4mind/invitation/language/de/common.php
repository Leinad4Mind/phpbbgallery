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
	'INVITE_BIRTHDAY'						=> 'Glückwunsch! Du hast zum Geburtstag %s Einladung(en) erhalten.<br /><br />Alles Gute zum Geburtstag!',

	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Hallo, dies ist die automatische Nachricht, die du erhältst, weil du %s Benutzer auf die Seite %s eingeladen hast. Wir würden das Einladungssystem gern beibehalten, daher wurden dir weitere %s Einladungen zugeteilt.<br /><br />Wir wünschen dir eine angenehme Zeit.',
	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Hallo, dies ist die automatische Nachricht, die du erhältst, weil du weitere %s Benutzer auf die Seite %s eingeladen hast. Wir würden das Einladungssystem gern beibehalten, daher wurden dir weitere %s Einladungen zugeteilt.<br /><br />Wir wünschen dir eine angenehme Zeit.',

	'INVITE_PETITION_TITLE'					=> 'Einladungsanfrage',
	'INVITE_PETITIONS_NO'					=> 'Deine Anfrage wurde nicht genehmigt, daher wurden dir die Einladungen nicht zugeteilt!',
	'INVITE_PETITION_NO'					=> 'Deine Anfrage wurde nicht genehmigt, daher wurden dir die Einladung nicht zugeteilt!',
	'INVITE_PETITION_YES'					=> 'Deine Anfrage wurde genehmigt, %s Einladung(en) wurde(n) dir gutgeschrieben!',

	'INVITE_PETITION_REQUEST'				=> 'The user %s is requesting %d invitations',

	'INVITE_JOIN'							=> 'Thank you for inviting the user %s',
));
