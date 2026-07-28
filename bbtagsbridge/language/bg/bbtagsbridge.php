<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Изображения в галерията',
	'BBTAGSBRIDGE_TAGS' => 'Етикети',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Добавете до %1$d етикета, разделени със запетаи. Всеки етикет трябва да съдържа между %2$d и %3$d знака. Новите етикети се изпращат на модераторите за одобрение.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Всеки етикет трябва да съдържа поне %2$d знака.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Всеки етикет може да съдържа най-много %3$d знака.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'Можете да добавите най-много %1$d етикета към изображение.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'Новите етикети остават скрити, докато модератор не ги одобри.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'Етикетите на изображението не можаха да бъдат запазени.',
	'BBTAGSBRIDGE_SEARCH_TAGS' => 'Търсене по етикети',
	'BBTAGSBRIDGE_SEARCH_TAGS_EXPLAIN' => 'Въведете един или повече етикети, разделени със запетаи.',
	'BBTAGSBRIDGE_MATCH_ALL_TAGS' => 'Съвпадение с всички етикети (И)',
	'BBTAGSBRIDGE_MATCH_ANY_TAG' => 'Съвпадение с произволен етикет (ИЛИ)',
	'BBTAGSBRIDGE_FILTER_MORE_TAGS' => 'Филтриране по още етикети',
]);
