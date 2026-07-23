<?php

/**
 * Invite. An extension for the phpBB Forum Software package.
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'INVITE'                      => 'Convites',
	'INVITE_INFO'                 => 'Informação sobre Convites',
	'INVITE_DELETE_CONFIRM'       => 'Se você quiser apagar o convite, clique %sAQUI%s.',
	'INVITE_DELETE_SUCCESS'       => 'O seu convite foi apagado com sucesso.',
	'INVITE_DELETE_SUCCESSES'     => 'Os seus convites foram apagados com sucesso.',
	'INVITE_DISABLED'             => '<span class="invitation_tred">O sistema de convite está atualmente desativado!</span>',
	'INVITE_EMAIL_BLOCK'          => 'Bloqueado!',
	'INVITE_INVITED'              => 'Convidado por',
	'INVITE_INVITES'              => 'Convidou',
	'INVITE_KEY_ERROR'            => '<div class="invitation_error">O convite não é válido!</div>',
	'INVITE_PERSON'               => '%s pessoa(s)',
	'INVITE_POINTS_PRESENT'       => 'A cada %s convite(s), enviamos %s %s !',
	'INVITE_REGISTRATION'         => '<div class="invitation_error">Registro apenas por convite!</div>',
	'INVITE_COPYRIGHT'            => 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018-2022',
]);
