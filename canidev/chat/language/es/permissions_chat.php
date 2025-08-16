<?php
/** 
* permissions_chat.php [Spanish [Es]]
* @package cBB Chat
* @version v1.1.0 16/12/2014
*
* @copyright (c) 2014 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACL_A_CHAT'				=> 'Puede administrar el chat',

	'ACL_M_CHAT_DELETE'			=> 'Puede borrar mensajes',
	'ACL_M_CHAT_EDIT'			=> 'Puede editar mensajes',

	'ACL_U_CHAT_ARCHIVE'		=> 'Puede ver el archivo',
	'ACL_U_CHAT_DELETE'			=> 'Puede borrar sus mensajes',
	'ACL_U_CHAT_EDIT'			=> 'Puede editar sus mensajes',
	'ACL_U_CHAT_IGNOREFLOOD'	=> 'Puede ignorar límite de saturación',
	'ACL_U_CHAT_POST'			=> 'Puede publicar mensajes',
	'ACL_U_CHAT_SENDPM'			=> 'Puede enviar mensajes privados',
	'ACL_U_CHAT_VIEW'			=> 'Puede ver el chat',
));
