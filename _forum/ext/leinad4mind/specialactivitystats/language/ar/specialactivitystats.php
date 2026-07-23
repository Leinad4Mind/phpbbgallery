<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 Basil Taha Alhitary
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	// for the normal sites
	'SPECIAL_ACTIVITY_STATS'         => 'إحصائيات اليوم',
	'SPECIAL_ACTIVITY_STATS_LATEST1' => 'في',
	'SPECIAL_ACTIVITY_STATS_LATEST2' => '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS' => 'المواضيع الجديدة <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'  => 'المشاركات الجديدة <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'  => 'الأعضاء الجُدد <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL' => [
		0 => 'إجمالي الأعضاء المتصلين كان <strong>0</strong> عضو :: ',
		1 => 'إجمالي الأعضاء المتصلين كان <strong>%d</strong> عضو :: ',
		2 => 'إجمالي الأعضاء المتصلين كان <strong>%d</strong> أعضاء :: ',
	],
	'SPECIAL_ACTIVITY_STATS_REG_USERS' => [
		0 => '0 مسجلين',
		1 => '%d مسجل',
		2 => '%d مسجلين',
	],
	'SPECIAL_ACTIVITY_STATS_HIDDEN' => [
		0 => '0 مخفي',
		1 => '%d مخفي',
		2 => '%d مخفيين',
	],
	'SPECIAL_ACTIVITY_STATS_BOTS' => [
		0 => '0 محرك بحث',
		1 => '%d محرك بحث',
		2 => '%d محركات بحث',
	],
	'SPECIAL_ACTIVITY_STATS_GUESTS' => [
		0 => '0 زائر',
		1 => '%d زائر',
		2 => '%d زائرين',
	],

	'SPECIAL_ACTIVITY_STATS_WORD'     => ' و',
	'SPECIAL_ACTIVITY_STATS_EXP'      => 'المعلومات التالية تعتمد على نشاط الأعضاء خلال الـ24 ساعة',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME' => [
		0 => 'المعلومات التالية تعتمد على نشاط الأعضاء في هذه اللحظة.', // h=m=s=0
		1 => 'المعلومات التالية تعتمد على نشاط الأعضاء خلال الفترة الماضية ', // first non zero value is 1
		2 => 'المعلومات التالية تعتمد على نشاط الأعضاء خلال الفترة الماضية ', // first non zero value is >1
	],
	'SPECIAL_ACTIVITY_STATS_DAYS' => [
		0 => '',
		1 => '%%s %1$s يوم',
		2 => '%%s %1$s أيام',
	],
	'SPECIAL_ACTIVITY_STATS_HOURS' => [
		0 => '',
		1 => '%%s %1$s ساعة',
		2 => '%%s %1$s ساعات',
	],
	'SPECIAL_ACTIVITY_STATS_MINUTES' => [
		0 => '',
		1 => '%%s %1$s دقيقة',
		2 => '%%s %1$s دقائق',
	],
	'SPECIAL_ACTIVITY_STATS_SECONDS' => [
		0 => '',
		1 => '%%s %1$s ثانية',
		2 => '%%s %1$s ثواني',
	],
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'    => 'أكبر عدد للأعضاء المتصلين كان <strong>%1$s</strong> في %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD' => 'أكبر عدد للأعضاء المتصلين كان <strong>%1$s</strong> بين %2$s و %3$s',
]);
