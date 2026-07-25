<?php
/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2025 Stoker
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/*
* [ spanish (mex) ] language file
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
	$lang = array();
}

$lang = array_merge($lang, array(
	'DECIMAL_BS'				=> '2',
	'DECIMAL_SEPARATOR_BS'		=> '.',
	'THOUSANDS_SEPARATOR_BS'	=> ',',
	
	'BS_BASIC_STATS'			=> 'Estadísticas del sitio',
	'BS_DAILY'					=> 'Diario',
	'BS_MONTHLY'				=> 'Mensual',
	'BS_YEARLY'					=> 'Anual',
	'BS_AS_ON'					=> 'Generado %s',
	'BS_AVG_POSTS_DAY'			=> 'Publicaciones por día',
	'BS_AVG_POSTS_MONTH'		=> 'Publicaciones por mes',
	'BS_AVG_POSTS_YEAR'			=> 'Publicaciones por año',
	'BS_AVG_TOPICS_DAY'			=> 'Temas por día',
	'BS_AVG_TOPICS_MONTH'		=> 'Temas por mes',
	'BS_AVG_TOPICS_YEAR'		=> 'Temas por año',
	'BS_AVG_USER_REGS_DAY'      => 'Registros por día',
	'BS_AVG_USER_REGS_MONTH'    => 'Registros por mes',
	'BS_AVG_USER_REGS_YEAR'     => 'Registros por año',
	'BS_AVERAGE'				=> 'Promedio',
	'BS_AVERAGE_SHORT'			=> 'Prom',
	'BS_COUNT'					=> 'Cantidad',
	'BS_COUNT_SHORT'			=> 'Cant',
	'BS_ALL_YEARS'				=> 'Todos los años',
	'BS_DAY_OF_MONTH_BREAKDOWN'	=> 'Desglose por día del mes',
	'BS_HOURLY_BREAKDOWN'		=> 'Desglose por hora',
	'BS_MONTH_OF_YEAR_BREAKDOWN'	=> 'Desglose por mes del año',
	'BS_NONE'					=> 'Nada',
	'BS_OVERALL'				=> 'Estadísticas generales',
	'BS_PEAK_HOUR_TOPICS'		=> 'Hora pico (temas)',
	'BS_PEAK_HOUR_POSTS'		=> 'Hora pico (publicaciones)',
	'BS_PEAK_HOUR_USER_REGS'	=> 'Hora pico (registraciones)',
	'BS_PERCENT'				=> 'Porcentaje',
	'BS_PERCENT_SHORT'			=> 'Pct',
	'BS_PERIODIC_DAY'			=> 'Día',
	'BS_PERIODIC_HOUR'			=> 'Hora',
	'BS_PERIODIC_MONTH'			=> 'Mes',
	'BS_PERIODIC_YEAR'			=> 'Año',
	'D_VIEW_BS'					=> 'Estadísticas diarias',
	'M_VIEW_BS'					=> 'Estadísticas mensuales',
	'Y_VIEW_BS'					=> 'Estadísticas anuales',
	'BS_STATS_MONTH_EXPLAIN'	=> 'Estadísticas del foro por <strong>%s</strong>',
	'BS_STATS_YEAR_EXPLAIN'		=> 'Estadísticas del foro por <strong>%s</strong>',
	'BS_STATS_YEARLY_EXPLAIN'	=> 'Estadísticas del foro por <strong>todos los años</strong>',
	'BS_TOPICS'					=> 'Temas',
	'BS_TOPIC_STATS'			=> 'Estadísticas de temas',
	'BS_POST_STATS'				=> 'Estadísticas de publicaciones',
	'BS_USER_REG_STATS'			=> 'Estadísticas de registraciones',
	'BS_TOTAL_POSTS'			=> 'Publicaciones totales',
	'BS_TOTAL_TOPICS'			=> 'Temas totales',
	'BS_TOTAL_USER_REGS'		=> 'Registraciones totales',
	'BS_USER_REGS'				=> 'Usuarios registrados',
	'VIEWONLINE_BASICSTATS'		=> 'Viendo estadísticas del foro',
	'BS_BASICSTATS_COPY'		=> 'Estadísticas de foro phpBB',
	'BS_REQUIRE_PHPBB'			=> 'Esta extensión requiere phpBB %1$s o superior. Su servidor está usando %2$s.',
    'BS_REQUIRE_PHP'			=> 'Esta extensión requiere PHP %1$s o superior. Su servidor está usando %2$s.',
));
