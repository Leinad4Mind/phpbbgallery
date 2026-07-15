<?php

/**
*
* @package PM Welcome [Czech]
* @copyright BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Translated to Czech by překlad R3gi
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
	'ACP_PMWELCOME'					=> 'Uvítací zpráva',
	'ACP_PMWELCOME_EXPLAIN'			=> 'Umožňuje nastavit text soukromé zprávy, která bude zaslána novému uživateli po registraci.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Nastavení uvítací zprávy.',
	'ACP_PMWELCOME_USER'			=> 'Odesílatel',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'ID uživatele fóra, jehož jménem bude soukromá zpráva zaslána.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Předmět',
	'ACP_PMWELCOME_TEXT'			=> 'Text uvítací zprávy',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'Můžete používat BBCode, smajlíky a proměnnou "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} a {BOARD_SIG}".',
));
