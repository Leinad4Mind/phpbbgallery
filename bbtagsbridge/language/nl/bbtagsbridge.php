<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Galerijafbeeldingen',
	'BBTAGSBRIDGE_TAGS' => 'Tags',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Voeg maximaal %1$d door komma’s gescheiden tags toe. Elke tag moet tussen %2$d en %3$d tekens bevatten. Nieuwe tags worden ter goedkeuring aan moderators voorgelegd.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Elke tag moet minimaal %2$d tekens bevatten.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Elke tag mag maximaal %3$d tekens bevatten.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'Je kunt maximaal %1$d tags aan een afbeelding toevoegen.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'Nieuwe tags blijven verborgen totdat een moderator ze goedkeurt.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'De tags van de afbeelding konden niet worden opgeslagen.',
	'BBTAGSBRIDGE_SEARCH_TAGS' => 'Zoeken op tags',
	'BBTAGSBRIDGE_SEARCH_TAGS_EXPLAIN' => 'Voer een of meer door komma’s gescheiden tags in.',
	'BBTAGSBRIDGE_MATCH_ALL_TAGS' => 'Alle tags moeten overeenkomen (EN)',
	'BBTAGSBRIDGE_MATCH_ANY_TAG' => 'Een willekeurige tag mag overeenkomen (OF)',
	'BBTAGSBRIDGE_FILTER_MORE_TAGS' => 'Filteren op meer tags',
]);
