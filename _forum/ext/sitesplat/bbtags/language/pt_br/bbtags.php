<?php

/**
 * BBtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBTAGS'               => 'Tags',
	'POSTING_TAGS'         => 'Tags do Tópico',
	'POSTING_TAGS_EXPLAIN' => 'Insira as tags separadas por vírgula.',
	'TAG_SEARCH_RESULTS'   => 'Resultados para a tag %s',
]);
