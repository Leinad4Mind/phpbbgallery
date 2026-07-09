<?php
/**
*
* Basic Stats extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com)
*
* @copyright (c) 2017 OXPUS <http://www.oxpus.net>
* @license GNU General Public License, version 2 (GPL-2.0)
*
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
   	'BASIC_STATS'	=> 'Statistiques',
   	'DAILY'			=> 'Quotidiennes',
   	'MONTHLY'		=> 'Mensuelles',
   	'YEARLY'		=> 'Annuelles',

	'ALL'					=> 'Tous',
	'AS_ON'					=> 'Nous sommes le %s',	
	'AVG_POSTS_DAY'			=> 'Moyenne quotidienne de messages',	
	'AVG_POSTS_MONTH'		=> 'Moyenne mensuelle de messages',	
	'AVG_POSTS_YEAR'		=> 'Moyenne annuelle de messages',	
	'AVG_TOPICS_DAY'		=> 'Moyenne quotidienne de sujets',
	'AVG_TOPICS_MONTH'		=> 'Moyenne mensuelle de sujets',
	'AVG_TOPICS_YEAR'		=> 'Moyenne annuelle de sujets',
	'AVG_USER_REGS_DAY'		=> 'Moyenne quotidienne de nouveaux membres',
	'AVG_USER_REGS_MONTH'	=> 'Moyenne mensuelle de nouveaux membres',
	'AVG_USER_REGS_YEAR'	=> 'Moyenne annuelle de nouveaux membres',
	'COUNT'					=> 'Total',
	'D_VIEW'				=> 'Statistiques journaliers',
	'M_VIEW'				=> 'Statistiques mensuelles',
	'NONE'					=> 'Aucun',
	'OVERALL'				=> 'Vue d’ensemble',
	'PERCENT'				=> 'Pourcentage',
	'PERIODIC_DAY'			=> 'Jour',
	'PERIODIC_MONTH'		=> 'Mois',
	'PERIODIC_YEAR'			=> 'Année',
	'SHOW_STATS_FOR_MONTH'	=> 'Afficher les statistiques du mois sélectionné',
	'SHOW_STATS_FOR_YEAR'	=> 'Afficher les statistiques de l’année sélectionnée',
	'STATS_MONTH_EXPLAIN'	=> 'Les statistiques suivantes concernent le mois de <strong>%s</strong>',
	'STATS_YEAR_EXPLAIN'	=> 'Les statistiques suivantes concernent l’année <strong>%s</strong>',
	'POSTS_TOTAL'			=> 'Total de messages',
	'TOPICS_TOTAL'			=> 'Total de sujets',
	'TOTAL_USER_REGS'		=> 'Total de nouveaux membres',
	'USER_REGS'				=> 'Nouveaux membres',
	'Y_VIEW'				=> 'Statistiques annuelles',

));
