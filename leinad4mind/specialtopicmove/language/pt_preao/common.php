<?php

/**
 * Prime Topic Move. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, kasimi, https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'SPECIAL_TOPIC_MOVE_ENTER_REASON' => [
		1 => 'Por favor, escreve um motivo para mover este tópico',
		2 => 'Por favor, escreve um motivo para mover estes tópicos',
	],
	'SPECIAL_TOPIC_MOVED_MESSAGE' => 'Este tópico foi movido',
	'SPECIAL_TOPIC_MOVED_FROM'    => 'de <strong>%s</strong>',
	'SPECIAL_TOPIC_MOVED_TO'      => 'para <strong>%s</strong>',
	'SPECIAL_TOPIC_MOVED_BY'      => 'por %s',
	'SPECIAL_TOPIC_MOVED_ON'      => 'em %s.',
	'SPECIAL_TOPIC_MOVED_NO_USER' => 'desconhecido',
	'SPECIAL_TOPIC_MOVED_UNDO'    => 'Mover este tópico de volta.',

	'SPECIAL_TOPIC_MOVED_NOTIFICATION'       => 'Quando alguém move um tópico teu.',
	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE' => 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
]);
