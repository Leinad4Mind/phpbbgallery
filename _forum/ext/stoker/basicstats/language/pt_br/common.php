<?php

/**
 *
 * @package phpBB Extension - Basic Stats
 * @copyright (c) 2025 Stoker
 * @copyright (c) 2015 OXPUS - www.oxpus.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 *
 */

/*
* [ portuguese (brazilian) ] language file
*/

/**
 * DO NOT CHANGE
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
	'DECIMAL_BS'				=> '2',
	'DECIMAL_SEPARATOR_BS'		=> ',',
	'THOUSANDS_SEPARATOR_BS'	=> '.',

	'BS_BASIC_STATS'			=> 'Estatísticas do Fórum',
	'BS_DAILY'					=> 'Diárias',
	'BS_MONTHLY'				=> 'Mensais',
	'BS_YEARLY'					=> 'Anuais',
	'BS_AS_ON'					=> 'Gerado em %s',
	'BS_AVG_POSTS_DAY'			=> 'Postagens por dia',
	'BS_AVG_POSTS_MONTH'		=> 'Postagens por mês',
	'BS_AVG_POSTS_YEAR'			=> 'Postagens por ano',
	'BS_AVG_TOPICS_DAY'			=> 'Tópicos por dia',
	'BS_AVG_TOPICS_MONTH'		=> 'Tópicos por mês',
	'BS_AVG_TOPICS_YEAR'		=> 'Tópicos por ano',
	'BS_AVG_USER_REGS_DAY'		=> 'Registros por dia',
	'BS_AVG_USER_REGS_MONTH'	=> 'Registros por mês',
	'BS_AVG_USER_REGS_YEAR'		=> 'Registros por ano',
	'BS_AVERAGE'				=> 'Média',
	'BS_AVERAGE_SHORT'			=> 'Méd.',
	'BS_COUNT'					=> 'Contagem',
	'BS_COUNT_SHORT'			=> 'Cont.',
	'BS_ALL_YEARS'				=> 'Todos os anos',
	'BS_DAY_OF_MONTH_BREAKDOWN'	=> 'Detalhamento por Dia do Mês',
	'BS_HOURLY_BREAKDOWN'		=> 'Detalhamento por Hora',
	'BS_MONTH_OF_YEAR_BREAKDOWN'	=> 'Detalhamento por Mês do Ano',
	'BS_NONE'					=> 'Nenhum',
	'BS_OVERALL'				=> 'Estatísticas Gerais',
	'BS_PEAK_HOUR_TOPICS'		=> 'Hora de pico (tópicos)',
	'BS_PEAK_HOUR_POSTS'		=> 'Hora de pico (postagens)',
	'BS_PEAK_HOUR_USER_REGS'	=> 'Hora de pico (registros)',
	'BS_PERCENT'				=> 'Porcentagem',
	'BS_PERCENT_SHORT'			=> 'Pct.',
	'BS_PERIODIC_DAY'			=> 'Dia',
	'BS_PERIODIC_HOUR'			=> 'Hora',
	'BS_PERIODIC_MONTH'			=> 'Mês',
	'BS_PERIODIC_YEAR'			=> 'Ano',
	'D_VIEW_BS'					=> 'Estatísticas Diárias',
	'M_VIEW_BS'					=> 'Estatísticas Mensais',
	'Y_VIEW_BS'					=> 'Estatísticas Anuais',
	'BS_STATS_MONTH_EXPLAIN'	=> 'Estatísticas do fórum para <strong>%s</strong>',
	'BS_STATS_YEAR_EXPLAIN'		=> 'Estatísticas do fórum para <strong>%s</strong>',
	'BS_STATS_YEARLY_EXPLAIN'	=> 'Estatísticas do fórum para <strong>todos os anos</strong>',
	'BS_TOPICS'					=> 'Tópicos',
	'BS_TOPIC_STATS'			=> 'Estatísticas de Tópicos',
	'BS_POST_STATS'				=> 'Estatísticas de Postagens',
	'BS_USER_REG_STATS'			=> 'Estatísticas de Registros',
	'BS_TOTAL_POSTS'			=> 'Total de postagens',
	'BS_TOTAL_TOPICS'			=> 'Total de tópicos',
	'BS_TOTAL_USER_REGS'		=> 'Total de registros',
	'BS_USER_REGS'				=> 'Registros de usuários',
	'VIEWONLINE_BASICSTATS'		=> 'Vendo as Estatísticas do Fórum',
	'BS_BASICSTATS_COPY'		=> 'Estatísticas do Fórum phpBB',
	'BS_REQUIRE_PHPBB'			=> 'Esta extensão requer o phpBB %1$s ou superior. Seu fórum está utilizando a versão %2$s.',
	'BS_REQUIRE_PHP'			=> 'Esta extensão requer o PHP %1$s ou superior. Seu servidor está utilizando a versão %2$s.',
]);
