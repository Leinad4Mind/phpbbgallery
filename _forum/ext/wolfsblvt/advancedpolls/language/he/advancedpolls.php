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
	'ADVANCEDPOLLS_EXT_NAME'				=> 'סקרים מתקדמים',

// Viewtopic
	'AP_VOTES_HIDDEN'						=> 'הצבעות נסתרות',
	'AP_POLL_RUN_TILL_APPEND'				=> ', עד אז  כל ההצבעות נסתרות.',
	'AP_VOTERS'								=> 'מצביעים',
	'AP_NONE'								=> 'אין',
	'AP_DELETED_USER'					=> 'משתמש שנמחק',

	'AP_POLL_CANT_VOTE'						=> 'אתה לא יכול להשתתף בסקר זה. סיבה-',
	'AP_POLL_REASON_NOT_POSTED'				=> 'לא כתבת הודעה בנושא זה',
	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'שים לב שההצבעה שלך גלויה.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'הצג תוצאות מבלי להצביע',
	'AP_POLL_RESULTS_ARE_ORDERED' => 'לתשומת לבך, התוצאות ממוינות לפי מספר הקולות בסדר יורד.',
	'AP_POLL_TYPE_MISMATCH' => 'נתוני הסקר אינם עקביים, שגיאה פנימית.',
	'AP_VOTE_CHANGED' => 'אין לך הרשאה לשנות את הקולות שכבר הצבעת.',
	'AP_TOO_MANY_VOTES' => 'ניסית להקצות יותר מדי קולות.',
	'AP_ABSTAINERS' => 'בחרו שלא להצביע',
	'AP_DELETE_VOTE' => 'מחיקת ההצבעה שלי',

	'AP_MAX_VOTES_SELECT' => [
		1 => 'ניתן לתת עד <strong>%2$d</strong> קולות לאפשרות <strong>%1$d</strong>',
		2 => 'ניתן לחלק עד <strong>%2$d</strong> קולות בין <strong>%1$d</strong> אפשרויות',
	],
	'AP_GUEST_VOTES' => [
		1 => '%d קול מאורח',
		2 => '%d קולות מאורחים',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d הצבעה',
		2 => '%d הצבעות',
	],
	'AP_SCORE_BREAKDOWN' => 'פירוט ההצבעות',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d הצבעה של %2$d נקודה',
		2 => '%1$d הצבעות של %2$d נקודות',
	],
	'AP_RANK_TOTAL' => [1 => 'נקודה %d', 2 => '%d נקודות'],
	'AP_RANK_BREAKDOWN' => 'פירוט הדירוג',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => 'קול %1$d במיקום %2$d', 2 => '%1$d קולות במיקום %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'יש לבחור בדיוק אפשרות %d לפי סדר העדיפות.',
		2 => 'יש לבחור בדיוק %d אפשרויות לפי סדר העדיפות.',
	],
