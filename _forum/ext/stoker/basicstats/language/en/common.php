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
* [ english ] language file
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
	
	'BS_BASIC_STATS'			=> 'Board Statistics',
	'BS_DAILY'					=> 'Daily',
	'BS_MONTHLY'				=> 'Monthly',
	'BS_YEARLY'					=> 'Yearly',
	'BS_AS_ON'					=> 'Generated %s',
	'BS_AVG_POSTS_DAY'			=> 'Posts per day',
	'BS_AVG_POSTS_MONTH'		=> 'Posts per month',
	'BS_AVG_POSTS_YEAR'			=> 'Posts per year',
	'BS_AVG_TOPICS_DAY'			=> 'Topics per day',
	'BS_AVG_TOPICS_MONTH'		=> 'Topics per month',
	'BS_AVG_TOPICS_YEAR'		=> 'Topics per year',
	'BS_AVG_USER_REGS_DAY'		=> 'Registrations per day',
	'BS_AVG_USER_REGS_MONTH'	=> 'Registrations per month',
	'BS_AVG_USER_REGS_YEAR'		=> 'Registrations per year',
	'BS_COUNT'					=> 'Count',
	'BS_COUNT_SHORT'			=> 'Cnt',
	'BS_ALL_YEARS'				=> 'All years',
	'BS_NONE'					=> 'None',
	'BS_OVERALL'				=> 'Overall Statistics',
	'BS_PERCENT'				=> 'Percent',
	'BS_PERCENT_SHORT'			=> 'Pct',
	'BS_PERIODIC_DAY'			=> 'Day',
	'BS_PERIODIC_MONTH'			=> 'Month',
	'BS_PERIODIC_YEAR'			=> 'Year',
	'D_VIEW_BS'					=> 'Daily Statistics',
	'M_VIEW_BS'					=> 'Monthly Statistics',
	'Y_VIEW_BS'					=> 'Yearly Statistics',
	'BS_STATS_MONTH_EXPLAIN'	=> 'Board Statistics for <strong>%s</strong>',
	'BS_STATS_YEAR_EXPLAIN'		=> 'Board Statistics for <strong>%s</strong>',
	'BS_STATS_YEARLY_EXPLAIN'	=> 'Board Statistics for <strong>all years</strong>',
	'BS_TOPICS'					=> 'Topics',
	'BS_TOPIC_STATS'			=> 'Topic Statistics',
	'BS_POST_STATS'				=> 'Post Statistics',
	'BS_USER_REG_STATS'			=> 'Registrations Statistics',
	'BS_TOTAL_POSTS'			=> 'Total posts',
	'BS_TOTAL_TOPICS'			=> 'Total topics',
	'BS_TOTAL_USER_REGS'		=> 'Total registrations',
	'BS_USER_REGS'				=> 'User registrations',
	'VIEWONLINE_BASICSTATS'		=> 'Viewing Board Statistics',
	'BS_BASICSTATS_COPY'		=> 'phpBB Board Statistics',
	'BS_REQUIRE_PHPBB'			=> 'This extension requires phpBB %1$s or higher. Your board is running %2$s.',
    'BS_REQUIRE_PHP'			=> 'This extension requires PHP %1$s or higher. Your server is running %2$s.',
));
