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
* [ dutch ] language file
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
	'DECIMAL_SEPARATOR_BS'		=> ',',
	'THOUSANDS_SEPARATOR_BS'	=> '.',
	
	'BS_BASIC_STATS'			=> 'Forumstatistieken',
	'BS_DAILY'					=> 'Dagelijks',
	'BS_MONTHLY'				=> 'Maandelijks',
	'BS_YEARLY'					=> 'Jaarlijks',
	'BS_AS_ON'					=> 'Gegenereerd op %s',
	'BS_AVG_POSTS_DAY'			=> 'Berichten per dag',
	'BS_AVG_POSTS_MONTH'		=> 'Berichten per maand',
	'BS_AVG_POSTS_YEAR'			=> 'Berichten per jaar',
	'BS_AVG_TOPICS_DAY'			=> 'Onderwerpen per dag',
	'BS_AVG_TOPICS_MONTH'		=> 'Onderwerpen per maand',
	'BS_AVG_TOPICS_YEAR'		=> 'Onderwerpen per jaar',
	'BS_AVG_USER_REGS_DAY'		=> 'Registraties per dag',
	'BS_AVG_USER_REGS_MONTH'	=> 'Registraties per maand',
	'BS_AVG_USER_REGS_YEAR'		=> 'Registraties per jaar',
	'BS_AVERAGE'				=> 'Gemiddelde',
	'BS_AVERAGE_SHORT'			=> 'Gem.',
	'BS_COUNT'					=> 'Aantal',
	'BS_COUNT_SHORT'			=> 'Aant.',
	'BS_ALL_YEARS'				=> 'Alle jaren',
	'BS_DAY_OF_MONTH_BREAKDOWN'	=> 'Verdeling per dag van de maand',
	'BS_HOURLY_BREAKDOWN'		=> 'Verdeling per uur',
	'BS_MONTH_OF_YEAR_BREAKDOWN'	=> 'Verdeling per maand van het jaar',
	'BS_NONE'					=> 'Geen',
	'BS_OVERALL'				=> 'Algemene statistieken',
	'BS_PEAK_HOUR_TOPICS'		=> 'Piekuur (onderwerpen)',
	'BS_PEAK_HOUR_POSTS'		=> 'Piekuur (berichten)',
	'BS_PEAK_HOUR_USER_REGS'	=> 'Piekuur (registraties)',
	'BS_PERCENT'				=> 'Procent',
	'BS_PERCENT_SHORT'			=> '%',
	'BS_PERIODIC_DAY'			=> 'Dag',
	'BS_PERIODIC_HOUR'			=> 'Uur',
	'BS_PERIODIC_MONTH'			=> 'Maand',
	'BS_PERIODIC_YEAR'			=> 'Jaar',
	'D_VIEW_BS'					=> 'Dagelijkse statistieken',
	'M_VIEW_BS'					=> 'Maandelijkse statistieken',
	'Y_VIEW_BS'					=> 'Jaarlijkse statistieken',
	'BS_STATS_MONTH_EXPLAIN'	=> 'Forumstatistieken voor <strong>%s</strong>',
	'BS_STATS_YEAR_EXPLAIN'		=> 'Forumstatistieken voor <strong>%s</strong>',
	'BS_STATS_YEARLY_EXPLAIN'	=> 'Forumstatistieken voor <strong>alle jaren</strong>',
	'BS_TOPICS'					=> 'Onderwerpen',
	'BS_TOPIC_STATS'			=> 'Onderwerpenstatistieken',
	'BS_POST_STATS'				=> 'Berichtenstatistieken',
	'BS_USER_REG_STATS'			=> 'Registratiestatistieken',
	'BS_TOTAL_POSTS'			=> 'Totaal aantal berichten',
	'BS_TOTAL_TOPICS'			=> 'Totaal aantal onderwerpen',
	'BS_TOTAL_USER_REGS'		=> 'Totaal aantal registraties',
	'BS_USER_REGS'				=> 'Gebruikersregistraties',
	'VIEWONLINE_BASICSTATS'		=> 'Bekijkt forumstatistieken',
	'BS_BASICSTATS_COPY'		=> 'phpBB Forumstatistieken',
	'BS_REQUIRE_PHPBB'			=> 'Deze extensie vereist phpBB %1$s of hoger. Je forum draait %2$s.',
    'BS_REQUIRE_PHP'			=> 'Deze extensie vereist PHP %1$s of hoger. Uw server draait %2$s.',
));
