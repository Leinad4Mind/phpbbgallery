<?php
/**
 * phpBB Gallery - ACP CleanUp Extension [Russian Translation]
 *
 * @package   phpbbgallery/acpcleanup
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator Eduard Schlak <https://translations.schlak.info>
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
	'ACP_GALLERY_CLEANUP' => 'Очистить галерею',

	'ACP_GALLERY_CLEANUP_EXPLAIN' => 'Здесь вы можете удалить некоторые остатки.',

	'CLEAN_AUTHORS_DONE'       => 'Изображения без действительного автора удалены',
	'CLEAN_CHANGED'            => 'Автор изменено на "Гость"',
	'CLEAN_COMMENTS_DONE'      => 'Комментарии без действительного автора удалены',
	'CLEAN_ENTRIES_DONE'       => 'Файлы без записи в Базе данных удалены',
	'CLEAN_GALLERY'            => 'Чистить галерею',
	'CLEAN_GALLERY_ABORT'      => 'Отменить очистку!',
	'CLEAN_NO_ACTION'          => 'Никакие действия не завершены. Что-то пошло не так!',
	'CLEAN_PERSONALS_DONE'     => 'Личные альбомы без действительного владельца удалены',
	'CLEAN_PERSONALS_BAD_DONE' => 'Личные альбомы выбранных пользователей удаленны',
	'CLEAN_PRUNE_DONE'         => 'Изображения успешно очищены',
	'CLEAN_PRUNE_NO_PATTERN'   => 'Нет поискового шаблона',
	'CLEAN_SOURCES_DONE'       => 'Изображения без файла удалены',

	'SOURCE_CHECK_PROGRESS' => 'Проверка исходных файлов Галереи',
	'SOURCE_CHECK_COMPLETE' => 'Проверка исходных файлов завершена',
	'SOURCE_CHECK_RESULT' => 'Проверено: %1$d; отсутствуют исходные файлы: %2$d.',
	'SOURCE_CHECK_RUN' => 'Повторно проверить исходные файлы',
	'MISSING_SOURCE_DIAGNOSTIC_EXPLAIN' => 'Диагностика проверяет активное хранилище возобновляемыми группами по 25 записей. Отсутствие medium- или mini-файлов не делает запись недействительной: эти производные можно создать заново из исходного файла.',
	'MISSING_SOURCE_SUMMARY' => 'У %1$d записей отсутствует исходный файл в активном хранилище %2$s.',
	'MISSING_SOURCE_CONTEXT' => 'Альбом и автор',
	'MISSING_SOURCE_EXPECTED_KEY' => 'Ожидаемый исходный объект',
	'MISSING_SOURCE_DERIVATIVES' => 'Существующие производные',
	'MISSING_SOURCE_MEDIUM' => 'Medium',
	'MISSING_SOURCE_MINI' => 'Mini',
	'MISSING_SOURCE_RESTORE_EXPLAIN' => 'Восстановите доступные оригиналы точно в указанном выше хранилище и по указанному ключу, затем повторите проверку. Выбирайте и удаляйте только записи, оригиналы которых невозможно восстановить; удаление требует подтверждения и сохраняет согласованность связанных данных.',
	'MISSING_SOURCE_STATUS_UNAPPROVED' => 'Ожидает одобрения',
	'MISSING_SOURCE_STATUS_APPROVED' => 'Одобрено',
	'MISSING_SOURCE_STATUS_LOCKED' => 'Заблокировано',
	'MISSING_SOURCE_STATUS_ORPHAN' => 'Незавершённая загрузка',
	'MISSING_SOURCE_STATUS_DELETE_REQUESTED' => 'Запрошено удаление',
	'MISSING_SOURCE_STATUS_UNKNOWN' => 'Неизвестно',

	'CONFIRM_CLEAN'               => 'Это действие не может быть отменено!',
	'CONFIRM_CLEAN_AUTHORS'       => 'Удалить изображеиня без действительного автора?',
	'CONFIRM_CLEAN_COMMENTS'      => 'Удалить комментарии без действительного автора?',
	'CONFIRM_CLEAN_ENTRIES'       => 'Файлы без записей в БД удалить?',
	'CONFIRM_CLEAN_PERSONALS'     => 'Удалить личные альбомы без действительных владельцев?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_PERSONALS_BAD' => 'Удалить личные альбомы выбранных пользователей?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_SOURCES'       => 'Изображения без файла удалить?',
	'CONFIRM_PRUNE'               => 'Все изображения, имеющие следующие условия, удалить:<br /><br />%s<br />',

	'PRUNE'                  => 'Очистить',
	'PRUNE_ALBUMS'           => 'Очистить альбомы',
	'PRUNE_CHECK_OPTION'     => 'Включите эту опцию, если вы хотите, чтобы очистить изображения',
	'PRUNE_COMMENTS'         => 'Менее чем x комментарий',
	'PRUNE_PATTERN_ALBUM_ID' => 'Изображение находится в одном из следующих альбомов:<br />&raquo; <strong>%s</strong>',
	'PRUNE_PATTERN_COMMENTS' => 'Изображение имеет меньше, чем <strong>%d</strong> комментарий',
	'PRUNE_PATTERN_RATES'    => 'Изображение имеет меньше, чем <strong>%d</strong> отзывов',
	'PRUNE_PATTERN_RATE_AVG' => 'Изображение имеет среднюю оценку меньше, чем <strong>%s</strong>.',
	'PRUNE_PATTERN_TIME'     => 'Изображение было через “<strong>%s</strong>“ загружено',
	'PRUNE_PATTERN_USER_ID'  => 'Изображение было загружено одним из следующих пользователей:<br />&raquo; <strong>%s</strong>',
	'PRUNE_RATINGS'          => 'Менее, чем x оценок',
	'PRUNE_RATING_AVG'       => 'Средняя оценка ниже, чем',
	'PRUNE_RATING_AVG_EXP'   => 'Будут очищены только изображения, со средней оценкой менее, чем “<samp>x.yz</samp>“.',
	'PRUNE_TIME'             => 'Загружено перед',
	'PRUNE_TIME_EXP'         => 'Очистить только изображения, которые были загружены перед “<samp>ГГГГ-ММ-ДД</samp>“',
	'PRUNE_USERNAME'         => 'Загружено пользователем',
	'PRUNE_USERNAME_EXP'     => 'Только изображения следующих пользователей очистить. Чтобы очистить изображения "гостей", установите флажок над полем имени пользователя',

	//Log
	'LOG_CLEANUP_DELETE_FILES'             => '%s Изображения без БД записей были удалены',
	'LOG_CLEANUP_DELETE_ENTRIES'           => '%s Изображения без файлов были удалены',
	'LOG_CLEANUP_DELETE_NO_AUTHOR'         => '%s Изображения без действительных авторов были удалены',
	'LOG_CLEANUP_COMMENT_DELETE_NO_AUTHOR' => '%s Комментарии без действительных авторов были удалены',

	'MOVE_TO_IMPORT'       => 'Move images to Import directory',
	'MOVE_TO_USER'         => 'Move to user',
	'MOVE_TO_USER_EXP'     => 'Images and comments will be moved as those of user you have defined. If none is selected - Anonymous will be used.',
	'CLEAN_USER_NOT_FOUND' => 'The user you selected does not exists!',

	'GALLERY_LEGACY_BBCODE_MIGRATE' => 'Перенести устаревшие BBCode галереи',
	'GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN' => 'Ищет скрытый псевдоним [album] в сообщениях, личных сообщениях и подписях. После подтверждения каждый запуск повторно обрабатывает до %1$d записей как %2$s и сохраняет согласованность метаданных BBCode phpBB. Повторяйте действие, пока записей не останется.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM' => 'Преобразовать следующую группу из [album] в %2$s? Сейчас осталось %1$d записей.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_NONE' => 'Устаревших записей [album] больше нет.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_RESULT' => 'Преобразовано записей: %1$d. Не удалось преобразовать: %2$d. Осталось записей: %3$d.',
	'GALLERY_CORE_NOT_FOUND'   => 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS' => 'Расширение успешно включено.',
]);
