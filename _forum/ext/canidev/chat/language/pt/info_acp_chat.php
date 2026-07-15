<?php
/** 
* info_acp_chat.php [Portuguese [pt]] 
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
	'ACP_CAT_CHAT'			=> 'Chat',
	
	'ACP_CHAT_CONFIG'		=> 'Configuração principal',
	'ACP_CHAT_PAGES'		=> 'Gerenciar páginas',
	'ACP_CHAT_ROOMS'		=> 'Gerenciar salas',
	'ACP_CHAT_TEXTS'		=> 'Textos e regras estáticas',

	'LOG_CHAT_CONFIG'			    => '<strong>cBB Chat:</strong> Configuração principal alterada',
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusões adicionadas<br />» %s',
 	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusões removidas<br />» %s',
	'LOG_CHAT_MESSAGE_MOVED'		=> '<strong>cBB Chat:</strong> Mensagem movida de <em>%1$s</em> para <em>%2$s</em><br />» %3$s',
	'LOG_CHAT_MESSAGES_MOVED'		=> array(
		1 => '<strong>cBB Chat:</strong> 1 mensagem movida de <em>%1$s</em> para <em>%2$s</em>',
		2 => '<strong>cBB Chat:</strong> %3$d mensagens movidas de <em>%1$s</em> para <em>%2$s</em>',
	),
	'LOG_CHAT_MESSAGE_REMOVED'		=> '<strong>cBB Chat:</strong> Mensagem excluida <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED'		=> array(
		1 => '<strong>cBB Chat:</strong> 1 mensagem excluída de <em>%1$s</em>',
		2 => '<strong>cBB Chat:</strong> %2$d mensagens deletadas de <em>%1$s</em>',
	),
	'LOG_CHAT_ROOM_REMOVED'		    => '<strong>cBB Chat:</strong> Excluida a sala <em>%s</em> e suas mensagens',
));