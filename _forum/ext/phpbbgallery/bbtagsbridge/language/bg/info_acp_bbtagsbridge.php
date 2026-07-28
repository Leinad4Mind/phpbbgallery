<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Следните задължителни разширения не са налични или активирани: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Разширението беше активирано успешно.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Правила за тагове в Галерията',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Настройте къде таговете от общия каталог на BBTags са достъпни в Галерията. Модерацията на предложения остава в Модераторския панел.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Каталог с тагове',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Таг',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'Общият каталог не съдържа одобрени тагове.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Достъпност в Галерията',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Достъпен в Галерията',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Изключването скрива тага от полетата и търсенията в Галерията, без да го премахва от BBTags или форума.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Достъпност по подразбиране',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'Най-близкото изрично правило за албум заменя тази настройка и наследените правила.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Достъпен, освен ако е забранен',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Недостъпен, освен ако е разрешен',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Правила по албуми',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Наследяване използва правилото на най-близкия родителски албум, а след това настройката по подразбиране.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Албум',
	'ACP_BBTAGSBRIDGE_RULE' => 'Правило',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Наследяване',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Разреши',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Забрани',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Няма албуми в Галерията за настройване.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'Правилото за тагове в Галерията не можа да бъде запазено.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'Правилото за тагове в Галерията беше запазено успешно.',
]);
