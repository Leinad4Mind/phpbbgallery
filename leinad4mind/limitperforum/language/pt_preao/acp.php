<?php

/**
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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

$lang = array_merge($lang, [
	'LIMIT_PER_FORUM'              => 'Limitar Mensagens por Fórum',
	'FORUM_MAX_POSTS'              => 'Número máximo de mensagens por utilizador',
	'FORUM_MAX_POSTS_SHORT'        => 'Limite de mensagens',
	'FORUM_MAX_TOPICS'             => 'Número máximo de tópicos por utilizador',
	'FORUM_MAX_TOPICS_SHORT'       => 'Limite de tópicos',
	'FORUM_MAX_GROUPS'             => 'Limites por grupo',
	'FORUM_MAX_GROUPS_EXPLAIN'     => 'Os limites por grupo substituem os limites acima. Define as horas como 0 para desactivar o limite de tempo.',
	'FORUM_MAX_TOPICS_EXPLAIN'     => 'Deve ser inferior ao número máximo de mensagens, excepto se estiver definido como 0',
	'FORUM_MAX_TOPICS_ERROR'       => 'O número máximo de tópicos por fórum deve ser inferior ao número máximo de mensagens por fórum',
	'FORUM_MAX_TP_EXPLAIN'         => 'Define como 0 para desactivar. Define as horas como 0 para desactivar o limite de tempo.',
	'LIMIT_POSTS_PER_FORUM_TOPICS' => 'tópicos',
	'LIMIT_POSTS_PER_FORUM_POSTS'  => 'mensagens',
	'LIMIT_POSTS_PER_FORUM_EVERY'  => 'a cada',
	'LIMIT_POSTS_PER_FORUM_HOURS'  => 'horas',
]);
