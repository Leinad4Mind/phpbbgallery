<?php

/**
 * BBpostdated
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
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
	'FUTURE_DATE'             => 'Data futura',
	'FUTURE_POST_ADDED'       => 'O tópico foi postado com sucesso e será exibido em uma data futura.',
	'TOPIC_PENDING'           => 'Este tópico está pendente para postagem em uma data futura.',
	'LOG_FUTURE_POST_APROVED' => 'A postagem futura foi publicada com sucesso',
]);
