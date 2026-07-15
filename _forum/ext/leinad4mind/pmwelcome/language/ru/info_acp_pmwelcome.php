<?php

/**
*
* @package PM Welcome [Russian]
* @copyright BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_PMWELCOME'					=> 'Приветственное сообщение',
	'ACP_PMWELCOME_EXPLAIN'			=> 'Вы можете указать текст личного сообщения который будет отправлен пользователю после регистрации.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Настройки приветственного сообщения.',
	'ACP_PMWELCOME_USER'			=> 'Отправитель',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'id пользователя форума, от имени которого будет отправлено личное сообщение.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Заголовок сообщения',
	'ACP_PMWELCOME_TEXT'			=> 'Текст приветственного сообщения',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'Вы можете использовать bbcode и смайлы, а также лексему "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} и {BOARD_SIG}".',
));
