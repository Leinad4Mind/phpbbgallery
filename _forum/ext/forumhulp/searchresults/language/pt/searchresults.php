<?php

/**
 * @package Search Results for phpBB.
 * @copyright (c) 2014 ForumHulp.com
 * @license https://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_SR_MANAGE_EXPLAIN' => 'Exibe as palavras-chave pesquisadas pelos visitantes.<br />Podes ordenar por palavra-chave, visitas e data da primeira ou última visita. O limite configurado nas funcionalidades do Fórum conserva os termos mais pesquisados e recentes.',
	'SEARCHWORD'            => 'Palavra(s)-chave',
	'REF_HITS'              => 'Visitas',
	'REF_FIRST'             => 'Primeira visita',
	'REF_LAST'              => 'Última visita',
	'FOUND'                 => 'Encontrado',
	'NOTFOUND'              => 'Não encontrado',
]);
