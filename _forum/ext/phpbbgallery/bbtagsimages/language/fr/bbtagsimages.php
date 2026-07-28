<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Images de la galerie',
	'BBTAGSIMAGES_TAGS' => 'Étiquettes',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Ajoutez jusqu’à %1$d étiquettes séparées par des virgules. Chaque étiquette doit contenir entre %2$d et %3$d caractères. Les nouvelles étiquettes sont soumises aux modérateurs.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Chaque étiquette doit contenir au moins %2$d caractères.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Chaque étiquette ne peut pas dépasser %3$d caractères.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'Vous ne pouvez pas ajouter plus de %1$d étiquettes à une image.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'Les nouvelles étiquettes restent masquées jusqu’à leur approbation par un modérateur.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'Les étiquettes de l’image n’ont pas pu être enregistrées.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Rechercher par étiquettes',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Saisissez une ou plusieurs étiquettes séparées par des virgules.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Correspondre à toutes les étiquettes (ET)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Correspondre à une étiquette quelconque (OU)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filtrer avec d’autres étiquettes',
]);
