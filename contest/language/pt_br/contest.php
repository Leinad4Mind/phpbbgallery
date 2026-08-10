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
	'CONTEST_RESULT_HIDDEN' => 'A avaliação destas imagens ficará oculta até o fim do concurso em %s.',
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
	'CONTEST_IMAGE_DESC'           => '<strong>Concurso</strong> » A descrição da imagem permanecerá oculta até o fim do concurso em %s.',
	'CONTEST_WINNERS_OF'           => 'Vencedores do concurso “%s”',
	'SEARCH_CONTEST'                    => 'Vencedores do concurso',
	'VIEW_SEARCH_CONTESTS'  => 'Ver vencedores dos concursos',
	'CONTEST_STATUS' => 'Status do concurso',
	'CONTEST_PHASE_UPCOMING' => 'Agendado',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Os envios começam em %s.',
	'CONTEST_PHASE_UPLOAD' => 'Envios abertos',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'As imagens podem ser enviadas até %s. A votação e os comentários ainda não estão disponíveis.',
	'CONTEST_PHASE_RATING' => 'Votação aberta',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Os envios estão encerrados. A votação permanece aberta até %s; os comentários serão liberados depois.',
	'CONTEST_PHASE_FINISHED' => 'Encerrado',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'O concurso terminou. Os resultados e comentários já estão disponíveis.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'As datas são exibidas no seu fuso horário: %s.',
]);
