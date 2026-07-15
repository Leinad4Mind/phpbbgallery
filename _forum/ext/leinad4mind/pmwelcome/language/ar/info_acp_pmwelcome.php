<?php

/**
*
* @package PM Welcome [Arabic]
* @copyright BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Translated to Arabic by Bassel Taha Alhitary (http://www.alhitary.net)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_PMWELCOME'					=> 'رسالة الترحيب',
	'ACP_PMWELCOME_EXPLAIN'			=> 'من هنا تستطيع تحديد نص رسالة الترحيب التي سيتم إرسالها إلى العضو عند تسجيل أول دخول له للمنتدى.',
	'ACP_PMWELCOME_SETTINGS'		=> 'الإعدادات.',
	'ACP_PMWELCOME_USER'			=> 'المرسل ',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'اكتب رقم العضوية للعضو الذي تريد أن يكون مُرسل رسالة الترحيب.',
	'ACP_PMWELCOME_SUBJECT'			=> 'عنوان الموضوع ',
	'ACP_PMWELCOME_TEXT'			=> 'نص رسالة الترحيب',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'تستطيع استخدام أكواد البي بي bbcode والإبتسامات , وكذلك تستطيع استخدام الرمز "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} و {BOARD_SIG}".',
));
