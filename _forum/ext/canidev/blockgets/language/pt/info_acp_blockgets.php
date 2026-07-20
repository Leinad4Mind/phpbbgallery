<?php

/**
 * @package cBB Blockgets for phpBB.
 * @version 2.0.7 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

// @ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
 * @general tags and messages
*/
$lang = array_merge($lang, [
	'ACP_BLOCKGETS'         => 'Blockgets',
	'ACP_BLOCKGETS_GENERAL' => 'Geral',

	'ACP_BLG_CONFIG_MAIN'     => 'Configuração geral',
	'ACP_BLG_CONFIG_OPTIONAL' => 'Configuração adicional',
	'ACP_BLG_IMAGES'          => 'Imagens',
	'ACP_PAGES_AND_BLOCKS'    => 'Páginas e Blocos',

	// Logs
	'LOG_BLG_CONFIG'       => '<strong>cBB Blockgets:</strong> Configuração principal alterada',
	'LOG_BLOCK_ADDED'      => '<strong>cBB Blockgets:</strong> Novo bloco adicionado<br />» %1$s em %2$s',
	'LOG_BLOCK_COPY_PAGE'  => '<strong>cBB Blockgets:</strong> Blocos copiados<br />» de %1$s para %2$s',
	'LOG_BLOCK_MOVED'      => '<strong>cBB Blockgets:</strong> Posição dos blocos alterada<br />» %1$s',
	'LOG_BLOCK_MOVED_PAGE' => '<strong>cBB Blockgets:</strong> Blocos movidos<br />» de %1$s para %2$s',
	'LOG_BLOCK_REMOVED'    => '<strong>cBB Blockgets:</strong> Bloco(s) eliminado(s)<br />» em %1$s',
	'LOG_BLOCK_UPDATED'    => '<strong>cBB Blockgets:</strong> Bloco editado<br />» %1$s em %2$s',
	'LOG_EVENT_REMOVED'    => '<strong>cBB Blockgets:</strong> Evento eliminado<br />» %1$s',
	'LOG_LIST_REMOVED'     => '<strong>cBB Blockgets:</strong> Lista eliminada<br />» %1$s',
	'LOG_PAGE_ADDED'       => '<strong>cBB Blockgets:</strong> Nova página adicionada<br />» %1$s',
	'LOG_PAGE_UPDATED'     => '<strong>cBB Blockgets:</strong> Página alterada<br />» %1$s',
	'LOG_PAGE_REMOVED'     => '<strong>cBB Blockgets:</strong> Página eliminada<br />» %1$s',

	// Permissions
	'ACL_A_BLOCKGETS_MANAGE'    => 'Pode gerir o cBB Blockgets',
	'ACL_U_BLOCKGETS_BIRTHDAYS' => 'Pode ver aniversários no Calendário',
	'ACL_U_BLOCKGETS_CALENDAR'  => 'Pode ver o calendário',
	'ACL_U_BLOCKGETS_EVENTS'    => 'Pode gerir eventos do calendário',
]);
