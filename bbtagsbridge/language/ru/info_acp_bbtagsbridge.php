<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Следующие обязательные расширения недоступны или отключены: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Расширение успешно включено.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Политики тегов Галереи',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Настройте доступность тегов из общего каталога BBTags в Галерее. Модерация предложений остаётся в Модераторском разделе.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Каталог тегов',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Тег',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'Общий каталог не содержит одобренных тегов.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Доступность в Галерее',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Доступен в Галерее',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Отключение скрывает тег из полей и поиска Галереи, не удаляя его из BBTags или форума.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Доступность по умолчанию',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'Ближайшее явное правило альбома переопределяет это значение и унаследованные правила.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Доступен, если не запрещён',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Недоступен, если не разрешён',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Правила альбомов',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Наследование использует правило ближайшего родительского альбома, а затем доступность по умолчанию.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Альбом',
	'ACP_BBTAGSBRIDGE_RULE' => 'Правило',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Наследовать',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Разрешить',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Запретить',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Нет альбомов Галереи для настройки.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'Не удалось сохранить политику тегов Галереи.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'Политика тегов Галереи успешно сохранена.',
]);
