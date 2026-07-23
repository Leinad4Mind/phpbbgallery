<?php

/**
 * Invite. An extension for the phpBB Forum Software package.
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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

$lang = array_merge($lang, [
	'ACL_A_INVITE'          => 'O utilizador pode sincronizar dados',
	'ACL_A_INVITE_CONFIG'   => 'O utilizador pode alterar as configurações do convite.',
	'ACL_A_INVITE_DELETE'   => 'O utilizador pode apagar convites',
	'ACL_A_INVITE_CLAIMING' => 'O utilizador pode gerir convites',
	'ACL_A_INVITE_SEND'     => 'O utilizador pode adicionar convites para membros',
	'ACL_A_INVITE_PEND'     => 'O utilizador pode gerir convites pendentes',
	'ACL_A_INVITE_USERS'    => 'O utilizador pode ver uma lista de membros convidados',
	'ACL_M_INVITE_CLAIMING' => 'O utilizador pode aprovar um pedido de convite.',
	'ACL_U_INVITE_DELETE'   => 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
	'ACL_U_INVITE_REQUEST'  => 'O utilizador pode solicitar convite',
	'ACL_U_INVITE_SENDING'  => 'O utilizador pode convidar novos membros para o site',
	'ACL_U_INVITE_MAX'      => 'O utilizador tem convites ilimitados',
	'ACL_U_INVITE_USERS'    => 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
]);
