<?php

/**
 * @package User Login Redirect for phpBB.
 * @copyright (c) 2014 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'INVALID_ANNOUNCEMENT_TOPIC' => 'O tópico de anúncio é inválido.',
	'INVALID_GROUP_TOPIC'        => 'O tópico de grupo é inválido.',
	'INVALID_WELCOME_TOPIC'      => 'O tópico de boas-vindas é inválido.',

	'LATEST' => 'Mais recente',

	'REDIRECT_ALWAYS'                    => 'Redirecionar sempre',
	'REDIRECT_ALWAYS_EXPLAIN'            => 'Redirecionar sempre o utilizador para o tópico especificado.',
	'REDIRECT_ANNOUNCE'                  => 'Redirecionar para anúncio no login',
	'REDIRECT_ANNOUNCE_EXPLAIN'          => 'Redirecionar todos os utilizadores que não fizeram login desde que o último anúncio foi publicado.',
	'REDIRECT_ANNOUNCE_MESSAGE_EXPLAIN'  => 'Apresentar uma mensagem a informar que o utilizador está a ser redirecionado para o último anúncio.',
	'REDIRECT_ANNOUNCE_OPTIONS'          => 'Opções de anúncio',
	'REDIRECT_ANNOUNCE_PRIORITY'         => 'Prioridade de redirecionamento de anúncio',
	'REDIRECT_ANNOUNCE_PRIORITY_EXPLAIN' => 'Especificar qual anúncio tem prioridade',
	'REDIRECT_ANNOUNCE_TOPIC_ID'         => 'ID do tópico de anúncio',
	'REDIRECT_ANNOUNCE_TOPIC_ID_EXPLAIN' => 'Insere o ID do tópico de anúncio para o qual deseja redirecionar todos os utilizadores.',
	'REDIRECT_ANY_ANNOUNCE_EXPLAIN'      => 'Redirecionar todos os utilizadores que não fizeram login desde que o anúncio especificado foi publicado.',

	'REDIRECT_ENABLE'  => 'Ativar',
	'REDIRECT_ENABLED' => 'Ativar redirecionamento de login do utilizador',

	'REDIRECT_GLOBAL'                 => 'Redirecionar para um anúncio Global',
	'REDIRECT_GLOBAL_EXPLAIN'         => 'Redirecionar o utilizador para um anúncio Global em vez de um anúncio "normal".',
	'REDIRECT_GROUP'                  => 'Redirecionamento para tópico de grupo',
	'REDIRECT_GROUP_ALL'              => 'Todos os membros de grupos',
	'REDIRECT_GROUP_ALL_EXPLAIN'      => 'Definir isto como Sim anulará qualquer grupo individual selecionado abaixo.',
	'REDIRECT_GROUP_EXPLAIN'          => 'Redirecionar membros de um grupo, ou de todos os grupos, para um tópico específico após o login.',
	'REDIRECT_GROUP_ID'               => 'Selecionar grupo',
	'REDIRECT_GROUP_MESSAGE_EXPLAIN'  => 'Apresentar uma mensagem a informar que o utilizador está a ser redirecionado para um tópico específico.',
	'REDIRECT_GROUP_OPTIONS'          => 'Opções de grupo',
	'REDIRECT_GROUP_TOPIC_ID'         => 'ID do tópico de grupo',
	'REDIRECT_GROUP_TOPIC_ID_EXPLAIN' => 'Insere o ID do tópico para o qual deseja redirecionar os membros do grupo.',

	'REDIRECT_LATEST_ANNOUNCE' => 'Redirecionamento para o anúncio mais recente no login',

	'REDIRECT_LOGIN'         => 'Redirecionamento de login',
	'REDIRECT_LOGIN_EXPLAIN' => 'Aqui pode escolher que um novo utilizador seja redirecionado para um tópico de boas-vindas no seu primeiro login após o registo, redirecionar todos os utilizadores para o anúncio mais recente se ainda não o tiverem visto e/ou redirecionar todos os membros ou os de um grupo selecionado para uma nova mensagem após fazerem login.',

	'REDIRECT_SHOW_MESSAGE' => 'Apresentar uma mensagem de redirecionamento',

	'REDIRECT_WELCOME'                  => 'Redirecionamento para tópico de boas-vindas',
	'REDIRECT_WELCOME_EXPLAIN'          => 'Redirecionar todos os novos utilizadores para um tópico de boas-vindas no primeiro login no fórum.',
	'REDIRECT_WELCOME_MESSAGE_EXPLAIN'  => 'Apresentar uma mensagem a informar que o novo utilizador está a ser redirecionado para o tópico de boas-vindas.',
	'REDIRECT_WELCOME_OPTIONS'          => 'Opções de boas-vindas',
	'REDIRECT_WELCOME_TOPIC_ID'         => 'ID do tópico de boas-vindas',
	'REDIRECT_WELCOME_TOPIC_ID_EXPLAIN' => 'Insere o ID do tópico de boas-vindas para o qual deseja redirecionar todos os novos utilizadores.',

	'SELECTED' => 'Selecionado',
]);
