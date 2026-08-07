<?php
/**
 *
 * Advanced Polls [Hebrew]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Translation by koraldon (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=336119)
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
	'AP_TITLE_ACP'					=> 'סקרים מתקדמים',
	'AP_SETTINGS_ACP'				=> 'הגדרות',

	'AP_TITLE'						=> 'סקרים מתקדמים',
	'AP_TITLE_EXPLAIN'				=> 'מקדם את מערכת הסקרים של phpBB עם אפשרויות חדשות כגון הסתרת הצבעות עד סוף הסקר, הצגת שמות המצביעים ועוד.',

	'AP_SETTINGS'					=> 'הגדרות סקרים מתקדמים',
	'AP_GLOBAL_SETTINGS' => 'הגדרות כלליות של סקרים מתקדמים',
	'AP_PER_POLL_SETTINGS' => 'הגדרות לכל סקר',
	'AP_DEFAULT_POLL_VISIBILITY' => 'נראות ברירת המחדל של התוצאות',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'מצב הנראות שנבחר כברירת מחדל בעת יצירת סקר.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'מצב ברירת המחדל לשינוי הצבעה',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'מצב שינוי ההצבעה שנבחר כברירת מחדל בעת יצירת סקר.',
	'AP_VISIBILITY_PUBLIC' => 'ציבורי — להציג תמיד את התוצאות',
	'AP_VISIBILITY_DEFAULT' => 'לאחר ההצבעה הראשונה',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'לאחר שימוש בכל הקולות הזמינים',
	'AP_VISIBILITY_PRIVATE' => 'פרטי — רק לאחר סיום הסקר',
	'AP_VOTE_MODE_NO_CHANGE' => 'ללא שינויים',
	'AP_VOTE_MODE_INCREMENTAL' => 'הצבעה הדרגתית',
	'AP_VOTE_MODE_CHANGE' => 'לאפשר שינויים',

	'AP_ACT_VOTES_HIDE'				=> 'הפעלת הסתרת מצביעים',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'מפעיל את האפשרות לבחר להסתיר את ההצבעות עד תום הסקר.',
	'AP_ACT_VOTERS_SHOW'			=> 'הפעל הצגת מצביעים',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'מפעיל את האפשרות לבחור ששמות המצביעים יוצגו בתוצאה שהם בחרו.',
	'AP_ACT_VOTERS_LIMIT'			=> 'הפעל הגבלת מצביעים',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'מפעיל את האפשרות לבחור שרק מי שפרסם הודעה בנושא יכול להצביע בסקר.',
	'AP_ACT_POLL_NO_VOTE' => 'הפעלת האפשרות לא להצביע',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN' => 'מחליף את הקישור „הצג תוצאות” בקישור „לא להצביע, הצג תוצאות”, שמונע הצבעה לאחר מכן אלא אם מותר לשנות הצבעות.',
	'AP_ACT_SHOW_ABSTAINERS' => 'הצגת מספר הנמנעים',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'מציג כמה משתמשים רשומים בחרו במפורש שלא להצביע. שמות מוצגים רק כאשר רשימת המצביעים פעילה ולמשתמש יש הרשאה.',
	'AP_ACT_VOTE_DELETE' => 'לאפשר מחיקת הצבעה',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'מאפשר למשתמשים רשומים למחוק את ההצבעה שלהם כל עוד הסקר פתוח ומאפשר שינויים.',
	'AP_ACT_SHOW_ORDERED' => 'הפעלת תוצאות ממוינות',
	'AP_ACT_SHOW_ORDERED_EXPLAIN' => 'מאפשר להציג את התוצאות לפי מספר הקולות בסדר יורד.',
	'AP_ACT_POLL_SCORING' => 'הפעלת סקרי ניקוד',
	'AP_ACT_POLL_SCORING_EXPLAIN' => 'מאפשר להעניק ניקוד שונה לאפשרויות הסקר.',
	'AP_ACT_INCREMENTAL_VOTES' => 'הפעלת הצבעה הדרגתית',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN' => 'מאפשר להצביע בהדרגה כל עוד נותרו קולות זמינים.',
	'AP_ACT_CLOSED_VOTING' => 'הפעלת הצבעה בנושא נעול',
	'AP_ACT_CLOSED_VOTING_EXPLAIN' => 'מאפשר להצביע בסקר פתוח גם כאשר הנושא נעול.',
	'AP_ACT_POLL_END' => 'הפעלת תאריך סיום לסקר',
	'AP_ACT_POLL_END_EXPLAIN' => 'מאפשר לציין תאריך ושעה מדויקים לסיום הסקר במקום משך זמן מתחילת הסקר.',
	'AP_ACT_POLL_NOTIFICATIONS' => 'הפעלת התראות סקר',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN' => 'מפעיל התראות כאשר תוצאות של סקר מוסתר נעשות גלויות וכאשר אפשרויות חדשות נוספות לסקר שבו משתמש הצביע.',
	'AP_ACT_POLL_COLLAPSIBLE' => 'הפעלת סקרים מתקפלים',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN' => 'מציג את אפשרות הקיפול בעת יצירה או עריכה של סקר. בעת ההתקנה ההגדרה מופעלת אוטומטית אם „Collapsible Forum Categories” מותקנת; מנהלים יכולים לשנות אותה בכל עת.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'ברירת המחדל עבור שינוי הצבעות',
	'AP_DEFAULT_VOTES_HIDE'			=> 'ברירת המחדר עבור הסתרת מצביעים',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'ברירת המחדל עבור הצגת מצביעים',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'ברירת המחדל עבור הגבלת מצביעים',
	'AP_DEFAULT_SHOW_ORDERED' => 'הצגת תוצאות ממוינות כברירת מחדל',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>השלבים הבאים</strong></p><ol><li>בדוק את הגדרות ההרחבה תחת <strong>%1$s » %2$s » %3$s</strong> והגדר את תכונות הסקרים ואת ערכי ברירת המחדל הדרושים לפורום.</li><li>בדוק את ההרשאות <strong>%8$s</strong> ו־<strong>%9$s</strong> תחת <strong>%4$s » %5$s » %6$s</strong> (חברים) ותחת <strong>%4$s » %5$s » %7$s</strong> (מנהלים). הענק אותן רק לתפקידים או לקבוצות שרשאים לראות את זהות המצביעים.</li></ol><p>שאר תכונות הסקרים אינן דורשות הגדרה נוספת.</p></div>',
]);
