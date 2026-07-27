<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'REPLACE_IMAGE'                => 'Заменить файл изображения',
	'REPLACE_IMAGE_EXPLAIN'        => 'Выберите новый файл. Идентификатор, описание, комментарии, оценки и число просмотров сохраняются.',
	'IMAGE_REVISIONS'              => 'Предыдущие файлы изображения',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Сохранённые файлы можно просматривать и восстанавливать. При восстановлении текущий файл сохраняется в истории.',
	'RESTORE_REVISION'             => 'Восстановить эту версию',
	'IMAGE_REPLACE_FAILED'         => 'Не удалось безопасно применить новый файл.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Эта версия изображения больше недоступна.',
	'IMAGE_REVISION_RESTORED'      => 'Версия изображения успешно восстановлена.',
]);
