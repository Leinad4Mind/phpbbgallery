<?php

/**
 * Subject Check. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
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
	'SUBJECT_CHECK_SIMILAR_TOPIC' => [
		1 => 'O assunto/título do teu tópico é semelhante a um tópico existente. Por favor, verifica-o e/ou responde no mesmo em vez de criar um novo tópico.',
		2 => 'O assunto/título do teu tópico é semelhante a tópicos existentes. Por favor, verifica-os e/ou responde nos mesmos em vez de criar um novo tópico.',
	],
	'SUBJECT_CHECK_STRICT_TOPIC' => [
		1 => 'O assunto/título do teu tópico é uma correspondência exata de um tópico existente. Por favor, responde a este em vez de criar um novo tópico.',
		2 => 'O assunto/título do teu tópico é uma correspondência exata de tópicos existentes. Por favor, responde àquele que mais se aproxima da tua mensagem em vez de criar um novo tópico.',
	],
	'SUBJECT_CHECK_EXACT_TOPIC' => [
		1 => 'O assunto/título do teu tópico é uma correspondência exata de um tópico existente. Por favor, responde a esse em vez de criar um novo tópico.',
		2 => 'O assunto/título do teu tópico tem mais do que uma correspondência exata de tópicos existentes. Por favor, responde àquele que mais se aproxima da tua mensagem em vez de criar um novo tópico.',
	],

	// One of these two strings will be appended to the above strings, so they need a leading space or some other separator.
	'SUBJECT_CHECK_NEW_WINDOW'  => ' (Os links abrir-se-ão numa nova janela.)',
	'SUBJECT_CHECK_SAME_WINDOW' => ' (Os links <em>NÃO</em> abrir-se-ão numa nova janela.)',

	// AJAX
	'SUBJECT_CHECK_WORKING' => 'A verificar se existem tópicos com títulos/assuntos semelhantes...',
]);
