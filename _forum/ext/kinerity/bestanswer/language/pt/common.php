<?php

/**
 * @copyright (c) 2014-2020 Leinad4Mind, Feneck91, etc.
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */
if (!defined('IN_PHPBB'))
{
exit;
}
if (empty($lang) || !is_array($lang))
{
$lang = [];
}
$lang = array_merge($lang, [
	'ANSWERS'                         => 'Respostas',
	'ENABLE_ANSWER'                   => 'Ativar melhor resposta',
	'ENABLE_ANSWER_EXPLAIN'           => 'Se ativado, o criador do tópico (se permitido) e os moderadores (onde permitido) poderão marcar uma resposta do tópico como a melhor resposta.',
	'TO_POST'                         => 'Ir para a mensagem completa',
	'LOG_MARK_ANSWER'                 => '<strong>Marcou a mensagem como melhor resposta</strong><br />» %1$s por %2$s',
	'LOG_UNMARK_ANSWER'               => '<strong>Desmarcou a mensagem como melhor resposta</strong><br />» %1$s por %2$s',
	'MARK_ANSWER'                     => 'Marcar resposta',
	'MARK_ANSWER_CONFIRM'             => 'Tens a certeza de que desejas marcar esta mensagem como a melhor resposta?',
	'TOTAL_ANSWERS'                   => 'Total de respostas',
	'UNMARK_ANSWER'                   => 'Desmarcar resposta',
	'UNMARK_ANSWER_CONFIRM'           => 'Tens a certeza de que desejas desmarcar esta mensagem como a melhor resposta?',
	'MARK_ANSWER_NOTIFICATION'        => '%1$s marcou a tua mensagem no tópico "%2$s" como a melhor resposta.',
	'UNMARK_ANSWER_NOTIFICATION'      => '%1$s desmarcou a tua mensagem no tópico "%2$s" como a melhor resposta.',
	'NOTIFICATION_TYPE_MARK_ANSWER'   => 'Alguém marca a tua resposta ao tópico como a melhor resposta',
	'NOTIFICATION_TYPE_UNMARK_ANSWER' => 'Alguém desmarca a tua resposta ao tópico como a melhor resposta',
	'BUTTON_MARK'                     => 'Marcar resposta',
	'BUTTON_UNMARK'                   => 'Desmarcar resposta',
]);
