<?php

/**
 * Fancy Lazy Topics Loader
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'FLTL_EXPLAIN'       => 'Desce para veres mais tópicos',
	'FLTL_BY'            => '&nbsp;&#45;&nbsp;Por&nbsp;',
	'FLTL_LIMIT'         => 'Publicações a exibir',
	'FLTL_LIMIT_EXPLAIN' => 'Define o bloco de publicações por cada linha (padrão: 4)',

	'FLTL_TIME'         => 'Limite de Obtenção de Tópicos',
	'FLTL_TIME_EXPLAIN' => 'Define a quantidade de dias até quando recuar na obtenção de tópicos da base de dados. 0 desactiva o limite.',

	'FLTL_TYPE'         => 'Ordem de Classificação',
	'FLTL_TYPE_EXPLAIN' => 'Exibe a primeira ou a última publicação dos tópicos recentes',

	'FLTL_EXCLUDED_FORUMS'         => 'Excluir fóruns do carregamento (Fancy Lazy Topics loader)',
	'FLTL_EXCLUDED_FORUMS_EXPLAIN' => 'Mantém pressionada a tecla SHIFT ou CTRL caso queiras seleccionar vários fóruns',

	'FLTL_READ_MORE'        => 'LER MAIS',
	'FLTL_BACK_TO_START'    => 'VOLTAR AO INÍCIO',
	'FLTL_VIEW_MORE_TOPICS' => 'VISUALIZAR MAIS TÓPICOS'
]);
