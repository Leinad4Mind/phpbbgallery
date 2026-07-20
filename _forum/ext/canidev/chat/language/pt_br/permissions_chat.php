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
	'ACL_U_CHAT_VIEW'   => 'Pode ver o chat',
	'ACL_U_CHAT_POST'   => 'Pode publicar mensagens',
	'ACL_U_CHAT_EDIT'   => 'Pode editar as próprias mensagens',
	'ACL_U_CHAT_DELETE' => 'Pode remover as próprias mensagens',
	'ACL_U_CHAT_IGNORE' => 'Pode ignorar Flood/limite de caracteres',
	'ACL_U_CHAT_PM'     => 'Pode enviar mensagens privadas',
	'ACL_U_CHAT_REPORT' => 'Pode reportar mensagens',

	'ACL_M_CHAT_EDIT'   => 'Pode editar mensagens',
	'ACL_M_CHAT_DELETE' => 'Pode remover mensagens',
	'ACL_M_CHAT_BAN'    => 'Pode gerir exclusões',

	'ACL_A_CHAT' => 'Pode gerir as configurações do chat',
]);
