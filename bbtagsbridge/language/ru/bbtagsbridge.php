<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Изображения галереи',
	'BBTAGSBRIDGE_TAGS' => 'Теги',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Добавьте до %1$d тегов, разделённых запятыми. Каждый тег должен содержать от %2$d до %3$d символов. Новые теги отправляются модераторам на одобрение.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Каждый тег должен содержать не менее %2$d символов.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Каждый тег может содержать не более %3$d символов.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'К изображению можно добавить не более %1$d тегов.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'Новые теги остаются скрытыми до одобрения модератором.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'Не удалось сохранить теги изображения.',
	'BBTAGSBRIDGE_SEARCH_TAGS' => 'Поиск по тегам',
	'BBTAGSBRIDGE_SEARCH_TAGS_EXPLAIN' => 'Введите один или несколько тегов через запятую.',
	'BBTAGSBRIDGE_MATCH_ALL_TAGS' => 'Совпадение со всеми тегами (И)',
	'BBTAGSBRIDGE_MATCH_ANY_TAG' => 'Совпадение с любым тегом (ИЛИ)',
	'BBTAGSBRIDGE_FILTER_MORE_TAGS' => 'Фильтровать по дополнительным тегам',
]);
