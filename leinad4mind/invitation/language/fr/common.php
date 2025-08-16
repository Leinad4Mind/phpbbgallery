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
	'INVITE_BIRTHDAY'						=> 'Félicitations! Vous avez reçu %s invitation(s) pour votre anniversaire.<br /><br />Nous vous souhaitons un joyeux anniversaire !',

	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Bonjour, vous recevez ce message car vous avez invité des utilisateurs, %s, sur le site “%s”, et nous vous en sommes reconnaissants. Nous souhaiterions continuer à utiliser le système d’Invitations aussi nous demandons %s invitations supplémentaires.<br /><br />Bien cordialement.',
	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Bonjour, vous recevez ce message car vous avez à nouveau invité des utilisateurs, %s, sur le site “%s”, et nous vous en sommes reconnaissants. Nous souhaiterions continuer à utiliser le système d’Invitations aussi nous demandons %s invitations supplémentaires.<br /><br />Bien cordialement.',

	'INVITE_PETITION_TITLE'					=> 'Demande d’Invitation',
	'INVITE_PETITIONS_NO'					=> 'Votre demande n’a pas été approuvée, aussi les invitations ne vous sont pas attribuées !',
	'INVITE_PETITION_NO'					=> 'Votre demande n’a pas été approuvée, aussi l’invitation ne vous est pas attribuée !',
	'INVITE_PETITION_YES'					=> 'Votre demande est approuvée, %s invitation(s) vous sont créditées !',

	'INVITE_PETITION_REQUEST'				=> 'The user %s is requesting %d invitations',

	'INVITE_JOIN'							=> 'Thank you for inviting the user %s',
));