// Posting
	'AP_POLL_TYPE' => 'סוג הסקר',
	'AP_POLL_TYPE_EXPLAIN' => 'בחר כיצד משתמשים מקצים את הקולות או הנקודות שלהם.',
	'AP_POLL_TYPE_CHOICE' => 'בחירה',
	'AP_POLL_TYPE_SCORING' => 'ניקוד מספרי',
	'AP_POLL_TYPE_RANKING' => 'דירוג לפי סדר',
	'AP_POLL_VISIBILITY' => 'נראות התוצאות',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'בחר מתי התוצאות הכוללות של הסקר יהיו גלויות.',
	'AP_VISIBILITY_PUBLIC' => 'ציבורי — להציג תמיד את התוצאות',
	'AP_VISIBILITY_DEFAULT' => 'לאחר ההצבעה הראשונה',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'לאחר שימוש בכל הקולות הזמינים',
	'AP_VISIBILITY_PRIVATE' => 'פרטי — רק לאחר סיום הסקר',
	'AP_POLL_VOTE_MODE' => 'שינוי הצבעות',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'בחר אם ההצבעות סופיות, ניתנות לשליחה בהדרגה או ניתנות לשינוי כל עוד הסקר פתוח.',
	'AP_VOTE_MODE_NO_CHANGE' => 'ללא שינויים',
	'AP_VOTE_MODE_INCREMENTAL' => 'הצבעה הדרגתית',
	'AP_VOTE_MODE_CHANGE' => 'לאפשר שינויים',
	'AP_POLL_VOTES_HIDE'					=> 'הסתר הצבעות',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'אם מופעל ההצבעות נסתרות עד סיום הסקר. אפשרות זו עובדת רק אם לסקר יש מועד סיום.',
	'AP_POLL_VOTERS_SHOW'					=> 'הצג מצביעים',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'אם מופעל בעלי הרשאות יוכלו לראות מי הצביע. שים לב שמצביעים עדיין יהיו נסתרים אם האפשרות מופעלות.',
	'AP_POLL_VOTERS_LIMIT'					=> 'הגבל הצבעות',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'אם מופעל רק מי שכתב הודעה בנושא זה יכול להצביע.',
	'AP_POLL_SHOW_ORDERED' => 'הצגת תוצאות ממוינות',
	'AP_POLL_SHOW_ORDERED_EXPLAIN' => 'כאשר התוצאות מוצגות, הן ממוינות לפי מספר הקולות בסדר יורד. אחרת נשמר סדר אפשרויות הסקר.',
	'AP_POLL_COLLAPSIBLE' => 'סקר מתקפל',
	'AP_POLL_COLLAPSIBLE_EXPLAIN' => 'מאפשר למשתמשים לכווץ ולהרחיב את הסקר הזה.',
	'AP_COLLAPSE_POLL' => 'כיווץ הסקר',
	'AP_EXPAND_POLL' => 'הרחבת הסקר',
	'AP_RUN_POLL' => 'משך הסקר',
	'AP_RUN_POLL_FOR' => 'למשך',
	'AP_RUN_POLL_UNTIL' => 'עד',
	'AP_RUN_POLL_INDEFINITELY' => 'ללא הגבלה',
	'AP_POLL_END' => 'סיום הסקר',
	'AP_POLL_END_EXPLAIN' => 'ציין את התאריך והשעה שבהם הסקר יסתיים. מילוי אחד מהשדות מחליף את משך הסקר. שדות תאריך ריקים ישתמשו בתאריך הסיום הנוכחי ושדות שעה ריקים ישתמשו ב־0. כדי לחזור לשימוש במשך הסקר יש לנקות את כל השדות.',

	'AP_YYYY_MM_DD' => 'YYYY-MM-DD',
	'AP_HH_MM' => 'HH:MM',
	'AP_POLL_END_INVALID' => 'התאריך או השעה שצוינו אינם תקינים',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES' => 'מספר הקולות המרבי לאפשרות אחת אינו יכול להיות גדול ממספר הקולות הכולל לחלוקה',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS' => 'מספר האפשרויות המרבי לבחירה אינו יכול להיות גדול ממספר הקולות הכולל לחלוקה',

	'AP_POLL_MAX_VALUE' => 'מספר קולות מרבי',
	'AP_POLL_MAX_VALUE_EXPLAIN' => 'זהו מספר הקולות המרבי שמצביע יכול לתת לאפשרות אחת.',
	'AP_POLL_TOTAL_VALUE' => 'סך כל הקולות',
	'AP_POLL_TOTAL_VALUE_EXPLAIN' => 'זהו מספר הקולות הכולל שמצביע יכול לחלק בין כל האפשרויות.',

	'AP_RANK_POINTS' => 'נקודות לפי מיקום',
	'AP_RANK_POINTS_EXPLAIN' => 'הגדר ערך חיובי ויורד לכל מיקום בדירוג. מספר המיקומים נקבע לפי מספר האפשרויות המרבי למשתמש.',
	'AP_RANK_POSITION' => 'מיקום %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE' => 'לא ניתן להקצות מספר קולות גדול מהערך המרבי המותר.',
	'AP_POLL_VALUES_INVALID' => 'הניקוד המזערי אינו יכול לעלות על הניקוד המרבי; מספר האפשרויות המרבי, הניקוד המרבי והניקוד הכולל חייבים להיות גדולים מאפס.',
	'AP_RANK_POSITIONS_INVALID' => 'מספר מיקומי הדירוג חייב להיות בין 1 למספר אפשרויות הסקר.',
	'AP_RANK_POINTS_INCOMPLETE' => 'יש להגדיר ערך נקודות לכל מיקום בדירוג.',
	'AP_RANK_POINTS_INVALID' => 'כל ערך נקודות בדירוג חייב להיות בין 1 ל־999.',
	'AP_RANK_POINTS_ORDER' => 'ערכי הנקודות חייבים לרדת מהדירוג הראשון לאחרון.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'לא ניתן להשתמש בהצבעה מצטברת עם דירוג לפי סדר.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'יש לבחור בדיוק את מספר האפשרויות שהוגדר, לפי סדר העדיפות.',
	'AP_QUESTION' => 'שאלה',
	'AP_QUESTION_REQUIRED' => 'שאלת חובה',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'יש לחייב מענה על השאלה הראשונה לפני שניתן לשלוח את טופס ההצבעה המלא.',
	'AP_APPEND_OPTIONS' => 'הוספת אפשרויות בלי לאפס הצבעות',
	'AP_APPEND_OPTIONS_EXPLAIN' => 'שומר את כל ההצבעות הקיימות ומוסיף רק אפשרויות חדשות בסוף רשימת האפשרויות של שאלה.',
	'AP_APPEND_OPTIONS_WARNING' => 'אין לשנות שם, להסיר או לסדר מחדש שאלות ואפשרויות קיימות. יש לאפשר שינוי הצבעה. מצביעים רשומים קודמים הזכאים לכך יקבלו הודעה בהתאם להגדרת לוח הניהול ולהעדפות ההתראה שלהם.',
	'AP_APPEND_INVALID' => 'לא ניתן להוסיף אפשרויות לסקר זה בבטחה.',
	'AP_APPEND_REQUIRES_CHANGES' => 'יש לאפשר שינוי הצבעה לפני הוספת אפשרויות בלי לאפס הצבעות קיימות.',
	'AP_APPEND_POLL_ENDED' => 'לא ניתן להוסיף אפשרויות בלי לאפס הצבעות לאחר שהסקר הסתיים.',
	'AP_APPEND_STRUCTURE_CHANGED' => 'שאלות או אפשרויות קיימות שונו. יש לשחזר את ההגדרה המקורית ולהוסיף אפשרויות חדשות רק בסוף.',
	'AP_APPEND_TOO_MANY' => 'האפשרויות שנוספו חורגות מהמספר המרבי שהוגדר לאפשרויות בסקר.',
	'AP_APPEND_NONE' => 'לא נוספו אפשרויות חדשות לסקר.',
	'AP_ADDITIONAL_QUESTIONS' => 'עמודי שאלות נוספים',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'כל עמוד משתמש באותו סוג סקר ובאותם כללים של מגבלות, ניקוד, נראות ושינוי הצבעה. יש להזין אפשרות אחת בכל שורה.',
	'AP_ADD_QUESTION' => 'הוספת שאלה',
	'AP_MULTI_INVALID' => 'נתוני השאלות הנוספות אינם תקינים.',
	'AP_MULTI_TOO_MANY' => 'סקר יכול לכלול עד 20 שאלות נוספות.',
	'AP_MULTI_CONTENT_INVALID' => 'לכל שאלה נוספת דרושים כותרת ומספר מספיק של אפשרויות תקינות בהתאם למגבלות הכלליות של הסקר.',
	'AP_REQUIRED_QUESTION_MISSING' => 'יש לענות על שאלת חובה זו לפני שממשיכים.',
	'AP_POLL_NAVIGATION' => 'ניווט בין שאלות הסקר',
	'AP_POLL_MIN_VALUE' => 'ניקוד מינימלי',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'זהו הניקוד המינימלי שמצביע רשאי להקצות לאפשרות שנבחרה.',
	'AP_VOTE_OUTSIDE_RANGE' => 'כל ניקוד חייב להיות בין ערכי המינימום והמקסימום שהוגדרו.',
]);
