<?php
/**
*
* Advanced Polls extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com) & Chouf (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1352822)
*
* @copyright (c) 2015 Clemens Husung (Wolfsblvt) <www.pinkes-forum.de>
* @copyright (c) 2026 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'AP_TITLE_ACP'    => 'Sondages avancés',
	'AP_SETTINGS_ACP' => 'Paramètres',

	'AP_TITLE'         => 'Sondages avancés',
	'AP_TITLE_EXPLAIN' => 'Système avancé des sondages de phpBB comportant de nouvelles fonctionnalités telles que les votes masqués jusqu’à la fin, l’affichage du nom des votants, la restriction de votes et davantage.',

	'AP_SETTINGS'          => 'Paramètres des sondages avancés',
	'AP_GLOBAL_SETTINGS'   => 'Paramètres globaux des sondages avancés (s’applique à tous les sondages)',
	'AP_PER_POLL_SETTINGS' => 'Paramètres des sondages avancés par sondage (sélectionnable par sondage, comportant une valeur par défaut définie ici)',
	'AP_DEFAULT_POLL_VISIBILITY' => 'Visibilité par défaut des résultats',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Mode de visibilité sélectionné initialement lors de la création d’un sondage.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'Mode par défaut de modification du vote',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'Mode de modification du vote sélectionné initialement lors de la création d’un sondage.',
	'AP_VISIBILITY_PUBLIC' => 'Public — toujours afficher les résultats',
	'AP_VISIBILITY_DEFAULT' => 'Après le premier vote',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Après utilisation de tous les votes disponibles',
	'AP_VISIBILITY_PRIVATE' => 'Privé — uniquement après la fin du sondage',
	'AP_VOTE_MODE_NO_CHANGE' => 'Aucune modification',
	'AP_VOTE_MODE_INCREMENTAL' => 'Vote progressif',
	'AP_VOTE_MODE_CHANGE' => 'Autoriser les modifications',

	'AP_ACT_VOTES_HIDE'                 => 'Activer les votes masqués',
	'AP_ACT_VOTES_HIDE_EXPLAIN'         => 'Active l’option permettant de masquer les votes jusqu’à la fin du sondage.',
	'AP_ACT_VOTERS_SHOW'                => 'Activer l’affichage du nom des votants',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'        => 'Active l’option permettant de voir le nom des votants pour chacune des options du sondage.',
	'AP_ACT_VOTERS_LIMIT'               => 'Activer la restriction des votes',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'       => 'Active l’option permettant de restreindre les votes aux participants de ce sujet.',
	'AP_ACT_POLL_NO_VOTE'               => 'Activer le choix non votant',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'       => 'Ajoute au texte du lien « Voir les résultats » le texte précédent « Ne souhaite pas voter, », ne permettant pas de voter après avoir vu les résultats sauf si l’option « Permettre de voter à nouveau » est cochée.',
	'AP_ACT_SHOW_ABSTAINERS' => 'Afficher le nombre d’abstentions',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'Affiche le nombre d’utilisateurs inscrits ayant explicitement choisi de ne pas voter. Les noms ne sont affichés que si la liste des votants est activée et si l’utilisateur dispose de la permission.',
	'AP_ACT_VOTE_DELETE' => 'Autoriser la suppression du vote',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'Permet aux utilisateurs inscrits de supprimer leur propre vote tant que le sondage est ouvert et autorise les modifications.',
	'AP_ACT_SHOW_ORDERED'               => 'Activer le tri des votes',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'       => 'Active l’option permettant d’afficher les résultats triés par ordre décroissant du nombre de votes reçus (le plus de votes en premier).',
	'AP_ACT_POLL_SCORING'               => 'Activer la notation aux sondages',
	'AP_ACT_POLL_SCORING_EXPLAIN'       => 'Active la possibilité d’assigner différents scores aux options du sondage.',
	'AP_ACT_INCREMENTAL_VOTES'          => 'Activer le vote progressif',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'  => 'Active la possibilité de voter suivant ses capacités de vote disponibles.',
	'AP_ACT_CLOSED_VOTING'              => 'Activer le vote fermé',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'      => 'Active la possibilité de voter à un sondage ouvert, même si le sujet correspondant est verrouillé.',
	'AP_ACT_POLL_END'                   => 'Activer la fin du sondage',
	'AP_ACT_POLL_END_EXPLAIN'           => 'Permet de spécifier la date et l’heure de fin du sondage, en lieu et place d’une durée.',
	'AP_ACT_POLL_NOTIFICATIONS'         => 'Activer les notifications de sondage',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN' => 'Active l’envoi de notifications à tous les votants d’un sondage masqué lorsque celui-ci est terminé, indiquant que les résultats sont disponibles.',
	'AP_ACT_POLL_COLLAPSIBLE' => 'Activer les sondages réductibles',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN' => 'Affiche l’option réductible lors de la création ou de la modification d’un sondage. À l’installation, ce réglage est activé automatiquement si « Collapsible Forum Categories » est installé ; les administrateurs peuvent toujours le modifier.',

	'AP_DEFAULT_VOTES_CHANGE' => 'Paramètre par défaut pour le changement des votes',
	'AP_DEFAULT_VOTES_HIDE'   => 'Paramètre par défaut pour les votes masqués',
	'AP_DEFAULT_VOTERS_SHOW'  => 'Paramètre par défaut pour l’affichage du nom des votants',
	'AP_DEFAULT_VOTERS_LIMIT' => 'Paramètre par défaut pour la restriction des votes',
	'AP_DEFAULT_SHOW_ORDERED' => 'Paramètre par défaut pour le tri des votes',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Étapes suivantes</strong></p><ol><li>Vérifiez les paramètres de l’extension dans <strong>%1$s » %2$s » %3$s</strong> et configurez les fonctions et valeurs par défaut nécessaires à votre forum.</li><li>Vérifiez les permissions <strong>%8$s</strong> et <strong>%9$s</strong> dans <strong>%4$s » %5$s » %6$s</strong> (membres) et <strong>%4$s » %5$s » %7$s</strong> (modérateurs). Accordez-les uniquement aux rôles ou groupes autorisés à voir l’identité des votants.</li></ol><p>Les autres fonctions des sondages ne nécessitent aucune configuration supplémentaire.</p></div>',
]);
