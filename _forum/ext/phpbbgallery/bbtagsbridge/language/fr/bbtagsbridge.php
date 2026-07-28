<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Images de la galerie',
	'BBTAGSBRIDGE_TAGS' => 'Étiquettes',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Ajoutez jusqu’à %1$d étiquettes séparées par des virgules. Chaque étiquette doit contenir entre %2$d et %3$d caractères. Les nouvelles étiquettes sont soumises aux modérateurs.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Chaque étiquette doit contenir au moins %2$d caractères.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Chaque étiquette ne peut pas dépasser %3$d caractères.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'Vous ne pouvez pas ajouter plus de %1$d étiquettes à une image.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'Les nouvelles étiquettes restent masquées jusqu’à leur approbation par un modérateur.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'Les étiquettes de l’image n’ont pas pu être enregistrées.',
	'BBTAGSBRIDGE_SEARCH_TAGS' => 'Rechercher par étiquettes',
	'BBTAGSBRIDGE_SEARCH_TAGS_EXPLAIN' => 'Saisissez une ou plusieurs étiquettes séparées par des virgules.',
	'BBTAGSBRIDGE_MATCH_ALL_TAGS' => 'Correspondre à toutes les étiquettes (ET)',
	'BBTAGSBRIDGE_MATCH_ANY_TAG' => 'Correspondre à une étiquette quelconque (OU)',
	'BBTAGSBRIDGE_FILTER_MORE_TAGS' => 'Filtrer avec d’autres étiquettes',
]);
