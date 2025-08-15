<?php

/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/*
* [ german ] language file
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
   	'BASIC_STATS'	=> 'Basis Statistiken',
   	'DAILY'			=> 'Tagesdaten',
   	'MONTHLY'		=> 'Monatssummen',
   	'YEARLY'		=> 'Jahreswerte',

	'ALL'					=> 'Alle',
	'AS_ON'					=> 'Stand %s',	
	'AVG_POSTS_DAY'			=> 'Durchschnittliche Beiträge pro Tag',	
	'AVG_POSTS_MONTH'		=> 'Durchschnittliche Beiträge pro Monat',	
	'AVG_POSTS_YEAR'		=> 'Durchschnittliche Beiträge pro Jahr',	
	'AVG_TOPICS_DAY'		=> 'Durchschnittliche Themen pro Tag',
	'AVG_TOPICS_MONTH'		=> 'Durchschnittliche Themen pro Monat',
	'AVG_TOPICS_YEAR'		=> 'Durchschnittliche Themen pro Jahr',
	'AVG_USER_REGS_DAY'		=> 'Durchschnittliche Registrierungen pro Tag',
	'AVG_USER_REGS_MONTH'	=> 'Durchschnittliche Registrierungen pro Monat',
	'AVG_USER_REGS_YEAR'	=> 'Durchschnittliche Registrierungen pro Jahr',
	'COUNT'					=> 'Anzahl',
	'D_VIEW'				=> 'Tagesstatistiken',
	'M_VIEW'				=> 'Monatliche Statistiken',
	'NONE'					=> 'Keine',
	'OVERALL'				=> 'Gesamt',
	'PERCENT'				=> 'Prozent',
	'PERIODIC_DAY'			=> 'Tag',
	'PERIODIC_MONTH'		=> 'Monat',
	'PERIODIC_YEAR'			=> 'Jahr',
	'SHOW_STATS_FOR_MONTH'	=> 'Zeige Statistik für den gewählten Monat',
	'SHOW_STATS_FOR_YEAR'	=> 'Zeige Statistik für das gewählte Jahr',
	'STATS_MONTH_EXPLAIN'	=> 'Die folgenden Statistiken zeigen den Monat <strong>%s</strong>',
	'STATS_YEAR_EXPLAIN'	=> 'Die folgenden Statistiken zeigen das Jahr <strong>%s</strong>',
	'POSTS_TOTAL'			=> 'Gesamtanzahl Beiträge',
	'TOPICS_TOTAL'			=> 'Gesamtanzahl Themen',
	'TOTAL_USER_REGS'		=> 'Gesamtanzahl Benutzerregistrierungen',
	'USER_REGS'				=> 'Benutzerregistrierungen',
	'Y_VIEW'				=> 'Jahresstatistiken',

));
