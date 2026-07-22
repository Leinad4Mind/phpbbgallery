<?php

/**
 * @package phpBB Extension - Smartfeed for phpBB.
 * @copyright (c) 2020 Mark D. Hamill (mark@phpbbservices.com)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'SMARTFEED_ATOM_FEED'            => 'Feed Atom',
	'SMARTFEED_ATOM_TOPIC_FEED'      => 'Feed de tópico Atom',
	'SMARTFEED_FEED_TYPE'            => 'Formato do feed de notícias',
	'SMARTFEED_FIRST_POST_ONLY'      => 'Tipos de mensagens no feed',
	'SMARTFEED_INSTALL_REQUIREMENTS' => 'As seguintes extensões PHP são necessárias: xml, pcre e openssl. A tua versão do PHP tem de ser &gt; 3.3.0 e &lt; 4.0. Um ou mais destes requisitos estão em falta. Por favor, resolve estes problemas e tenta ativar a extensão novamente.',
	'SMARTFEED_NO_FORUMS_AVAILABLE'  => 'Desculpa, devido ao teu estatuto de utilizador, não podes aceder a nenhum fórum',
	'SMARTFEED_PAGE'                 => 'Smartfeed',
	'SMARTFEED_RSS_FEED'             => 'Feed RSS',
	'SMARTFEED_RSS_TOPIC_FEED'       => 'Feed de tópico RSS',
]);
