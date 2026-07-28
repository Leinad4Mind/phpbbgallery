<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Galeriebilder',
	'BBTAGSIMAGES_TAGS' => 'Schlagwörter',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Füge bis zu %1$d durch Kommas getrennte Schlagwörter hinzu. Jedes Schlagwort muss zwischen %2$d und %3$d Zeichen enthalten. Neue Schlagwörter werden Moderatoren zur Freigabe vorgelegt.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Jedes Schlagwort muss mindestens %2$d Zeichen enthalten.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Jedes Schlagwort darf höchstens %3$d Zeichen enthalten.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'Du kannst einem Bild höchstens %1$d Schlagwörter hinzufügen.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'Neue Schlagwörter bleiben verborgen, bis ein Moderator sie freigibt.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'Die Schlagwörter des Bildes konnten nicht gespeichert werden.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Nach Schlagwörtern suchen',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Gib ein oder mehrere durch Kommas getrennte Schlagwörter ein.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Alle Schlagwörter müssen zutreffen (UND)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Ein beliebiges Schlagwort muss zutreffen (ODER)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Nach weiteren Schlagwörtern filtern',
]);
