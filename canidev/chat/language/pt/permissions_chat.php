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
	'ACL_CAT_CHAT' => 'Chat',

	'ACL_U_CHAT_VIEW'        => 'Pode ver o chat',
	'ACL_U_CHAT_POST'        => 'Pode publicar mensagens',
	'ACL_U_CHAT_EDIT'        => 'Pode editar as próprias mensagens',
	'ACL_U_CHAT_DELETE'      => 'Pode remover as próprias mensagens',
	'ACL_U_CHAT_IGNOREFLOOD' => 'Pode ignorar o limite de flood',
	'ACL_U_CHAT_SENDPM'      => 'Pode enviar mensagens privadas',
	'ACL_U_CHAT_ARCHIVE'     => 'Pode ver o arquivo do chat',

	'ACL_M_CHAT_EDIT'   => 'Pode editar mensagens',
	'ACL_M_CHAT_DELETE' => 'Pode remover mensagens',

	'ACL_A_CHAT' => 'Pode gerir as configurações do chat',
]);
