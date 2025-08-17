<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	'TS_NAME'						=> 'Estatísticas do Tópico',
	'TS_ENABLED'					=> 'Activar Estatísticas do Tópico',
	'TS_VISIT'						=> 'Mostrar número de visitas',
	'TS_VISIT_EXPLAIN'				=> 'Mostrar o número de visitas ao tópico.',
	'TS_BOOKMARK'					=> 'Activar favoritos',
	'TS_BOOKMARK_EXPLAIN'			=> 'Mostra o número de utilizadores que adicionaram o tópico aos favoritos.',
	'TS_BOOKMARK_USERS'				=> 'Mostrar favoritos',
	'TS_BOOKMARK_USERS_EXPLAIN'		=> 'Mostrar utilizadores que adicionaram o tópico aos favoritos.',
	'TS_FOLLOWERS'					=> 'Activar seguidores',
	'TS_FOLLOWERS_EXPLAIN'			=> 'Mostra o número de utilizadores que seguem o tópico.',
	'TS_FOLLOWERS_USERS'			=> 'Mostrar seguidores',
	'TS_FOLLOWERS_USERS_EXPLAIN'	=> 'Mostrar utilizadores que seguem o tópico.',
]);
