<?php

/**
 * @package Statistics for phpBB.
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
	'ACP_STATISTICS'          => 'Estatísticas do Fórum',
	'LOG_STATISTICS_PRUNED'   => '<strong>Estatísticas do Fórum limpas</strong><br />» %1$.1f segundos usados, %2$.1f linhas por segundo',
	'LOG_STATISTICS_NO_PRUNE' => '<strong>Estatísticas do Fórum</strong><br />» Nenhum registro limpo',
	'STAT_DELETE_SUCCESS'     => 'Tabelas de arquivo esvaziadas',
	'STAT_DELETE_ERROR'       => 'Erro ao esvaziar tabelas de arquivo.',
	'FH_HELPER_NOTICE'        => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	'STATISTICS_NOTICE'       => '<div class="phpinfo"><p class="entry">A configuração desta extensão está em %1$s » %2$s » %3$s.</p></div>',
]);
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral gráfica dos visitantes',
			'DESCRIPTION_2' => 'Possível ver páginas personalizadas',
			'DESCRIPTION_3' => 'Visões gerais online e totais',
			'DESCRIPTION_4' => 'Configurável',
		],
		'note' => [
			'NOTICE_1' => 'Gráficos Highchart',
			'NOTICE_2' => 'Top 10',
			'NOTICE_3' => 'Pronto para phpBB 3.2'
		]
	]
]);
