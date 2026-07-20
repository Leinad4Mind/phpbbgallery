<?php

/**
 * @package phpBB Extension - Smartfeed for phpBB.
 * @copyright (c) 2020 Mark D. Hamill (mark@phpbbservices.com)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'SMARTFEED_ATOM_FEED'            => 'Feed Atom',
	'SMARTFEED_ATOM_TOPIC_FEED'      => 'Feed de tópico Atom',
	'SMARTFEED_FEED_TYPE'            => 'Formato do feed de notícias',
	'SMARTFEED_FIRST_POST_ONLY'      => 'Tipos de mensagens no feed',
	'SMARTFEED_INSTALL_REQUIREMENTS' => 'As seguintes extensões PHP são necessárias: xml, pcre e openssl. A sua versão do PHP tem de ser &gt; 3.3.0 e &lt; 4.0. Um ou mais destes requisitos estão em falta. Por favor, resolva estes problemas e tente habilitar a extensão novamente.',
	'SMARTFEED_NO_FORUMS_AVAILABLE'  => 'Desculpe, devido ao seu estatuto de usuário, não pode aceder a nenhum fórum',
	'SMARTFEED_PAGE'                 => 'Smartfeed',
	'SMARTFEED_RSS_FEED'             => 'Feed RSS',
	'SMARTFEED_RSS_TOPIC_FEED'       => 'Feed de tópico RSS',
]);
