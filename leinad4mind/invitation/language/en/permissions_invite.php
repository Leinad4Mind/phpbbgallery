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
	'ACL_A_INVITE'			=> 'User can synchronize data',
	'ACL_A_INVITE_CONFIG'	=> 'User can change invitation settings.',
	'ACL_A_INVITE_DELETE'	=> 'User can delete invitations',
	'ACL_A_INVITE_SIZE'		=> 'User can manage invitations',
	'ACL_A_INVITE_SEND'		=> 'User can allocate invitations to members',
	'ACL_A_INVITE_PEND'		=> 'User can manage pending invitations',
	'ACL_A_INVITE_USERS'	=> 'User can see a list of invited members',
	'ACL_M_INVITE_SIZE'		=> 'User can approve invitation application.',
	'ACL_U_INVITE_DELETE'	=> 'User can revoke invitation<br /><em>User can cancel an invitation he has sent.</em>',
	'ACL_U_INVITE_REQUEST'	=> 'User can request invitation',
	'ACL_U_INVITE_SEND'		=> 'User can invite new members to the site',
	'ACL_U_INVITE_MAX'		=> 'User has unlimited invitations',
	'ACL_U_INVITE_USERS'	=> 'User can view the list of users invited by others.',
));
