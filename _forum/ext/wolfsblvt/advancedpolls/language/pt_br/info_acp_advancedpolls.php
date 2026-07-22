<?php

/**
 * Advanced Polls [English]
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
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
//

$lang = array_merge($lang, [
	'AP_TITLE_ACP'    => 'Votações Avançadas',
	'AP_SETTINGS_ACP' => 'Configuração',

	'AP_TITLE'         => 'Votações Avançadas',
	'AP_TITLE_EXPLAIN' => 'Melhora o sistema de votações nativo do phpBB com novas funcionalidades como ocultar votos até o final, mostrar os votantes da votação, limitar os votantes e mais.',
	'AP_COPYRIGHT'     => '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',

	'AP_SETTINGS'          => 'Configuração de Votações Avançadas',
	'AP_GLOBAL_SETTINGS'   => 'Configuração Global de Votações Avançadas (aplica-se a todas as votações)',
	'AP_PER_POLL_SETTINGS' => 'Configuração Por Votação de Votações Avançadas (selecionável por votação, com o valor padrão indicado aqui)',

	'AP_ACT_VOTES_HIDE'                 => 'Ativar ocultação de votos',
	'AP_ACT_VOTES_HIDE_EXPLAIN'         => 'Ativa a opção de ocultar os votos da votação até que ela termine.',
	'AP_ACT_VOTERS_SHOW'                => 'Ativar mostrar votantes',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'        => 'Ativa a opção de mostrar os votantes de cada opção da votação.',
	'AP_ACT_VOTERS_LIMIT'               => 'Ativar limite de votantes',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'       => 'Ativa a opção de limitar os votantes de uma votação aos usuários que já tenham escrito nesse tópico.',
	'AP_ACT_POLL_NO_VOTE'               => 'Ativar opção de não votar',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'       => 'Substitui o link "Ver resultados" por "Não quero votar, ver resultados", que impede votar depois de ver os resultados, a menos que a opção "Alterar votos" esteja selecionada.',
	'AP_ACT_SHOW_ORDERED'               => 'Ativar ordenação dos resultados',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'       => 'Ativa a opção de mostrar os resultados por ordem decrescente de votos recebidos (o mais votado primeiro).',
	'AP_ACT_POLL_SCORING'               => 'Ativar pontuação de votações',
	'AP_ACT_POLL_SCORING_EXPLAIN'       => 'Ativa a possibilidade de atribuir pontuações diferentes às opções da votação.',
	'AP_ACT_INCREMENTAL_VOTES'          => 'Ativar votação incremental',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'  => 'Ativa a possibilidade de votar de forma incremental, enquanto a capacidade de voto disponível não estiver esgotada.',
	'AP_ACT_CLOSED_VOTING'              => 'Ativar votação em tópicos fechados',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'      => 'Ativa a possibilidade de votar em uma votação aberta mesmo que o tópico correspondente esteja fechado.',
	'AP_ACT_POLL_END'                   => 'Ativar data de término da votação',
	'AP_ACT_POLL_END_EXPLAIN'           => 'Permite especificar quando termina uma votação através de uma data/hora, em vez de apenas especificar uma duração a partir do início da votação.',
	'AP_ACT_POLL_NOTIFICATIONS'         => 'Ativar notificações de votações',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN' => 'Ativa o envio de notificações a todos os votantes de uma votação oculta quando ela terminar e os resultados se tornarem visíveis.',

	'AP_DEFAULT_VOTES_CHANGE' => 'Valor padrão para alterar voto',
	'AP_DEFAULT_VOTES_HIDE'   => 'Valor padrão para ocultar votos',
	'AP_DEFAULT_VOTERS_SHOW'  => 'Valor padrão para mostrar votantes',
	'AP_DEFAULT_VOTERS_LIMIT' => 'Valor padrão para limitar votantes',
	'AP_DEFAULT_SHOW_ORDERED' => 'Valor padrão para ordenação',
]);
