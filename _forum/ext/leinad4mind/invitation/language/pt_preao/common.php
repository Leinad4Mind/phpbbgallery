<?php

/**
 * Invite. An extension for the phpBB Forum Software package.
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'INVITE_BIRTHDAY' => 'Parabéns! Recebeste %s convite(s) para o teu aniversário.<br /><br />Desejamos-te um feliz aniversário!',

	'INVITE_GIFT_INVITED_USERS_FIRST' => 'Olá, esta é uma mensagem que se recebe por convidar o utilizador %s para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',

	'INVITE_GIFT_INVITED_USERS_FURTHER' => 'Olá, esta é uma mensagem que se recebe por convidar mais %s utilizadores para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',

	'INVITE_PETITION_TITLE' => 'Solicitação de convite',
	'INVITE_PETITIONS_NO'   => 'A tua solicitação não foi aprovada, portanto, os convites não te serão creditados!',
	'INVITE_PETITION_NO'    => 'A tua solicitação não foi aprovada, então o convite não te será creditado!',
	'INVITE_PETITION_YES'   => 'A tua solicitação foi aprovada, %s convite(s) creditado(s)!',

	'INVITE_PETITION_REQUEST' => 'O utilizador %s está a solicitar %d convite(s)',

	'INVITE_JOIN' => 'Obrigado por convidares o utilizador %s',
]);
