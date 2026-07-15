<?php

/**
 * Simple Spoiler extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @ignore
 */
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'HELP_BBCODE_BLOCK_SPOILERS' => 'Criando Spoilers',

	'HELP_BBCODE_SPOILERS_BASIC_QUESTION'	=> 'Adicionando um spoiler a uma mensagem',
	'HELP_BBCODE_SPOILERS_BASIC_ANSWER'		=> 'Um spoiler básico consiste em texto encapsulado entre as etiquetas <strong>[spoiler][/spoiler]</strong>. Por exemplo:<br /><br /><strong>[spoiler]</strong>%2$s<strong>[/spoiler]</strong><br /><br />Isto gerará:<br />%1$s',

	'HELP_BBCODE_SPOILERS_TITLE_QUESTION'	=> 'Adicionando um spoiler com título a uma mensagem',
	'HELP_BBCODE_SPOILERS_TITLE_ANSWER'		=> 'Um spoiler opcionalmente pode mostrar um título personalizado, para isso o texto necessita ser encapsulado entre as etiquetas <strong>[spoiler title=][/spoiler]</strong>. Por exemplo:<br /><br /><strong>[spoiler title=</strong>%3$s<strong>]</strong>%2$s<strong>[/spoiler]</strong><br /><br />Isto gerará:<br />%1$s',

	'HELP_BBCODE_SPOILERS_DEMO_TITLE'	=> 'Resumo de algo',
	'HELP_BBCODE_SPOILERS_DEMO_BODY'	=> 'Detalhes da sinopse do filme'
]);
