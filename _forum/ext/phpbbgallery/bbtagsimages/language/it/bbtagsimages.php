<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Immagini della galleria',
	'BBTAGSIMAGES_TAGS' => 'Tag',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Aggiungi fino a %1$d tag separati da virgole. Ogni tag deve contenere da %2$d a %3$d caratteri. I nuovi tag vengono inviati ai moderatori per l’approvazione.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Ogni tag deve contenere almeno %2$d caratteri.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Ogni tag può contenere al massimo %3$d caratteri.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'Non puoi aggiungere più di %1$d tag a un’immagine.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'I nuovi tag restano nascosti finché un moderatore non li approva.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'Non è stato possibile salvare i tag dell’immagine.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Cerca per tag',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Inserisci uno o più tag separati da virgole.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Corrispondenza con tutti i tag (E)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Corrispondenza con qualsiasi tag (O)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filtra con altri tag',
]);
