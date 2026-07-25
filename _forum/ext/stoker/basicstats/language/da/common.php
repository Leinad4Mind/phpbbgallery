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
* [ danish ] language file
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
	
	'BS_BASIC_STATS'			=> 'Forum Statistikker',
	'BS_DAILY'					=> 'Daglig',
	'BS_MONTHLY'				=> 'Månedlig',
	'BS_YEARLY'					=> 'Årlig',
	'BS_AS_ON'					=> 'Genereret %s',
	'BS_AVG_POSTS_DAY'			=> 'Indlæg per dag',
	'BS_AVG_POSTS_MONTH'		=> 'Indlæg per måned',
	'BS_AVG_POSTS_YEAR'			=> 'Indlæg per år',
	'BS_AVG_TOPICS_DAY'			=> 'Emner per dag',
	'BS_AVG_TOPICS_MONTH'		=> 'Emner per måned',
	'BS_AVG_TOPICS_YEAR'		=> 'Emner per år',
	'BS_AVG_USER_REGS_DAY'		=> 'Tilmeldinger per dag',
	'BS_AVG_USER_REGS_MONTH'	=> 'Tilmeldinger per måned',
	'BS_AVG_USER_REGS_YEAR'		=> 'Tilmeldinger per år',
	'BS_COUNT'					=> 'Antal',
	'BS_COUNT_SHORT'			=> 'Antal',
	'BS_ALL_YEARS'				=> 'Alle år',
	'BS_NONE'					=> 'Ingen',
	'BS_OVERALL'				=> 'Overall Statistikker',
	'BS_PERCENT'				=> 'Procent',
	'BS_PERCENT_SHORT'			=> 'Pct',
	'BS_PERIODIC_DAY'			=> 'Dag',
	'BS_PERIODIC_MONTH'			=> 'Måned',
	'BS_PERIODIC_YEAR'			=> 'År',
	'D_VIEW_BS'					=> 'Daglige Statistikker',
	'M_VIEW_BS'					=> 'Månedlige Statistikker',
	'Y_VIEW_BS'					=> 'Årlige Statistikker',
	'BS_STATS_MONTH_EXPLAIN'	=> 'Følgende Statistikker er vist for <strong>%s</strong> måned',
	'BS_STATS_YEAR_EXPLAIN'		=> 'Følgende Statistikker er vist for år <strong>%s</strong>',
	'BS_STATS_YEARLY_EXPLAIN'	=> 'Følgende Statistikker er vist for <strong>alle år</strong>',
	'BS_TOPICS'					=> 'Emner',
	'BS_TOPIC_STATS'			=> 'Emne Statistikker',
	'BS_POST_STATS'				=> 'Indlæg Statistikker',
	'BS_USER_REG_STATS'			=> 'Tilmeldings Statistikker',
	'BS_TOTAL_POSTS'			=> 'Indlæg ialt',
	'BS_TOTAL_TOPICS'			=> 'Emner ialt',
	'BS_TOTAL_USER_REGS'		=> 'Tilmeldinger ialt',
	'BS_USER_REGS'				=> 'Tilmeldinger',
	'VIEWONLINE_BASICSTATS'		=> 'Læser Forum Statistikker',
	'BS_BASICSTATS_COPY'		=> 'phpBB Forum Statistikker',
	'BS_REQUIRE_PHPBB'			=> 'Denne extension kræver phpBB %1$s eller højere. Dit forum kører %2$s.',
    'BS_REQUIRE_PHP'			=> 'Denne extension kræver PHP %1$s eller højere. Din server kører %2$s.',
));
