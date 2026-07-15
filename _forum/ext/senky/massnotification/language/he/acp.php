<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'MASSNOTIFICATION_DESC'	=> 'כאן באפשרותך לשלוח הודעת התראת לוח לכל המשתמשים, משתמשים ספציפיים או קבוצות ספציפיות.',

	'COMPOSE'				=> 'כתוב התראה המונית',
	'ALL_USERS'				=> 'כל המשתמשים',
	'SEND_TO_GROUP'			=> 'שלח לקבוצה',
	'SEND_TO_USERS'			=> 'שלח למשתמשים',
	'SEND_TO_USERS_EXPLAIN'	=> 'הזנת שמות כאן תעקוף כל קבוצה שנבחרה לעיל. הזן כל שם משתמש בשורה חדשה.',
	'TITLE'					=> 'כותרת התראה',
	'MESSAGE_EXPLAIN'		=> 'שמור בניסוח קצר, רצוי מתחת ל -150 תווים. ניתן להשתמש ב- HTML.',
	'URL'					=> 'כתובת אתר (URL) לניתוב הפניה מחדש',
	'URL_EXPLAIN'			=> 'הזן כתובת אתר (URL) שאליה יופנה המשתמש לאחר לחיצה על ההודעה.',
	'AUTHOR_EXPLAIN'		=> 'הזן את מחבר ההודעה. השאר ריק עבור הודעה כללית ללא מחבר.',
	'SEND_NOTIFICATION'		=> 'שלח התראה',

	'NO_NOTIFICATION_TITLE'		=> 'עליך לציין כותרת התראה.',
	'NO_NOTIFICATION_MESSAGE'	=> 'עליך לציין תוכן הודעת התראה.',
	'NO_NOTIFICATION_AUTHOR'	=> 'המחבר אינו קיים.',

	'NOTIFICATION_SEND'	=> 'ההתראה שלך נשלחה.',
));
