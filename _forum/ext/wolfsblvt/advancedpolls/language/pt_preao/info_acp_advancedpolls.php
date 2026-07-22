<?php

/**
 * Advanced Polls [English]
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
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
	'AP_TITLE_ACP'    => 'Votações Avançadas',
	'AP_SETTINGS_ACP' => 'Configuração',

	'AP_TITLE'         => 'Votações Avançadas',
	'AP_TITLE_EXPLAIN' => 'Melhora o sistema de votações nativo do phpBB com novas funcionalidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os votantes e mais.',
	'AP_COPYRIGHT'     => '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',

	'AP_SETTINGS'          => 'Configuração de Votações Avançadas',
	'AP_GLOBAL_SETTINGS'   => 'Configuração Global de Votações Avançadas (aplica-se a todas as votações)',
	'AP_PER_POLL_SETTINGS' => 'Configuração Por Votação de Votações Avançadas (seleccionável por votação, com o valor por defeito indicado aqui)',

	'AP_ACT_VOTES_HIDE'                 => 'Activar ocultação de votos',
	'AP_ACT_VOTES_HIDE_EXPLAIN'         => 'Activa a opção de ocultar os votos da votação até que esta termine.',
	'AP_ACT_VOTERS_SHOW'                => 'Activar mostrar votantes',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'        => 'Activa a opção de mostrar os votantes de cada opção da votação.',
	'AP_ACT_VOTERS_LIMIT'               => 'Activar limite de votantes',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'       => 'Activa a opção de limitar os votantes de uma votação aos utilizadores que já tenham escrito nesse tópico.',
	'AP_ACT_POLL_NO_VOTE'               => 'Activar opção de não votar',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'       => 'Substitui o link "Ver resultados" por "Não quero votar, ver resultados", que impede votar depois de ver os resultados, a menos que a opção "Alterar votos" esteja seleccionada.',
	'AP_ACT_SHOW_ORDERED'               => 'Activar ordenação dos resultados',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'       => 'Activa a opção de mostrar os resultados por ordem decrescente de votos recebidos (o mais votado primeiro).',
	'AP_ACT_POLL_SCORING'               => 'Activar pontuação de votações',
	'AP_ACT_POLL_SCORING_EXPLAIN'       => 'Activa a possibilidade de atribuir pontuações diferentes às opções da votação.',
	'AP_ACT_INCREMENTAL_VOTES'          => 'Activar votação incremental',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'  => 'Activa a possibilidade de votar de forma incremental, enquanto a capacidade de voto disponível não estiver esgotada.',
	'AP_ACT_CLOSED_VOTING'              => 'Activar votação em tópicos fechados',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'      => 'Activa a possibilidade de votar numa votação aberta mesmo que o tópico correspondente esteja fechado.',
	'AP_ACT_POLL_END'                   => 'Activar data de término da votação',
	'AP_ACT_POLL_END_EXPLAIN'           => 'Permite especificar quando termina uma votação através de uma data/hora, em vez de apenas especificar uma duração a partir do início da votação.',
	'AP_ACT_POLL_NOTIFICATIONS'         => 'Activar notificações de votações',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN' => 'Activa o envio de notificações a todos os votantes de uma votação oculta quando esta terminar e os resultados se tornarem visíveis.',

	'AP_DEFAULT_VOTES_CHANGE' => 'Valor por defeito para alterar voto',
	'AP_DEFAULT_VOTES_HIDE'   => 'Valor por defeito para ocultar votos',
	'AP_DEFAULT_VOTERS_SHOW'  => 'Valor por defeito para mostrar votantes',
	'AP_DEFAULT_VOTERS_LIMIT' => 'Valor por defeito para limitar votantes',
	'AP_DEFAULT_SHOW_ORDERED' => 'Valor por defeito para ordenação',
]);
