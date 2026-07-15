<?php
/** 
* permissions_chat.php [Portuguese [pt]] 
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
	'ACL_CAT_CHAT'				=> 'Chat',
	'ACL_A_CHAT'				=> 'Pode gerenciar o chat',

	'ACL_M_CHAT_DELETE'			=> 'Pode excluir mensagens',
	'ACL_M_CHAT_EDIT'			=> 'Pode editar mensagens',

	'ACL_U_CHAT_ARCHIVE'		=> 'Pode ver o arquivo',
	'ACL_U_CHAT_DELETE'			=> 'Pode deletar suas próprias mensagens',
	'ACL_U_CHAT_EDIT'			=> 'Pode editar suas próprias mensagens',
	'ACL_U_CHAT_IGNOREFLOOD'	=> 'Pode ignorar o limite de flood',
	'ACL_U_CHAT_POST'			=> 'Pode postar mensagens',
	'ACL_U_CHAT_SENDPM'			=> 'Pode enviar mensagens privadas',
	'ACL_U_CHAT_VIEW'			=> 'Pode ver o chat',
));