<?php

/**
 * @package cBB Chat for phpBB.
 * [English [En]]
 * @version 1.2.6 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_CAT_CHAT' => 'Chat',

	'ACP_CHAT_CONFIG' => 'Configuração principal',
	'ACP_CHAT_PAGES'  => 'Gerir páginas',
	'ACP_CHAT_ROOMS'  => 'Gerir salas',
	'ACP_CHAT_TEXTS'  => 'Textos estáticos e Regras',

	'LOG_CHAT_CONFIG'            => '<strong>cBB Chat:</strong> Configuração principal alterada',
	'LOG_CHAT_EXCLUSION_ADDED'   => '<strong>cBB Chat:</strong> Exclusões adicionadas<br />» %s',
	'LOG_CHAT_EXCLUSION_REMOVED' => '<strong>cBB Chat:</strong> Exclusões removidas<br />» %s',
	'LOG_CHAT_MESSAGE_MOVED'     => '<strong>cBB Chat:</strong> Mensagem movida de <em>%1</em> para <em>%2</em><br />» %3',
	'LOG_CHAT_MESSAGES_MOVED'    => [
		1 => '<strong>cBB Chat:</strong> 1 mensagem movida de <em>%1</em> para <em>%2</em>',
		2 => '<strong>cBB Chat:</strong> %3 mensagens movidas de <em>%1</em> para <em>%2</em>',
	],
	'LOG_CHAT_MESSAGE_REMOVED'  => '<strong>cBB Chat:</strong> Mensagem eliminada <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED' => [
		1 => '<strong>cBB Chat:</strong> 1 mensagem eliminada de <em>%1</em>',
		2 => '<strong>cBB Chat:</strong> %2 mensagens eliminadas de <em>%1</em>',
	],
	'LOG_CHAT_ROOM_REMOVED' => '<strong>cBB Chat:</strong> Sala <em>%s</em> e respetivas mensagens eliminadas',
]);
