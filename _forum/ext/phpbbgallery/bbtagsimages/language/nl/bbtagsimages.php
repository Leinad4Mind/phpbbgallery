<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Galerijafbeeldingen',
	'BBTAGSIMAGES_TAGS' => 'Tags',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Voeg maximaal %1$d door komma’s gescheiden tags toe. Elke tag moet tussen %2$d en %3$d tekens bevatten. Nieuwe tags worden ter goedkeuring aan moderators voorgelegd.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Elke tag moet minimaal %2$d tekens bevatten.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Elke tag mag maximaal %3$d tekens bevatten.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'Je kunt maximaal %1$d tags aan een afbeelding toevoegen.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'Nieuwe tags blijven verborgen totdat een moderator ze goedkeurt.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'De tags van de afbeelding konden niet worden opgeslagen.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Zoeken op tags',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Voer een of meer door komma’s gescheiden tags in.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Alle tags moeten overeenkomen (EN)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Een willekeurige tag mag overeenkomen (OF)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filteren op meer tags',
]);
