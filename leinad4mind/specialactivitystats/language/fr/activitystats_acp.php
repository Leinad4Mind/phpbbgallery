<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 ForumsFaciles
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
	$lang = [];
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'SPECIAL_ACTIVITY_STATS_INSTALLED'				=> 'Version installée : v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'					=> 'Statistiques d’activité',
	'SPECIAL_ACTIVITY_STATS_DISP_SET'				=> 'Paramètres d’affichage',
	'SPECIAL_ACTIVITY_STATS_OTHER'					=> 'Autres paramètres',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Afficher les nouveaux sujets ',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Affiche le nombre de nouveaux sujets.',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Afficher les nouveaux messages ',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Affiche les nouveaux messages.',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Afficher les nouveaux membres ',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Affiche le nombre de nouveaux membres.',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'				=> 'Afficher les robots ',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Certains utilisateurs pourraient s’interroger sur ce que sont les robots et en avoir peur.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'			=> 'Afficher les visiteurs ',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Afficher les visiteurs dans le compteur ?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'			=> 'Afficher les membres masqués ',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Les membres masqués doivent-ils être affichés dans la liste ? (des permissions sont nécessaires).',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'				=> 'Afficher l’heure ',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Visible par tous les utilisateurs ou par personne. Pas de fonction spéciale pour les administrateurs.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Format de la date ',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'				=> 'Afficher au survol de la souris',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'				=> 'Afficher l’IP de l’utilisateur ',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'			=> 'Uniquement pour les membres avec des permissions d’administration, tout comme sur la page viewonline.php.',

	'SPECIAL_ACTIVITY_STATS_RECORD'					=> 'Record ',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'				=> 'Afficher et enregistrer le record.',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Format de la date pour le record ',
	'SPECIAL_ACTIVITY_STATS_RESET'					=> 'Réinitialiser le record ',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'				=> 'Réinitialise l’heure et le compteur du record des statistiques d’activité.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'				=> 'Si vous validez ce formulaire, le record sera réinitialisé.',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Configuration mise à jour avec succès.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'				=> 'Trier les utilisateurs selon leur ',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'			=> 'Dans quel ordre les utilisateurs doivent-ils être affichés ?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'				=> 'nom d’utilisateur A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'				=> 'nom d’utilisateur Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'				=> 'heure de visite croissante',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'				=> 'heure de visite décroissante',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'				=> 'ID d’utilisateur croissant',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'				=> 'ID d’utilisateur décroissant',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'				=> 'Durée du cache en secondes ',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Durée pendant laquelle les données ne sont pas recalculées (améliore les performances).',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Vérifier les permissions ',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'Non = tout le monde peut consulter les statistiques d’activité (sans tenir compte des permissions); Oui = utilisation des permissions (ex. : autoriser uniquement les utilisateurs enregistrés : PCA -> permissions -> permissions globales -> permissions des groupes -> utilisateurs enregistrés -> permissions avancées -> divers -> « peut consulter les statistiques d’activité »).',

	'SPECIAL_ACTIVITY_STATS_MODE'					=> 'Affichage des utilisateurs ',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'				=> 'Afficher les utilisateurs d’aujourd’hui (depuis minuit, selon le fuseau horaire du forum), ou de la période de temps définie dans l’option suivante.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'				=> 'Aujourd’hui',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'			=> 'Période de temps ',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'mettez 0, si vous souhaitez afficher les utilisateurs des dernières 24 heures',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'désactivé, si vous avez choisi « aujourd’hui »',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'secondes',

]);
