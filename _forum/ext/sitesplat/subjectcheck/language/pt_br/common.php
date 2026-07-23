<?php

/**
 * Subject Check. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
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

$lang = array_merge($lang, [
	'SUBJECT_CHECK_SIMILAR_TOPIC' => [
		1 => 'O assunto/título do seu tópico é semelhante a um tópico existente. Por favor, verifique-o e/ou responda no mesmo em vez de criar um novo tópico.',
		2 => 'O assunto/título do seu tópico é semelhante a tópicos existentes. Por favor, verifique-os e/ou responda nos mesmos em vez de criar um novo tópico.',
	],
	'SUBJECT_CHECK_STRICT_TOPIC' => [
		1 => 'O assunto/título do seu tópico é uma correspondência exata de um tópico existente. Por favor, responda a este em vez de criar um novo tópico.',
		2 => 'O assunto/título do seu tópico é uma correspondência exata de tópicos existentes. Por favor, responda àquele que mais se aproxima da sua mensagem em vez de criar um novo tópico.',
	],
	'SUBJECT_CHECK_EXACT_TOPIC' => [
		1 => 'O assunto/título do seu tópico é uma correspondência exata de um tópico existente. Por favor, responda a esse em vez de criar um novo tópico.',
		2 => 'O assunto/título do seu tópico tem mais do que uma correspondência exata de tópicos existentes. Por favor, responda àquele que mais se aproxima da sua mensagem em vez de criar um novo tópico.',
	],

	// One of these two strings will be appended to the above strings, so they need a leading space or some other separator.
	'SUBJECT_CHECK_NEW_WINDOW'  => ' (Os links vão abrir em uma nova janela.)',
	'SUBJECT_CHECK_SAME_WINDOW' => ' (Os links <em>NÃO</em> vão abrir em uma nova janela.)',

	// AJAX
	'SUBJECT_CHECK_WORKING' => 'A verificar se existem tópicos com títulos/assuntos semelhantes...',
]);
