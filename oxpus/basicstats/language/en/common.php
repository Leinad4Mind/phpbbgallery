<?php

/**
*
* @package phpBB Extension - Basic Stats
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
   	'BASIC_STATS'	=> 'Basic Statistics',
   	'DAILY'			=> 'Daily',
   	'MONTHLY'		=> 'Monthly',
   	'YEARLY'		=> 'Yearly',

	'ALL'					=> 'All',
	'AS_ON'					=> 'As on %s',	
	'AVG_POSTS_DAY'			=> 'Average posts per day',	
	'AVG_POSTS_MONTH'		=> 'Average posts per month',	
	'AVG_POSTS_YEAR'		=> 'Average posts per year',	
	'AVG_TOPICS_DAY'		=> 'Average topics per day',
	'AVG_TOPICS_MONTH'		=> 'Average topics per month',
	'AVG_TOPICS_YEAR'		=> 'Average topics per year',
	'AVG_USER_REGS_DAY'		=> 'Average registrations per day',
	'AVG_USER_REGS_MONTH'	=> 'Average registrations per month',
	'AVG_USER_REGS_YEAR'	=> 'Average registrations per year',
	'COUNT'					=> 'Count',
	'D_VIEW'				=> 'Daily Statistics',
	'M_VIEW'				=> 'Monthly Statistics',
	'NONE'					=> 'None',
	'OVERALL'				=> 'Overall',
	'PERCENT'				=> 'Percent',
	'PERIODIC_DAY'			=> 'Tag',
	'PERIODIC_MONTH'		=> 'Month',
	'PERIODIC_YEAR'			=> 'Year',
	'SHOW_STATS_FOR_MONTH'	=> 'Show statistics for the selected month',
	'SHOW_STATS_FOR_YEAR'	=> 'Show statistics for the selected year',
	'STATS_MONTH_EXPLAIN'	=> 'The following statistics are shown for month of <strong>%s</strong>',
	'STATS_YEAR_EXPLAIN'	=> 'The following statistics are shown for the year <strong>%s</strong>',
	'POSTS_TOTAL'			=> 'Total posts',
	'TOPICS_TOTAL'			=> 'Total topics',
	'TOTAL_USER_REGS'		=> 'Total user registrations',
	'USER_REGS'				=> 'User registrations',
	'Y_VIEW'				=> 'Yearly Statistics',

));
