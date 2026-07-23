<?php

/**
 * @package cBB Debugger for phpBB.
 * [English [En]]
 * @version 1.0.2 11/03/2024
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
	'ERROR_MSG'   => 'Ocorreu um erro.<br />A extensão não pôde ser habilitada.',
	'EXPLAIN'     => 'Usa esta página para habilitar o modo de depuração se não conseguires aceder ao Painel de Administração do seu fórum.',
	'ENABLE'      => 'Habilitar',
	'RETURN'      => 'Voltar',
	'SUCCESS_MSG' => 'Modo de depuração ativado com sucesso',
	'TITLE'       => 'Modo de Depuração',
]);
