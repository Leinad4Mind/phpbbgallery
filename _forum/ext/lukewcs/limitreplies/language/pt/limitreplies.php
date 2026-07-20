<?php

/**
 * Limit Multiple Replies. An extension for the phpBB Forum Software package.
 * @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 * Note: This extension is 100% genuine handcraft and consists of selected
 * natural raw materials. There was no AI involved in making it.
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
//
// Some characters you may want to copy&paste:
// ’ « » “ ” … „ “

$lang = array_merge($lang, [
	'LIMITREPLIES_CONFIG_TITLE'       => 'Limitar Múltiplas Respostas',
	'LIMITREPLIES_CONFIG_DESC'        => 'Aqui pode alterar as definições para a extensão <strong>%s</strong>.',
	'LIMITREPLIES_SETTINGS_TITLE'     => 'Configurações',
	'LIMITREPLIES_ENABLE'             => 'Ativar função',
	'LIMITREPLIES_ENABLE_EXPLAIN'     => 'Com este interruptor pode desativar a funcionalidade sem ter de desativar a extensão completamente.',
	'LIMITREPLIES_WAIT_TIME'          => 'Período de espera entre duas mensagens',
	'LIMITREPLIES_WAIT_TIME_EXPLAIN'  => 'Aqui pode especificar após qual período de espera uma nova resposta é permitida se a última mensagem foi do mesmo utilizador.',
	'LIMITREPLIES_MINUTES'            => 'minutos',
	'LIMITREPLIES_HINT_MODE'          => 'Mostrar explicação',
	'LIMITREPLIES_HINT_MODE_EXPLAIN'  => 'Aqui pode especificar como a explicação deve ser mostrada quando o bloqueio está ativo.',
	'LIMITREPLIES_HINT_MODE_ONCLICK'  => 'Ao clicar (como popup de info)',
	'LIMITREPLIES_HINT_MODE_ALWAYS'   => 'Sempre (como caixa de info)',
	'LIMITREPLIES_MSG_SETTINGS_SAVED' => 'Limitar Múltiplas Respostas: Configurações guardadas com sucesso',
]);
