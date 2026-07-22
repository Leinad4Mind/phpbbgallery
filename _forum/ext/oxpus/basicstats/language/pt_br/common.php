<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'BASIC_STATS'          => 'Estatísticas Básicas',
	'DAILY'                => 'Diárias',
	'MONTHLY'              => 'Mensais',
	'YEARLY'               => 'Anuais',
	'ALL'                  => 'Todos',
	'AS_ON'                => 'Em %s',
	'AVG_POSTS_DAY'        => 'Média de mensagens por dia',
	'AVG_POSTS_MONTH'      => 'Média de mensagens por mês',
	'AVG_POSTS_YEAR'       => 'Média de mensagens por ano',
	'AVG_TOPICS_DAY'       => 'Média de tópicos por dia',
	'AVG_TOPICS_MONTH'     => 'Média de tópicos por mês',
	'AVG_TOPICS_YEAR'      => 'Média de tópicos por ano',
	'AVG_USER_REGS_DAY'    => 'Média de registros por dia',
	'AVG_USER_REGS_MONTH'  => 'Média de registros por mês',
	'AVG_USER_REGS_YEAR'   => 'Média de registros por ano',
	'COUNT'                => 'Contagem',
	'D_VIEW'               => 'Estatísticas Diárias',
	'M_VIEW'               => 'Estatísticas Mensais',
	'NONE'                 => 'Nenhum',
	'OVERALL'              => 'Geral',
	'PERCENT'              => 'Porcentagem',
	'PERIODIC_DAY'         => 'Dia',
	'PERIODIC_MONTH'       => 'Mês',
	'PERIODIC_YEAR'        => 'Ano',
	'SHOW_STATS_FOR_MONTH' => 'Mostrar estatísticas para o mês selecionado',
	'SHOW_STATS_FOR_YEAR'  => 'Mostrar estatísticas para o ano selecionado',
	'STATS_MONTH_EXPLAIN'  => 'As seguintes estatísticas são mostradas para o mês de <strong>%s</strong>',
	'STATS_YEAR_EXPLAIN'   => 'As seguintes estatísticas são mostradas para o ano de <strong>%s</strong>',
	'POSTS_TOTAL'          => 'Total de mensagens',
	'TOPICS_TOTAL'         => 'Total de tópicos',
	'TOTAL_USER_REGS'      => 'Total de registros de usuários',
	'USER_REGS'            => 'Registros de usuários',
	'Y_VIEW'               => 'Estatísticas Anuais',
]);
