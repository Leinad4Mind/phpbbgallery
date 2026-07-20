<?php

/**
 * @package Custom Language for phpBB.
 * @version $Id$
 * @copyright (c) 2015-2021 https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
// Some characters you may want to copy&paste: ‚ ‘ ’ « » „ “ ” …

$lang = array_merge($lang, [
	'NEW_PROJECT'                 => 'Partilhar Novo Projeto',
	'MY_PROJECTS'                 => 'Os Meus Projetos',
	'NEW_ORDER'                   => 'Criar Novo Pedido',
	'HELP'                        => 'Ajuda',
	'RULES'                       => 'Regras',
	'INVITATIONS'                 => 'Convites',
	'SETTINGS_NOTIFICATION'       => 'Preferências de Notificação',
	'WROTE'                       => '',
	'POST_STORED_MOD'             => 'Tópico criado com sucesso, embora necessite ser Aprovado e posteriormente Movido.',
	'NOTIFICATION_TOPIC_APPROVED' => '<strong>Tópico Aprovado, será Movido brevemente</strong>:',
	'FORCE_PASSWORD_EXPLAIN'      => 'Por motivos de Segurança. É obrigatório que alteres a tua senha.<br>Podes ler mais aqui depois de alterares a senha: <a style="color:white" href="https://goldtuganime.com/forum/seguranca">https://goldtuganime.com/forum/seguranca</a>',
]);
