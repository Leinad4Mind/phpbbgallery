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
	'HELP_BBCODE_BLOCK_SPOILERS' => 'Criar spoilers',

	'HELP_BBCODE_SPOILERS_BASIC_QUESTION'	=> 'Adicionar um spoiler numa mensagem',
	'HELP_BBCODE_SPOILERS_BASIC_ANSWER'		=> 'Um spoiler básico é composto por um texto colocado entre <strong>[spoiler][/spoiler]</strong>. Por exemplo:<br><br><strong>[spoiler]</strong>%2$s<strong>[/spoiler]</strong><br><br>O resultado terá o seguinte aspecto:<br>%1$s',

	'HELP_BBCODE_SPOILERS_TITLE_QUESTION'	=> 'Adicionar um spoiler com título numa mensagem',
	'HELP_BBCODE_SPOILERS_TITLE_ANSWER'		=> 'Um spoiler pode, opcionalmente, mostrar um título personalizado. Para efectuar isto, o texto deve ser colocado entre <strong>[spoiler title=][/spoiler]</strong>. Por exemplo:<br><br><strong>[spoiler title=</strong>%3$s<strong>]</strong>%2$s<strong>[/spoiler]</strong><br><br>O resultado terá o seguinte aspecto:<br>%1$s',

	'HELP_BBCODE_SPOILERS_DEMO_TITLE'	=> 'Resumo do enredo',
	'HELP_BBCODE_SPOILERS_DEMO_BODY'	=> 'Pormenores sobre o enredo do filme'
]);
