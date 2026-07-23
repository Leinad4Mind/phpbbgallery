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
	'ACP_CAT_QUICKQUOTE'            => 'QuickQuote',
	'ACP_QUICKQUOTE_CONFIG'         => 'Configuração',
	'ACP_QUICKQUOTE_CONFIG_EXPLAIN' => 'A partir daqui você pode gerenciar as opções principais da extensão.',

	'MAIN_OPTIONS'                => 'Opções principais',
	'QUICKQUOTE_FLOATBTN'         => 'Botão flutuante',
	'QUICKQUOTE_FLOATBTN_EXPLAIN' => 'Se ativado, um botão irá aparecer na parte inferior de todas as páginas permitidas, exibindo as citações guardadas.
		<br />Caso contrário, será exibido um botão no editor para inserir as citações.',
	'QUICKQUOTE_GROUPS'         => 'Grupos autorizados',
	'QUICKQUOTE_GROUPS_EXPLAIN' => 'Define os grupos que podem usar esta extensão.<br />
		Você pode selecionar vários grupos usando a tecla <em>Ctrl</em> no seu teclado.<br /><br />
		<em>Além deste parâmetro, o uso da extensão será condicionado pelas permissões de publicação de mensagens.</em>',
	'QUICKQUOTE_REPLY_OVERWRITE'         => 'Substituir o texto da resposta',
	'QUICKQUOTE_REPLY_OVERWRITE_EXPLAIN' => 'Decide se o texto escrito na resposta rápida será substituído ao usar a função <em>Responder</em>.<br />
		Se estiver definido para "Não", a citação será inserida no final do texto.',
]);
