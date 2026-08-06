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
	'ADVANCEDPOLLS_EXT_NAME' => 'Sondages avancés',

// Viewtopic
	'AP_VOTES_HIDDEN'         => 'Votes masqués',
	'AP_POLL_RUN_TILL_APPEND' => ', tous les votes seront masqués jusqu’à cette date.',
	'AP_VOTERS'               => 'Votants',
	'AP_NONE'                 => 'Aucun',
	'AP_DELETED_USER'         => 'Utilisateur supprimé',

	'AP_POLL_CANT_VOTE'              => 'Vous ne pouvez pas voter à ce sondage. Raison',
	'AP_POLL_REASON_NOT_POSTED'      => 'Vous n’avez pas participé à ce sujet.',
	'AP_POLL_VOTES_ARE_VISIBLE'      => 'Veuillez noter que si vous votez, votre vote sera visible.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS' => 'Ne souhaite pas voter, voir les résultats',
	'AP_POLL_RESULTS_ARE_ORDERED'    => 'Veuillez noter que les résultats sont triés par ordre décroissant du nombre de votes reçus.',
	'AP_POLL_TYPE_MISMATCH'          => 'Erreur interne, les données du sondage sont incompatibles.',
	'AP_VOTE_CHANGED'                => 'Vous n’avez pas l’autorisation de modifier vos votes.',
	'AP_TOO_MANY_VOTES'              => 'Vous avez tenté de soumettre un nombre trop élevé de votes.',
	'AP_ABSTAINERS' => 'Ont choisi de ne pas voter',
	'AP_DELETE_VOTE' => 'Supprimer mon vote',

	'AP_MAX_VOTES_SELECT' => [
		1 => 'Vous pouvez soumettre jusqu’à <strong>%2$d</strong> votes pour <strong>%1$d</strong> option',
		2 => 'Vous pouvez soumettre jusqu’à <strong>%2$d</strong> votes parmi <strong>%1$d</strong> options',
	],
	'AP_GUEST_VOTES' => [
		1 => '%d vote d’invité',
		2 => '%d votes d’invités',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d vote',
		2 => '%d votes',
	],
	'AP_SCORE_BREAKDOWN' => 'Répartition des votes',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d vote à %2$d point',
		2 => '%1$d votes à %2$d points',
	],
	'AP_RANK_TOTAL' => [1 => '%d point', 2 => '%d points'],
	'AP_RANK_BREAKDOWN' => 'Détail du classement',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d vote en position %2$d', 2 => '%1$d votes en position %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Sélectionnez exactement %d option par ordre de préférence.',
		2 => 'Sélectionnez exactement %d options par ordre de préférence.',
	],
