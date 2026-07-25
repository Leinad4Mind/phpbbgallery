<?php
/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2025 Stoker
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @copyright (c) 2025 french translation by Fred Rimbert https://forums.caforum.fr
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/*
* [ french ] language file
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
	
	'BS_BASIC_STATS'			=> 'Statistiques du forum',
	'BS_DAILY'					=> 'Quotidiennes',
	'BS_MONTHLY'				=> 'Mensuelles',
	'BS_YEARLY'				    => 'Annuelles',
	'BS_AS_ON'					=> 'Généré le %s',
	'BS_AVG_POSTS_DAY'			=> 'Messages par jour',
	'BS_AVG_POSTS_MONTH'		=> 'Messages par mois',
	'BS_AVG_POSTS_YEAR'		    => 'Messages par an',
	'BS_AVG_TOPICS_DAY'		    => 'Sujets par jour',
	'BS_AVG_TOPICS_MONTH'		=> 'Sujets par mois',
	'BS_AVG_TOPICS_YEAR'		=> 'Sujets par an',
	'BS_AVG_USER_REGS_DAY'		=> 'Inscriptions par jour',
	'BS_AVG_USER_REGS_MONTH'	=> 'Inscriptions par mois',
	'BS_AVG_USER_REGS_YEAR'	    => 'Inscriptions par an',
	'BS_AVERAGE'				=> 'Moyenne',
	'BS_AVERAGE_SHORT'			=> 'Moy.',
	'BS_COUNT'					=> 'Total',
	'BS_COUNT_SHORT'			=> 'Total',
	'BS_ALL_YEARS'				=> 'Toutes les années',
	'BS_DAY_OF_MONTH_BREAKDOWN'	=> 'Répartition par jour du mois',
	'BS_HOURLY_BREAKDOWN'		=> 'Répartition horaire',
	'BS_MONTH_OF_YEAR_BREAKDOWN'	=> 'Répartition par mois de l’année',
	'BS_NONE'					=> 'Aucune',
	'BS_OVERALL'				=> 'Statistiques globales',
	'BS_PEAK_HOUR_TOPICS'		=> 'Heure de pointe (sujets)',
	'BS_PEAK_HOUR_POSTS'		=> 'Heure de pointe (messages)',
	'BS_PEAK_HOUR_USER_REGS'	=> 'Heure de pointe (inscriptions)',
	'BS_PERCENT'				=> 'Pourcentage',
	'BS_PERCENT_SHORT'			=> 'p.c.',	
	'BS_PERIODIC_DAY'			=> 'Jour',
	'BS_PERIODIC_HOUR'			=> 'Heure',
	'BS_PERIODIC_MONTH'		    => 'Mois',
	'BS_PERIODIC_YEAR'			=> 'An',	
	'D_VIEW_BS'				    => 'Statistiques journalières',
	'M_VIEW_BS'				    => 'Statistiques mensuelles',
	'Y_VIEW_BS'				    => 'Statistiques annuelles',
	'BS_STATS_MONTH_EXPLAIN'	=> 'Les statistiques suivantes concernent le mois en cours, <strong>%s</strong>',
	'BS_STATS_YEAR_EXPLAIN'	    => 'Les statistiques suivantes concernent l’année <strong>%s</strong>',
	'BS_STATS_YEARLY_EXPLAIN'	=> 'Les statistiques suivantes concernent <strong>toutes les années</strong>',	
	'BS_TOPICS'				    => 'Sujets',
	'BS_TOPIC_STATS'			=> 'Statistiques de sujet',
	'BS_POST_STATS'			    => 'Statistiques de message',
	'BS_USER_REG_STATS'		    => 'Statistiques des inscriptions',
	'BS_TOTAL_POSTS'			=> 'Total des messages',
	'BS_TOTAL_TOPICS'		    => 'Total des sujets',
	'BS_TOTAL_USER_REGS'		=> 'Total des inscriptions',
	'BS_USER_REGS'				=> 'Inscriptions des utilisateurs',
	'VIEWONLINE_BASICSTATS'	    => 'Affichage des statistiques du forum',
	'BS_BASICSTATS_COPY'		=> 'Statistiques du forum phpBB',
	'BS_REQUIRE_PHPBB'			=> 'Cette extension nécessite phpBB %1$s ou supérieur. Votre forum utilise %2$s.',
    'BS_REQUIRE_PHP'			=> 'Cette extension nécessite PHP %1$s ou supérieur. Votre serveur exécute %2$s.',
));
