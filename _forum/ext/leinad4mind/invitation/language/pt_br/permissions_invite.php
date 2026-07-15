<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
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
	'ACL_A_INVITE'			=> 'O usuário pode sincronizar dados',
	'ACL_A_INVITE_CONFIG'	=> 'O usuário pode alterar as configurações do convite.',
	'ACL_A_INVITE_DELETE'	=> 'O usuário pode excluir convites',
	'ACL_A_INVITE_CLAIMING' => 'O usuário pode gerenciar convites',
	'ACL_A_INVITE_SEND'		=> 'O usuário pode adicionar convites para membros',
	'ACL_A_INVITE_PEND'		=> 'O usuário pode gerenciar convites pendentes',
	'ACL_A_INVITE_USERS'	=> 'O usuário pode ver uma lista de membros convidados',
	'ACL_M_INVITE_CLAIMING'	=> 'O usuário pode aprovar um pedido de convite.',
	'ACL_U_INVITE_DELETE'	=> 'O usuário pode revogar convite<br /><em>O usuário pode cancelar um convite que ele enviou.</em>',
	'ACL_U_INVITE_REQUEST'	=> 'O usuário pode solicitar convite',
	'ACL_U_INVITE_SENDING'		=> 'O usuário pode convidar novos membros para o site',
	'ACL_U_INVITE_MAX'		=> 'O usuário tem convites ilimitados',
	'ACL_U_INVITE_USERS'	=> 'O usuário pode visualizar a lista de usuários convidados por outras pessoas.',
));
