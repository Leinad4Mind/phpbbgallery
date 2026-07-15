<?php
/** 
* info_mcp_chat.php [Portuguese [pt]] 
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'MCP_CHAT_BAN'				=> 'Exclusões do Chat',
	
	'CHAT_BAN_CELL'				=> 'Nome de usuário',
	'CHAT_BAN_CELL_EXPLAIN'		=> 'Para especificar mais de um nome de usuário, insira cada um em uma nova linha.<br />
        Use o link <em><u>Encontrar um Usuário</ u> </ em> para encontrar e adicionar usuários automaticamente.',
	'CHAT_BAN_LIST'				=> 'Usuários Excluídos',
	'CHAT_EXCLUSIONS_ADDED'		=> 'As exclusões foram modificadas',
	'CHAT_EXCLUSIONS_DELETED'	=> 'As exclusões foram excluídas',
	'CHAT_EXCLUSIONS_ERROR'		=> 'Ocorreu um erro, verifique os dados inseridos',
	
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusões adicionadas<br />» %s',
 	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusões removidas<br />» %s',
 	'LOG_CHAT_MESSAGE_MOVED'		=> '<strong>cBB Chat:</strong> Message moved from <em>%1$s</em> to <em>%2$s</em><br />» %3$s',
	'LOG_CHAT_MESSAGES_MOVED'		=> array(
		1 => '<strong>cBB Chat:</strong> 1 message moved from <em>%1$s</em> to <em>%2$s</em>',
		2 => '<strong>cBB Chat:</strong> %3$d messages moved from <em>%1$s</em> to <em>%2$s</em>',
	),
	'LOG_CHAT_MESSAGE_REMOVED'		=> '<strong>cBB Chat:</strong> Message removed <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED'		=> array(
		1 => '<strong>cBB Chat:</strong> 1 message removed from <em>%1$s</em>',
		2 => '<strong>cBB Chat:</strong> %2$d messages removed from <em>%1$s</em>',
	),
));