<?php

/**
 * @package cBB QuickMod for phpBB.
 * [English [En]]
 * @version 1.1.6 01/11/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_CAT_QUICKMOD'            => 'QuickMod',
	'ACP_QUICKMOD_CONFIG'         => 'Configuração Principal',
	'ACP_QUICKMOD_CONFIG_EXPLAIN' => 'A partir daqui podes gerir as principais opções de moderação.<br />Para organizares os botões, arrasta-os para a posição correcta na lista inferior. A visibilidade dos botões na página viewforum depende das permissões do utilizador e do estado do tópico.',
	'QM_MAIN_CONFIG'              => 'Configuração Principal',
	'QM_CONFIRM'                  => 'Caixa de confirmação',
	'QM_CONFIRM_EXPLAIN'          => 'Activar/Desactivar a caixa de confirmação nas acções rápidas.',
	'QM_BUTTON_MANAGE'            => 'Gerir Botões Rápidos',
	'QM_LAYOUT'                   => 'Exibição da Caixa de Acções',
	'QM_LAYOUT_EXPLAIN'           => 'Define como a caixa será exibida para a execução de acções em massa.',
	'QM_LAYOUT_DEFAULT'           => 'Predefinida',
	'QM_LAYOUT_FIXED'             => 'Flutuante',
	'QM_TYPE'                     => 'Exibição do ícone',
	'QM_TYPE_EXPLAIN'             => 'Define o formato de exibição para as acções rápidas no fórum.',
	'QM_TYPE_ICON'                => 'Ícones',
	'QM_TYPE_MENU'                => 'Menu de contexto',

	'BUTTONS_AVAILABLE' => 'Botões disponíveis',
	'BUTTONS_SELECTED'  => 'Botões seleccionados',

	'LOG_QUICKMOD_CONFIG' => '<strong>cBB QuickMod:</strong> Configuração Alterada',
]);
