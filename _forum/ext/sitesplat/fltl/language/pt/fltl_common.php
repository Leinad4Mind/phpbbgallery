<?php

/**
 * Fancy Lazy Topics Loader
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

	'FLTL_EXCLUDED_FORUMS'         => 'Excluir fóruns do carregamento (Fancy Lazy Topics loader)',
	'FLTL_EXCLUDED_FORUMS_EXPLAIN' => 'Mantenha a tecla SHIFT ou CTRL pressionada caso deseje para o efeito selecionar vários fóruns',

	'FLTL_READ_MORE'        => 'LER MAIS',
	'FLTL_BACK_TO_START'    => 'VOLTAR AO INÍCIO',
	'FLTL_VIEW_MORE_TOPICS' => 'VISUALIZAR MAIS TÓPICOS'
]);
