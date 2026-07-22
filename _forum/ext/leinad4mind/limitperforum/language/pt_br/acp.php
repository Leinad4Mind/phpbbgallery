<?php

/**
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'LIMIT_PER_FORUM'              => 'Limitar Posts por Fórum',
	'FORUM_MAX_POSTS'              => 'Número máximo de posts por usuário',
	'FORUM_MAX_POSTS_SHORT'        => 'Limite de posts',
	'FORUM_MAX_TOPICS'             => 'Número máximo de tópicos por usuário',
	'FORUM_MAX_TOPICS_SHORT'       => 'Limite de tópicos',
	'FORUM_MAX_GROUPS'             => 'Limites por grupo',
	'FORUM_MAX_GROUPS_EXPLAIN'     => 'Os limites por grupo substituem os limites acima. Defina as horas como 0 para desativar o limite de tempo.',
	'FORUM_MAX_TOPICS_EXPLAIN'     => 'Deve ser menor que o número máximo de posts, exceto se estiver definido como 0',
	'FORUM_MAX_TOPICS_ERROR'       => 'O número máximo de tópicos por fórum deve ser menor que o número máximo de posts por fórum',
	'FORUM_MAX_TP_EXPLAIN'         => 'Defina como 0 para desativar. Defina as horas como 0 para desativar o limite de tempo.',
	'LIMIT_POSTS_PER_FORUM_TOPICS' => 'tópicos',
	'LIMIT_POSTS_PER_FORUM_POSTS'  => 'posts',
	'LIMIT_POSTS_PER_FORUM_EVERY'  => 'a cada',
	'LIMIT_POSTS_PER_FORUM_HOURS'  => 'horas',
]);
