<?php

/**
 * @package cBB Chat for phpBB.
 * [English [En]]
 * @version 1.2.6 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

// DO NOT CHANGE
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'MCP_CHAT_BAN' => 'Exclusões do Chat',

	'CHAT_BAN_CELL'         => 'Nome de utilizador',
	'CHAT_BAN_CELL_EXPLAIN' => 'Para especificar mais do que um nome de utilizador, insere cada um numa nova linha.<br />
		Usa a ligação <em><u>Procurar um Nome de utilizador</u></em> para encontrar e adicionar utilizadores automaticamente.',
	'CHAT_BAN_LIST'           => 'Utilizadores Excluídos',
	'CHAT_EXCLUSIONS_ADDED'   => 'As exclusões foram modificadas',
	'CHAT_EXCLUSIONS_DELETED' => 'As exclusões foram eliminada',
	'CHAT_EXCLUSIONS_ERROR'   => 'Ocorreu um erro, verifica os dados introduzidos',

	'LOG_CHAT_EXCLUSION_ADDED'   => '<strong>cBB Chat:</strong> Exclusões adicionadas<br />» %s',
	'LOG_CHAT_EXCLUSION_REMOVED' => '<strong>cBB Chat:</strong> Exclusões removidas<br />» %s',
	'LOG_CHAT_MESSAGE_MOVED'     => '<strong>cBB Chat:</strong> Mensagem movida de <em>%1</em> para <em>%2</em><br />» %3',
	'LOG_CHAT_MESSAGES_MOVED'    => [
		1 => '<strong>cBB Chat:</strong> 1 mensagem movida de <em>%1</em> para <em>%2</em>',
		2 => '<strong>cBB Chat:</strong> %3 mensagens movidas de <em>%1</em> para <em>%2</em>',
	],
	'LOG_CHAT_MESSAGE_REMOVED'  => '<strong>cBB Chat:</strong> Mensagem removida <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED' => [
		1 => '<strong>cBB Chat:</strong> 1 mensagem removida de <em>%1</em>',
		2 => '<strong>cBB Chat:</strong> %2 mensagens removidas de <em>%1</em>',
	],
]);
