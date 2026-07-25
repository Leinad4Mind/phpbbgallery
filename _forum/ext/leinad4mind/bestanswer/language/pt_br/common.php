<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ANSWERS'  => 'Respostas',
	'ANSWERED' => 'Respondidas',
	
	'BEST_ANSWER'             => 'Melhor resposta',
	'BBPOINTS_ANSWER'         => 'Quantidade de BBpoints para a postagem “Melhor resposta”',
	'BBPOINTS_ANSWER_EXPLAIN' => 'Defina o número de pontos BB a serem creditados ao autor da postagem quando sua postagem neste fórum for marcada como “Melhor resposta”',

	'ENABLE_ANSWER'         => 'Habilitar melhor resposta',
	'ENABLE_ANSWER_EXPLAIN' => 'Se ativado, o autor do tópico (se permitido) e os moderadores (onde permitido) poderão marcar uma resposta ao tópico como a melhor resposta.',
	'EXTENSION_NOT_ENABLED' => 'A extensão Melhor resposta não está ativada neste fórum.',

	'LOG_MARK_ANSWER'   => '<strong>Postagem marcada como melhor resposta</strong><br />» %1$s by %2$s',
	'LOG_UNMARK_ANSWER' => '<strong>Postagem desmarcada como melhor resposta</strong><br />» %1$s by %2$s',

	'LOG_BBPOINTS_MARK_ANSWER'   => '<strong>Adicionados bbpoints ao autor pela melhor resposta</strong><br />» %1$s by %2$s',
	'LOG_BBPOINTS_UNMARK_ANSWER' => '<strong>Removidos bbpoints ao autor por perder a melhor resposta</strong><br />» %1$s by %2$s',

	'MARK_ANSWER'         => 'Marcar resposta',
	'MARK_ANSWER_CONFIRM' => 'Tem certeza de que deseja marcar esta postagem como a melhor resposta?',

	'TO_POST'          => '<i class="fa fa-eye"></i> Ver postagem',
	'TOPIC_FIRST_POST' => 'Você não pode marcar esta postagem como a melhor resposta, pois é a primeira postagem do tópico.',
	'TOTAL_ANSWERS'    => 'Total de respostas',

	'UNMARK_ANSWER'         => 'Desmarcar resposta',
	'UNMARK_ANSWER_CONFIRM' => 'Tem certeza de que deseja desmarcar esta postagem como a melhor resposta?',

	'MARK_ANSWER_NOTIFICATION'        => '%1$s marcou sua postagem no tópico “%2$s” como a melhor resposta.',
	'UNMARK_ANSWER_NOTIFICATION'      => '%1$s desmarcou sua postagem no tópico “%2$s” como a melhor resposta.',
	'NOTIFICATION_TYPE_MARK_ANSWER'   => 'Alguém marcou sua resposta no tópico como a melhor resposta',
	'NOTIFICATION_TYPE_UNMARK_ANSWER' => 'Alguém desmarcou sua resposta no tópico como a melhor resposta',
]);
