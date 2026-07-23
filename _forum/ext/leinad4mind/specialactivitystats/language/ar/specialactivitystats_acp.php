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
	'SPECIAL_ACTIVITY_STATS_INSTALLED' => 'إصدار النسخة : v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'    => 'إحصائيات اليوم',
	'SPECIAL_ACTIVITY_STATS_DISP_SET' => 'إظهار الإعدادات',
	'SPECIAL_ACTIVITY_STATS_OTHER'    => 'إعدادات أخرى',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'     => 'عرض المواضيع الجديدة ',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP' => 'إظهار عدد المواضيع الجديدة',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'      => 'عرض المشاركات الجديدة ',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'  => 'إظهار عدد المشاركات الجديدة',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'      => 'عرض الأعضاء الجُدد ',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'  => 'إظهار عدد الأعضاء الجُدد',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'        => 'عرض محركات البحث ',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'    => 'ربما يسأل بعض الأعضاء عن محركات البحث ويقلق منها.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'      => 'عرض الزائرين ',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'  => 'إظهار عدد الزائرين في الإحصائيات ؟',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'      => 'عرض الأعضاء المخفيين ',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'  => 'هل تريد إظهار الأعضاء المخفيين في الإحصائيات ؟ ( الصلاحية مطلوبة )',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'        => 'عرض الوقت ',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'    => 'سيتم إظهار الوقت لجميع الأعضاء. لا يوجد تخصيص للمدراء فقط.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT' => 'تنسيق الوقت ',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'       => 'عند الإشارة بالماوس',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'          => 'عرض رقم الـ IP',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'      => 'متاح فقط للأعضاء الذين لديهم الصلاحيات الإدارية , مثل صفحة "الموجودون الآن / viewonline.php" ',

	'SPECIAL_ACTIVITY_STATS_RECORD'            => 'السجل ',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'        => 'إظهار وحفظ السجل',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT' => 'تنسيق التاريخ لقائمة السجل ',
	'SPECIAL_ACTIVITY_STATS_RESET'             => 'إعادة ضبط السجل ',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'         => 'إعادة ضبط الوقت والعدد لسجل إحصائيات اليوم.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'        => 'هل أنت متأكد من إعادة ضبط السجل ؟',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED' => 'تم التحديث بنجاح.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'        => 'ترتيب الأعضاء حسب ',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'    => 'اختار الترتيب الذي تريده لإظهار الأعضاء.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'      => 'إسم المستخدم A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'      => 'إسم المستخدم Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'      => 'وقت الزيارة تصاعدياً',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'      => 'وقت الزيارة تنازلياً',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'      => 'رقم العضو تصاعدياً',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'      => 'رقم العضو تنازلياً',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'     => 'الملفات المؤقتة (ثواني)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP' => 'الفترة التي لا يتم إعادة قراءة البيانات من جديد (لتحسين الأداء)',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'فحص الصلاحيات ',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'اختيارك "لا" يعني أن جميع الأعضاء يستطيعون مُشاهدة إحصائيات اليوم ( تجاهل إعدادات الصلاحية ); اختيارك "نعم" يعني استخدام صلاحية مُحددة ( مثال : السماح للأعضاء الجُدد فقط : لوحة التحكم الرئيسية ->الصلاحيات->صلاحيات عامة -> صلاحيات المجموعات -> آخر الأعضاء المسجلين -> صلاحيات متقدمة -> عام -> "يستطيع مُشاهدة إحصائيات اليوم")',

	'SPECIAL_ACTIVITY_STATS_MODE'             => 'عرض الأعضاء خلال ',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'         => 'إظهار الأعضاء خلال اليوم ( 24 ساعة ) , أو خلال فترة مُحددة يمكنك تحديدها من الخيار التالي.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'       => 'اليوم',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'      => 'فترة مُحددة',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'  => 'أجعلها "صفر" في حالة أنك تريد إظهار الأعضاء خلال الـ24 ساعة',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2' => 'هذا الخيار غير فعال في حالة تحديد "اليوم" في الخيار أعلاه',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3' => 'ثواني',

]);
