<?php

/**
 * Fancy Lazy Topics Loader
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
	'FLTL'               => 'Fancy Lazy Topics loader',
	'FLTL_EXPLAIN'       => 'Role para baixo para ver mais tópicos',
	'FLTL_BY'            => '&nbsp;&#45;&nbsp;Por&nbsp;',
	'FLTL_LIMIT'         => 'Posts a exibir',
	'FLTL_LIMIT_EXPLAIN' => 'Defina o bloco de posts por linha (padrão: 4)',

	'FLTL_TIME'         => 'Limite de Busca de Tópicos',
	'FLTL_TIME_EXPLAIN' => 'Defina a quantidade de dias para buscar tópicos no banco de dados. 0 desabilita o limite.',

	'FLTL_TYPE'         => 'Ordem de Classificação',
	'FLTL_TYPE_EXPLAIN' => 'Exibe a primeira ou a última postagem dos tópicos recentes',

	'FLTL_EXCLUDED_FORUMS'         => 'Excluir fóruns do carregamento (Fancy Lazy Topics loader)',
	'FLTL_EXCLUDED_FORUMS_EXPLAIN' => 'Mantenha a tecla SHIFT ou CTRL pressionada caso deseje para o efeito selecionar vários fóruns',

	'FLTL_READ_MORE'        => 'LER MAIS',
	'FLTL_BACK_TO_START'    => 'VOLTAR AO INÍCIO',
	'FLTL_VIEW_MORE_TOPICS' => 'VISUALIZAR MAIS TÓPICOS'
]);
