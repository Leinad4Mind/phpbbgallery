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
	'INVITE_BIRTHDAY'						=> 'Parabéns! Você recebeu %s convite(s) para o seu aniversário.<br /><br />Desejamos-lhe um feliz aniversário!', 

	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Oi, esta é uma mensagem que você recebe por convidar os usuários %s para o site “%s”, por isso estamos muito gratos. Queremos que você continue a usar o sistema de convite, para que você receba %s convites adicionais.<br /><br />Desejamos a você um momento agradável.',
	
	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Oi, esta é uma mensagem que você recebe por convidar mais %s usuários para o site “%s”, por isso estamos muito gratos. Queremos que você continue a usar o sistema de convite, para que você receba %s convites adicionais.<br /><br />Desejamos a você um momento agradável.',

	'INVITE_PETITION_TITLE'					=> 'Solicitação de convite',
	'INVITE_PETITIONS_NO'					=> 'Sua solicitação não foi aprovada, portanto, os convites não serão creditados para você!',
	'INVITE_PETITION_NO'					=> 'Sua solicitação não foi aprovada, então o convite não será creditado para você!',
	'INVITE_PETITION_YES'					=> 'Sua solicitação foi aprovada, %s convite(s) creditado(s)!', 

	'INVITE_PETITION_REQUEST'				=> 'O usuário %s está solicitando %d convite(s)', 

	'INVITE_JOIN'							=> 'Obrigado por convidar o usuário %s',
));