// Posting
	'AP_POLL_TYPE' => 'Type de sondage',
	'AP_POLL_TYPE_EXPLAIN' => 'Choisissez comment les utilisateurs attribuent leurs votes ou leurs points.',
	'AP_POLL_TYPE_CHOICE' => 'Choix',
	'AP_POLL_TYPE_SCORING' => 'Notation numérique',
	'AP_POLL_TYPE_RANKING' => 'Classement ordonné',
	'AP_POLL_VISIBILITY' => 'Visibilité des résultats',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'Choisissez quand les résultats globaux du sondage deviennent visibles.',
	'AP_VISIBILITY_PUBLIC' => 'Public — toujours afficher les résultats',
	'AP_VISIBILITY_DEFAULT' => 'Après le premier vote',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Après utilisation de tous les votes disponibles',
	'AP_VISIBILITY_PRIVATE' => 'Privé — uniquement après la fin du sondage',
	'AP_POLL_VOTE_MODE' => 'Modification des votes',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'Choisissez si les votes sont définitifs, peuvent être envoyés progressivement ou modifiés tant que le sondage est ouvert.',
	'AP_VOTE_MODE_NO_CHANGE' => 'Aucune modification',
	'AP_VOTE_MODE_INCREMENTAL' => 'Vote progressif',
	'AP_VOTE_MODE_CHANGE' => 'Autoriser les modifications',
	'AP_POLL_VOTES_HIDE'           => 'Masquer les votes',
	'AP_POLL_VOTES_HIDE_EXPLAIN'   => 'Si activé, les votes seront masqués jusqu’à la fin du sondage. Cette option fonctionne uniquement si le sondage possède une date d’échéance.',
	'AP_POLL_VOTERS_SHOW'          => 'Afficher le nom des votants',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'  => 'Si activé, le noms des votants sera affiché aux utilisateurs ayant la permission adéquate. Le nom des votants ne sera pas affiché si les votes sont masqués.',
	'AP_POLL_VOTERS_LIMIT'         => 'Restreindre les votes',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN' => 'Si activé, seuls les participants à ce sujet peuvent voter.',
	'AP_POLL_SHOW_ORDERED'         => 'Trier les résultats',
	'AP_POLL_SHOW_ORDERED_EXPLAIN' => 'Lorsque les résultats sont affichés, ceux-ci sont triés par ordre décroissant du nombre de votes reçus (le plus de votes en premier). Sinon, l’option de tri par défaut du sondage est utilisée.',
	'AP_POLL_COLLAPSIBLE' => 'Sondage réductible',
	'AP_POLL_COLLAPSIBLE_EXPLAIN' => 'Autorise les utilisateurs à réduire et développer ce sondage.',
	'AP_COLLAPSE_POLL' => 'Réduire le sondage',
	'AP_EXPAND_POLL' => 'Développer le sondage',
	'AP_RUN_POLL'                  => 'Lancer le sondage',
	'AP_RUN_POLL_FOR'              => 'pour',
	'AP_RUN_POLL_UNTIL'            => 'jusqu’à',
	'AP_RUN_POLL_INDEFINITELY'     => 'indéfiniment',
	'AP_POLL_END'                  => 'Fin du sondage',
	'AP_POLL_END_EXPLAIN'          => 'Spécifie la date et l’heure de fin du sondage. Si un de ces champs est spécifié, cela remplace la durée du sondage. Les champs laissés vides pour la date sont remplacés par la date de fin par défaut; les champs de l’heure laissés vides sont par défaut à 0. Si vous souhaitez utiliser la durée du sondage, cela nécessite de vider tous les champs.',

	'AP_YYYY_MM_DD'                 => 'AAAA-MM-JJ',
	'AP_HH_MM'                      => 'HH:MM',
	'AP_POLL_END_INVALID'           => 'La date/heure spécifiée est invalide',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES' => 'Le nombre maximum de votes pour une seule option ne peut pas dépasser le nombre total de votes à soumettre à toutes les options',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'  => 'Le nombre maximum d’options de vote ne peut pas dépasser le nombre total de votes à soumettre à toutes les options',

	'AP_POLL_MAX_VALUE'           => 'Nombre maximum de votes',
	'AP_POLL_MAX_VALUE_EXPLAIN'   => 'Il s’agit du nombre maximum de votes qu’un votant peut soumettre à une seule option.',
	'AP_POLL_TOTAL_VALUE'         => 'Nombre total de votes',
	'AP_POLL_TOTAL_VALUE_EXPLAIN' => 'Il s’agit du nombre total de votes qu’un votant peut soumettre parmi toutes les options.',

	'AP_RANK_POINTS' => 'Points par position',
	'AP_RANK_POINTS_EXPLAIN' => 'Définissez une valeur positive et décroissante pour chaque position. Le nombre de positions dépend du maximum d’options par utilisateur.',
	'AP_RANK_POSITION' => 'Position %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE' => 'Vous ne pouvez pas attribuer un nombre de votes supérieur à la valeur maximale autorisée.',
	'AP_POLL_VALUES_INVALID' => 'La note minimale ne peut pas dépasser la note maximale ; le nombre maximal d’options, la note maximale et la note totale doivent être supérieurs à zéro.',
	'AP_RANK_POSITIONS_INVALID' => 'Le nombre de positions doit être compris entre 1 et le nombre d’options du sondage.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Définissez une valeur en points pour chaque position.',
	'AP_RANK_POINTS_INVALID' => 'Chaque valeur en points doit être comprise entre 1 et 999.',
	'AP_RANK_POINTS_ORDER' => 'Les points doivent strictement diminuer de la première à la dernière position.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'Le vote incrémental ne peut pas être utilisé avec le classement ordonné.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Sélectionnez exactement le nombre d’options configuré par ordre de préférence.',
	'AP_QUESTION' => 'Question',
	'AP_QUESTION_REQUIRED' => 'Question obligatoire',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Exige une réponse à la première question avant l’envoi du bulletin complet.',
	'AP_ADDITIONAL_QUESTIONS' => 'Pages de questions supplémentaires',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'Chaque page utilise le même type de sondage ainsi que les mêmes limites et règles de points, de visibilité et de modification du vote. Saisissez une option par ligne.',
	'AP_ADD_QUESTION' => 'Ajouter une question',
	'AP_MULTI_INVALID' => 'Les données des questions supplémentaires ne sont pas valides.',
	'AP_MULTI_TOO_MANY' => 'Un sondage peut contenir au maximum 20 questions supplémentaires.',
	'AP_MULTI_CONTENT_INVALID' => 'Chaque question supplémentaire doit avoir un titre et suffisamment d’options valides pour respecter les limites globales du sondage.',
	'AP_REQUIRED_QUESTION_MISSING' => 'Répondez à cette question obligatoire avant de continuer.',
	'AP_POLL_NAVIGATION' => 'Navigation entre les questions du sondage',
	'AP_POLL_MIN_VALUE' => 'Score minimal',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'Il s’agit du score minimal qu’un votant peut attribuer à une option sélectionnée.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Chaque score attribué doit être compris entre les valeurs minimale et maximale configurées.',
]);
