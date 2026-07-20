<?php

/**
 * Limit Posts per Forum. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, kasimi, https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

$lang = array_merge($lang, [
	'ERROR_POST_COUNT' => [
		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
	],
	'ERROR_POST_COUNT_TIME' => [
		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
	],
	'ERROR_TOPIC_COUNT' => [
		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
	],
	'ERROR_TOPIC_COUNT_TIME' => [
		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
	],
	'ERROR_POST_REST' => [
		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
	],
	'ERROR_TOPIC_REST' => [
		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
	],
	'ERROR_POST_TOPIC_REST'   => 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
	'ERROR_POSTS_TOPIC_REST'  => 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
	'ERROR_POST_TOPICS_REST'  => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
	'ERROR_POSTS_TOPICS_REST' => 'Podes adicionar <strong class="error">%1$s</strong> novos tópicos e <strong class="error">%2$s</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
]);
