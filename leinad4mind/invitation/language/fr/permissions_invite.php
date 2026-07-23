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
	'ACL_A_INVITE'			=> 'Peut synchroniser les données',
	'ACL_A_INVITE_CONFIG'	=> 'Peut changer les paramètres d’invitation',
	'ACL_A_INVITE_DELETE'	=> 'Peut supprimer des invitations',
	'ACL_A_INVITE_CLAIMING'		=> 'Peut gérer les invitations',
	'ACL_A_INVITE_SEND'		=> 'Peut allouer des invitations à des membres',
	'ACL_A_INVITE_PEND'		=> 'Peut gérer les invitations en attente',
	'ACL_A_INVITE_USERS'	=> 'Peut voir les listes de membres invités',
	'ACL_M_INVITE_CLAIMING'		=> 'Peut approuver une demande d’invitation',
	'ACL_U_INVITE_DELETE'	=> 'Peut annuler une invitation qu’il a envoyée',
	'ACL_U_INVITE_REQUEST'	=> 'Peut demander une invitation',
	'ACL_U_INVITE_SENDING'		=> 'Peut inviter des nouveaux membres sur le site',
	'ACL_U_INVITE_MAX'		=> 'Peut disposer d’un nombre illimité d’invitations',
	'ACL_U_INVITE_USERS'	=> 'Peut voir la liste des membres invités par les autres',
));
