<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
));
