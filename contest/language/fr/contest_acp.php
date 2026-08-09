<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ALBUM_TYPE_CONTEST'                  => 'Concours',
	'CONTEST_CREATION'                    => 'Autoriser les nouveaux concours',
	'CONTEST_CREATION_EXPLAIN'            => 'Permet aux administrateurs de créer de nouveaux albums de concours. Les concours existants restent actifs et modifiables lorsque cette option est désactivée.',
	'CONTEST_CREATION_DISABLED'           => 'La création de nouveaux albums de concours est désactivée dans la configuration de la Galerie.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Un album simple ne peut pas être transformé en album-concours.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Un album-concours ne peut pas être transformé en un album simple.',
	'CONTEST_DATE_EXPLAIN'                => 'Merci de saisir une date dans ce format AAAA-MM-JJ HH:MM.',
	'CONTEST_END'                         => 'Fin du concours',
	'CONTEST_END_BEFORE_RATING'           => 'Le concours ne doit pas se terminer avant que les votes ne soient démarrés.',
	'CONTEST_END_BEFORE_START'            => 'Le concours ne doit pas se terminer avant qu’il ne soit démarré.',
	'CONTEST_END_EXPLAIN'                 => 'Après la fin du concours, les utilisateurs ne peuvent plus noter les images.',
	'CONTEST_END_INVALID'                 => 'Fin de concours invalide (%s). Merci de saisir une date dans ce format AAAA-MM-JJ HH:MM.',
	'CONTEST_RATING'                      => 'Début des votes',
	'CONTEST_RATING_BEFORE_START'         => 'Les votes ne doivent pas débuter avant le concours.',
	'CONTEST_RATING_EXPLAIN'              => 'Après le « Début des votes », les utilisateurs ne peuvent plus charger d’images.',
	'CONTEST_RATING_INVALID'              => 'Début des votes invalide (%s). Merci de saisir une date dans ce format AAAA-MM-JJ HH:MM.',
	'CONTEST_SETTINGS'                    => 'Paramètres du concours',
	'CONTEST_WINNER_THUMBNAIL'            => 'Utiliser les miniatures des gagnants',
	'CONTEST_WINNER_THUMBNAIL_EXPLAIN'    => 'Après la fin d’un concours, utilise par défaut l’image valide classée première comme miniature de l’album. Chaque concours peut hériter de ce réglage ou le remplacer. Une image d’album définie manuellement reste toujours prioritaire.',
	'CONTEST_THUMBNAIL_POLICY'            => 'Miniature de l’album après le concours',
	'CONTEST_THUMBNAIL_POLICY_EXPLAIN'    => 'Contrôle uniquement la miniature dans la liste des albums. La date, l’auteur et l’état de lecture de la dernière image restent inchangés.',
	'CONTEST_THUMBNAIL_INHERIT'           => 'Hériter du réglage global',
	'CONTEST_THUMBNAIL_LAST'              => 'Utiliser la dernière image',
	'CONTEST_THUMBNAIL_WINNER'            => 'Utiliser l’image gagnante après la fin du concours',
	'CONTEST_START'                       => 'Début du concours',
	'CONTEST_START_EXPLAIN'               => 'Au début du concours, les utilisateurs sont autorisés à charger des images.',
	'CONTEST_START_INVALID'               => 'Début du concours invalide (%s). Merci de saisir une date dans ce format AAAA-MM-JJ HH:MM.',
]);
