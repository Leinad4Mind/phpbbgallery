<?php

/**
*
* @package PM Welcome [Greek]
* @copyright BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Translated to Portuguese by gtsoukn
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
	'ACP_PMWELCOME'					=> 'Μήνυμα καλωσορίσματος',
	'ACP_PMWELCOME_EXPLAIN'			=> 'Μπορείτε να καθορίσετε το κείμενο της προσωπικό μήνυμα που θα σταλεί στον χρήστη κατά την εγγραφή.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Ρυθμίσεις μηνύματος καλωσορίσματος.',
	'ACP_PMWELCOME_USER'			=> 'Αποστολέας',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'Το id του μέλους από το οποίο θα σταλεί το προσωπικό μήνυμα.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Θέμα Μηνύματος',
	'ACP_PMWELCOME_TEXT'			=> 'Κείμενο μηνύματος',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'Μπορείτε να χρησιμοποιήσετε bbcode και smilies, και τις μεταβλητές "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} και {BOARD_SIG}".',
));
