<?php

/**
 * @package User Login Redirect for phpBB.
 * @copyright (c) 2014 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * DO NOT CHANGE
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'REDIRECT_LOGIN_ANNOUNCE_TOPIC' => 'Iniciou sessão com sucesso. Um novo anúncio foi publicado desde a sua última visita e será redirecionado para o mesmo.',
	'REDIRECT_LOGIN_GROUP_TOPIC'    => 'Iniciou sessão com sucesso. Uma nova mensagem de grupo foi publicada desde a sua última visita e será redirecionado para a mesma.',
	'REDIRECT_LOGIN_WELCOME_TOPIC'  => 'Iniciou sessão com sucesso. Como esta é a sua primeira visita, será agora redirecionado para o nosso tópico de boas-vindas.',

	'REDIRECT_REFRESH_ANNOUNCE' => '%sAvançar para o tópico de anúncio%s',
	'REDIRECT_REFRESH_GROUP'    => '%sAvançar para o tópico de grupo%s',
	'REDIRECT_REFRESH_WELCOME'  => '%sAvançar para o tópico de boas-vindas%s',
]);
