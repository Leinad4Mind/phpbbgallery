<?php

/**
 * @package Ext Common Core for phpBB.
 * [English [En]]]
 * @version 1.1.2 20/09/2023
 * @copyright (c) 2023 CaniDev
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

$lang = array_merge($lang, [
	'AUTHOR'               => 'Autor:',
	'CODE'                 => 'Código',
	'DATE'                 => 'Data:',
	'DESCRIPTION_OPTIONAL' => 'Descrição (Opcional):',
	'INSERT'               => 'Inserir',
	'MAXIMIZE'             => 'Maximizar editor',
	'PRINT'                => 'Imprimir',
	'REMOVE_FORMAT'        => 'Remover Formatação',
	'UNLINK'               => 'Remover Link',
	'URL'                  => 'Url:',
	'VIEW_SOURCE'          => 'Mostrar Código',
]);
