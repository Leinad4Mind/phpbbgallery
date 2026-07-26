<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	'ANSWERS'  => 'Tópicos Resolvidos',
	'ANSWERED' => 'Respondido',
	
	'BEST_ANSWER'             => 'Melhor Resposta',
	'BBPOINTS_ANSWER'         => 'Montante de PontosGold para mensagem com "Melhor Resposta"',
	'BBPOINTS_ANSWER_EXPLAIN' => 'Coloca o número de pontos a serem creditados ao autor da mensagem quando a sua mensagem neste fórum for marcada como "Melhor Resposta"',

	'ENABLE_ANSWER'         => 'Activar Melhor Resposta',
	'ENABLE_ANSWER_EXPLAIN' => 'Se ativado, o autor do tópico (caso tenha permissão) e os moderadores (onde permitido) poderão marcar uma resposta do tópico como a melhor resposta.',
	'EXTENSION_NOT_ENABLED' => 'A extensão "Melhor Resposta" não está ativada neste fórum.',

	'LOCK_ON_ANSWER'         => 'Bloquear tópico ao marcar melhor resposta',
	'LOCK_ON_ANSWER_EXPLAIN' => 'Se ativado, o tópico é bloqueado automaticamente quando uma mensagem é marcada como a melhor resposta.',

	'BESTANSWER_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p>Foi adicionada uma nova opção em <strong>%1$s » %2$s » %3$s</strong>: <em>"Bloquear tópico ao marcar melhor resposta"</em>.</p><p>Também foram adicionadas duas novas permissões — <strong>%8$s</strong> e <strong>%9$s</strong> — já atribuídas por omissão às funções padrão de fórum e de moderação. Revê-as ou ajusta-as por fórum em <strong>%4$s » %5$s » %6$s</strong> (membros) e <strong>%4$s » %5$s » %7$s</strong> (moderadores).</p></div>',

	'LOG_MARK_ANSWER'   => '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
	'LOG_UNMARK_ANSWER' => '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',

	'LOG_BBPOINTS_MARK_ANSWER'   => '<strong>Adicionados PontosGold ao autor pela melhor resposta</strong><br />» %1$s by %2$s',
	'LOG_BBPOINTS_UNMARK_ANSWER' => '<strong>Removidos PontosGold ao autor pela melhor resposta</strong><br />» %1$s by %2$s',

	'MARK_ANSWER'         => 'Marcar Melhor Resposta',
	'MARK_ANSWER_CONFIRM' => 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',

	'TO_POST'          => '<i class="fa fa-eye"></i> Ver Mensagem',
	'TOPIC_FIRST_POST' => 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
	'TOTAL_ANSWERS'    => 'Total de Tópicos Resolvidos',

	'UNMARK_ANSWER'         => 'Remover Melhor Resposta',
	'UNMARK_ANSWER_CONFIRM' => 'Tens a certeza de que queres desmarcar esta mensagem como sendo a melhor resposta?',

	'MARK_ANSWER_NOTIFICATION'        => '%1$s marcou a tua mensagem no tópico “%2$s” como sendo a melhor resposta.',
	'UNMARK_ANSWER_NOTIFICATION'      => '%1$s desmarcou a tua mensagem no tópico “%2$s” como sendo a melhor resposta.',
	'NOTIFICATION_TYPE_MARK_ANSWER'   => 'Alguém marca a tua mensagem como melhor resposta',
	'NOTIFICATION_TYPE_UNMARK_ANSWER' => 'Alguém desmarca a tua mensagem como melhor resposta',
]);
