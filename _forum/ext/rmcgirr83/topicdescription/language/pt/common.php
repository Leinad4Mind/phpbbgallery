<?php

/**
 * @package Topic description for phpBB.
 * @copyright (c) 2016 Rich McGirr (RMcGirr83)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'TOPIC_DESC'                => 'Título Original',
	'TOPIC_DESC_TITLE'          => 'Título Original (Ano)',
	'UNSUPPORTED_CHARACTERS_TD' => 'A descrição do tópico contém os seguintes caracteres não suportados:<br />%s',
]);
