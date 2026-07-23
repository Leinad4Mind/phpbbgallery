<?php

/**
 * @package cBB QuickQuote for phpBB.
 * [English [En]]
 * @version 1.0.4 01/06/2024
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
	'QQ_INSERT'          => 'Inserir',
	'QQ_INSERT_ALL'      => 'Inserir todas',
	'QQ_INSERT_QUOTES'   => 'Inserir citações',
	'QQ_INSERT_SELECTED' => 'Inserir as selecionadas',
	'QQ_REMOVE'          => 'Remover',
	'QQ_REMOVE_ALL'      => 'Remover todas',
	'QQ_REMOVE_SELECTED' => 'Remover as selecionadas',
	'QQ_REPLY'           => 'Responder',
	'QQ_SAVE_QUOTE'      => 'Guardar citação',
	'QUOTES'             => 'Citações',

	'CORE_INSTALL_ERROR' => 'Não carregaste todos os arquivos do pacote de instalação ou está a tentar instalar um pacote antigo.<br />
		Por favor, certifica-te de que carregas todos os arquivos (incluindo a pasta <em>core</em>) e usas um pacote descarregado do site oficial.',
]);
