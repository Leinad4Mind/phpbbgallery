<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ALBUM_TYPE_CONTEST'                  => 'Конкурс',
	'CONTEST_CREATION'                    => 'Разреши нови конкурси',
	'CONTEST_CREATION_EXPLAIN'            => 'Позволява на администраторите да създават нови конкурсни албуми. Съществуващите конкурси остават активни и могат да се редактират, когато тази настройка е изключена.',
	'CONTEST_CREATION_DISABLED'           => 'Създаването на нови конкурсни албуми е изключено в настройките на Галерията.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Албум без конкурс не може да бъде превърнат в такъв със.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Състезателен албум не може да бъде превърнат в не състезателен.',
	'CONTEST_DATE_EXPLAIN'                => 'Моля въведете дата във формат YYYY-MM-DD HH:MM',
	'CONTEST_END'                         => 'Край на конкурса',
	'CONTEST_END_BEFORE_RATING'           => 'Края на конкурса не трябва да е преди начлото на етапа за гласуване.',
	'CONTEST_END_BEFORE_START'            => 'Края на конкурса не трябва да е преди началото на конкурса.',
	'CONTEST_END_EXPLAIN'                 => 'След края на конкурса, потребителите няма да могат да оценяват изображенията.',
	'CONTEST_END_INVALID'                 => 'Не валиден край на конкурса (%s). Моля въвдете датата във формат YYYY-MM-DD HH:MM',
	'CONTEST_RATING'                      => 'Начало на оценяването',
	'CONTEST_RATING_BEFORE_START'         => 'Начлото на етапа за оценяване не трбва да е преди началото на конкурса.',
	'CONTEST_RATING_EXPLAIN'              => 'След “Начало на оценяване“, поребителите няма да могат да качват повече изображения.',
	'CONTEST_RATING_INVALID'              => 'Не валидно начало на етапа за гласуване (%s). Моля въвдете датата във формат YYYY-MM-DD HH:MM',
	'CONTEST_SETTINGS'                    => 'Настройка на конкурс',
	'CONTEST_START'                       => 'Начало на конкурса',
	'CONTEST_START_EXPLAIN'               => 'В началото на конкурса, на потребителите е позволено да качват изображения.',
	'CONTEST_START_INVALID'               => 'Не валидно начало на конкурса (%s). Моля въвдете датата във формат YYYY-MM-DD HH:MM',
]);
