<?php

/**
 * @package Search Results for phpBB.
 * @copyright (c) 2014 ForumHulp.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_SEARCHRESULTS'     => 'Resultados de pesquisa',
	'ACP_SR_MANAGE'         => 'Resultados de pesquisa',
	'ACP_SR_MANAGE_EXPLAIN' => 'Exibe uma lista de palavras-chave pesquisadas pelos seus visitantes.<br />Pode ordenar por palavra-chave, visitas e data da primeira e última visita. Uma tarefa eliminará registros onde a última visita for mais antiga que x dias, ajustável nas funcionalidades do Fórum.',
	'SEARCHWORD'            => 'Palavra(s)-chave',
	'REF_HITS'              => 'Visitas',
	'REF_FIRST'             => 'Primeira visita',
	'REF_LAST'              => 'Última visita',
	'FOUND'                 => 'Encontrado',
	'NOTFOUND'              => 'Não encontrado',
]);
