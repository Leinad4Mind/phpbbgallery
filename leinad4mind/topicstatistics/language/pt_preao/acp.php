<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
// ’ » “ ” …

$lang = array_merge($lang, [
   'TS_NAME'                             => 'Estatísticas do Tópico',
   'TS_TOPICS_ENABLED'                   => 'Activar Estatísticas dos Tópicos',
   'TS_USER_LIMIT_MAX'                   => 'Número máximo de utilizadores a exibir',
   'TS_USER_LIMIT_MAX_EXPLAIN'           => 'Limita número de utilizadores a exibir para melhorar performance em fóruns com muitos utilizadores',
   'TS_USER_PROFILE_LINK'                => 'Adicionar link no nome do utilizador',
   'TS_USER_PROFILE_LINK_EXPLAIN'        => 'Adiciona link do perfil no nome do utilizador',
   'TS_TOPICS_VISIT'                     => 'Mostrar número de visitas nos tópicos',
   'TS_TOPICS_VISIT_EXPLAIN'             => 'Mostra o número de visitas que cada tópico recebeu.',
   'TS_TOPICS_BOOKMARK'                  => 'Activar favoritos nos tópicos',
   'TS_TOPICS_BOOKMARK_EXPLAIN'          => 'Mostra o número de utilizadores que adicionaram o tópico aos favoritos.',
   'TS_TOPICS_BOOKMARK_USERS'            => 'Mostrar favoritos nos tópicos',
   'TS_TOPICS_BOOKMARK_USERS_EXPLAIN'    => 'Mostra os utilizadores que adicionaram o tópico aos favoritos.',
   'TS_TOPICS_BOOKMARK_AVATARS'          => 'Mostrar avatar de favoritos nos tópicos',
   'TS_TOPICS_BOOKMARK_AVATARS_EXPLAIN'  => 'Mostra o avatar de utilizadores que adicionaram o tópico aos favoritos.',
   'TS_TOPICS_FOLLOWERS'                 => 'Activar seguidores nos tópicos',
   'TS_TOPICS_FOLLOWERS_EXPLAIN'         => 'Mostra o número de utilizadores que seguem o tópico.',
   'TS_TOPICS_FOLLOWERS_USERS'           => 'Mostrar seguidores nos tópicos',
   'TS_TOPICS_FOLLOWERS_USERS_EXPLAIN'   => 'Mostra os utilizadores que seguem o tópico.',
   'TS_TOPICS_FOLLOWERS_AVATARS'         => 'Mostrar avatar de seguidores nos tópicos',
   'TS_TOPICS_FOLLOWERS_AVATARS_EXPLAIN' => 'Mostra o avatar dos utilizadores que seguem o tópico.',
   'TS_FORUMS_ENABLED'                   => 'Activar Estatísticas dos fóruns',
   'TS_FORUMS_VISIT'                     => 'Mostrar número de visitas nos fóruns',
   'TS_FORUMS_VISIT_EXPLAIN'             => 'Mostra o número de visitas que cada fórum recebeu.',
   'TS_FORUMS_FOLLOWERS'                 => 'Activar seguidores nos fóruns',
   'TS_FORUMS_FOLLOWERS_EXPLAIN'         => 'Mostra o número de utilizadores que seguem o fórum.',
   'TS_FORUMS_FOLLOWERS_USERS'           => 'Mostrar seguidores nos fóruns',
   'TS_FORUMS_FOLLOWERS_USERS_EXPLAIN'   => 'Mostra os utilizadores que seguem o fórum.',
   'TS_FORUMS_FOLLOWERS_AVATARS'         => 'Mostrar avatar de seguidores nos fóruns',
   'TS_FORUMS_FOLLOWERS_AVATARS_EXPLAIN' => 'Mostra o avatar dos utilizadores que seguem o fórum.',
]);