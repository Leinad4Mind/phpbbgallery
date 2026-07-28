<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'Следните задължителни разширения не са налични или активирани: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Разширението беше активирано успешно.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Правила за тагове в Галерията',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Настройте къде таговете от общия каталог на BBTags са достъпни в Галерията. Модерацията на предложения остава в Модераторския панел.',
	'ACP_BBTAGSIMAGES_TAG' => 'Каталог с тагове',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Таг',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'Общият каталог не съдържа одобрени тагове.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Достъпност в Галерията',
	'ACP_BBTAGSIMAGES_ENABLED' => 'Достъпен в Галерията',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Изключването скрива тага от полетата и търсенията в Галерията, без да го премахва от BBTags или форума.',
	'ACP_BBTAGSIMAGES_MODE' => 'Достъпност по подразбиране',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'Най-близкото изрично правило за албум заменя тази настройка и наследените правила.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Достъпен, освен ако е забранен',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Недостъпен, освен ако е разрешен',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Правила по албуми',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Наследяване използва правилото на най-близкия родителски албум, а след това настройката по подразбиране.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Албум',
	'ACP_BBTAGSIMAGES_RULE' => 'Правило',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Наследяване',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Разреши',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Забрани',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'Няма албуми в Галерията за настройване.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'Правилото за тагове в Галерията не можа да бъде запазено.',
	'ACP_BBTAGSIMAGES_SAVED' => 'Правилото за тагове в Галерията беше запазено успешно.',
]);
