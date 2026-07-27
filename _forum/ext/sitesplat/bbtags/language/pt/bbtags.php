<?php

/**
 * BBtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBTAGS'              => 'Tags',
	'BBTAGS_AUTO_SUGGEST' => 'Sugestão Automática',
	'BBTAGS_TAG_SPEC'     => 'caracteres: [a-z 0-9 + # - .] Separa as tags por ponto e vírgula, vírgula ou pressiona enter',

	'BBTAGS_ENTER_TAGS_PLACEHOLDER' => 'Introduz as tags...',
	'BBTAGS_SEARCH_TAGS'            => 'Pesquisar por tags',
	'BBTAGS_SEARCH_OPERATOR'        => 'Modo de correspondencia das tags',
	'BBTAGS_MATCH_ALL'              => 'Corresponder a todas as tags',
	'BBTAGS_MATCH_ANY'              => 'Corresponder a qualquer tag',
	'TOPICTIME'                     => 'Tempo de atividade do tópico',
]);
