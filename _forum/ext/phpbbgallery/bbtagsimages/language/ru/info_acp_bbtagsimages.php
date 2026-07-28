<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'Следующие обязательные расширения недоступны или отключены: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Расширение успешно включено.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Политики тегов Галереи',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Настройте доступность тегов из общего каталога BBTags в Галерее. Модерация предложений остаётся в Модераторском разделе.',
	'ACP_BBTAGSIMAGES_TAG' => 'Каталог тегов',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Тег',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'Общий каталог не содержит одобренных тегов.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Доступность в Галерее',
	'ACP_BBTAGSIMAGES_ENABLED' => 'Доступен в Галерее',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Отключение скрывает тег из полей и поиска Галереи, не удаляя его из BBTags или форума.',
	'ACP_BBTAGSIMAGES_MODE' => 'Доступность по умолчанию',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'Ближайшее явное правило альбома переопределяет это значение и унаследованные правила.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Доступен, если не запрещён',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Недоступен, если не разрешён',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Правила альбомов',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Наследование использует правило ближайшего родительского альбома, а затем доступность по умолчанию.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Альбом',
	'ACP_BBTAGSIMAGES_RULE' => 'Правило',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Наследовать',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Разрешить',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Запретить',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'Нет альбомов Галереи для настройки.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'Не удалось сохранить политику тегов Галереи.',
	'ACP_BBTAGSIMAGES_SAVED' => 'Политика тегов Галереи успешно сохранена.',
]);
