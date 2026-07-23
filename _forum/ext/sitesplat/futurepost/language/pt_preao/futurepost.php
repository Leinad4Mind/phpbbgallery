<?php

/**
 * BBpostdated
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'FUTURE_POST_ADDED'       => 'O tópico foi publicado com sucesso e será exibido numa data futura.',
	'TOPIC_PENDING'           => 'Este tópico está pendente para publicação numa data futura.',
	'LOG_FUTURE_POST_APROVED' => 'A publicação futura foi publicada com sucesso',
]);
