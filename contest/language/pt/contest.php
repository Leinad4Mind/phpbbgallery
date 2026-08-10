<?php
/**
 * phpBB Gallery Contest frontend language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'CONTEST_RATING_HIDDEN' => 'oculta',
	'CONTEST_RESULT_HIDDEN' => 'A classificação destas imagens está oculta até ao fim do concurso em %s.',
	'CONTEST_COMMENTS_STARTS'      => 'Comentários em imagens neste concurso são permitidos a partir de %s.',
	'CONTEST_ENDED'                => 'Este concurso terminou em %s.',
	'CONTEST_ENDS'                 => 'Este concurso termina em %s.',
	'CONTEST_RATING_STARTED'       => 'A votação para este concurso iniciou em %s.',
	'CONTEST_RATING_STARTS'        => 'A votação para este concurso inicia em %s.',
	'CONTEST_RESULT'               => 'Concurso',
	'CONTEST_RESULT_1'             => 'Vencedor',
	'CONTEST_RESULT_2'             => 'Segundo',
	'CONTEST_RESULT_3'             => 'Terceiro',
	'CONTEST_STARTED'              => 'O concurso iniciou em %s.',
	'CONTEST_STARTS'               => 'O concurso inicia em %s.',
	'CONTEST_USERNAME'             => '<strong>Concurso</strong>',
	'CONTEST_IMAGE_DESC'           => '<strong>Concurso</strong> » A descrição da imagem permanecerá oculta até ao fim do concurso em %s.',
	'CONTEST_WINNERS_OF'           => 'Vencedores do concurso “%s”',
	'SEARCH_CONTEST'                    => 'Vencedores do concurso',
	'VIEW_SEARCH_CONTESTS'  => 'Ver vencedores dos concursos',
	'CONTEST_STATUS' => 'Estado do concurso',
	'CONTEST_PHASE_UPCOMING' => 'Agendado',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'As submissões abrem em %s.',
	'CONTEST_PHASE_UPLOAD' => 'Submissões abertas',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'É possível enviar imagens até %s. A votação e os comentários ainda não estão disponíveis.',
	'CONTEST_PHASE_RATING' => 'Votação aberta',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'As submissões estão encerradas. A votação permanece aberta até %s; os comentários abrem depois.',
	'CONTEST_PHASE_FINISHED' => 'Terminado',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'O concurso terminou. Os resultados e os comentários estão agora disponíveis.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'As datas são apresentadas no teu fuso horário: %s.',
]);
