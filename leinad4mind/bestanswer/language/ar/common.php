<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
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
	$lang = array();
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

$lang = array_merge($lang, array(
	'ANSWERS'	=> 'الإجابات',
	'ANSWERED'		=> 'أجاب',
	
	'BEST_ANSWER'	=> 'افضل جواب',
	'BBPOINTS_ANSWER'			=> 'مقدار النقاط لمنشور "أفضل إجابة"',
	'BBPOINTS_ANSWER_EXPLAIN'	=> 'قم بتعيين عدد النقاط التي سيتم إضافتها لمؤلف النشر عندما يتم تمييز مشاركته في هذا المنتدى على أنها "أفضل إجابة"',

	'ENABLE_ANSWER'			=> 'تفعيل “أفضل إجابة”',
	'ENABLE_ANSWER_EXPLAIN'	=> 'عند اختيارك “نعم”, كاتب الموضوع (إذا لديه الترخيص) والمشرفين (بالمنتديات المسموح بها) يستطيعون إضافة علامة “أفضل إجابة” إلى أحد ردود الموضوع',
	'EXTENSION_NOT_ENABLED'			=> 'ملحق ”أفضل إجابة“ غير ممكّن في هذا المنتدى.',

	'LOG_MARK_ANSWER'	=> '<strong>تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
	'LOG_UNMARK_ANSWER'	=> '<strong>إلغاء تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',

	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>النقاط المضافة للكاتب للحصول على أفضل إجابة</strong><br />» %1$s بواسطة %2$s',
	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>إزالة نقاط المؤلف للحصول على أفضل إجابة</strong><br />» %1$s بواسطة %2$s',

	'MARK_ANSWER'			=> 'تحديد الإجابة الأفضل',
	'MARK_ANSWER_CONFIRM'	=> 'متأكد أنك تريد تحديد هذه المشاركة كأفضل إجابة؟',

	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
	'TOPIC_FIRST_POST'	=> 'لا يمكنك وضع علامة على هذا المنشور كأفضل إجابة لأنه المنشور الأول في الموضوع.', 
	'TOTAL_ANSWERS'	=> 'إجمالي الإجابات',

	'UNMARK_ANSWER'			=> 'إلغاء تحديد الإجابة الأفضل',
	'UNMARK_ANSWER_CONFIRM'	=> 'متأكد أنك تريد إلغاء تحديد هذه المشاركة كأفضل إجابة؟',

	'MARK_ANSWER_NOTIFICATION'			=> '%1$s حدد مشاركتك في الموضوع “%2$s” كأفضل إجابة.',
	'UNMARK_ANSWER_NOTIFICATION'		=> '%1$s ألغى تحديد مشاركتك في الموضوع “%2$s” كأفضل إجابة.',
	'NOTIFICATION_TYPE_MARK_ANSWER'		=> 'أحد الأعضاء يحدد مشاركتك بالموضوع كأفضل إجابة',
	'NOTIFICATION_TYPE_UNMARK_ANSWER'	=> 'أحد الأعضاء يلغي تحديد مشاركتك بالموضوع كأفضل إجابة',
));
