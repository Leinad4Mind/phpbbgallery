<?php

/**
*
* @package PM Welcome [Spanish]
* @copyright BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Translated to Spanish by zone_sjm (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1497666)
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
	'ACP_PMWELCOME'					=> 'Mensaje privado de bienvenida',
	'ACP_PMWELCOME_EXPLAIN'			=> 'Usted puede especificar el texto del mensaje personal que será enviado al usuario en el momento que se inscriba.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Configuraciones del mensaje de bienvenida.',
	'ACP_PMWELCOME_USER'			=> 'Remitente',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'El id del usuario del foro quien enviara el mensaje privado.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Asunto',
	'ACP_PMWELCOME_TEXT'			=> 'Texto del mensaje de bienvenida',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'Usted puede usar bbcode y emoticonos, y las marcas claves "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} y {BOARD_SIG}".',
));
