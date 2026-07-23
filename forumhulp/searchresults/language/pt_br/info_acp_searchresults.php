<?php

/**
 * @package Search Results for phpBB.
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
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
	'ACP_SEARCHRESULTS'           => 'Resultados de pesquisa',
	'PRUNE_SEARCHRESULTS'         => 'Limpar Resultados de Pesquisa',
	'PRUNE_SEARCHRESULTS_EXPLAIN' => 'Máximo de registros na tabela de resultados de pesquisa antes da limpeza, 0 desativará esta função.',
	'LOG_SR_REMOVED'              => '<strong>Limpeza de resultados de pesquisa</strong><br />» Resultados de pesquisa (%1$s), %2$s registros',
	'LOG_SR_REMOVED_ALL'          => '<strong>Resultados de pesquisa purgados</strong>',
	'FH_HELPER_NOTICE'            => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	'SEARCHRESULTS_NOTICE'        => '<div class="phpinfo"><p class="entry">Esta extensão reside em %1$s » %2$s » %3$s.<br>As definições de configuração estão em %4$s » %5$s » %6$s.</p></div>',
]);
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Ordenável',
			'DESCRIPTION_2' => 'Limpeza automática de registros antigos',
			'DESCRIPTION_3' => 'Agrupado em encontrado e não encontrado na mensagem',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para phpBB 3.2'
		]
	]
]);
