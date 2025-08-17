<?php

/**
 *
 * @package PM Welcome [Deutsch]
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
   exit;
}

if (empty($lang) || !is_array($lang)) {
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
// ’ « » “ ” …
//
$lang = array_merge($lang, [
   'ACP_PMWELCOME'               => 'Willkommensnachricht',
   'ACP_PMWELCOME_EXPLAIN'         => 'Hier kannst du den Text festlegen, den die Persönliche Nachricht enthalten soll, die einem neuen Benutzer nach seiner Registrierung gesendet wird.',
   'ACP_PMWELCOME_SETTINGS'      => 'Einstellungen Willkommensnachricht.',
   'ACP_PMWELCOME_USER'         => 'Absender',
   'ACP_PMWELCOME_USER_EXPLAIN'   => 'Gib die ID des Forumbenutzers an, unter dessen Namen die private Nachricht gesendet werden soll.',
   'ACP_PMWELCOME_SUBJECT'         => 'Betreff der Nachricht',
   'ACP_PMWELCOME_TEXT'         => 'Text der Willkommensnachricht',
   'ACP_PMWELCOME_TEXT_EXPLAIN'   => 'Du kannst BBCode und Smilies benutzen, und die Tokens "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} and {BOARD_SIG}", die in der Nachricht ersetzt werden.',
]);
