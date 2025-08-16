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
	'INVITE_BIRTHDAY'						=> 'Congratulations! You have received %s invitation(s) for your birthday.<br /><br />We wish you a happy birthday!',

	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Hi, this is a message you get for inviting us %s users to the “%s” site, why we are very grateful. We want to continue to use the invitation system, so you are allocated additional %s invites.<br /><br />We wish you a pleasant time.',
	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Hi, this is a message you get for inviting us further %s users to the “%s” site, why we are very grateful. We want to continue to use the invitation system, so you are allocated additional %s invites.<br /><br />We wish you a pleasant time.',

	'INVITE_PETITION_TITLE'					=> 'Invitation Request',
	'INVITE_PETITIONS_NO'					=> 'Your request was not approved, so the invitations are not allocated to you!',
	'INVITE_PETITION_NO'					=> 'Your request was not approved, so the invitation is not allocated to you!',
	'INVITE_PETITION_YES'					=> 'Your request was approved, %s invitation(s) credited!',

	'INVITE_PETITION_REQUEST'				=> 'The user %s is requesting %d invitations',

	'INVITE_JOIN'							=> 'Thank you for inviting the user %s',
));
