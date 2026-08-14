<?php
/**
 * phpBB Gallery - ACP CleanUp Extension [Bulgarian Translation]
 *
 * @package   phpbbgallery/acpcleanup
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator Lucifer <https://www.anavaro.com>
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_GALLERY_CLEANUP'         => 'Почистване на галерия',
	'ACP_GALLERY_CLEANUP_EXPLAIN' => 'Тук можете да изтриете малко останки.',

	'CLEAN_AUTHORS_DONE'       => 'Изображения без валиден автор са изтрити.',
	'CLEAN_CHANGED'            => 'Автора променен на "Гост".',
	'CLEAN_COMMENTS_DONE'      => 'Коментари без валиден автор - изтрити.',
	'CLEAN_ENTRIES_DONE'       => 'Файлове без DB редове - изтрити.',
	'CLEAN_GALLERY'            => 'Изчисти галерия',
	'CLEAN_GALLERY_ABORT'      => 'Прекрати почистване!',
	'CLEAN_NO_ACTION'          => 'Не беше извършено действие. Нещо се прецака!',
	'CLEAN_PERSONALS_DONE'     => 'Лични албуми без валиден собственик - изтрити!',
	'CLEAN_PERSONALS_BAD_DONE' => 'Лични албуми от избраните потребители - изтрити.',
	'CLEAN_PRUNE_DONE'         => 'Успешно прочеистени изображения.',
	'CLEAN_PRUNE_NO_PATTERN'   => 'Няма задедн параметър за търсене.',
	'CLEAN_SOURCES_DONE'       => 'Изображения без файлове - изтрити!',

	'SOURCE_CHECK_PROGRESS' => 'Проверка на изходните файлове на Галерията',
	'SOURCE_CHECK_COMPLETE' => 'Проверката на изходните файлове завърши',
	'SOURCE_CHECK_RESULT' => 'Проверени: %1$d; липсващи изходни файлове: %2$d.',
	'SOURCE_CHECK_RUN' => 'Провери отново изходните файлове',
	'MISSING_SOURCE_DIAGNOSTIC_EXPLAIN' => 'Тази диагностика проверява активния доставчик на съхранение във възобновяеми групи по 25. Липсващи medium или mini файлове не правят записа невалиден, защото тези производни могат да бъдат създадени отново от изходния файл.',
	'MISSING_SOURCE_SUMMARY' => '%1$d записа нямат изходен файл при активния доставчик %2$s.',
	'MISSING_SOURCE_CONTEXT' => 'Албум и автор',
	'MISSING_SOURCE_EXPECTED_KEY' => 'Очакван изходен обект',
	'MISSING_SOURCE_DERIVATIVES' => 'Налични производни',
	'MISSING_SOURCE_MEDIUM' => 'Medium',
	'MISSING_SOURCE_MINI' => 'Mini',
	'MISSING_SOURCE_RESTORE_EXPLAIN' => 'Възстановете наличните оригинали точно при показания доставчик и изходен ключ, след което повторете проверката. Избирайте и изтривайте само записи, чиито оригинали не могат да бъдат възстановени; изтриването изисква потвърждение и запазва свързаните данни последователни.',
	'MISSING_SOURCE_STATUS_UNAPPROVED' => 'Очаква одобрение',
	'MISSING_SOURCE_STATUS_APPROVED' => 'Одобрено',
	'MISSING_SOURCE_STATUS_LOCKED' => 'Заключено',
	'MISSING_SOURCE_STATUS_ORPHAN' => 'Незавършено качване',
	'MISSING_SOURCE_STATUS_DELETE_REQUESTED' => 'Поискано изтриване',
	'MISSING_SOURCE_STATUS_UNKNOWN' => 'Неизвестно',

	'CONFIRM_CLEAN'               => 'Тази стъпка не може да сърне на зад!',
	'CONFIRM_CLEAN_AUTHORS'       => 'Изтрий изображения без валиден автор?',
	'CONFIRM_CLEAN_COMMENTS'      => 'Изтрий коментари без валиден автор?',
	'CONFIRM_CLEAN_ENTRIES'       => 'Изтрий файлове без запис в базата?',
	'CONFIRM_CLEAN_PERSONALS'     => 'Изтрий лични албуми без валиден соственик?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_PERSONALS_BAD' => 'Изтрий личните албуми от избран потребител?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_SOURCES'       => 'Изтрий изображения без валиден фаил?',
	'CONFIRM_PRUNE'               => 'Изтрий всички изборажения отговарящи на следните условия:<br /><br />%s<br />',

	'PRUNE'                  => 'Прочисти',
	'PRUNE_ALBUMS'           => 'Прочисти албум',
	'PRUNE_CHECK_OPTION'     => 'Избери тази опция, докато прочистваш изображенията.',
	'PRUNE_COMMENTS'         => 'По-малко от х коментара',
	'PRUNE_PATTERN_ALBUM_ID' => 'Изображението е в един от следните албуми:<br />&raquo; <strong>%s</strong>',
	'PRUNE_PATTERN_COMMENTS' => 'Изображението има по-малко от <strong>%d</strong> коментара.',
	'PRUNE_PATTERN_RATES'    => 'Изображението е оценено по-малко от <strong>%d</strong> пъти.',
	'PRUNE_PATTERN_RATE_AVG' => 'Средната оценка за изображението е по-малко от <strong>%s</strong>.',
	'PRUNE_PATTERN_TIME'     => 'Изображението е качено преди “<strong>%s</strong>“.',
	'PRUNE_PATTERN_USER_ID'  => 'Изображението е качено от един следните потребители:<br />&raquo; <strong>%s</strong>',
	'PRUNE_RATINGS'          => 'По-малко от х оценки',
	'PRUNE_RATING_AVG'       => 'Средна оценка по-ниска от',
	'PRUNE_RATING_AVG_EXP'   => 'Премахни само изображения със средна оценка по-малка от “<samp>x.yz</samp>“.',
	'PRUNE_TIME'             => 'Качени преди',
	'PRUNE_TIME_EXP'         => 'Премахни изображения качени преди “<samp>YYYY-MM-DD</samp>“.',
	'PRUNE_USERNAME'         => 'Качени от',
	'PRUNE_USERNAME_EXP'     => 'Премахни изображения само от отделни потребители. За да премахнете изображения от "Гости" - изберете отметката от долу.',

	//Log
	'LOG_CLEANUP_DELETE_FILES'             => 'Премахнати %s изображения без редове в базата.',
	'LOG_CLEANUP_DELETE_ENTRIES'           => 'Премахнати %s изображения без файлове.',
	'LOG_CLEANUP_DELETE_NO_AUTHOR'         => 'Премахнати %s изображения без валиден автор.',
	'LOG_CLEANUP_COMMENT_DELETE_NO_AUTHOR' => 'Премахнати %s коментара без валиден автор.',

	'MOVE_TO_IMPORT'       => 'Премести избораженията в Import директорията',
	'MOVE_TO_USER'         => 'Премести при потребител',
	'MOVE_TO_USER_EXP'     => 'Изображенията и коментарите ще бъдат преместеи като такива на посочения потребител. Ако не посочите потребител - Гост е зададен по-подразбиране',
	'CLEAN_USER_NOT_FOUND' => 'Желаният от вас потребител не е открит!',

	'GALLERY_LEGACY_BBCODE_MIGRATE' => 'Мигриране на наследените BBCodes на галерията',
	'GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN' => 'Търси скрития псевдоним [album] в публикации, лични съобщения и подписи. След потвърждение всяко изпълнение обработва до %1$d записа като %2$s и поддържа съгласувани BBCode метаданните на phpBB. Повтаряйте действието, докато не останат записи.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM' => 'Да се преобразува ли следващата група от [album] към %2$s? В момента остават %1$d записа.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_NONE' => 'Не остават наследени записи с [album].',
	'GALLERY_LEGACY_BBCODE_MIGRATE_RESULT' => 'Преобразувани са %1$d записа. %2$d записа не можаха да бъдат преобразувани. Остават %3$d записа.',
	'GALLERY_CORE_NOT_FOUND'   => 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS' => 'Разширението е активирано успешно.',
]);
