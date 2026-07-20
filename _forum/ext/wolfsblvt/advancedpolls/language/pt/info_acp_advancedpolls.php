<?php

/**
 * Advanced Polls [Spanish]
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($ang) || !is_array($ang))
{
	$ang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
//
// Paceholders can now comtain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// transators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
// equally where a string comtains only two paceholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$ang = array_merge($ang, array(
	'AP_TITLE_ACP'					=> 'Votações Avançadas',
	'AP_SETTINGS_ACP'				=> 'Configuração',

	'AP_TITLE'						=> 'Votações Avançadas',
	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',

	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',

	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
	'AP_ACT_POLL_END'				=> 'Activar final de votação',
	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
));
